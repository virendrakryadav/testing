#to manage task completion date by the doer

ALTER TABLE `gc_dta_task_tasker` ADD `proposed_completion_date` DATETIME NOT NULL AFTER `approved_on` ,
ADD `proposed_duration` VARCHAR( 30 ) NOT NULL AFTER `proposed_date` ;



update tables

task_tasker table add column
total_amount_received

ALTER TABLE `gc_dta_task_tasker` ADD `total_amount_received` DECIMAL( 10, 2 ) NOT NULL AFTER `is_tasker_saved` ;


task_tasker_receipt table
task_tasker_receipt_id
task_tasker_id
receipt_amount
receipt_reason
approved_amount
approved_on
approver_comments

attachment
status


created at
updated at


index on task_tasker_id
