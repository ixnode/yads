# Use mariadb 10.6.3 image
FROM mariadb:10.6.3

# Adds mysqld.conf
ADD conf.d/mysqld.cnf /etc/mysql/conf.d/mysqld.cnf
