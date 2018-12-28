CREATE TABLE user(
id INTEGER AUTO_INCREMENT,
user_name VARCHAR(20) NOT NULL,
password VARCHAR(40) NOT NULL,
created_at DATETIME,
PRIMARY KEY(id),
UNIQUE KEY user_name_index(user_name)
) ENGING = INNODB;

CREATE TABLE following(
 user_id INTEGER,
 following_id INTEGER,
 PRIMARY KEY(user_id, following_id)
) ENGING = INNODB;

CREATE TABLE status(
 id INTEGER AUTO_INCREMENT,
 user_id INTEGER NOT NULL,
 body VARCHAR(255),
 created_at DATETIME,
 PRIMARY KEY(id),
 INDEX user_id_index(user_id)
)  ENGING = INNODB;

ALTER TABLE following ADD FOREIGN KEY(user_id) REFERECES user(id);
ALTER TABLE following ADD FOREIGN KEY(following_id) REFERECES user(id);
ALTER TABLE status ADD FOREIGN KEY (user_id) REFERECES user(id);
