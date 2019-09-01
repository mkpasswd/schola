## MySQL DB schola database creation
DROP TABLE IF EXISTS adh;
CREATE TABLE IF NOT EXISTS adh (
	id INT AUTO_INCREMENT,
	## probably insecure for crypto specialists 
	## unavailable in mySQL<8, see trigger to deal with that
	## akey VARCHAR(32) default (md5(concat(rand(),rand()))),
	akey VARCHAR(32) NULL default NULL,
	sn VARCHAR(128) default '',
	givenName VARCHAR(128) default '',
	mail VARCHAR(128) default '',
	category VARCHAR(32) default '',
	isAdmin BOOLEAN default false,
	jsonVals JSON,
	createTS TIMESTAMP default current_timestamp,
	modifyTS TIMESTAMP default current_timestamp on update current_timestamp,
	lastCallTS TIMESTAMP NULL,
	lastUserModTS TIMESTAMP NULL,
	PRIMARY KEY (id)
	);
ALTER TABLE adh auto_increment=1024;
CREATE INDEX adhmail ON adh (mail);
CREATE TRIGGER adhinsert
BEFORE INSERT ON adh
FOR EACH ROW
    SET NEW.akey = ifnull(NEW.akey,md5(concat(rand(),rand())));
##
## bootstrap root user creation
## to be deleted once a real admin user is set
INSERT into adh set id=0,sn='root',givenName='square',mail='nope',akey='tagada',isadmin=true;
##
## multi attrs table. Not used
## CREATE TABLE IF NOT EXISTS adhattrs (
	## idaa INT AUTO_INCREMENT,
	## adh INT default=0,
	## value VARCHAR(32) default='DUH'
	## PRIMARY KEY (idaa)
	## );
## CREATE INDEX aaval ON adhattrs (value);
## CREATE INDEX aaaval ON adhattrs (adh,value);

