CREATE TABLE `gc_dta_user_attrib` (
  `user_id` bigint(20) DEFAULT NULL COMMENT 'attribute related to which user?',
  `attrib_type` varchar(30) DEFAULT NULL COMMENT 'attribute type such as preference, filter_task, filter_tasker, filter_poster, credit_card, fb, tw auth details etc.', 
  `attrib_subtype` varchar(50) DEFAULT NULL
  `attrib_desc` varchar(30) NULL COMMENT 'attribute sub type such as filter name or sub type under attrib_type e.g. filter1', 
  `val_bigint` bigint(20) COMMENT 'Long integer value',
  `val_int` int(11) COMMENT 'Integer value',
  `val_real` decimal(15,2) COMMENT 'real value',
  `val_str` varchar(8000) COMMENT 'string value, for example filter and preferences related data',
  `val_dt` datetime COMMENT 'date value', 
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`user_id`,`attrib_type`,`attrib_desc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds user attributes which are assigned on need basis and not always required for each user. for example, search filters etc.';

alter table gc_dta_user add column `account_type` varchar(2) DEFAULT 'r' COMMENT 'r = regular , p = premium , sp = super premium' after user_type;

alter table gc_dta_task_tasker  modify `status` char(1) DEFAULT 'a' COMMENT 'a = active, s = selected, r rejected/not interested, d = drafted'
                                add column is_invited tinyint(3) NOT NULL DEFAULT '0',
                                add column invited_at datetime,      
                                add column not_interested tinyint(3) NOT NULL DEFAULT '0',
                                add column not_interested_at datetime,
                                add column is_tasker_saved tinyint(3) NOT NULL DEFAULT '0';

#It is assumed that:
#  1) if user A connects to B then by default connection is approved. No approval is required.
#  2) if A is connected to B then in B's connections list, A is shown. In that case 2 records (A -> B. B->A) are created on connection request. 
#  3) gc_dta_user.connection_cnt column is updated for both A and B.

CREATE TABLE `gc_dta_user_connection` (
  `user_id` bigint(20) DEFAULT NULL COMMENT 'connection info of which user',
  `connected_user_id` varchar(30) NOT NULL COMMENT 'user_id is connected with which user id',
  `approval_status` char(1) NOT NULL DEFAULT 'a' COMMENT 'a = approved, r = rejected, p = approval pending',
  `approved_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`user_id`,`connected_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds all connections related details of a user_id. Once connection is approved, a new record is created for by swaping user_id and connected_user_id values.';

CREATE TABLE `gc_dta_user_bookmark` (
  `bookmark_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Bookmark information of which user',
  `bookmark_type` varchar(30) NOT NULL COMMENT 'task, tasker, poster',  
  `bookmark_subtype` char(1) NOT NULL DEFAULT 'r' COMMENT 'f = favorite, r = mark read, s = mark saved for later selection',  
  `task_id` bigint(20),
  `bookmark_user_id` bigint(20),
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `source_app` varchar(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`bookmark_id`),
  KEY `idx1_gc_dta_user_bookmark_type` (`user_id`,`bookmark_type`,`bookmark_subtype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table holds all bookmarks information created by a user. Based on value of bookmark_type, bookmark_user_id or task_id column will have valid value';
