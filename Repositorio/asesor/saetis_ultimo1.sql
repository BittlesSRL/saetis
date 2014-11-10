-- MySQL Script generated by MySQL Workbench
-- 11/03/14 22:34:14
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema saetis
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema saetis
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `saetis` DEFAULT CHARACTER SET latin1 ;
USE `saetis` ;

-- -----------------------------------------------------
-- Table `saetis`.`aplicacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`aplicacion` (
  `APLICACION_A` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`APLICACION_A`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`estado` (
  `ESTADO_E` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`ESTADO_E`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`usuario` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `ESTADO_E` VARCHAR(50) NOT NULL,
  `PASSWORD_U` VARCHAR(50) NOT NULL,
  `TELEFONO_U` VARCHAR(8) NOT NULL,
  `CORREO_ELECTRONICO_U` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`),
  INDEX `FK_ESTADO__USUARIO` USING BTREE (`ESTADO_E` ASC),
  CONSTRAINT `FK_ESTADO__USUARIO`
    FOREIGN KEY (`ESTADO_E`)
    REFERENCES `saetis`.`estado` (`ESTADO_E`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 2048
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`asesor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`asesor` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `NOMBRES_A` VARCHAR(50) NOT NULL,
  `APELLIDOS_A` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`),
  CONSTRAINT `FK_USUARIO__ASESOR`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`usuario` (`NOMBRE_U`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 4096
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`tipo` (
  `TIPO_T` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`TIPO_T`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`registro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`registro` (
  `ID_R` INT(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `TIPO_T` VARCHAR(50) NOT NULL,
  `ESTADO_E` VARCHAR(50) NOT NULL,
  `NOMBRE_R` VARCHAR(50) NOT NULL,
  `FECHA_R` DATE NOT NULL,
  `HORA_R` TIME NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`),
  INDEX `FK_ESTADO__REGISTRO` USING BTREE (`ESTADO_E` ASC),
  INDEX `FK_TIPO__REGISTRO` USING BTREE (`TIPO_T` ASC),
  INDEX `FK_USUARIO_REGISTRO` USING BTREE (`NOMBRE_U` ASC),
  CONSTRAINT `FK_ESTADO__REGISTRO`
    FOREIGN KEY (`ESTADO_E`)
    REFERENCES `saetis`.`estado` (`ESTADO_E`),
  CONSTRAINT `FK_TIPO__REGISTRO`
    FOREIGN KEY (`TIPO_T`)
    REFERENCES `saetis`.`tipo` (`TIPO_T`),
  CONSTRAINT `FK_USUARIO_REGISTRO`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`usuario` (`NOMBRE_U`))
ENGINE = InnoDB
AUTO_INCREMENT = 78
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`asignacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`asignacion` (
  `ID_R` INT(11) NOT NULL,
  `EMISOR_A` VARCHAR(30) NOT NULL,
  `RECEPTOR_A` VARCHAR(30) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`),
  CONSTRAINT `FK_REGISTRO__ASIGNACION`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`asistencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`asistencia` (
  `ID_R` INT(11) NOT NULL,
  `CODIGO_SOCIO_A` INT(11) NOT NULL,
  `ASISTENCIA_A` TINYINT(1) NOT NULL,
  `LICENCIA_A` TINYINT(1) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`, `CODIGO_SOCIO_A`),
  CONSTRAINT `FK_REGISTRO__ASISTENCIA`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`criterio_evaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`criterio_evaluacion` (
  `ID_R` INT(11) NOT NULL,
  `ID_C_E` INT(11) NOT NULL,
  `CRITERIO_E` TEXT CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`, `ID_C_E`),
  CONSTRAINT `FK_REGISTRO_CRITERIO_E`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 4096
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`descripcion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`descripcion` (
  `ID_R` INT(11) NOT NULL,
  `DESCRIPCION_D` VARCHAR(100) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`documento` (
  `ID_D` INT(11) NOT NULL AUTO_INCREMENT,
  `ID_R` INT(11) NOT NULL,
  `TAMANIO_D` INT(11) NOT NULL,
  `RUTA_D` VARCHAR(100) NOT NULL,
  `VISUALIZABLE_D` TINYINT(1) NOT NULL,
  `DESCARGABLE_D` TINYINT(1) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_D`),
  INDEX `FK_REGISTRO_DOCUMENTO` USING BTREE (`ID_R` ASC),
  CONSTRAINT `FK_REGISTRO_DOCUMENTO`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
AUTO_INCREMENT = 34
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`entrega`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`entrega` (
  `ID_R` INT(11) NOT NULL,
  `ENTREGABLE_P` VARCHAR(30) NOT NULL,
  `ENTREGADO_P` TINYINT(1) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`, `ENTREGABLE_P`),
  CONSTRAINT `FK_REGISTRO__PRESENTACION`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`grupo_empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`grupo_empresa` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `NOMBRE_CORTO_GE` CHAR(50) NOT NULL,
  `NOMBRE_LARGO_GE` VARCHAR(50) NOT NULL,
  `DIRECCION_GE` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`),
  CONSTRAINT `FK_USUARIO__GRUPO_EMPRESA`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`usuario` (`NOMBRE_U`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 4096
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`planificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`planificacion` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `ESTADO_E` VARCHAR(50) NOT NULL,
  `FECHA_INICIO_P` DATE NOT NULL,
  `FECHA_FIN_P` DATE NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`),
  INDEX `FK_ESTADO__PLANIFICACION` USING BTREE (`ESTADO_E` ASC),
  CONSTRAINT `FK_ESTADO__PLANIFICACION`
    FOREIGN KEY (`ESTADO_E`)
    REFERENCES `saetis`.`estado` (`ESTADO_E`),
  CONSTRAINT `FK_GRUPO_EMPRESA__PLANIFICACION`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`grupo_empresa` (`NOMBRE_U`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`entregable`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`entregable` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `ENTREGABLE_E` CHAR(30) NOT NULL,
  `DESCRIPCION_E` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`, `ENTREGABLE_E`),
  CONSTRAINT `FK_PLANIFICACION__ENTREGABLE`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`planificacion` (`NOMBRE_U`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`fecha_realizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`fecha_realizacion` (
  `ID_R` INT(11) NOT NULL,
  `FECHA_FR` DATE NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`),
  CONSTRAINT `FK_REGISTRO__FECHA_REALIZACION`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`gestion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`gestion` (
  `ID_G` INT(11) NOT NULL AUTO_INCREMENT,
  `FECHA_INICIO_G` DATE NOT NULL,
  `FECHA_FIN_G` DATE NOT NULL,
  PRIMARY KEY USING BTREE (`ID_G`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`proyecto` (
  `CODIGO_P` INT(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_P` VARCHAR(50) NOT NULL,
  `DESCRIPCION_P` VARCHAR(200) NOT NULL,
  PRIMARY KEY USING BTREE (`CODIGO_P`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`inscripcion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`inscripcion` (
  `NOMBRE_UA` VARCHAR(50) NOT NULL,
  `NOMBRE_UGE` VARCHAR(50) NOT NULL,
  `ID_G` INT(11) NOT NULL,
  `CODIGO_P` INT(11) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_UGE`, `NOMBRE_UA`, `ID_G`, `CODIGO_P`),
  INDEX `FK_ASESOR__INSCRIPCION` USING BTREE (`NOMBRE_UA` ASC),
  INDEX `FK_GESTION__INSCRIPCION` USING BTREE (`ID_G` ASC),
  INDEX `FK_PROYECTO__INSCRIPCION` USING BTREE (`CODIGO_P` ASC),
  CONSTRAINT `FK_ASESOR__INSCRIPCION`
    FOREIGN KEY (`NOMBRE_UA`)
    REFERENCES `saetis`.`asesor` (`NOMBRE_U`),
  CONSTRAINT `FK_GESTION__INSCRIPCION`
    FOREIGN KEY (`ID_G`)
    REFERENCES `saetis`.`gestion` (`ID_G`),
  CONSTRAINT `FK_GRUPO_EMPRESA__INSCRIPCION`
    FOREIGN KEY (`NOMBRE_UGE`)
    REFERENCES `saetis`.`grupo_empresa` (`NOMBRE_U`),
  CONSTRAINT `FK_PROYECTO__INSCRIPCION`
    FOREIGN KEY (`CODIGO_P`)
    REFERENCES `saetis`.`proyecto` (`CODIGO_P`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 4096
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`mensaje`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`mensaje` (
  `ID_R` INT(11) NOT NULL,
  `ASUNTO_M` VARCHAR(30) NOT NULL,
  `MENSAJE_M` VARCHAR(100) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`),
  CONSTRAINT `FK_REGISTRO__MENSAJE`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`pago` (
  `ID_R` INT(11) NOT NULL,
  `MONTO_P` DECIMAL(10,0) NOT NULL,
  `PORCENTAJE_DEL_TOTAL_P` INT(11) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`),
  CONSTRAINT `FK_REGISTRO__PAGO`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`plazo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`plazo` (
  `ID_R` INT(11) NOT NULL,
  `FECHA_INICIO_PL` DATE NOT NULL,
  `FECHA_FIN_PL` DATE NOT NULL,
  `HORA_INICIO_PL` TIME NOT NULL,
  `HORA_FIN_PL` TIME NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`),
  CONSTRAINT `FK_REGISTRO__PLAZO`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`))
ENGINE = InnoDB
AVG_ROW_LENGTH = 8192
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`precio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`precio` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `PRECIO_P` DECIMAL(10,0) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`),
  CONSTRAINT `FK_PLANIFICACION__PRECIO`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`planificacion` (`NOMBRE_U`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`rol_reporte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`rol_reporte` (
  `ROL_RR` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`ROL_RR`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`reporte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`reporte` (
  `ID_R` INT(11) NOT NULL,
  `ROL_RR` VARCHAR(50) NOT NULL,
  `ACTIVIDAD_R` VARCHAR(100) NOT NULL,
  `HECHO_R` TINYINT(1) NOT NULL,
  `RESULTADO_R` VARCHAR(200) NOT NULL,
  `CONCLUSION_R` VARCHAR(200) NOT NULL,
  `OBSERVACION_R` VARCHAR(200) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_R`, `ROL_RR`),
  INDEX `FK_ROL_REPORTE__REPORTE` USING BTREE (`ROL_RR` ASC),
  CONSTRAINT `FK_REGISTRO__REPORTE`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`),
  CONSTRAINT `FK_ROL_REPORTE__REPORTE`
    FOREIGN KEY (`ROL_RR`)
    REFERENCES `saetis`.`rol_reporte` (`ROL_RR`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`rol` (
  `ROL_R` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`ROL_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`rol_aplicacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`rol_aplicacion` (
  `ROL_R` VARCHAR(50) NOT NULL,
  `APLICACION_A` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`ROL_R`, `APLICACION_A`),
  INDEX `FK_APLICACION__ROL_APLICACION` USING BTREE (`APLICACION_A` ASC),
  CONSTRAINT `FK_APLICACION__ROL_APLICACION`
    FOREIGN KEY (`APLICACION_A`)
    REFERENCES `saetis`.`aplicacion` (`APLICACION_A`),
  CONSTRAINT `FK_ROL__ROL_APLICACION`
    FOREIGN KEY (`ROL_R`)
    REFERENCES `saetis`.`rol` (`ROL_R`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`sesion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`sesion` (
  `ID_S` INT(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `FECHA_S` DATE NOT NULL,
  `HORA_S` TIME NOT NULL,
  `IP_S` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`ID_S`),
  INDEX `FK_USUARIO_SESION` USING BTREE (`NOMBRE_U` ASC),
  CONSTRAINT `FK_USUARIO_SESION`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`usuario` (`NOMBRE_U`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`socio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`socio` (
  `CODIGO_S` INT(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `NOMBRES_S` VARCHAR(50) NOT NULL,
  `APELLIDOS_S` VARCHAR(50) NOT NULL,
  `LOGIN_S` VARCHAR(45) NOT NULL,
  `PASSWORD_S` VARCHAR(45) NOT NULL,
  PRIMARY KEY USING BTREE (`CODIGO_S`),
  INDEX `FK_GRUPO_EMPRESA__SOCIO` USING BTREE (`NOMBRE_U` ASC),
  CONSTRAINT `FK_GRUPO_EMPRESA__SOCIO`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`grupo_empresa` (`NOMBRE_U`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
AVG_ROW_LENGTH = 819
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`usuario_rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`usuario_rol` (
  `NOMBRE_U` VARCHAR(50) NOT NULL,
  `ROL_R` VARCHAR(50) NOT NULL,
  PRIMARY KEY USING BTREE (`NOMBRE_U`, `ROL_R`),
  INDEX `FK_ROL__USUARIO_ROL` USING BTREE (`ROL_R` ASC),
  CONSTRAINT `FK_ROL__USUARIO_ROL`
    FOREIGN KEY (`ROL_R`)
    REFERENCES `saetis`.`rol` (`ROL_R`),
  CONSTRAINT `FK_USUARIO__USUARIO_ROL`
    FOREIGN KEY (`NOMBRE_U`)
    REFERENCES `saetis`.`usuario` (`NOMBRE_U`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`menu` (
  `id_menu` INT NOT NULL AUTO_INCREMENT,
  `nom_menu` VARCHAR(45) NOT NULL,
  `url` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_menu`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `saetis`.`permisos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`permisos` (
  `ROL_R` VARCHAR(50) NOT NULL,
  `id_permiso` INT NOT NULL AUTO_INCREMENT,
  `menu_id_menu` INT NOT NULL,
  PRIMARY KEY (`id_permiso`),
  INDEX `fk_rol_has_menu_rol1_idx` (`ROL_R` ASC),
  INDEX `fk_permisos_menu1_idx` (`menu_id_menu` ASC),
  CONSTRAINT `id_menu`
    FOREIGN KEY (`ROL_R`)
    REFERENCES `saetis`.`rol` (`ROL_R`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permisos_menu1`
    FOREIGN KEY (`menu_id_menu`)
    REFERENCES `saetis`.`menu` (`id_menu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `saetis`.`periodo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `saetis`.`periodo` (
  `ID_R` INT(11) NOT NULL,
  `fecha_p` DATE NOT NULL,
  `hora_p` TIME NOT NULL,
  PRIMARY KEY (`ID_R`),
  CONSTRAINT `fk_periodo_registro1`
    FOREIGN KEY (`ID_R`)
    REFERENCES `saetis`.`registro` (`ID_R`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
