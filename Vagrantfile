# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

@script = <<SCRIPT

sudo su

# Dependencies
add-apt-repository ppa:ondrej/php
apt-get update
apt-get install software-properties-common
apt-get install -y apache2 git curl php7.1 php7.1-bcmath php7.1-bz2 php7.1-cli php7.1-curl php7.1-intl \
    php7.1-json php7.1-mbstring php7.1-opcache php7.1-soap php7.1-sqlite3 php7.1-xml php7.1-xsl php7.1-zip \
    libapache2-mod-php7.1 postgresql-9.5 php7.1-pgsql php7.1-fpm php7.1-xdebug


# PostgreSQL
DB_NAME=home_todo_tasks
DB_USERNAME=pg_user
DB_PASSWORD=pg_pass
DB_HOST=localhost

sudo -u postgres psql -c "ALTER USER postgres with encrypted password 'postgres'" -U postgres
sudo -u postgres psql -c "CREATE ROLE "$DB_USERNAME" CREATEDB CREATEUSER LOGIN Encrypted PASSWORD '$DB_PASSWORD';" -U postgres
service postgresql restart
sudo -u postgres psql -c "CREATE DATABASE \"$DB_NAME\"  WITH OWNER \"$DB_USERNAME\";" -U postgres

cp /var/www/vagrant/pg_hba.conf /etc/postgresql/9.5/main/
cp /var/www/vagrant/postgresql.conf /etc/postgresql/9.5/main/


# MongoDB
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 0C49F3730359A14518585931BC711F9BA15703C6
echo "deb [ arch=amd64,arm64 ] http://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.4 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.4.list
apt-get update
apt-get install -y mongodb-org

cp /var/www/vagrant/mongod.conf /etc/
service mongod start

mkdir -p /data/db

mongod --port 27017 --fork --logpath /var/log/mongodb.log
mongo --port 27017 < /var/www/vagrant/mongodb_admin.js
mongod --shutdown

mongod --auth --port 27017 --fork --logpath /var/log/mongodb.log
mongo --port 27017 -u "mongodb_admin" -p "mongodb_pass" --authenticationDatabase "admin" < /var/www/vagrant/mongodb_user.js


# FPM
echo Listen=127.0.0.1:9000 >> /etc/php/7.1/fpm/pool.d/www.conf


# Xdebug
echo "xdebug.remote_enable = on" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_connect_back = on" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.idekey = \"vagrant\"" >> /etc/php/7.1/mods-available/xdebug.ini
echo "xdebug.remote_autostart = on" >> /etc/php/7.1/mods-available/xdebug.ini


# Restart services
service postgresql restart
service mongod restart
service php7.1-fpm restart
service apache2 restart


# Configure Apache
echo '<VirtualHost *:80>
	DocumentRoot /var/www/public
	AllowEncodedSlashes On

	<Directory /var/www/public>
		Options +Indexes +FollowSymLinks
		DirectoryIndex index.php index.html
		Order allow,deny
		Allow from all
		AllowOverride All
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

a2enmod rewrite
service apache2 restart

if [ -e /usr/local/bin/composer ]; then
    /usr/local/bin/composer self-update
else
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi


# Reset home directory of vagrant user
if ! grep -q "cd /var/www" /home/vagrant/.profile; then
    echo "cd /var/www" >> /home/vagrant/.profile
fi


echo "** [ZF] Run the following command to install dependencies, if you have not already:"
echo "    vagrant ssh -c 'composer install'"
echo "** [ZF] Visit http://localhost:8080 in your browser for to view the application **"
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = 'bento/ubuntu-16.04'
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 5432, host: 5432, host_ip: "127.0.0.1"
  config.vm.network "forwarded_port", guest: 27017, host: 27117
  config.vm.synced_folder '.', '/var/www'
  config.vm.provision 'shell', inline: @script

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--name", "ZF Application - Ubuntu 16.04"]
  end
end
