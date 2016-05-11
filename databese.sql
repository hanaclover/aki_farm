-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 5 朁E11 日 05:05
-- サーバのバージョン： 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aki_farm_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `reserve`
--

CREATE TABLE `reserve` (
  `RID` int(10) UNSIGNED NOT NULL,
  `UID` int(10) UNSIGNED NOT NULL,
  `SID` int(10) UNSIGNED NOT NULL,
  `StartDay` date NOT NULL,
  `StartTime` time NOT NULL,
  `PeopleNum` int(10) UNSIGNED NOT NULL,
  `Course` int(10) UNSIGNED NOT NULL,
  `Course_4` text,
  `ReservedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Course_flag` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `reserve`
--

INSERT INTO `reserve` (`RID`, `UID`, `SID`, `StartDay`, `StartTime`, `PeopleNum`, `Course`, `Course_4`, `ReservedTime`, `Course_flag`) VALUES
(385, 0, 7, '2016-05-11', '13:05:00', 8, 7, '', '2016-05-11 02:25:48', 0),
(386, 0, 18, '2016-05-11', '10:00:00', 18, 7, '', '2016-05-11 02:29:45', 0),
(387, 0, 9, '2016-05-11', '10:00:00', 18, 7, '', '2016-05-11 02:29:45', 0),
(388, 0, 8, '2016-05-11', '10:00:00', 18, 7, '', '2016-05-11 02:29:45', 0),
(389, 0, 14, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(390, 0, 15, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(391, 0, 16, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(392, 0, 17, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(393, 0, 18, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(394, 0, 8, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(395, 0, 7, '2016-05-11', '15:02:00', 15, 7, '', '2016-05-11 02:41:46', 0),
(396, 0, 0, '2016-05-11', '17:00:00', 14, 10, '', '2016-05-11 02:45:04', 0),
(397, 0, 0, '2016-05-11', '17:00:00', 11, 10, '', '2016-05-11 02:46:24', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `seat`
--

CREATE TABLE `seat` (
  `SID` int(10) UNSIGNED NOT NULL,
  `SNum` int(10) UNSIGNED NOT NULL,
  `MaxPeople` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `seat`
--

INSERT INTO `seat` (`SID`, `SNum`, `MaxPeople`) VALUES
(1, 1, 6),
(2, 2, 6),
(3, 3, 6),
(4, 4, 4),
(5, 5, 4),
(6, 6, 4),
(7, 7, 8),
(8, 8, 8),
(9, 9, 8),
(10, 11, 8),
(11, 12, 8),
(12, 13, 8),
(13, 14, 8),
(14, 21, 16),
(15, 23, 16),
(16, 25, 16),
(17, 27, 16),
(18, 30, 30);

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `UID` int(10) UNSIGNED NOT NULL,
  `FamilyName` text NOT NULL,
  `FirstName` text NOT NULL,
  `FamilyName_kana` text NOT NULL,
  `FirstName_kana` text NOT NULL,
  `PhoneNum` text NOT NULL,
  `Mail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`UID`, `FamilyName`, `FirstName`, `FamilyName_kana`, `FirstName_kana`, `PhoneNum`, `Mail`) VALUES
(1, '齋藤', '裕介', 'さいとう', 'ゆうすけ', '090-1234-1234', 'saito@meijin.com'),
(2, '氏', '名', 'し', 'めい', '090-4321-4321', 'test@meijin.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`RID`),
  ADD KEY `UID` (`UID`),
  ADD KEY `SID` (`SID`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `reserve`
  MODIFY `RID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;
--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `SID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
