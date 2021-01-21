CREATE TABLE `ejercicio`.`prospectos` (
  `id` BIGINT NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `primer_apellido` VARCHAR(100) NOT NULL,
  `segundo_apellido` VARCHAR(100) NULL,
  `calle` VARCHAR(100) NOT NULL,
  `numero` INT(6) NOT NULL,
  `colonia` VARCHAR(100) NOT NULL,
  `codigo_postal` INT(6) NOT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `rfc` INT(13) NOT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `ejercicio`.`prospectos` 
ADD COLUMN `fecha_aprobado` TIMESTAMP NULL DEFAULT NULL AFTER `rfc`,
ADD COLUMN `fecha_rechazado` TIMESTAMP NULL DEFAULT NULL AFTER `fecha_aprobado`,
ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `fecha_rechazado`,
ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `ejercicio`.`prospectos` 
CHANGE COLUMN `numero` `numero` VARCHAR(10) NOT NULL ;

ALTER TABLE `ejercicio`.`prospectos` 
ADD COLUMN `motivo_rechazo` TEXT NULL AFTER `fecha_rechazado`;

ALTER TABLE `ejercicio`.`prospectos` 
CHANGE COLUMN `rfc` `rfc` VARCHAR(13) NOT NULL ;
