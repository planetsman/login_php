create database login_php;
grant all on login_php.* to dbuser@localhost identified by 'Ku7+Lz9(';
use login_php
create table users (
 id int not null auto_increment primary key,
 email varchar(255) unique,
 password varchar(255),
 created datetime,
 modified datetime
);
desc users;