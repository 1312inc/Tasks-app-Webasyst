<?php

$_model = new waModel();
$_table = 'tasks_releases_task_types';
$_field = 'color';

try {
    $_model->query("SELECT `{$_field}` FROM `{$_table}` WHERE 0");
} catch (waDbException $e) {
    $_model->exec("ALTER TABLE `{$_table}` ADD COLUMN `{$_field}` VARCHAR (64) NULL DEFAULT NULL");
}
