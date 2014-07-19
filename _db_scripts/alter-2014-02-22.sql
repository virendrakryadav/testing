#Table to hold invite and bidding related details
#selection_type - inv (invited by poster), bid (bidding by poster), auto (auto selected by system), 
#                 repeat (repeated the tasker)
# Tasker location info is useful to maintain, if tasker is invited or auto selected by the user
# source_app - each table should have source app type such as web, android, iOs etc. Usefull to know the data input channel
# tasker_location info helps to retain point of time info
# status = 'a' means active, 's' - selected - 'r' rejected, 'd' drafted
CREATE TABLE IF NOT EXISTS `gc_dta_task_tasker` (
  `task_tasker_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL,
  `tasker_id` bigint(20) NOT NULL,  
  `selection_type` varchar(10) NOT NULL,    
   tasker_location_longitude varchar(30), 
   tasker_location_latidude varchar(30), 
   tasker_location_geo_area varchar(100),
   tasker_in_range int(4),   
   poster_comments varchar(500),   
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` bigint(20) NOT NULL,
  `source_app` varchar(10),
  `status` char(1) default 'a',
  PRIMARY KEY (`task_tasker_id`)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8;

create index gc_dta_task_tasker_idx1 on gc_dta_task_tasker(task_id,status);
create index gc_dta_task_tasker_idx2 on gc_dta_task_tasker(status,task_id);
create index gc_dta_task_tasker_idx3 on gc_dta_task_tasker(tasker_id,status);

#This table holds any alerts for poster or tasker that can ne shown on deshboard
# for_user_id alter is for which user
# by_user_id` is alert caused by some user like viewed for_user_id profile  
# alert_desc if required to set description of an alert, otherwise, based on alert_type, desc can be generated
# task_tasker_id can be available, if alert is related to task such as bid received, task invitation, 
#                                 task allocation, task_rejection, profile viewed by etc. 
#is_seen - false means 'for_user_id' has not seen the alert yet
#seen_at - when 'for_user_id' has seen the alert?
#seen_from_source_app - from where 'for_user_id' has seen it

CREATE TABLE IF NOT EXISTS `gc_dta_user_alert` (
  `alert_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `alert_type` varchar(20) NOT NULL,
  `alert_desc` varchar(100),  
  `for_user_id` bigint(20) NOT NULL,  
  `by_user_id` bigint(20),  
  `task_tasker_id` bigint(20),
  `is_seen` bit(1) NOT NULL default b'0',   
  `seen_at` timestamp,   
  `seen_from_source_app` varchar(10),   
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp,
  `updated_by` int(11) NOT NULL,
  `source_app` varchar(10),
  `status` char(1) default 'a',
  PRIMARY KEY (`alert_id`)
  )ENGINE=MyISAM DEFAULT CHARSET=utf8;

create index gc_dta_user_alert_idx1 on gc_dta_user_alert(for_user_id,alert_type,is_seen);
create index gc_dta_user_alert_idx2 on gc_dta_user_alert(for_user_id,is_seen,alert_type);

#This table holds any user daily activity that we want to store for analytics purpose
#activity_type can be signin, signout, forgotpwd, changepwd, any feature id (searchtask, searchtasker etc),  
#activity_subtype can be used to hold activity sepecific data such as searchtask under which category
#comments can be used to hold any activity related details, if required. E.g reason for sign in error

CREATE TABLE IF NOT EXISTS `gc_dta_user_activity` (
  `activity_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `by_user_id` bigint(20) NOT NULL,  
  `activity_type` varchar(20) NOT NULL,
  `activity_subtype` varchar(100) NOT NULL,
  `comments` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `source_app` varchar(10),
  PRIMARY KEY (`activity_id`)
  )ENGINE=MyISAM DEFAULT CHARSET=utf8;

create index gc_dta_user_activity_idx1 on gc_dta_user_activity(created_at,by_user_id,activity_type);
create index gc_dta_user_activity_idx2 on gc_dta_user_activity(by_user_id,activity_type,created_at);


#This table holds any task level daily activity that we want to store for analytics purpose
#activity_type can be post, del, publice, etc.  
#activity_subtype can be used to hold activity sepecific data such as task category
#comments can be used to hold any activity related details, if required. E.g any error reason

CREATE TABLE IF NOT EXISTS `gc_dta_task_activity` (
  `activity_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL,  
  `by_user_id` bigint(20) NOT NULL,  
  `activity_type` varchar(20) NOT NULL,
  `activity_subtype` varchar(100) NOT NULL,
  `comments` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `source_app` varchar(10),
  PRIMARY KEY (`activity_id`)
  )ENGINE=MyISAM DEFAULT CHARSET=utf8;

create index gc_dta_task_activity_idx1 on gc_dta_task_activity(created_at,task_id,activity_type);
create index gc_dta_task_activity_idx2 on gc_dta_task_activity(task_id,activity_type,created_at);
create index gc_dta_task_activity_idx3 on gc_dta_task_activity(by_user_id,activity_type,created_at);



-- colums were added in gc_mst_category_question_locale table but need to add in gc_mst_category_question table 
ALTER TABLE `gc_mst_category_question_locale` DROP COLUMN question_type;
ALTER TABLE `gc_mst_category_question_locale` DROP COLUMN question_for;
ALTER TABLE `gc_mst_category_question_locale` DROP COLUMN is_answer_must;

ALTER TABLE `gc_mst_category_question`
  add column `question_type` char(1) NOT NULL default 'l',
  add column `question_for` char(1) NOT NULL default 't',
  add column `is_answer_must` bit(1) NOT NULL default b'0';
  
  
ALTER TABLE `gc_dta_user`
  add column `location_longitude` varchar(30),
  add column `location_latidude` varchar(30);
