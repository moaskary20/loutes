# حل مشكلة 403 Forbidden للفيديوهات

## المشكلة
عند محاولة الوصول إلى الفيديوهات من السيرفر، يظهر خطأ:
```
GET https://lotus-co.com/storage/sliders/video1.mp4 net::ERR_ABORTED 403 (Forbidden)
```

## الحلول (نفذها على السيرفر)

### 1. إنشاء الرابط الرمزي (Symbolic Link)

```bash
cd /path/to/your/project
php artisan storage:link
```

### 2. التحقق من وجود الرابط

```bash
ls -la public/storage
```

يجب أن ترى:
```
storage -> /path/to/your/project/storage/app/public
```

### 3. تعديل الصلاحيات (مهم جداً!)

```bash
# إعطاء صلاحيات القراءة للمجلدات
chmod -R 755 storage
chmod -R 755 public/storage
chmod -R 755 storage/app/public
chmod -R 755 storage/app/public/sliders

# إعطاء صلاحيات القراءة للملفات (خاصة الفيديوهات)
chmod 644 storage/app/public/sliders/video1.mp4
chmod 644 storage/app/public/sliders/video2.mp4
chmod 644 storage/app/public/sliders/video3.mp4
chmod 644 storage/app/public/sliders/*.mp4
```

### 4. التأكد من صلاحيات مستخدم الويب

```bash
# إذا كان المستخدم www-data (Apache)
chown -R www-data:www-data storage
chown -R www-data:www-data public/storage
chown -R www-data:www-data storage/app/public/sliders

# أو إذا كان nginx
chown -R nginx:nginx storage
chown -R nginx:nginx public/storage
chown -R nginx:nginx storage/app/public/sliders
```

### 5. التحقق من إعدادات Nginx (إذا كنت تستخدم Nginx)

افتح ملف إعدادات Nginx وأضف:

```nginx
location /storage {
    alias /path/to/your/project/public/storage;
    try_files $uri $uri/ =404;
    
    # Allow video files
    location ~* \.(mp4|webm|ogg)$ {
        add_header Access-Control-Allow-Origin *;
        add_header Content-Type video/mp4;
    }
}
```

### 6. التحقق من إعدادات Apache (إذا كنت تستخدم Apache)

تأكد من أن ملف `.htaccess` في `public/` يحتوي على القواعد المضافة.

### 7. التأكد من رفع الملفات

تأكد من رفع جميع ملفات الفيديو إلى السيرفر:
- `storage/app/public/sliders/video1.mp4`
- `storage/app/public/sliders/video2.mp4`
- `storage/app/public/sliders/video3.mp4`

### 8. اختبار الوصول

بعد تنفيذ الخطوات السابقة، جرب الوصول مباشرة:
```
https://lotus-co.com/storage/sliders/video1.mp4
```

### 9. إذا استمرت المشكلة

#### أ. تحقق من سجلات الأخطاء:
```bash
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/error.log  # أو /var/log/apache2/error.log
```

#### ب. تحقق من SELinux (إذا كان مفعلاً):
```bash
# تعطيل SELinux مؤقتاً للاختبار
setenforce 0

# أو إضافة قاعدة SELinux:
chcon -R -t httpd_sys_content_t storage/app/public/sliders/
```

#### ج. تحقق من وجود ملف `.htaccess` في `public/storage/`:
إذا كان موجوداً، احذفه أو أضف:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine Off
</IfModule>
```

## ملاحظات مهمة:

1. **الصلاحيات:** يجب أن تكون 755 للمجلدات و 644 للملفات
2. **المالك:** يجب أن يكون مالك الملفات هو مستخدم الويب
3. **الرابط الرمزي:** يجب أن يكون موجوداً وصحيحاً
4. **رفع الملفات:** تأكد من رفع جميع ملفات الفيديو

## الأوامر السريعة (انسخ والصق):

```bash
# على السيرفر
cd /path/to/your/project
php artisan storage:link
chmod -R 755 storage public/storage storage/app/public
chmod 644 storage/app/public/sliders/*.mp4
chown -R www-data:www-data storage public/storage  # أو nginx:nginx
```
