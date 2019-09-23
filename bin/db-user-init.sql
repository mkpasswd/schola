## MySQL DB user an database creation
## of course to be modified to fit your MySQL server
## this should at least work for a purely local installation
create user 'schola'@'localhost' identified by 'tooeasytoguess';
create database schola default character set utf8;
grant all privileges on schola.* to 'schola'@'localhost';
