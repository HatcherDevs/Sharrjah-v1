#!/bin/bash

# تعريف المسارات والمتغيرات
REPO_PATH="/home/u211620568/domains/sharjaharchitecture.org/public_html"
BRANCH="live"
REMOTE="origin"
LOG_FILE="/home/u211620568/git-sat-cleanup.log"

# دخول مجلد الريبو
cd "$REPO_PATH" || exit 1

# تسجيل العملية
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting Git cleanup..." >> "$LOG_FILE"

# جلب أحدث التحديثات
git fetch $REMOTE $BRANCH

# الخطوة 1: استعادة الملفات المعدلة (tracked files)
git restore .

# الخطوة 2: حذف الملفات الجديدة (untracked files)
git clean -fd

# الخطوة 3: مسح الملفات المتجاهلة إذا كان فيه محاولة
git clean -fdx

# الخطوة 4: إعادة تعيين HEAD لآخر commit
git reset --hard $REMOTE/$BRANCH

# تسجيل النجاح
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Git cleanup completed successfully" >> "$LOG_FILE"
echo "---" >> "$LOG_FILE"
