CREATE TABLE `gc_mst_rating` (
   rating_id int(11) AUTO_INCREMENT NOT NULL,
   rating_for char(1) COMMENT '''p'' for poster to rate a poster ''t'' for tasker to rate a tasker, ''u'' for any user to rate the service, if required',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a' COMMENT ' ''a'' means active, ''d'' means deleted',
  PRIMARY KEY (`rating_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds rating codes that poster and tasker use to rate each other of task completion';

CREATE TABLE `gc_mst_rating_locale` (
   rating_id int(11) AUTO_INCREMENT NOT NULL,
   language_code varchar(5) not null COMMENT 'Language of the rating description',
   rating_desc  varchar(30) NOT NULL,
   rating_priority  int(11) default 0 COMMENT 'Display order on UI 0,1,2 etc. High order rows to be displayed first',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a' COMMENT ' ''a'' means active, ''d'' means deleted',
  PRIMARY KEY (language_code,rating_id),
  CONSTRAINT `gc_mst_rating_locale_fk_1` FOREIGN KEY (`rating_id`) REFERENCES `gc_mst_rating` (`rating_id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds rating description for each language';

create index gc_mst_rating_locale_rating_id_idx1 on gc_mst_rating_locale(rating_id);

#Note - it is assumed that rating is always given for a task.
CREATE TABLE `gc_dta_user_rating` (
   user_rating_trno bigint(20) AUTO_INCREMENT NOT NULL COMMENT 'entry id',
   task_id bigint(20) NOT NULL COMMENT 'Rating is given against which task?',
   rating_for char(1) NOT NULL COMMENT 'Rating is given for_user_id, ''p'' means for Poster ''t'' means for Tasker',
   by_user_id bigint(20) NOT NULL COMMENT 'user_id of the user, who has given the rating',
   for_user_id bigint(20) NOT NULL COMMENT 'user_id of the user, for whom rating is given',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a' COMMENT ' ''a'' means active, ''d'' means deleted',
  PRIMARY KEY (`user_rating_trno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds a task related rating master information';

CREATE TABLE `gc_dta_user_rating_dtl` (
   user_rating_trno bigint(20),
   rating_id int(11) NOT NULL,
   rating decimal(5,2) default 0 COMMENT 'rating value in range 0-max allowed rating value',
  `status` char(1) DEFAULT 'a' COMMENT ' ''a'' means active, ''d'' means deleted',
  PRIMARY KEY (`user_rating_trno`,`rating_id`),
  CONSTRAINT `gc_dta_user_rating_dtl_fk_1` FOREIGN KEY (`user_rating_trno`) REFERENCES `gc_dta_user_rating` (`user_rating_trno`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds rating_id wise rating value.';

CREATE TABLE `gc_sum_user_rating` (
   user_id bigint(20) NOT NULL,
   rating_id int(11) NOT NULL COMMENT 'rating id for which summary is maintained',
   rating_min decimal(5,2) NOT NULL default 0 COMMENT 'Min rating given so far under a rating_id',	   
   rating_max decimal(5,2) NOT NULL default 0 COMMENT 'Max rating given so far under a rating_id',	   
   rating_avg decimal(5,2) NOT NULL default 0 COMMENT 'Avg rating given so far under a rating_id',	   
   rating_total decimal(10,2) NOT NULL default 0 COMMENT 'Sum of all the ratings given so far under a rating_id',
   rating_cnt int(11) NOT NULL default 0 COMMENT 'Count of all the users who have given rating so far under a rating_id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a' COMMENT ' ''a'' means active, ''d'' means deleted',
   PRIMARY KEY (`user_id`,`rating_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds summary of rating data for each user at rating_id level';

alter table gc_dta_user 
add column rating_min_as_tasker decimal(5,2) NOT NULL default 0 COMMENT 'Overall Min rating of this user as tasker',
add column rating_max_as_tasker decimal(5,2) NOT NULL default 0 COMMENT 'Overall Max rating of this user as tasker',
add column rating_avg_as_tasker decimal(5,2) NOT NULL default 0 COMMENT 'Overall Avg rating of this user as tasker',
add column rating_total_as_tasker decimal(10,2) NOT NULL default 0 COMMENT 'Overall Sum of all the ratings given so far to this user as tasker under any rating_id',
add column rating_cnt_as_tasker int(11) NOT NULL default 0 COMMENT 'Overall Count of all the posters who have given rating so far',
add column rating_min_as_poster decimal(5,2) NOT NULL default 0 COMMENT 'Overall Min rating of this user as poster',
add column rating_max_as_poster decimal(5,2) NOT NULL default 0 COMMENT 'Overall Max rating of this user as poster',
add column rating_avg_as_poster decimal(5,2) NOT NULL default 0 COMMENT 'Overall Avg rating of this user as poster',
add column rating_total_as_poster decimal(10,2) NOT NULL default 0 COMMENT 'Overall Sum of all the ratings given so far to this user as poster',
add column rating_cnt_as_poster int(11) NOT NULL default 0 COMMENT 'Overall Count of all taskers who have given rating so far to this user as poster';
