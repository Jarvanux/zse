/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Starlly Software
 * Created: 28/11/2017
 */

CREATE TABLE `projects` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(10) NULL DEFAULT NULL,
	`domain` VARCHAR(150) NULL DEFAULT NULL,
	`name` VARCHAR(100) NULL DEFAULT NULL,
	`description` VARCHAR(300) NULL DEFAULT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;

CREATE TABLE `files` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_project` INT(11) NULL DEFAULT NULL,
	`name` VARCHAR(100) NULL DEFAULT NULL,
	`extension` VARCHAR(5) NULL DEFAULT NULL,
	`type` VARCHAR(20) NULL DEFAULT NULL,
	`icon` VARCHAR(50) NULL DEFAULT NULL,
	`path` VARCHAR(150) NULL DEFAULT NULL,
	`code_type` VARCHAR(10) NULL DEFAULT NULL COMMENT 'java, php, js, css, etc.',
	`created_at` VARCHAR(150) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;
