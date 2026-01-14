# تعليمات النشر على السيرفر

## حل مشكلة 403 Forbidden للصور

إذا واجهت خطأ 403 Forbidden عند محاولة الوصول إلى الصور من مجلد `storage` على السيرفر الخارجي، اتبع الخطوات التالية:

### 1. إنشاء الرابط الرمزي (Symbolic Link)

```bash
php artisan storage:link
```

هذا الأمر ينشئ رابط رمزي من `public/storage` إلى `storage/app/public`

### 2. التحقق من وجود الرابط

```bash
ls -la public/storage
```

يجب أن ترى:
```
storage -> /path/to/your/project/storage/app/public
```

### 3. تعديل الصلاحيات

```bash
# إعطاء صلاحيات القراءة للمجلدات
chmod -R 755 storage
chmod -R 755 public/storage

# إعطاء صلاحيات القراءة للملفات
chmod -R 644 storage/app/public/sliders/*
```

### 4. التأكد من وجود المجلدات

```bash
mkdir -p storage/app/public/sliders
```

### 5. إذا لم يعمل الأمر تلقائياً، أنشئ الرابط يدوياً

```bash
# احذف الرابط القديم إن وجد
rm public/storage

# أنشئ رابط جديد
ln -s /path/to/your/project/storage/app/public /path/to/your/project/public/storage
```

**مثال:**
```bash
ln -s /var/www/html/loutes/storage/app/public /var/www/html/loutes/public/storage
```

### 6. التأكد من صلاحيات مستخدم الويب

تأكد من أن مستخدم الويب (www-data, nginx, apache) لديه صلاحيات القراءة:

```bash
# إذا كان المستخدم www-data
chown -R www-data:www-data storage
chown -R www-data:www-data public/storage

# أو إذا كان nginx
chown -R nginx:nginx storage
chown -R nginx:nginx public/storage
```

### 7. اختبار الوصول

بعد تنفيذ الخطوات السابقة، جرب الوصول إلى:
```
https://lotus-co.com/storage/sliders/banner1.png
```

### ملاحظات مهمة:

1. **تأكد من رفع الملفات:** تأكد من رفع جميع الملفات من `storage/app/public/sliders/` إلى السيرفر
2. **الصلاحيات:** يجب أن تكون الصلاحيات 755 للمجلدات و 644 للملفات
3. **المالك:** يجب أن يكون مالك الملفات هو مستخدم الويب (www-data أو nginx)

### استكشاف الأخطاء:

إذا استمرت المشكلة:

1. تحقق من سجلات الأخطاء:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. تحقق من إعدادات Nginx/Apache:
   - تأكد من أن `public` هو Document Root
   - تأكد من عدم وجود قواعد تمنع الوصول إلى `storage`

3. تحقق من `.htaccess` (إذا كنت تستخدم Apache):
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^storage/(.*)$ storage/$1 [L]
   </IfModule>
   ```
