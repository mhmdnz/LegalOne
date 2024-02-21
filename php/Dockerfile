FROM php:8.0-fpm

WORKDIR /var/www/html/LegalOne

RUN apt-get update

RUN apt-get install zip unzip

ADD FreshMigrations.sh /tmp/FreshMigrations.sh
RUN chmod 777 /tmp/FreshMigrations.sh

ADD RunTests.sh /tmp/RunTests.sh
RUN chmod 777 /tmp/RunTests.sh

ADD Prepration.sh /tmp/Prepration.sh
RUN chmod 777 /tmp/Prepration.sh

ADD ComposerInstall.sh /tmp/ComposerInstall.sh
RUN chmod 777 /tmp/ComposerInstall.sh
