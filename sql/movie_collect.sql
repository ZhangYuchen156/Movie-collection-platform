-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2026-04-26 10:42:37
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `movie_collect`
--

-- --------------------------------------------------------

--
-- 表的结构 `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `comment_likes`
--

INSERT INTO `comment_likes` (`id`, `comment_id`, `user_id`) VALUES
(1, 1, 3),
(4, 5, 7),
(5, 6, 1);

-- --------------------------------------------------------

--
-- 表的结构 `movie`
--

CREATE TABLE `movie` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `rating` decimal(3,1) NOT NULL CHECK (`rating` between 0 and 10),
  `poster_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `movie`
--

INSERT INTO `movie` (`id`, `user_id`, `title`, `type`, `rating`, `poster_url`, `description`, `release_date`, `created_at`) VALUES
(1, NULL, 'Detective Chinatown 3', 'Action/Comedy', 7.0, 'images/唐探3 1602207730_772087.jpg', 'Qin Feng and Tang Ren head to Tokyo to solve a bizarre murder case.', '2021-02-12', '2026-04-20 12:06:44'),
(2, NULL, 'Godzilla x Kong: The New Empire', 'Action/Fantasy', 6.5, 'images/哥斯拉大战2 t019bd39f260de77968.jpg', 'Two iconic Titans team up to battle a colossal threat hidden within our world.', '2024-03-29', '2026-04-20 12:06:44'),
(3, NULL, 'Barbie', 'Comedy/Adventure', 7.0, 'images/芭比.jpg', 'Barbie and Ken journey to the real world in this vibrant comedy.', '2023-07-21', '2026-04-20 12:06:44'),
(4, NULL, 'Dune: Part Two', 'Sci-Fi/Action', 8.2, 'images/沙丘2.jpg', 'Paul Atreides joins forces with the Fremen to wage war against those who destroyed his family.', '2024-03-01', '2026-04-20 12:06:44'),
(5, NULL, 'Deadpool & Wolverine', 'Action/Comedy', 8.5, 'images/死侍与金刚狼.jpg', 'R-rated Marvel team-up with time-travel chaos and mutant action.', '2024-07-26', '2026-04-20 12:06:44'),
(6, NULL, 'Inside Out 2', 'Animation/Comedy', 7.8, 'images/头脑特工队2.jpg', 'Riley\'s emotions face new challenges as Anxiety arrives in her mind.', '2024-06-14', '2026-04-20 12:06:44'),
(10, NULL, 'Next Goal Wins', 'Comedy/Sports', 7.2, 'images/抖擞.jpg', 'A heartwarming underdog sports comedy.', '2026-04-15', '2026-04-20 12:06:44'),
(11, NULL, 'Beef', 'Drama/Thriller', 8.3, 'images/怒呛人生p2890296057.jpg', 'A road rage incident spirals into a bitter feud.', '2023-04-06', '2026-04-20 12:06:44'),
(12, NULL, 'The Boys', 'Action/Superhero', 8.7, 'images/黑豹纠察队.jpg', 'A group of vigilantes fight against corrupt superheroes.', '2019-07-25', '2026-04-20 12:06:44'),
(13, NULL, 'Heated Rivalry', 'Action/Drama', 7.5, 'images/巅峰对决.jpg', 'A high-stakes confrontation between rivals.', '2025-11-28', '2026-04-20 12:06:44'),
(14, NULL, 'Avatar: The Last Airbender', 'Animation/Fantasy', 9.0, 'images/安昂传奇：最后的气宗.jpg', 'The Avatar returns to bring balance to the world.', '2026-10-09', '2026-04-20 12:06:44'),
(15, NULL, 'The Mummy', 'Action/Adventure', 6.8, 'images/木乃伊.jpg', 'An ancient Egyptian mummy is awakened to wreak havoc.', '2026-04-07', '2026-04-20 12:06:44'),
(16, NULL, 'Euphoria', 'Drama', 8.3, 'images/亢奋.jpg', 'A group of high school students navigate love and friendship.', '2019-06-16', '2026-04-20 12:06:44'),
(20, NULL, 'Wasp 4', 'Action', 7.1, 'images/黄蜂4.jpg', 'A high-stakes action thriller featuring the iconic Wasp.', '2026-01-10', '2026-04-20 12:06:44'),
(21, NULL, 'Top Diplomat', 'Political/Drama', 7.4, 'images/头号外交官4.jpg', 'A seasoned ambassador navigates global conflicts.', '2026-02-15', '2026-04-20 12:06:44'),
(22, NULL, 'Shadow Spider', 'Superhero/Action', 7.3, 'images/暗影蜘蛛侠.jpg', 'A dark vigilante fights crime in the shadows.', '2026-03-05', '2026-04-20 12:06:44'),
(23, NULL, 'The Vanished', 'Thriller/Mystery', 7.0, 'images/消失之人 Vanished.jpg', 'A detective searches for a missing person.', '2026-01-20', '2026-04-20 12:06:44'),
(24, NULL, 'GG Bond: Racing Heroes', 'Animation/Adventure', 6.9, 'images/猪猪侠大电影之竞速小英雄.jpg', 'An animated racing adventure with GG Bond.', '2026-02-01', '2026-04-20 12:06:44'),
(25, NULL, 'The Devil Wears Prada 2', 'Comedy/Drama', 7.2, 'images/穿普拉达的女王2.jpg', 'A glamorous fashion drama sequel.', '2026-03-12', '2026-04-20 12:06:44'),
(30, NULL, 'The Mandalorian & Grogu', 'Sci-Fi/Adventure', 8.8, 'images/曼达洛人与古古.jpg', 'A bounty hunter and his companion\'s new adventure.', '2026-05-01', '2026-04-20 12:06:44'),
(31, NULL, 'Rebel', 'Action/Thriller', 7.5, 'images/反叛 .jpg', 'No hesitation, no mercy.', '2026-04-20', '2026-04-20 12:06:44'),
(32, NULL, 'Tekken 2', 'Action/Fighting', 7.7, 'images/真人快打2.jpg', 'Fight to become the King of Iron Fist.', '2026-03-18', '2026-04-20 12:06:44'),
(33, NULL, 'Miraculous Ladybug', 'Animation/Adventure', 7.6, 'images/奇迹少女.jpg', 'Rising to protect Paris from villains.', '2026-02-28', '2026-04-20 12:06:44'),
(41, 7, 'Mr. Bean', 'Comedy', 10.0, NULL, NULL, NULL, '2026-04-22 07:59:33');

-- --------------------------------------------------------

--
-- 表的结构 `movie_category`
--

CREATE TABLE `movie_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `movie_category`
--

INSERT INTO `movie_category` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Comedy'),
(3, 'Drama'),
(4, 'Sci-Fi'),
(5, 'Thriller');

-- --------------------------------------------------------

--
-- 表的结构 `movie_comments`
--

CREATE TABLE `movie_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `movie_comments`
--

INSERT INTO `movie_comments` (`id`, `movie_id`, `user_id`, `comment`, `created_at`) VALUES
(6, 4, 8, 'A very beautiful movie. I highly recommend that everyone go to the cinema to experience it!', '2026-04-22 11:06:58');

-- --------------------------------------------------------

--
-- 表的结构 `movie_ratings`
--

CREATE TABLE `movie_ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `rating` decimal(3,1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `movie_ratings`
--

INSERT INTO `movie_ratings` (`id`, `movie_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 10, 5, 9.0, '2026-04-22 03:24:52');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'tom', '$2y$10$zQ2.JR5p6EoXzt1HgMCCpOHu7PoCy6zY1pEC4kN5QQZUyQ7k.JQOu', 'user', '2026-04-17 12:28:13'),
(2, 'lucy', '$2y$10$jbV30pL5e3eDWjUUmr/rGeJPp1LEXbUax5xcc29rxHKr53wLq/6uW', 'user', '2026-04-17 12:29:11'),
(3, 'max', '$2y$10$Lfme3aJSj4Cjtf5zxmd0.eRJzA2G9QEvQ5fXK.I9vWS0Wj.MqYPY6', 'user', '2026-04-17 12:51:55'),
(4, 'leo', '$2y$10$oFJijbWijRmJOAfVNLgti.bOEtuA5ZLoZvYUpNuPx4KO0R3pb7FtG', 'user', '2026-04-20 01:04:48'),
(6, 'amy', '$2y$10$eKlPljOmniE3YeeD4T.2p.VUcetrBwIr.F9B6/p1cZDkoqGtaivy.', 'user', '2026-04-22 07:19:27'),
(8, 'user', '$2y$10$.UG5JFm51sWCnrwfdJYHyOpMtS8ayCMp4urnbz3lspq.wzdUEJ/P2', 'user', '2026-04-22 11:04:04');

--
-- 转储表的索引
--

--
-- 表的索引 `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `movie_category`
--
ALTER TABLE `movie_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `movie_comments`
--
ALTER TABLE `movie_comments`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `movie_ratings`
--
ALTER TABLE `movie_ratings`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- 使用表AUTO_INCREMENT `movie_category`
--
ALTER TABLE `movie_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `movie_comments`
--
ALTER TABLE `movie_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `movie_ratings`
--
ALTER TABLE `movie_ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
