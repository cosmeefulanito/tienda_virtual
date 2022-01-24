/*
 Navicat Premium Data Transfer

 Source Server         : mitienda
 Source Server Type    : MySQL
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : tiendavirtual

 Target Server Type    : MySQL
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 01/11/2021 15:19:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for catergoria
-- ----------------------------
DROP TABLE IF EXISTS `catergoria`;
CREATE TABLE `catergoria`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `datecreated` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  CONSTRAINT `catergoria_ibfk_1` FOREIGN KEY (`id`) REFERENCES `producto` (`categoriaid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of catergoria
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_pedido
-- ----------------------------
DROP TABLE IF EXISTS `detalle_pedido`;
CREATE TABLE `detalle_pedido`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pedidoid` bigint(20) NOT NULL,
  `productoid` bigint(20) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pedidoid`(`pedidoid`) USING BTREE,
  INDEX `productoid`(`productoid`) USING BTREE,
  CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedidoid`) REFERENCES `pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`productoid`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_pedido
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_temp
-- ----------------------------
DROP TABLE IF EXISTS `detalle_temp`;
CREATE TABLE `detalle_temp`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productoid` bigint(20) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `productoid`(`productoid`) USING BTREE,
  CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`productoid`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_temp
-- ----------------------------

-- ----------------------------
-- Table structure for modulo
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of modulo
-- ----------------------------
INSERT INTO `modulo` VALUES (4, 'Dashboard', 'dashboard', 1);
INSERT INTO `modulo` VALUES (5, 'Clientes', 'clientes de tienda', 1);
INSERT INTO `modulo` VALUES (6, 'Productos', 'productos de tienda', 1);
INSERT INTO `modulo` VALUES (7, 'Pedidos', 'pedidos', 1);

-- ----------------------------
-- Table structure for pedido
-- ----------------------------
DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `personaid` bigint(20) NOT NULL,
  `fecha` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `monto` int(11) NOT NULL,
  `tipopagoid` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `personaid`(`personaid`) USING BTREE,
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`personaid`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pedido
-- ----------------------------

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rolid` bigint(20) NOT NULL,
  `moduloid` bigint(11) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rolid`(`rolid`) USING BTREE,
  INDEX `moduloid`(`moduloid`) USING BTREE,
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 85 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES (9, 30, 4, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (10, 30, 5, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (11, 30, 6, 0, 1, 1, 1);
INSERT INTO `permisos` VALUES (12, 30, 7, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (13, 31, 4, 0, 0, 0, 1);
INSERT INTO `permisos` VALUES (14, 31, 5, 0, 0, 0, 1);
INSERT INTO `permisos` VALUES (15, 31, 6, 0, 0, 0, 1);
INSERT INTO `permisos` VALUES (16, 31, 7, 0, 0, 0, 1);
INSERT INTO `permisos` VALUES (25, 34, 4, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (26, 34, 5, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (27, 34, 6, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (28, 34, 7, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (33, 35, 4, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (34, 35, 5, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (35, 35, 6, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (36, 35, 7, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (41, 38, 4, 0, 1, 0, 1);
INSERT INTO `permisos` VALUES (42, 38, 5, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (43, 38, 6, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (44, 38, 7, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (49, 36, 4, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (50, 36, 5, 1, 1, 0, 0);
INSERT INTO `permisos` VALUES (51, 36, 6, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (52, 36, 7, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (65, 29, 4, 1, 1, 0, 0);
INSERT INTO `permisos` VALUES (66, 29, 5, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (67, 29, 6, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (68, 29, 7, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (69, 40, 4, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (70, 40, 5, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (71, 40, 6, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (72, 40, 7, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (73, 39, 4, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (74, 39, 5, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (75, 39, 6, 1, 0, 0, 0);
INSERT INTO `permisos` VALUES (76, 39, 7, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (77, 37, 4, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (78, 37, 5, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (79, 37, 6, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (80, 37, 7, 1, 1, 1, 1);
INSERT INTO `permisos` VALUES (81, 42, 4, 1, 0, 0, 1);
INSERT INTO `permisos` VALUES (82, 42, 5, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (83, 42, 6, 0, 0, 0, 0);
INSERT INTO `permisos` VALUES (84, 42, 7, 1, 0, 0, 1);

-- ----------------------------
-- Table structure for persona
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombres` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_fiscal` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion_fiscal` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `datecreated` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idrol`(`rolid`) USING BTREE,
  CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of persona
-- ----------------------------
INSERT INTO `persona` VALUES (1, '123123', 'manuel', 'herrera', 23432423, 'sdfsdfsdfsdf', '556d7dc3a115356350f1f9910', '', '', '', '', 39, '2021-07-15 22:44:52', 0);
INSERT INTO `persona` VALUES (2, '444444444', 'zuko', 'rneta', 222224445, 'aaaaaaaaaa@hotmail.com', '91a73fd806ab2c005c13b4dc1', '', '', '', '', 34, '2021-07-15 22:48:42', 0);
INSERT INTO `persona` VALUES (3, '11111111-1', 'JAIME', 'apellido test', 99834192, 'test@contacto.cl', '556d7dc3a115356350f1f9910', '', '', '', '', 34, '2021-07-15 22:58:00', 0);
INSERT INTO `persona` VALUES (4, '11111111-5', 'Felipe', 'ffff', 4454545, 'aaaaa@bbb.cl', '556d7dc3a115356350f1f9910', '', '', '', '', 36, '2021-07-15 23:08:21', 2);
INSERT INTO `persona` VALUES (5, '17786431-5', 'ANDRÉS', 'ASTORGA', 934386071, 'andres.astorga@mayor.cl', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '', '', '', '', 29, '2021-07-16 00:16:38', 1);
INSERT INTO `persona` VALUES (6, '33333333-3', 'JAVIER', 'lopez', 22224445, '3aaaaaaaa@bb.cl', 'b3a8e0e1f9ab1bfe3a36f231f', '', '', '', '', 39, '2021-07-16 00:19:26', 1);
INSERT INTO `persona` VALUES (7, '11222333-4', 'ANDRES', 'ASTORGA', 98888349, 'andres.astorga@contacto.cl', 'a665a45920422f9d417e4867e', '', '', '', '', 41, '2021-07-18 23:33:47', 1);
INSERT INTO `persona` VALUES (8, '333333333', 'sdffdgdgf', 'bbbbb', 45645645, 'ssssss@aaa.lol', '349c41201b62db851192665c5', '', '', '', '', 29, '2021-07-24 14:41:58', 2);
INSERT INTO `persona` VALUES (9, '333333331', 'asdzzz', 'dddd', 45454, 'test@test.com', 'f7bd7059a799f3a0d50193f87', '', '', '', '', 36, '2021-07-24 14:43:05', 0);
INSERT INTO `persona` VALUES (10, '66666666-6', 'katara', 'apellido prueba', 92389457, 'pruebas@prueba.cl', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '', '', '', '', 37, '2021-09-22 23:13:04', 1);
INSERT INTO `persona` VALUES (11, '22222222-2', 'qa', 'apellidos qa', 992382111, 'qa@contacto.cl', '204164d223b35aabb54ea32b1', '', '', '', '', 39, '2021-09-22 23:15:08', 1);
INSERT INTO `persona` VALUES (12, '99999999-9', 'BARBARA', 'HERMOSILLA NAVARRO', 998238123, 'barbi.hermosillan@gmail.com', '5e968ce47ce4a17e3823c2933', '', '', '', '', 37, '2021-09-26 22:40:53', 2);
INSERT INTO `persona` VALUES (13, '00000000-0', 'aaaaaaaaa', 'aasssssssssss', 0, 'dddd', '9b871512327c09ce91dd649b3', '', '', '', '', 37, '2021-09-28 23:49:24', 1);
INSERT INTO `persona` VALUES (14, '20226016-0', 'MATIA', 'ASTORGA', 99983481, 'mastorga@gmail.com', 'f6e0a1e2ac41945a9aa7ff8a8aaa0cebc12a3bcc981a929ad5cf810a090e11ae', '', '', '', '', 37, '2021-09-29 00:37:02', 1);
INSERT INTO `persona` VALUES (15, '444', '3333', 'aseada', 0, 'ffff', '730f75dafd73e047b86acb2db', '', '', '', '', 42, '2021-10-03 23:38:26', 1);
INSERT INTO `persona` VALUES (16, '55555555-5', 'dddddd', 'gggggggggg', 44445555, 'contacto@qa.cl', 'a665a45920422f9d417e4867e', '', '', '', '', 29, '2021-10-04 00:53:29', 1);
INSERT INTO `persona` VALUES (17, '88888888-8', 'PRUEBA NOMBRES', 'PRUEBA APELLIDOS', 88888888, 'prueba@info.cl', '556d7dc3a115356350f1f9910', '', '', '', '', 39, '2021-10-05 01:18:20', 1);

-- ----------------------------
-- Table structure for producto
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto`  (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `decripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `datecreated` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `status` int(11) NOT NULL DEFAULT 1,
  `categoriaid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `categoriaid`(`categoriaid`) USING BTREE,
  INDEX `categoriaid_2`(`categoriaid`) USING BTREE,
  INDEX `categoriaid_3`(`categoriaid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of producto
-- ----------------------------

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rol
-- ----------------------------
INSERT INTO `rol` VALUES (29, 'Custom 1', 'usuario custom 1', 1);
INSERT INTO `rol` VALUES (30, 'Cliente', 'usuario registrado', 0);
INSERT INTO `rol` VALUES (31, 'Cliente 2', 'usuario invitado', 0);
INSERT INTO `rol` VALUES (32, 'prueba', 'prueba', 0);
INSERT INTO `rol` VALUES (33, 'dddddd', '', 0);
INSERT INTO `rol` VALUES (34, 'administrador clientes', 'administrador de usuarios clientes', 1);
INSERT INTO `rol` VALUES (35, 'Administrador pedidos', 'administrador de pedidos', 0);
INSERT INTO `rol` VALUES (36, 'SAC', 'servicio al cliente', 2);
INSERT INTO `rol` VALUES (37, 'Programador', 'Desarrollo y automatiza tareas relacionadas con codigo', 1);
INSERT INTO `rol` VALUES (38, 'abababab', 'gagagaga', 0);
INSERT INTO `rol` VALUES (39, 'cliente', 'usuario cliente', 1);
INSERT INTO `rol` VALUES (40, 'test', 'testing', 0);
INSERT INTO `rol` VALUES (41, 'doctor', 'atiende funcionarios con algún problema de salud', 1);
INSERT INTO `rol` VALUES (42, 'test', 'asadada', 1);

SET FOREIGN_KEY_CHECKS = 1;
