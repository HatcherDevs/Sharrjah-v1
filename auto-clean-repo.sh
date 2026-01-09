#!/bin/bash

REPO_PATH="/home/u367625671/websites/rZAXlsj79/public_html"
LOG_FILE="/home/u367625671/websites/rZAXlsj79/public_html/git-sat-cleanup.log"

cd "$REPO_PATH" || exit 1

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Starting Git cleanup..." >> "$LOG_FILE"

# حذف الملفات الجديدة (untracked) فقط - مع استثناء المجلدات المهمة
git clean -fd 
# استعادة الملفات المعدلة من آخر commit في master
git checkout -- . 2>/dev/null || true

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Git cleanup completed successfully" >> "$LOG_FILE"
echo "---" >> "$LOG_FILE"
