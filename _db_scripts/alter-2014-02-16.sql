#http://www.aryahelp.com/greencomet/in-person-task.html
#http://www.aryahelp.com/greencomet/instant-task.html
#http://www.aryahelp.com/greencomet/instant-task-mapview.html 
#http://www.aryahelp.com/greencomet/virtual-task.html
#http://www.aryahelp.com/greencomet/instant-task-mapview.html 

# is_virtual - can this category applicable for virtual task?
# is_inperson - can this category applicable for inperson task?
# is_instant - can this category applicable for instant task?

alter table `gc_mst_category` add column is_virtual bit(1) NOT NULL default b'1', 
             add column is_inperson bit(1) NOT NULL default b'1',
             add column is_instant bit(1) NOT NULL default b'1',
             add column `parent_id` int(11) DEFAULT NULL;

alter table `gc_mst_category`
             add column `task_post_cnt` int(11) DEFAULT 0,
             add column `task_post_total_hours` int(11) DEFAULT 0,
             add column `task_post_total_price` int(11) DEFAULT 0,
             add column `task_done_cnt` int(11) DEFAULT 0,
             add column `task_done_total_hours` int(11) DEFAULT 0,
             add column `task_done_total_price` int(11) DEFAULT 0,
             add column `task_cancel_cnt` int(11) DEFAULT 0,
             add column `task_cancel_total_hours` int(11) DEFAULT 0,
             add column `task_cancel_total_price` int(11) DEFAULT 0;

create index idx_gc_mst_category_is_virtual on gc_mst_category(is_virtual);
create index idx_gc_mst_category_is_inperson on gc_mst_category(is_inperson);
create index idx_gc_mst_category_is_instant on gc_mst_category(is_instant);

###ALTER TABLE gc_mst_category_locale  DROP FOREIGN KEY `fk_categorylocale_parentid`;

###alter table gc_mst_category_locale drop column parent_id on cascade;

alter table `gc_mst_category_locale` modify `category_name` varchar(40) NOT NULL;

#Discussions category name, sub category name and task title, user's display name should be restricted to 30 to 50 charactrts, as will appear in URLs. 
#Need to decide on this.
#
# task_kind = v/p/i - v - virtual, p - in person, i = instant
# payment_mode - 'f' fixed price, 'b' bidding
# preferred_location - 'r' regison' - 'c' country, null means no preference. Applicable in Virtual type task
# tasker_in_range - an int value that can be interprated as miles or time to drive as required.
alter table `gc_dta_task` 
        modify `title` varchar(40) NOT NULL, 
        add column task_kind char(1), 
        add column location_longitude varchar(30), 
	add column location_latitude varchar(30), 
	add column location_geo_area varchar(100),
	add column tasker_in_range int(4),
	add column start_date date,
	add column start_time char(4),
	add column end_date date,
	add column end_time char(4),
	add column payment_mode char(1),	
	add column cash_required decimal(12,2),	
	add column preferred_location char(1),
	drop column is_location_region,
	drop column work_hrs,
	drop column bid_start_dt,
	drop column bid_close_dt
	;
	
###drop table gc_dta_task_reference;

#day - 0 - sun, 1 - mon, 2 - tue and son on
#start_hour and end_hour - 24 hour clock and value is always 4 digits such 0930 (means 9.30 AM), 1330 means 1.30PM) etc.
#status = 'a' means record can be used for checking the working hours on a day
CREATE TABLE IF NOT EXISTS `gc_dta_user_work_hours` (
  `user_id` bigint(20) NOT NULL,
  `day` int(1) DEFAULT NULL,
  `start_hour` char(4) NOT NULL,
  `end_hour` char(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`user_id`,`day`,`start_hour`,`end_hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create index idx_gc_dta_user_work_hours on gc_dta_user_work_hours(`day`,`start_hour`,`end_hour`,`user_id`);

alter table `gc_dta_user` 
  add column notify_by_pn bit(1) NOT NULL default b'1',
  modify `notify_by_sms` bit(1) NOT NULL DEFAULT b'0',
  modify `notify_by_email` bit(1) NOT NULL DEFAULT b'1',
  modify `notify_by_chat` bit(1) NOT NULL DEFAULT b'1',
  modify `notify_by_fb` bit(1) NOT NULL DEFAULT b'1',
  modify `notify_by_tw` bit(1) NOT NULL DEFAULT b'1'
;




#task_templates is array of json objects like [{title:"Wants some for ....",desc:"I need a person or a group"}]
alter table `gc_mst_category` add column task_templates varchar(2000);

#tasker_id_source - decided by the user or system or by bidding values can be 'user', 'auto', 'bid'
alter table `gc_dta_task` add column tasker_id_source varchar(10) AFTER tasker_user_id ;

alter table `gc_dta_task` add column valid_from_dt varchar(4) default '0000',
   add column valid_from_time varchar(4) default '2359',
   add column valid_to_dt varchar(4) default NULL,
   add column valid_to_time varchar(4) default NULL;

