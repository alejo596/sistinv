/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : SQLite
 Source Server Version : 3035005 (3.35.5)
 Source Schema         : main

 Target Server Type    : SQLite
 Target Server Version : 3035005 (3.35.5)
 File Encoding         : 65001

 Date: 17/10/2024 16:10:50
*/

PRAGMA foreign_keys = false;

-- ----------------------------
-- Table structure for requerimientos
-- ----------------------------
DROP TABLE IF EXISTS "requerimientos";
CREATE TABLE "requerimientos" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "descripcion" TEXT NOT NULL,
  "unidad" TEXT NOT NULL,
  "usuario" TEXT NOT NULL,
  "mes" INTEGER NOT NULL,
  "año" INTEGER NOT NULL,
  "update_at" timestamp,
  "created_at" timestamp
);

-- ----------------------------
-- Records of requerimientos
-- ----------------------------

-- ----------------------------
-- Auto increment value for requerimientos
-- ----------------------------

PRAGMA foreign_keys = true;
