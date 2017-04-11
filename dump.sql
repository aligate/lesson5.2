-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 11 2017 г., 19:12
-- Версия сервера: 5.5.48
-- Версия PHP: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `check`
--

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_user_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `is_done` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `user_id`, `assigned_user_id`, `description`, `is_done`, `date_added`) VALUES
(6, 2, 6, 'Заехать по дороге на работу в авторемонт', 1, '2017-04-10 20:14:22'),
(11, 5, 2, 'домашние задания / php курс', 1, '2017-03-26 15:57:08'),
(12, 5, 2, 'полить цветы', 0, '2017-03-26 16:04:11'),
(13, 5, 2, 'Купить жене подарок', 0, '2017-03-26 20:19:28'),
(14, 6, 2, 'Сходить в гости', 0, '2017-03-26 16:06:55'),
(15, 7, 7, 'Сделать домашнее задание', 1, '2017-03-26 17:55:36'),
(16, 7, 6, 'Сходить в магазин', 0, '2017-03-26 17:56:21'),
(18, 2, 5, 'Помочь соседу с переездом', 1, '2017-04-07 13:28:12'),
(21, 2, 6, 'Погулять с собакой вечером', 0, '2017-04-07 12:24:41'),
(23, 2, 5, 'домашние задания / php курс', 0, '2017-04-07 12:21:31'),
(24, 2, 6, 'Погулять вечером', 0, '2017-04-10 20:14:02'),
(25, 9, 9, 'собрать шкаф', 0, '2017-04-11 14:17:16');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`) VALUES
(2, 'Alex', '202cb962ac59075b964b07152d234b70'),
(5, 'marina', '202cb962ac59075b964b07152d234b70'),
(6, 'Lex', '202cb962ac59075b964b07152d234b70'),
(7, 'Nick', '202cb962ac59075b964b07152d234b70'),
(8, 'Misha', '202cb962ac59075b964b07152d234b70'),
(9, 'Саша', '202cb962ac59075b964b07152d234b70');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
