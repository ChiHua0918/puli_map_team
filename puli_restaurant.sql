-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-06-09 17:38:35
-- 伺服器版本： 10.4.14-MariaDB
-- PHP 版本： 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `wordpress`
--

-- --------------------------------------------------------

--
-- 資料表結構 `puli_restaurant`
--

DROP TABLE IF EXISTS `puli_restaurant`;
CREATE TABLE `puli_restaurant` (
  `Restaurant_ID` int(20) NOT NULL,
  `Restaurant_name` varchar(20) NOT NULL,
  `Restaurant_TEL` varchar(10) NOT NULL,
  `Restaurant_intro` text NOT NULL,
  `Restaurant_time` text NOT NULL,
  `Restaurant_photo` varchar(20) NOT NULL,
  `Restaurant_comment` text NOT NULL,
  `Restaurant_price` int(10) NOT NULL,
  `Restaurant_address` text NOT NULL,
  `Restaurant_x` decimal(20,0) NOT NULL,
  `Restaurant_y` decimal(20,0) NOT NULL,
  `wordpress_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `puli_restaurant`
--

INSERT INTO `puli_restaurant` (`Restaurant_ID`, `Restaurant_name`, `Restaurant_TEL`, `Restaurant_intro`, `Restaurant_time`, `Restaurant_photo`, `Restaurant_comment`, `Restaurant_price`, `Restaurant_address`, `Restaurant_x`, `Restaurant_y`, `wordpress_link`) VALUES
(66, 'test', '02562', '4561', '星期日 19:30~20:00 22:30~01:00,星期一 11:30~13:45 17:30~20:00 22:30~01:00,星期二 11:30~13:45 17:30~20:00 22:30~01:00,星期三 11:30~13:45 17:30~20:00 22:30~01:00,星期四 11:3~13:45 17:30~20:00 22:30~01:00,星期五 11:30~13:45 17:30~20:00 22:30~01:00,星期六 11:30~13:45 17:30~20:00 22:30~01:00', '', '123', 200, '545南投縣埔里鎮仁愛路319號', '100', '300', 'https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/212226/'),
(67, 'test', '02562', '4561', '星期日 公休,星期一 11:30~13:45 17:30~20:00 22:30~01:00,星期二 11:30~13:45 17:30~20:00 22:30~01:00,星期三 11:30~13:45 17:30~20:00 22:30~01:00,星期四 11:3~13:45 17:30~20:00 22:30~01:00,星期五 11:30~13:45 17:30~20:00 22:30~01:00,星期六 11:30~13:45 17:30~20:00 22:30~01:00', '', '123', 200, '南投縣埔里鎮中華路171號', '200', '500', 'https://jscorpio.pixnet.net/blog/post/30454572'),
(68, 'test', '02562', '4561', '星期日 19:30~20:00 22:30~01:00,星期一 11:30~13:45 17:30~20:00 22:30~01:00,星期二 11:30~13:45 17:30~20:00 22:30~01:00,星期三 11:30~13:45 17:30~20:00 22:30~01:00,星期四 11:3~13:45 17:30~20:00 22:30~01:00,星期五 11:30~13:45 17:30~20:00 22:30~01:00,星期六 11:30~13:45 17:30~20:00', '', '123', 200, '545南投縣埔里鎮仁愛路319號', '100', '300', 'https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/212226/'),
(69, 'test', '02562', '4561', '星期日 19:30~20:00 22:30~01:00,星期一 11:30~13:45 17:30~20:00 22:30~01:00,星期二 11:30~13:45 17:30~20:00 22:30~01:00,星期三 11:30~13:45 17:30~20:00 22:30~01:00,星期四 11:3~13:45 17:30~20:00 22:30~01:00,星期五 11:30~13:45 17:30~20:00 22:30~01:00,星期六 11:30~13:45 17:30~20:00 22:30~01:00', '', '123', 200, '545南投縣埔里鎮仁愛路319號', '100', '300', 'https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/212226/'),
(70, 'test', '02562', '4561', '星期日 19:30~20:00 22:30~01:00,星期一 11:30~13:45 17:30~20:00 22:30~01:00,星期二 11:30~13:45 17:30~20:00 22:30~01:00,星期三 11:30~13:45 17:30~20:00 22:30~01:00,星期四 11:3~13:45 17:30~20:00 22:30~01:00,星期五 11:30~13:45 17:30~20:00 22:30~01:00,星期六 11:30~13:45 17:30~20:00 22:30~02:00', '', '123', 200, '545南投縣埔里鎮信義路994號', '100', '300', 'https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/212226/');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `puli_restaurant`
--
ALTER TABLE `puli_restaurant`
  ADD PRIMARY KEY (`Restaurant_ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `puli_restaurant`
--
ALTER TABLE `puli_restaurant`
  MODIFY `Restaurant_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
