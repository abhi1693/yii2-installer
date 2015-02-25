-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2015 at 05:24 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `starter-kit`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `id` CHAR(128) NOT NULL PRIMARY KEY,
  `expire` INT(11),
  `data`   BLOB
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name`  VARCHAR(128) UNIQUE,
  `value` TEXT
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id`                   INT(11)      NOT NULL,
  `username`             VARCHAR(255) NOT NULL,
  `email`                VARCHAR(255) NOT NULL,
  `password_hash`        VARCHAR(255) NOT NULL,
  `super_admin`          INT(11)      DEFAULT NULL,
  `status`               INT(11)      NOT NULL,
  `auth_key`             VARCHAR(255) DEFAULT NULL,
  `activation_token`     VARCHAR (24) DEFAULT NULL ,
  `password_reset_token` VARCHAR(255) DEFAULT NULL,
  `created_at`           DATETIME     NOT NULL,
  `updated_at`           DATETIME     NOT NULL
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id`         INT(11)      NOT NULL,
  `uid`        INT(11)      NOT NULL,
  `name_first` VARCHAR(255) NOT NULL,
  `name_last`  VARCHAR(255) DEFAULT NULL,
  `sex`        INT(11)      DEFAULT NULL
)
  ENGINE =InnoDB
  DEFAULT CHARSET =latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uid` (`uid`), ADD UNIQUE KEY `uid_index` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
ADD CONSTRAINT `profile_uid_user_id` FOREIGN KEY (`uid`) REFERENCES `user` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
