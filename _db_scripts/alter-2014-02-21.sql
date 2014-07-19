#http://www.aryahelp.com/greencomet/in-person-task.html
#http://www.aryahelp.com/greencomet/instant-task.html
#http://www.aryahelp.com/greencomet/instant-task-mapview.html 
#http://www.aryahelp.com/greencomet/virtual-task.html
#http://www.aryahelp.com/greencomet/instant-task-mapview.html 
CREATE TABLE IF NOT EXISTS `gc_mst_skill`(
`skill_id` int(11) NOT NULL AUTO_INCREMENT,
`category_id` int(11) NOt NULL,
PRIMARY KEY(`skill_id`),
CONSTRAINT `fk_skill_category_id` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gc_mst_skill_locale`(
`skill_id` int(11) NOT NULL,
`language_code` varchar(5) NOt NULL,
`skill_desc` varchar(40) NOt NULL,
PRIMARY KEY (`skill_id`,`language_code`),
CONSTRAINT `fk_skill_locale_skill_id` FOREIGN KEY (`skill_id`) REFERENCES `gc_mst_skill` (`skill_id`) ON UPDATE CASCADE,
CONSTRAINT `fk_skill_locale_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gc_dta_task_location`(
id bigint(20) NOT NULL AUTO_INCREMENT,
task_id bigint(20) NOT NULL,
is_location_region char(1) 
region_id int(11),
country_code varchar(2)
location_longitude varchar(30),
location_latitude varchar(30),
location_geo_area varchar(100),
PRIMARY KEY (`id`),
CONSTRAINT `fk_task_location_region_id` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE,
CONSTRAINT `fk_task_location_country_code` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
CONSTRAINT `fk_task_location_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create index idx_gc_dta_task_location_region_id on gc_dta_task_location(region_id);
create index idx_gc_dta_task_location_country_code on gc_dta_task_location(country_code);
create index idx_gc_dta_task_location_location_latlong on gc_dta_task_location(location_longitude, location_latitude);


CREATE TABLE IF NOT EXISTS `gc_dta_task_question`(
task_id bigint(20) NOT NULL,
question_id	bigint(20) NOT NULL,
PRIMARY KEY (`task_id`, `question_id`),
CONSTRAINT `fk_task_question_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
CONSTRAINT `fk_task_question_question_id` FOREIGN KEY (`question_id`) REFERENCES `gc_mst_category_question` (`question_id`) ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `gc_dta_task_skill`(
`skill_id` int(11) NOT NULL AUTO_INCREMENT,
`task_id` bigint(20) NOt NULL,
PRIMARY KEY(`task_id`, `skill_id`),
CONSTRAINT `fk_task_skill_skill_id` FOREIGN KEY (`skill_id`) REFERENCES `gc_mst_skill` (`skill_id`) ON UPDATE CASCADE,
CONSTRAINT `fk_task_skill_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gc_dta_task_question_reply`(
`task_id` bigint(20) NOT NULL,
`tasker_id` bigint(20) NOt NULL,
`question_id` bigint(20) NOT NULL,
`reply_desc` varchar(2000),
`reply_yesno` char(1),
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
`updated_at` timestamp NOT NULL,
PRIMARY KEY(`task_id`, `tasker_id`, `question_id`),
CONSTRAINT `fk_task_question_reply_tasker_id` FOREIGN KEY (`tasker_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
CONSTRAINT `fk_task_question_reply_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task_question` (`task_id`) ON UPDATE CASCADE,
CONSTRAINT `fk_task_question_reply_question_id` FOREIGN KEY (`question_id`) REFERENCES `gc_dta_task_question` (`question_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





ALTER TABLE `gc_dta_task` DROP COLUMN location_region_id;
ALTER TABLE `gc_dta_task` DROP COLUMN location_street1;
ALTER TABLE `gc_dta_task` DROP COLUMN location_street2;
ALTER TABLE `gc_dta_task` DROP COLUMN location_country_code;
ALTER TABLE `gc_dta_task` DROP COLUMN location_state_id;
ALTER TABLE `gc_dta_task` DROP COLUMN location_city_id;
ALTER TABLE `gc_dta_task` DROP COLUMN location_zipcode;
ALTER TABLE `gc_dta_task` DROP COLUMN location_longitude;
ALTER TABLE `gc_dta_task` DROP COLUMN location_latitude;
ALTER TABLE `gc_dta_task` DROP COLUMN location_geo_area;
ALTER TABLE `gc_dta_task` DROP COLUMN is_location_region;





