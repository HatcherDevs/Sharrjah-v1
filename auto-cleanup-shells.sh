#!/bin/bash
# Auto Shell Cleaner Script with Telegram Alerts
# يبحث ويمسح web shells تلقائياً ويرسل تنبيهات

LOG_FILE="/home/u367625671/websites/rZAXlsj79/public_html/shell-cleanup.log"
DATE=$(date '+%Y-%m-%d %H:%M:%S')

# إعدادات Telegram
TELEGRAM_BOT_TOKEN="8408094939:AAEDNvEepP0VBwn9B_pXQR6cAxliVoY8C1Q"
TELEGRAM_CHAT_ID="1439229117"

# دالة لإرسال رسالة عبر Telegram
send_telegram() {
    local message="$1"
    curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
        -d chat_id="${TELEGRAM_CHAT_ID}" \
        -d text="${message}" \
        -d parse_mode="Markdown" > /dev/null 2>&1
}

echo "[$DATE] ===== Starting Shell Cleanup =====" | tee -a "$LOG_FILE"

# البحث عن الملفات المصابة
INFECTED_FILES=$(grep -rl -E "(Pernah waras|kamunanya|ensure_csrf|__asli_authed)" ~/domains --include="*.php" 2>/dev/null)

# عدد الملفات
COUNT=$(echo "$INFECTED_FILES" | grep -v '^$' | wc -l)

if [ "$COUNT" -eq 0 ]; then
    echo "[$DATE] ✅ No infected files found. System clean!" | tee -a "$LOG_FILE"
    # لا ترسل شيء على Telegram
    exit 0
fi

echo "[$DATE] 🚨 Found $COUNT infected file(s):" | tee -a "$LOG_FILE"

# بداية رسالة Telegram
TELEGRAM_MSG="🚨 *Shell Cleanup Alert*
\`[$DATE]\`

Found *${COUNT}* infected file(s):

"

DELETED_COUNT=0
FAILED_COUNT=0

# Loop على كل ملف وحذفه
while IFS= read -r file; do
    if [ -n "$file" ] && [ -f "$file" ]; then
        echo "[$DATE] Deleting: $file" | tee -a "$LOG_FILE"
        
        # إضافة للرسالة
        TELEGRAM_MSG="${TELEGRAM_MSG}🗑️ Deleting:
\`${file}\`

"
        
        # حذف الملف
        rm -f "$file"
        
        if [ $? -eq 0 ]; then
            echo "[$DATE] ✅ Deleted successfully: $file" | tee -a "$LOG_FILE"
            TELEGRAM_MSG="${TELEGRAM_MSG}✅ Deleted successfully

"
            DELETED_COUNT=$((DELETED_COUNT + 1))
        else
            echo "[$DATE] ❌ Failed to delete: $file" | tee -a "$LOG_FILE"
            TELEGRAM_MSG="${TELEGRAM_MSG}❌ Failed to delete

"
            FAILED_COUNT=$((FAILED_COUNT + 1))
        fi
        
        # فاصل بين الملفات
        TELEGRAM_MSG="${TELEGRAM_MSG}---

"
        
    fi
done <<< "$INFECTED_FILES"

# تحقق نهائي
REMAINING=$(grep -rl -E "(Pernah waras|kamunanya|ensure_csrf|__asli_authed)" /home/u367625671/websites/rZAXlsj79/public_html --include="*.php" 2>/dev/null | wc -l)

echo "[$DATE] ===== Cleanup Complete =====" | tee -a "$LOG_FILE"
echo "[$DATE] Remaining infected files: $REMAINING" | tee -a "$LOG_FILE"

# إنهاء رسالة Telegram
TELEGRAM_MSG="${TELEGRAM_MSG}*===== Cleanup Complete =====*

📊 *Summary:*
✅ Deleted: ${DELETED_COUNT}
❌ Failed: ${FAILED_COUNT}
⚠️ Remaining: ${REMAINING}

"

# الحالة النهائية
if [ "$REMAINING" -eq 0 ]; then
    TELEGRAM_MSG="${TELEGRAM_MSG}✅ All shells removed successfully! 🛡️"
    echo "[$DATE] ✅ All shells removed successfully!" | tee -a "$LOG_FILE"
else
    TELEGRAM_MSG="${TELEGRAM_MSG}⚠️ Warning: ${REMAINING} file(s) still infected!
🔴 Manual intervention required!"
    echo "[$DATE] ⚠️  Warning: $REMAINING file(s) still infected!" | tee -a "$LOG_FILE"
fi

# إرسال الرسالة فقط لو لقى وحذف ملفات
# لو الرسالة طويلة (أكثر من 4000 حرف)، قسمها
if [ ${#TELEGRAM_MSG} -gt 4000 ]; then
    # إرسال ملخص مختصر
    SHORT_MSG="🚨 *Shell Cleanup Alert*
\`[$DATE]\`

Found *${COUNT}* infected file(s)

"
    
    # أول 5 ملفات فقط
    FILE_COUNTER=0
    while IFS= read -r file; do
        if [ -n "$file" ] && [ $FILE_COUNTER -lt 5 ]; then
            SHORT_MSG="${SHORT_MSG}\`${file}\`
"
            FILE_COUNTER=$((FILE_COUNTER + 1))
        fi
    done <<< "$INFECTED_FILES"
    
    if [ "$COUNT" -gt 5 ]; then
        SHORT_MSG="${SHORT_MSG}
... and $((COUNT - 5)) more files

"
    fi
    
    SHORT_MSG="${SHORT_MSG}
*===== Cleanup Complete =====*

📊 *Summary:*
✅ Deleted: ${DELETED_COUNT}
❌ Failed: ${FAILED_COUNT}
⚠️ Remaining: ${REMAINING}

"
    
    if [ "$REMAINING" -eq 0 ]; then
        SHORT_MSG="${SHORT_MSG}✅ All shells removed successfully! 🛡️"
    else
        SHORT_MSG="${SHORT_MSG}⚠️ Warning: ${REMAINING} file(s) still infected!
🔴 Manual intervention required!"
    fi
    
    send_telegram "$SHORT_MSG"
else
    send_telegram "$TELEGRAM_MSG"
fi

exit 0
