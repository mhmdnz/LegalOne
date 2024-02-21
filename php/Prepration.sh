cd /var/www/html/snappfood
composer install
php artisan key:generate
php artisan migrate:fresh --seed
cronjob="* * * * * cd /var/www/html/snappfood && php artisan schedule:run >> /dev/null 2>&1"
(crontab -u root -l; echo "$cronjob" ) | crontab -u root -
crond
