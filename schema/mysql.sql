create table if not exists `page`
(
	`id` int(10) not null auto_increment,
	`alias` varchar(200) default null,
	`title` varchar(100) default null,
	`active` tinyint(1) default 1,
	`modifyDate` datetime,
	`text` text,
	primary key (`id`),
	key `alias` (`alias`)
) engine InnoDB;
