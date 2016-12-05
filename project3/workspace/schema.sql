DROP DATABASE IF EXISTS cheapo;
CREATE DATABASE cheapo;
USE cheapo;



CREATE TABLE `User`(
`id` int(11) NOT NULL auto_increment,
`firstname` char(40) NOT NULL,
`lastname` char(40) NOT NULL,
`username` char(20) NOT NULL,
`password` char(40) NOT NULL,
PRIMARY KEY  (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8;



CREATE TABLE `Message`(
`id` int(11) NOT NULL auto_increment,
`recipient_ids`int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`subject` char(60) NOT NULL,
`body` char(1000) NOT NULL,
`date_sent` date,
PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8;



CREATE TABLE `Message_read`(
`id` int(11) NOT NULL auto_increment,
`message_id` int(40),
`reader_id` int(40),
`message_date` date,
PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8;