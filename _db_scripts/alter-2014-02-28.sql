#bid_duration values can be `1 day`, `1 week`, `15 days`, `1 month` or null
ALTER TABLE `gc_dta_task` ADD `bid_duration` VARCHAR( 10 ) NULL AFTER `work_hrs` ;


# changed `bid_start_dt` from current_timestamp to datetime and `bid_close_dt` from '0000-00-00 00:00:00' to null datetime 
# because `bid_start_dt` and `bid_close_dt` would be updated when user will publish the task not at the time of task creation.
ALTER TABLE `gc_dta_task` CHANGE `bid_start_dt` `bid_start_dt` DATETIME NULL DEFAULT NULL ,
CHANGE `bid_close_dt` `bid_close_dt` DATETIME NULL DEFAULT NULL ;


## added foreign key constraint on task_id field
ALTER TABLE `gc_dta_task_tasker` ADD CONSTRAINT `fk_gc_dta_task_tasker_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE;
ALTER TABLE `gc_dta_task_tasker` ADD CONSTRAINT `fk_gc_dta_task_tasker_tasker_id` FOREIGN KEY (`tasker_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;
ALTER TABLE `gc_dta_task_tasker` ADD CONSTRAINT `fk_gc_dta_task_tasker_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;
ALTER TABLE `gc_dta_task_tasker` ADD CONSTRAINT `fk_gc_dta_task_tasker_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;