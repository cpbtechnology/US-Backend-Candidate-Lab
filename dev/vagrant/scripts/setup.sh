#!/usr/bin/env bash



####################################
# UPDATE EVERYTHING
####################################

yum -y update



####################################
# ADD EPEL REPO 
# (Extra Packages for Enterprise Linux)
####################################

if [ "$(uname -m | grep '64')" != "" ]; then 
	epel_repo_url="http://epel.mirror.constant.com/6/x86_64/epel-release-6-8.noarch.rpm"
else
	epel_repo_url="http://epel.mirror.constant.com/6/i386/epel-release-6-8.noarch.rpm"
fi

rpm --upgrade --hash --verbose $epel_repo_url



####################################
# ADD REMI REPO
# (For PHP & MYSQL)
####################################

rpm --upgrade --hash --verbose http://rpms.famillecollet.com/enterprise/remi-release-6.rpm



####################################
# INSTALL NAMESERVER CACHE DAEMON
####################################

yum -y install nscd
service nscd start



####################################
# INCREASE MAX OPEN FILES
####################################

echo "* soft nofile 100000" >> /etc/security/limits.conf
echo "* hard nofile 100000" >> /etc/security/limits.conf

ulimit -n 100000



####################################
# CREATE WWW USER AND GROUP
####################################
# perl -e 'print crypt("password", "salt"),"\n"'

useradd www -p "laTrl/7uzuSZM" # encrypted pass



####################################
# INSTALL NGINX 1.6 (1.6.0-2.el6.ngx)
####################################

# Add latest stable nginx package
rpm --upgrade --hash --verbose http://nginx.org/packages/centos/6/noarch/RPMS/nginx-release-centos-6-0.el6.ngx.noarch.rpm

yum -y --enablerepo=nginx install nginx

# move over nginx server blocks
cp /vagrant/nginx/nginx.conf /etc/nginx/nginx.conf
cp /vagrant/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf



####################################
# INSTALL MYSQL 5.5 (5.5.38-1.el6.remi)
####################################

yum -y --enablerepo=remi install mysql mysql-server



####################################
# INSTALL PHP FPM 5.5 (5.5.15-1.el6.remi)
#
# php-fpm 
# php-common (CURL, fileinfo, JSON, phar, zip)
# php-mysqlnd (MySQL native driver)
# php-pdo (PDO will use mysqlnd)
# php-mbstring (multibyte string extension)
# php-mcrypt (encryption extension - required by laravel)
# php-pecl-apcu (APCU object cache)
# php-opcache (zend opcache)
####################################

yum -y --enablerepo=remi,remi-php55 install php-fpm php-common php-mysqlnd php-pdo php-mbstring php-mcrypt php-pecl-apcu php-opcache

# change php-fpm user & group to www
sed -i 's/apache/www/g' /etc/php-fpm.d/www.conf



####################################
# SETUP APP DIRECTORIES
####################################

# Create dir for api
mkdir -p /var/www/

# Change the ownership of everything under /var/www to www:www
chown -R www:www /var/www

# Change the permissions of all the folders to 2775
# 6=set user and group id, 7=rwx for owner (www), 7=rwx for group (www), 5=rx for world
find /var/www -type d -exec chmod 6775 {} +

# Change permissions for all files to 0664
# 6=rw for owner (www), 6=rw for group (www), 4=r for world
find /var/www -type f -exec chmod 0664 {} +



####################################
# START SERVICES
####################################

service mysqld start
service php-fpm start
service nginx start

chkconfig mysqld on
chkconfig php-fpm on
chkconfig nginx on



####################################
# SETUP MYSQL DATABASE
####################################

mysql -u root -e 'CREATE DATABASE `api` DEFAULT CHARACTER SET `utf8`;'

# Create Tables
cd /var/www/api && php artisan migrate

# Seed Database
cd /var/www/api && php artisan db:seed