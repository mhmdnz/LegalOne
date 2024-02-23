FROM php:8.0-fpm

WORKDIR /var/www/html/LegalOne

RUN apt-get update

RUN apt-get install zip unzip

CMD chmod +x /var/www/html/LegalOne/php/FreshMigrations.sh
CMD chmod +x /var/www/html/LegalOne/php/RunTests.sh
CMD chmod +x /var/www/html/LegalOne/php/Prepration.sh
CMD chmod +x /var/www/html/LegalOne/php/ComposerInstall.sh
CMD chmod +x /var/www/html/LegalOne/php/setup-elasticsearch.sh
