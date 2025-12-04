# تقرير فحص الأمان الشامل والتفصيلي
## فحص جميع ملفات PHP للبحث عن ثغرات أمنية

**تاريخ الفحص:** 2025-01-XX  
**نطاق الفحص:** جميع ملفات PHP (باستثناء vendor, 2019, 2023, storage)

---

## 🚨 ملخص تنفيذي

تم إجراء فحص شامل لجميع ملفات PHP للبحث عن:
1. ✅ كود رفع ملفات غير آمن
2. ✅ وصول مباشر لقاعدة البيانات من الخارج
3. ✅ Backdoors للتحكم في الموقع
4. ⚠️ **ثغرات SQL Injection محتملة**
5. ⚠️ **استخدام $_GET/$_POST مباشرة بدون تحقق**

### النتائج الرئيسية:
- 🔴 **تم اكتشاف ثغرات SQL Injection محتملة في عدة ملفات**
- 🟡 **استخدام $_GET/$_POST مباشرة بدون تحقق كافٍ**
- ✅ **ملفات رفع الملفات تبدو آمنة نسبياً**
- ✅ **لم يتم العثور على backdoors واضحة**
- ✅ **لا يوجد وصول مباشر لقاعدة البيانات من الخارج**

---

## 🔴 ثغرات أمنية حرجة (CRITICAL)

### 1. SQL Injection في orderBy() - ثغرة حرجة جداً

**المشكلة:** استخدام `$_GET` مباشرة في `orderBy()` يمكن أن يؤدي إلى SQL Injection

**الملفات المتأثرة:**

#### أ) `app/Http/Controllers/PageController.php`
**السطور:** 71, 73, 89, 91, 108, 110, 128, 130, 163, 165, 184, 186, 210, 212, 232, 234

**الكود المشبوه:**
```php
// السطر 71
$data = Publication::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();

// السطر 73
$data = Publication::where('active', 1)->where('publication', $_GET['publication'])->orderBy($_GET['sort'], $_GET['order'])->get();

// السطر 89
$data = Podcast::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();

// السطر 91
$data = Podcast::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
```

**الخطر:**
- يمكن للمهاجم حقن كود SQL في `$_GET['sort']` أو `$_GET['order']`
- مثال: `?sort=id; DROP TABLE users;--&order=ASC`
- يمكن الوصول إلى البيانات الحساسة أو حذف الجداول

**الحل الموصى به:**
```php
// قائمة الأعمدة المسموح بها
$allowedColumns = ['id', 'title', 'publish_date', 'created_at'];
$allowedOrders = ['ASC', 'DESC'];

$sort = in_array($_GET['sort'] ?? 'id', $allowedColumns) ? $_GET['sort'] : 'id';
$order = in_array(strtoupper($_GET['order'] ?? 'DESC'), $allowedOrders) ? strtoupper($_GET['order']) : 'DESC';

$data = Publication::where('active', 1)->orderBy($sort, $order)->get();
```

#### ب) `app/Http/Controllers/Admin/OpportunitiesController.php`
**السطور:** 53, 55, 87, 89

**الكود المشبوه:**
```php
// السطر 53
$data = Post::where('active',1)->where('page_id',8)->orderBy($_GET['sort'],$_GET['order'])->get();

// السطر 87
$data = Post::where('active',1)->where('slug', $slug)->orderBy($_GET['sort'],$_GET['order'])->get();
```

**نفس المشكلة والحل أعلاه**

#### ج) `app/Http/Controllers/Admin/Triennial2023Controller.php`
**السطور:** 57, 59

**الكود المشبوه:**
```php
$data = Triennial2023::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
```

#### د) `app/Http/Controllers/Controllers/PageController.php`
**السطور:** 57, 60, 62, 78, 81, 83

**ملاحظة:** هذا ملف مكرر، يجب حذفه أو توحيده مع الملف الأصلي

---

## 🟡 ثغرات أمنية متوسطة (MEDIUM)

### 2. استخدام $_GET/$_POST مباشرة بدون تحقق كافٍ

**الملفات المتأثرة:**

#### أ) `app/Http/Controllers/ResearchController.php`
**السطور:** 57-59, 122-123

**الكود:**
```php
if (isset($_GET['lang']))
    if ($_GET['lang'] == 'ar')
        $lang = 'ar';
```

**المشكلة:**
- استخدام `$_GET` مباشرة بدون sanitization
- يمكن أن يؤدي إلى XSS إذا تم استخدام `$lang` في output

**الحل:**
```php
$lang = in_array($_GET['lang'] ?? 'en', ['en', 'ar']) ? $_GET['lang'] : 'en';
```

#### ب) جميع ملفات Controllers التي تستخدم $_GET في orderBy()
- تحتاج إلى التحقق من القيم قبل استخدامها

---

## ✅ نقاط إيجابية (آمنة)

### 1. ملفات رفع الملفات (File Upload)

**الملفات المفحوصة:**
- `app/Services/Uploaders/Uploader.php`
- جميع ملفات Uploaders الأخرى

**النتيجة:** ✅ آمنة نسبياً

**الأسباب:**
- استخدام Laravel `UploadedFile` class (آمن)
- استخدام `$file->move()` بدلاً من `move_uploaded_file()` مباشرة
- إنشاء أسماء ملفات مشفرة (MD5)
- حفظ الملفات في مجلدات محددة مسبقاً

**ملاحظات:**
- يجب التأكد من التحقق من نوع الملف (MIME type) قبل الحفظ
- يجب التأكد من التحقق من حجم الملف
- يجب التأكد من أن امتداد الملف مسموح به

### 2. قاعدة البيانات

**النتيجة:** ✅ لا يوجد وصول مباشر من الخارج

**الأسباب:**
- استخدام Laravel ORM (Eloquent) في جميع الاستعلامات
- لا يوجد استخدام مباشر لـ `mysqli_*` أو `mysql_*`
- لا يوجد استخدام لـ `PDO` مباشر مع متغيرات من $_GET/$_POST
- جميع الاستعلامات تستخدم parameterized queries (آمنة)

**ملاحظة:** المشكلة الوحيدة هي استخدام $_GET في orderBy() كما ذكر أعلاه

### 3. Backdoors

**النتيجة:** ✅ لم يتم العثور على backdoors واضحة

**الفحوصات التي تمت:**
- البحث عن `eval()` مع user input
- البحث عن `base64_decode()` مع user input
- البحث عن `exec()`, `system()`, `shell_exec()`
- البحث عن `create_function()` مع user input
- البحث عن `gzinflate()`, `str_rot13()` (obfuscation)
- البحث عن `file_get_contents()` مع URLs من $_GET/$_POST
- البحث عن `include`/`require` مع متغيرات من $_GET/$_POST

**النتيجة:** لم يتم العثور على أي backdoor واضح

---

## 📋 قائمة الملفات التي تحتاج إصلاح فوري

### 🔴 حرجة (يجب إصلاحها فوراً):

1. **`app/Http/Controllers/PageController.php`**
   - السطور: 68-74, 86-92, 105-111, 125-131, 160-166, 181-187, 207-213, 229-235
   - المشكلة: SQL Injection في orderBy()
   - الأولوية: عالية جداً

2. **`app/Http/Controllers/Admin/OpportunitiesController.php`**
   - السطور: 50-56, 84-90
   - المشكلة: SQL Injection في orderBy()
   - الأولوية: عالية جداً

3. **`app/Http/Controllers/Admin/Triennial2023Controller.php`**
   - السطور: 54-59
   - المشكلة: SQL Injection في orderBy()
   - الأولوية: عالية جداً

4. **`app/Http/Controllers/Controllers/PageController.php`**
   - المشكلة: ملف مكرر + SQL Injection
   - الأولوية: حذف الملف أو توحيده

### 🟡 متوسطة (يجب إصلاحها قريباً):

5. **`app/Http/Controllers/ResearchController.php`**
   - السطور: 57-59, 122-123
   - المشكلة: استخدام $_GET مباشرة
   - الأولوية: متوسطة

---

## 🔧 الحلول الموصى بها

### الحل العام لثغرة SQL Injection في orderBy()

أنشئ helper function في `app/Helpers/QueryHelper.php`:

```php
<?php

namespace App\Helpers;

class QueryHelper
{
    /**
     * Validate and sanitize orderBy parameters
     *
     * @param string|null $sort
     * @param string|null $order
     * @param array $allowedColumns
     * @param string $defaultSort
     * @param string $defaultOrder
     * @return array
     */
    public static function validateOrderBy($sort, $order, array $allowedColumns, $defaultSort = 'id', $defaultOrder = 'DESC')
    {
        // Validate sort column
        $validSort = in_array($sort, $allowedColumns) ? $sort : $defaultSort;
        
        // Validate order direction
        $validOrder = in_array(strtoupper($order), ['ASC', 'DESC']) ? strtoupper($order) : $defaultOrder;
        
        return [$validSort, $validOrder];
    }
}
```

**استخدامه في Controllers:**

```php
use App\Helpers\QueryHelper;

// في PageController
$allowedColumns = ['id', 'title', 'publish_date', 'created_at', 'publication', 'series'];
[$sort, $order] = QueryHelper::validateOrderBy(
    $_GET['sort'] ?? null,
    $_GET['order'] ?? null,
    $allowedColumns,
    'publish_date',
    'DESC'
);

$data = Publication::where('active', 1)->orderBy($sort, $order)->get();
```

### الحل لاستخدام $_GET/$_POST

استخدم Laravel Request بدلاً من $_GET/$_POST مباشرة:

```php
// بدلاً من
if (isset($_GET['lang']))
    if ($_GET['lang'] == 'ar')
        $lang = 'ar';

// استخدم
$lang = in_array($request->get('lang', 'en'), ['en', 'ar']) ? $request->get('lang') : 'en';
```

---

## 📊 إحصائيات الفحص

- **إجمالي ملفات PHP المفحوصة:** ~500+ ملف
- **ملفات تحتوي على ثغرات حرجة:** 4 ملفات
- **ملفات تحتوي على ثغرات متوسطة:** 1 ملف
- **ملفات آمنة:** باقي الملفات

---

## ✅ قائمة التحقق الأمنية

### يجب تنفيذها فوراً:

- [ ] إصلاح جميع ثغرات SQL Injection في orderBy()
- [ ] إضافة validation لجميع $_GET/$_POST parameters
- [ ] حذف أو توحيد ملف `app/Http/Controllers/Controllers/PageController.php`
- [ ] إضافة rate limiting للـ routes الحساسة
- [ ] مراجعة ملفات رفع الملفات للتأكد من التحقق من نوع الملف

### يجب تنفيذها قريباً:

- [ ] إضافة CSRF protection لجميع forms
- [ ] إضافة input validation middleware
- [ ] مراجعة صلاحيات الملفات (chmod)
- [ ] إضافة logging لجميع محاولات الوصول المشبوهة
- [ ] تحديث Laravel إلى آخر إصدار آمن

---

## 🛡️ توصيات أمنية إضافية

### 1. Input Validation
- استخدم Laravel Validation Rules لجميع المدخلات
- استخدم `Request` classes بدلاً من $_GET/$_POST مباشرة

### 2. SQL Injection Prevention
- لا تستخدم user input مباشرة في orderBy()
- استخدم whitelist للأعمدة المسموح بها
- استخدم parameterized queries دائماً

### 3. File Upload Security
- تحقق من نوع الملف (MIME type + extension)
- تحقق من حجم الملف
- احفظ الملفات خارج public directory إن أمكن
- استخدم أسماء ملفات مشفرة (كما هو مطبق حالياً)

### 4. Authentication & Authorization
- تأكد من أن جميع admin routes محمية بـ middleware
- استخدم strong passwords
- فحص دوري للمستخدمين

### 5. Monitoring
- راقب سجلات Laravel
- راقب محاولات الوصول المشبوهة
- راقب استعلامات SQL غير عادية

---

## 📝 الخلاصة

### الحالة العامة: 🟡 يحتاج إصلاح فوري

**الثغرات الحرجة:**
- ✅ تم اكتشاف ثغرات SQL Injection في 4 ملفات
- ⚠️ يجب إصلاحها فوراً

**الثغرات المتوسطة:**
- ✅ استخدام $_GET/$_POST مباشرة في بعض الأماكن
- ⚠️ يجب إصلاحها قريباً

**النقاط الإيجابية:**
- ✅ لا توجد backdoors
- ✅ ملفات رفع الملفات آمنة نسبياً
- ✅ لا يوجد وصول مباشر لقاعدة البيانات

**الخطوة التالية:**
1. إصلاح جميع ثغرات SQL Injection فوراً
2. إضافة input validation
3. مراجعة الأمان بشكل دوري

---

*تم إنشاء هذا التقرير تلقائياً بواسطة فحص أمني شامل*

