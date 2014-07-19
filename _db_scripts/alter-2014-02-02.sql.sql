alter table gc_dta_user add column `profile_folder_name` varchar(10) DEFAULT null;
alter table gc_dta_user add column `instant_available` bit(1) DEFAULT 1;
#question_type value can be 'l' - for logical answer
#                           'v' - for online verification purpose
#                           'd' - for descriptive answer

#question_for value can be  'p' - for poster to provide answer under for category
#                           't' - for tasker to provide answer under for category
#                           'b' - for both poster and tasker to provide answer under for category

#is_answer_must - true means answer of this question is REQUIRED from the "question_for" column value basis. False means no

CREATE TABLE IF NOT EXISTS `gc_mst_category_question` (
  `question_id` bigint(20) NOT NULL AUTO_INCREMENT,
   PRIMARY KEY (`question_id`)
   )ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gc_mst_category_question_locale` (
  `category_id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `question_desc` varchar(2000) NOT NULL,
  `question_type` char(1) NOT NULL default 'l',
  `question_for` char(1) NOT NULL default 't',  
  `is_answer_must` bit(1) NOT NULL default b'0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NULL,
  `updated_at` timestamp NOT NULL,
  `updated_by` int(11) NULL,
  `status` char(1) default 'a',
  PRIMARY KEY (`category_id`,`language_code`,`question_id`),
  CONSTRAINT `fk_category_question_locale_category_id` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_category_question_locale_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  CONSTRAINT `fk_category_question_locale_question_id` FOREIGN KEY (`question_id`) REFERENCES `gc_mst_category_question` (`question_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_category_question_locale_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_category_question_locale_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  #to acces quetion desc based on language
  CREATE INDEX idx_gc_mst_category_question_locale_question_id on gc_mst_category_question_locale(question_id,language_code,category_id);

#creator_role - 't' tasker, 'p' poster
#creator_user_id - task is created by which user. In case of external task. User wants to add task posted or completed out side the Green Comet
#is_external_task - Is it external stask
#language_code - language of the task. 
#     DESIGN ASSUMPTION: One task will be posted in one language only by the poster
#state - 'o' - open for bid, 'c' - cancelled, 'a' assigned to tasker, 'f' finished, 'd' under dispute, 's' suspended.
#  Need to discuss on Status
# location_type 'r' preferred location type is Regions, 
#is_external true means Task is done out side Green Comet
#attachments is an ARRAY of JSON objects. E.g [{"type":"<attachment_type>", "file":"<filename>","upload_on":"<date of upload>"},
#                                              {"type":"<attachment_type>", "file":"<filename>","upload_on":"<date of upload>"}]
#                                         attachment_type can be 'p'- pdf, 'w' - word, 'a'- audio, 'v'-video, 'i' - image 
#work_hrs":"[{"day":"mon","hrs":"9-10,16-18"},{"day":"tue","hrs":"9-10,16-18"},..]"}
#  Need to discuss, do we need to match tasker stasfying the working days? If yes then we may have to maintain work_hrs in task and user in separate tables.
# price_currency - see http://www.countries-ofthe-world.com/world-currencies.html
#  To be discussed, do we need currency type. If no then how to handle meney tranfer in different countries like India, USA etc. Or price is always in USD?
# tasker_user_id can be same as creator_user_id
CREATE TABLE IF NOT EXISTS `gc_dta_task` (
  `task_id` bigint(20) NOT NULL AUTO_INCREMENT,  
  `creator_user_id` bigint(20) NOT NULL,  
  `creator_role` char(1) NOT NULL default 't',  
  `is_external` bit(1) NOT NULL default b'0',  
  `language_code` varchar(5) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(4000) NOT NULL,
  `state` varchar(2) default 'o',
  `price` DECIMAL(12,2),
  `price_currency` varchar(3) default 'USD',
  `is_location_region` bit(1) default b'1',
  `location_region_id` int(11),
  `location_street1` varchar(100),
  `location_street2` varchar(100),
  `location_country_code` varchar(4),
  `location_state_id` int(11),
  `location_city_id` int(11),  
  `location_zipcode` varchar(20) DEFAULT NULL,
  `is_public` bit(1) default b'1',
  `bid_start_dt` timestamp DEFAULT CURRENT_TIMESTAMP,
  `bid_close_dt` timestamp,
  `tasker_user_id` bigint(20),
  `task_finished_on` date,
  `rank` int(2),
  `attachments` varchar(1000),  
  `work_hrs` varchar(500),  
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL,
  `updated_by` bigint(20) NULL,
  `status` char(1) default 'a',
  PRIMARY KEY (`task_id`),
  CONSTRAINT `fk_gc_dta_task_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  CONSTRAINT `fk_gc_dta_task_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_gc_dta_task_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;

 #Index to see all the tasks posted in a language and in say in open statge
 CREATE INDEX idx1_gc_dta_task_language_code on gc_dta_task(`language_code`,`state`,`location_region_id`);
 #Index to see all the tasks related to poster. Also the number of task completed by a tasker for a poster
 CREATE INDEX idx2_gc_dta_task_creator_user_id on gc_dta_task(`creator_user_id`,`state`,`tasker_user_id`);
 #Index to see all the tasks related to tasker. Also the number of task completed by a tasker
 CREATE INDEX idx2_gc_dta_task_tasker_user_id on gc_dta_task(`tasker_user_id`,`state`,`creator_user_id`);


#category_id - under which main category the task is posted
#     DESIGN ASSUMPTION: A task can be posted under one or more categories. Discussed with Rashmi and decided to allow it
#language_code - to avoid join with gc_dat_task column, it is maintained in this table also.
#status - 'o' - open for bidding, 'c' cancelled, 'p' in progress, 'f' finished in time, 'd' under dispute, 'l' late finished.
CREATE TABLE IF NOT EXISTS `gc_dta_task_category` (
  `task_id` bigint(20) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `updated_by` bigint(20) NULL,
  `status` char(1) default 'o',
   PRIMARY KEY (`language_code`,`category_id`,`task_id`),
  CONSTRAINT `fk_task_category_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_category_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_category_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_category_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
 CREATE INDEX idx_gc_dta_task_lang_catg_status on gc_dta_task_category(`language_code`,`category_id`,`status`,`created_at` DESC);

CREATE TABLE IF NOT EXISTS `gc_dta_task_speciality` (
  `task_id` bigint(20) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `is_required` bit(1) default b'1',  
  `required_rank` int(2),  
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL,
  `updated_by` bigint(20) NULL,
  `status` char(1) default 'a',
  PRIMARY KEY (`task_id`,`speciality_id`),
  CONSTRAINT `fk_task_speciality_speciality_id` FOREIGN KEY (`speciality_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_speciality_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_speciality_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_speciality_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;
 CREATE INDEX idx1_gc_dta_task_speciality_id on gc_dta_task_speciality(`speciality_id`,`created_at` DESC);

#contact_id can be phone or email
#verified_by - is reference to admin user
#verified_status - 'p' pending, 'c' completed
CREATE TABLE IF NOT EXISTS `gc_dta_task_reference` (
  `task_id` bigint(20) NOT NULL,
  `contact_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,  
  `verification_status` char(1) default 'p',  
  `verified_on` timestamp,  
  `verified_by` int(11),  
  `rank` int(11),  
  `remarks` int(11),  
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL,
  `updated_by` bigint(20) NULL,
  `status` char(1) default 'a',
  PRIMARY KEY (`task_id`,`contact_id`),
  CONSTRAINT `fk_task_reference_verified_by` FOREIGN KEY (`verified_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_reference_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_reference_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_task_reference_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;

 CREATE INDEX idx1_gc_dta_task_reference_verification_status on gc_dta_task_reference(`verification_status`,`created_at` DESC);
 
 alter table gc_dta_task_reference add column `ref_email` varchar(100) DEFAULT null;
 alter table gc_dta_task_reference add column `ref_phone` varchar(20) DEFAULT null;
 alter table gc_dta_task_reference modify column `remarks` varchar(500) DEFAULT null;
 
 alter table gc_mst_adminuser modify column `user_id` bigint(20);

 -- 15/02/2014

 alter table gc_dta_task add column `ref_pending` bit(1) DEFAULT 0;
 alter table gc_dta_task add column `ref_done_on` datetime DEFAULT null;
 alter table gc_dta_task add column `ref_done_by_name` varchar(50) DEFAULT null;
 alter table gc_dta_task add column `ref_done_by_phone` varchar(100) DEFAULT null;
 alter table gc_dta_task add column `ref_done_by_email` varchar(100) DEFAULT null;
 alter table gc_dta_task add column `ref_done_by_user_id` bigint(20) DEFAULT null;
 alter table gc_dta_task add column `ref_done_by_admin_id` int(11) DEFAULT null;
 alter table gc_dta_task add column `ref_notify_on` datetime DEFAULT null;
 alter table gc_dta_task add column `ref_notify_cnt` int(11) DEFAULT null;
 alter table gc_dta_task add column `ref_remarks` varchar(500) DEFAULT null;
 
 CREATE INDEX idx1_gc_dta_task_ref_pending on gc_dta_task(`ref_pending` DESC);
 
 alter table gc_dta_task add column `ref_done_by_admin_id` int(11) DEFAULT null;
 ALTER TABLE `gc_dta_task`
  ADD CONSTRAINT `fk_task_ref_done_by_user_id` FOREIGN KEY (`ref_done_by_user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_ref_done_by_admin_id` FOREIGN KEY (`ref_done_by_admin_id`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;
  
 alter table gc_dta_user add column `created_by_user_id` bigint(20) DEFAULT null;
 alter table gc_dta_user add column `created_by_admin_id` int(11) DEFAULT null;
 alter table gc_dta_user add column `updated_by_user_id` bigint(20) DEFAULT null;
 alter table gc_dta_user add column `updated_by_admin_id` int(11) DEFAULT null;
  ALTER TABLE `gc_dta_user`
  ADD CONSTRAINT `fk_user_created_by_user_id` FOREIGN KEY (`created_by_user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_created_by_admin_id` FOREIGN KEY (`created_by_admin_id`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_updated_by_user_id` FOREIGN KEY (`updated_by_user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_updated_by_admin_id` FOREIGN KEY (`updated_by_admin_id`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;
  
  
