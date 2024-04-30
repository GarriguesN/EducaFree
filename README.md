<h2>TODO List</h2>

<h3>Step 1: Clear Cache and Set Permissions</h3>

<p>In the root directory of your project, run the following commands to clear cache and set the correct permissions:</p>

<pre><code>
# Clear cache and configuration
php artisan cache:clear
php artisan config:clear

# Set owner and permissions for storage and bootstrap/cache directories
chown -R $USER:www-data storage
chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 755 bootstrap/cache

# Restart Apache service
service apache2 restart
</code></pre>

<h3>Step 2: Update File and Directory Permissions</h3>

<p>To ensure proper permissions for your project, update the owner and group to <code>www-data</code> for all files and directories. Additionally, set appropriate file and directory permissions:</p>

<pre><code>
# Change owner and group to www-data for all files and directories
chown -R www-data:www-data *

# Add the user to the www-data group
usermod -a -G www-data ubuntu

# Set file permissions to 644 and directory permissions to 755
find /var/www/html/EducaFree -type f -exec chmod 644 {} \;
find /var/www/html/EducaFree -type d -exec chmod 755 {} \;
</code></pre>

<h3>Step 3: Create Storage Link and Update Permissions</h3>

<p>If there is no previous storage link, create one and set the necessary permissions for the storage directories:</p>

<pre><code>
# Create storage link and set permissions
php artisan storage:link

# Set permissions for storage directories
chmod -R 775 storage/app/public
chmod -R 775 public/storage

# Change owner and group to www-data for storage directories
chown -R www-data:www-data storage/app/public
chown -R www-data:www-data public/storage
</code></pre>

<h3>Running Development and Production Builds</h3>

<p>To use development and production builds, you need to install the required packages and run the appropriate commands:</p>

<pre><code>
# Install vite globally
npm install -g vite

# Run development build
npm run dev

# Run production build
npm run build
</code></pre>
