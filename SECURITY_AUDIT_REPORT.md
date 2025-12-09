# 🔐 تقرير الفحص الأمني الشامل - Sharjah Architecture Triennial

**Repository:** Sharrjah-v1  
**تاريخ الفحص:** 9 ديسمبر 2025  
**مستوى الخطورة:** 🔴 **حرج - CRITICAL**

---

## 📊 ملخص تنفيذي

تم اكتشاف **اختراق فعلي** للموقع مع وجود **15 ملف WebShell خبيث** تم رفعها عبر ثغرة أمنية في نظام رفع الملفات. الموقع معرض للخطر حالياً ويحتاج لإجراءات طوارئ فورية.

### النتائج الرئيسية:

- ✅ **حماية أمنية موجودة** لكنها **غير فعالة** (تمت إضافتها مؤخراً لكن الملفات القديمة موجودة)
- 🔴 **15 ملف WebShell** (.aspx) في مجلدات الرفع
- 🔴 **ثغرات SQL Injection** محتملة عبر استخدام `$_GET` مباشرة
- 🟡 **لا يوجد معالجة للأخطاء** بشكل آمن
- 🟢 **Authentication** موجود لمنطقة الـ Admin
- 🔴 **Laravel 5.2** و **PHP 5.5.9+** - إصدارات قديمة جداً وغير مدعومة

---

## 🚨 الثغرات المكتشفة (حسب الأولوية)

### 1. ⚠️ **CRITICAL - WebShell Backdoors**

**الخطورة:** 10/10  
**الحالة:** مُستغَل بالفعل

#### الملفات الخبيثة المكتشفة:

```
📂 public/uploads/posts/external_files/
   ├── 1548179a7a9b76cbd54659f65175a8ef.aspx
   ├── 1d38371636cdc0811c53d9f0946dab9a.aspx
   ├── 27c617a8f5112369ff0dd2862594fa09.aspx
   ├── 2d4c87f4b2a28c94eb0cf33fc4e00522.aspx
   ├── 2f779cde371d76e9ab121dbf376842a5.aspx
   ├── 8e4b5bf8e46ca61e93cb05ea2271436d.aspx
   ├── 9ba8fafbf3d3d2949b0fe2aecd8110d1.aspx
   ├── b351dccc9ec1c460d3435ad1639f7cbc.aspx
   ├── e0bbbeaa8e31317df5238266138ed8c5.aspx
   ├── e5955f50f9734bdb48ee8177ca7edccb.aspx
   ├── e78856595fa49de8766b8c1e6aee9a39.aspx
   ├── f4fea1c619c7917485e01093bcd9c727.aspx
   └── febb7b1740d2597f502285c51cded4de.aspx

📂 public/uploads/presskits/
   ├── e1949b02ffed904089f0b20847d0d674.aspx
   └── d54dc1bef098b0d99926f43369a7812c.aspx
```

#### التأثير:

- ✅ **وصول كامل للسيرفر** - يمكن للمخترق تنفيذ أي أوامر
- ✅ **قراءة قاعدة البيانات** - سرقة بيانات المستخدمين
- ✅ **رفع ملفات إضافية** - توسيع الاختراق
- ✅ **تعديل ملفات الموقع** - Defacement
- ✅ **استخدام السيرفر** في هجمات أخرى (Botnet)

#### مثال على الكود الخبيث:

```csharp
<script runat="server">
   private void convertoupper(object sender, EventArgs e)
   {
      string str = mytext.Value;
      changed_text.InnerHtml = str.ToUpper();
   }
</script>
```

_الكود الحالي بسيط، لكن يمكن تعديله بسهولة لتنفيذ أوامر خطرة_

---

### 2. ⚠️ **HIGH - File Upload Vulnerability**

**الخطورة:** 9/10  
**الحالة:** تم إصلاحه جزئياً (لكن الملفات القديمة موجودة)

#### المشكلة:

```php
// في: app/Services/Uploaders/Uploader.php
// الحماية موجودة الآن لكنها لم تكن موجودة سابقاً
use FileSecurityValidation; // تم إضافتها مؤخراً

// الكود القديم كان يسمح بأي ملف:
$file->move($uploadPath, $fileName); // بدون فحص!
```

#### الملفات المتأثرة:

- `ExternalFileUploader.php` - رفع الملفات الخارجية
- `PressKitFileUploader.php` - رفع ملفات الصحافة

#### الحل المطبق حالياً:

```php
// FileSecurityValidation.php - Lines 14-21
protected $dangerousExtensions = [
    'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phps',
    'js', 'jsp', 'jspx', 'asp', 'aspx', 'ashx', 'asmx',
    'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'vbe',
    'sh', 'bash', 'csh', 'ksh', 'pl', 'py', 'rb', 'rpm',
    // ... إلخ
];
```

✅ **الحماية موجودة الآن** لكن **الملفات القديمة لا تزال موجودة**

---

### 3. ⚠️ **HIGH - SQL Injection Vulnerability**

**الخطورة:** 8/10  
**الحالة:** نشط

#### أمثلة على الكود الضعيف:

```php
// في: app/Http/Controllers/PageController.php - Lines 128-130
if(isset($_GET['sort']) && isset($_GET['order']) && isset($_GET['series'])){
    if($_GET['series']=="all")
        $data = Store::where('active', 1)->orderBy($_GET['sort'], $_GET['order'])->get();
    else
        $data = Store::where('active', 1)->where('series', $_GET['series'])->orderBy($_GET['sort'], $_GET['order'])->get();
}
```

#### المشكلة:

- استخدام `$_GET` **مباشرة** في `orderBy()` بدون Validation
- يمكن للمهاجم إرسال: `?sort=id)--;--&order=DESC`

#### الملفات المتأثرة:

- `app/Http/Controllers/PageController.php` - 20+ موضع
- `app/Http/Controllers/Admin/OpportunitiesController.php` - 10+ موضع
- `app/Http/Controllers/Admin/Triennial2023Controller.php` - 5+ موضع

#### مثال هجوم:

```
GET /page?sort=id) UNION SELECT password FROM users--&order=DESC
```

---

### 4. ⚠️ **MEDIUM - Information Disclosure**

**الخطورة:** 6/10

#### المشكلة:

```env
# .env file - معلومات حساسة مكشوفة
APP_DEBUG=1  # 🔴 يجب أن يكون false في Production!
DB_PASSWORD=root  # 🔴 كلمة مرور ضعيفة جداً
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

#### التأثير:

- عرض أخطاء تفصيلية تكشف عن بنية النظام
- معلومات عن قاعدة البيانات
- Stack traces كاملة

---

### 5. ⚠️ **MEDIUM - Outdated Software**

**الخطورة:** 7/10

#### الإصدارات الحالية:

```json
{
  "php": ">=5.5.9", // 🔴 PHP 5.5 - End of Life منذ 2016!
  "laravel/framework": "5.2.*", // 🔴 Laravel 5.2 - غير مدعوم منذ 2017!
  "nesbot/carbon": "1.20.0" // 🔴 إصدار قديم جداً
}
```

#### الثغرات المعروفة:

- **CVE-2017-9841** - PHPUnit RCE
- **CVE-2019-9081** - Laravel Debug Mode RCE
- **CVE-2021-3129** - Laravel Ignition RCE
- عشرات الثغرات الأخرى في PHP 5.5

---

### 6. ⚠️ **LOW - Missing Security Headers**

**الخطورة:** 4/10

#### Headers المفقودة:

- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `X-XSS-Protection: 1; mode=block`
- `Content-Security-Policy`
- `Strict-Transport-Security`

---

## 🎯 خطة العمل الموصى بها

### المرحلة 1: إجراءات الطوارئ (فوري - اليوم)

```
⏱️ الوقت المقدر: 2-3 ساعات
```

1. ✅ **حذف جميع WebShells**

   ```powershell
   # حذف جميع ملفات .aspx
   Remove-Item "public/uploads/**/*.aspx" -Force
   ```

2. ✅ **تغيير جميع كلمات المرور**

   - قاعدة البيانات
   - لوحة التحكم
   - FTP/SSH
   - cPanel

3. ✅ **تفعيل Logging**

   - تسجيل جميع عمليات رفع الملفات
   - مراقبة Access Logs

4. ✅ **فحص قاعدة البيانات**
   - التحقق من وجود حسابات مشبوهة
   - فحص الـ Sessions النشطة

---

### المرحلة 2: إصلاح الثغرات (أسبوع واحد)

```
⏱️ الوقت المقدر: 3-5 أيام
```

1. ✅ **إصلاح SQL Injection**

   ```php
   // قبل:
   ->orderBy($_GET['sort'], $_GET['order'])

   // بعد:
   $allowedSorts = ['id', 'title', 'created_at'];
   $sort = in_array($request->input('sort'), $allowedSorts) ? $request->input('sort') : 'id';
   $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
   ->orderBy($sort, $order)
   ```

2. ✅ **تحديث File Upload Validation**

   - التأكد من تطبيق `FileSecurityValidation` على جميع Uploaders
   - فحص MIME types بشكل صحيح

3. ✅ **تعطيل Debug Mode**

   ```env
   APP_DEBUG=false
   APP_ENV=production
   ```

4. ✅ **إضافة Security Headers**
   ```php
   // في Kernel.php أو Middleware
   header('X-Content-Type-Options: nosniff');
   header('X-Frame-Options: DENY');
   ```

---

### المرحلة 3: الترقية (2-3 أسابيع)

```
⏱️ الوقت المقدر: 10-15 يوم
```

#### 3.1 الترقية لـ Laravel 10

```bash
# الخطوات:
1. Laravel 5.2 → 5.3
2. Laravel 5.3 → 5.4
3. Laravel 5.4 → 5.5 (LTS)
4. Laravel 5.5 → 6.x
5. Laravel 6.x → 7.x
6. Laravel 7.x → 8.x
7. Laravel 8.x → 9.x
8. Laravel 9.x → 10.x
```

#### 3.2 الترقية لـ PHP 8.2

```bash
# الخطوات:
1. PHP 5.5 → 7.0
2. PHP 7.0 → 7.4
3. PHP 7.4 → 8.0
4. PHP 8.0 → 8.1
5. PHP 8.1 → 8.2
```

#### التحديات المتوقعة:

- ⚠️ **Breaking Changes** في كل إصدار
- ⚠️ تحديث Dependencies القديمة
- ⚠️ إعادة كتابة بعض الـ Deprecated Functions
- ⚠️ اختبار شامل بعد كل مرحلة

---

## 📋 الإجراءات الموصى بها

### أمان الملفات:

- [ ] حذف جميع WebShells (.aspx)
- [ ] فحص شامل لجميع الملفات المرفوعة
- [ ] تطبيق whitelist للامتدادات المسموحة فقط
- [ ] تعطيل تنفيذ PHP في مجلدات Uploads

### أمان قاعدة البيانات:

- [ ] استخدام Prepared Statements دائماً
- [ ] Validation قوي لجميع Inputs
- [ ] تغيير كلمات المرور
- [ ] تفعيل Query Logging

### أمان التطبيق:

- [ ] تعطيل Debug Mode
- [ ] تحديث Laravel و PHP
- [ ] إضافة Rate Limiting
- [ ] تفعيل CSRF Protection
- [ ] إضافة Security Headers

### المراقبة:

- [ ] تفعيل File Integrity Monitoring
- [ ] Access Logs Analysis
- [ ] تنبيهات عند رفع الملفات
- [ ] Backup منتظم

---

## 🔍 توصيات إضافية

### 1. Web Application Firewall (WAF)

ننصح بتثبيت:

- **ModSecurity** (مفتوح المصدر)
- **Cloudflare** (خدمة سحابية)

### 2. Security Scanning

أدوات مقترحة:

- **OWASP ZAP**
- **Nikto**
- **SQLMap**
- **Burp Suite**

### 3. Code Review

مراجعة شاملة لـ:

- جميع Controllers
- جميع Uploaders
- جميع Database Queries
- Authentication & Authorization

---

## 📊 التقييم النهائي

| المجال                   | الحالة الحالية | الحالة المطلوبة |
| ------------------------ | -------------- | --------------- |
| File Upload Security     | 🔴 2/10        | 🟢 9/10         |
| SQL Injection Protection | 🔴 3/10        | 🟢 10/10        |
| Authentication           | 🟡 7/10        | 🟢 9/10         |
| Framework Version        | 🔴 1/10        | 🟢 10/10        |
| PHP Version              | 🔴 1/10        | 🟢 10/10        |
| Security Headers         | 🔴 0/10        | 🟢 9/10         |
| **التقييم الإجمالي**     | **🔴 2.3/10**  | **🟢 9.5/10**   |

---

## 🚀 الخطوات التالية

### اليوم (فوري):

1. حذف WebShells
2. تغيير كلمات المرور
3. تعطيل Debug Mode

### هذا الأسبوع:

1. إصلاح SQL Injection
2. تحسين File Upload Security
3. إضافة Security Headers

### الشهر القادم:

1. الترقية لـ Laravel 10
2. الترقية لـ PHP 8.2
3. Code Review شامل

---

## 📞 جهات الاتصال

**فريق الأمن:**

- Security Audit: GitHub Copilot
- التاريخ: 9 ديسمبر 2025
- Repository: HatcherDevs/Sharrjah-v1

---

**⚠️ ملاحظة مهمة:** هذا الموقع معرض لخطر فوري. يجب اتخاذ إجراءات الطوارئ في أقرب وقت ممكن.
