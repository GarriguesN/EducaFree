TODO // Permitir archivos
//* En la ruta del poryecto *//
php artisan cache:clear
php artisan config:clear

chown -R $USER:www-data storage
chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 755 bootstrap/cache

service apache2 restart
Segundo paso
chown -R www-data:www-data *
usermod -a -G www-data ubuntu
find /var/www/html/EducaFree -type f -exec chmod 644 {} \;   
find /var/www/html/EducaFree -type d -exec chmod 755 {} \;   
Tercer paso
Borrar si hay una carpeta anterior //
php artisan storage:link
chmod -R 775 storage/app/public
chmod -R 775 public/storage
chown -R www-data:www-data storage/app/public
chown -R www-data:www-data public/storage



Nacho Garrigues
  09:13
to use npm run dev && npm run build
npm install -g vite
