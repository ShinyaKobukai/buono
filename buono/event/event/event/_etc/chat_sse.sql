-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2020 年 1 月 06 日 07:32
-- サーバのバージョン： 10.1.8-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_sse`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_chat`
--

CREATE TABLE `t_chat` (
  `cid` int(11) NOT NULL COMMENT 'チャットID',
  `ctext` varchar(140) NOT NULL COMMENT 'チャット本文',
  `cmade` varchar(20) NOT NULL COMMENT '作成したユーザー名',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='チャットテーブル';

--
-- テーブルのデータのダンプ `t_chat`
--

INSERT INTO `t_chat` (`cid`, `ctext`, `cmade`, `created_at`) VALUES
(1, 'テスト発言', 'test', '2020-01-05 08:15:14'),
(2, 'サンプル発言', 'test', '2020-01-05 08:16:34'),
(3, 'なぜいかない発言', 'test', '2020-01-05 08:24:44'),
(4, 'ホゲ', 'test', '2020-01-05 08:56:54'),
(5, 'わからぬ', 'test', '2020-01-05 08:58:07'),
(6, '他人発言', 'kuro', '2020-01-05 08:58:56'),
(7, '他人発言ver2', 'kuro', '2020-01-06 01:04:59'),
(8, '他人発言ver3', 'kuro', '2020-01-06 01:08:16'),
(9, '他人発言ver4', 'kuro', '2020-01-06 01:09:51'),
(10, '他人発言ver5', 'kuro', '2020-01-06 02:07:41'),
(11, 'おれ発言', 'test', '2020-01-06 03:06:54'),
(12, '他人発言ver6', 'kuro', '2020-01-06 03:48:52'),
(13, '他人発言ver7', 'kuro', '2020-01-06 03:50:54'),
(14, 'おれ的発言ver2', 'test', '2020-01-06 03:54:54'),
(15, '他人発言ver8', 'kuro', '2020-01-06 03:56:39'),
(16, '他人発言ver9', 'kuro', '2020-01-06 04:29:17'),
(17, '他人発言ver10', 'kuro', '2020-01-06 04:46:48'),
(18, 'おれ的発言ver3', 'test', '2020-01-06 04:47:46'),
(19, '他人発言ver11', 'kuro', '2020-01-06 04:53:51'),
(20, '他人発言ver12', 'kuro', '2020-01-06 05:25:13'),
(21, 'おれ的発言ver4', 'test', '2020-01-06 05:26:19'),
(22, 'おれ的発言ver5', 'test', '2020-01-06 05:28:28'),
(23, '他人発言ver13', 'kuro', '2020-01-06 06:45:31');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_user`
--

CREATE TABLE `t_user` (
  `uid` int(11) NOT NULL COMMENT 'ユーザーID',
  `uname` varchar(20) NOT NULL COMMENT 'ユーザー名',
  `upass` char(20) NOT NULL COMMENT 'ユーザーパスワード',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ユーザー作成日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ユーザーテーブル';

--
-- テーブルのデータのダンプ `t_user`
--

INSERT INTO `t_user` (`uid`, `uname`, `upass`, `created_at`) VALUES
(1, 'test', 'pass', '2020-01-05 06:54:46'),
(2, 'kuro', '9696', '2020-01-05 08:57:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_chat`
--
ALTER TABLE `t_chat`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_chat`
--
ALTER TABLE `t_chat`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'チャットID', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
