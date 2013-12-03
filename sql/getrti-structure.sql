-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2013 at 10:10 AM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `getrti`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `slug` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `constituencies`
--

CREATE TABLE IF NOT EXISTS `constituencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `constituencies_ibfk_2` (`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mps`
--

CREATE TABLE IF NOT EXISTS `mps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `dob` varchar(128) DEFAULT NULL,
  `party` varchar(128) DEFAULT NULL,
  `permanent_address` varchar(256) DEFAULT NULL,
  `permanent_phone` varchar(256) DEFAULT NULL,
  `delhi_address` varchar(256) DEFAULT NULL,
  `delhi_phone` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `constituency` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `constituency` (`constituency`),
  KEY `name` (`name`),
  KEY `party` (`party`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_stand_on_campaigns`
--

CREATE TABLE IF NOT EXISTS `mp_stand_on_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mp_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `vote` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mp_id` (`mp_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(400) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_key` varchar(32) NOT NULL,
  `dat` datetime NOT NULL,
  `user_agent` varchar(400) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_key` (`session_key`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_vote_on_campaigns`
--

CREATE TABLE IF NOT EXISTS `users_vote_on_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `constituency_id` int(11) NOT NULL,
  `vote` tinyint(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `constituency_id` (`constituency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_comment_on_campaigns`
--

CREATE TABLE IF NOT EXISTS `user_comment_on_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `constituency_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `constituency_id` (`constituency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `constituencies`
--
ALTER TABLE `constituencies`
  ADD CONSTRAINT `constituencies_ibfk_2` FOREIGN KEY (`state`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `mps`
--
ALTER TABLE `mps`
  ADD CONSTRAINT `mps_ibfk_2` FOREIGN KEY (`constituency`) REFERENCES `constituencies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `mp_stand_on_campaigns`
--
ALTER TABLE `mp_stand_on_campaigns`
  ADD CONSTRAINT `mp_stand_on_campaigns_ibfk_3` FOREIGN KEY (`mp_id`) REFERENCES `mps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `mp_stand_on_campaigns_ibfk_4` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD CONSTRAINT `users_sessions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users_vote_on_campaigns`
--
ALTER TABLE `users_vote_on_campaigns`
  ADD CONSTRAINT `users_vote_on_campaigns_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_vote_on_campaigns_ibfk_4` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_vote_on_campaigns_ibfk_5` FOREIGN KEY (`constituency_id`) REFERENCES `constituencies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_comment_on_campaigns`
--
ALTER TABLE `user_comment_on_campaigns`
  ADD CONSTRAINT `user_comment_on_campaigns_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_comment_on_campaigns_ibfk_5` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_comment_on_campaigns_ibfk_6` FOREIGN KEY (`constituency_id`) REFERENCES `constituencies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
