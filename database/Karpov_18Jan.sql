-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 30 2025 г., 11:16
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Karpov_18Jan`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_data` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_service_id` int DEFAULT NULL,
  `custom_service` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_get_service` date NOT NULL,
  `time_get_service` time NOT NULL,
  `type_payment` enum('наличными','банковская карта') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_provision` enum('новая заявка','в работе','услуга оказана','услуга отменена') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'новая заявка',
  `reason_reject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `address`, `contact_data`, `type_service_id`, `custom_service`, `date_get_service`, `time_get_service`, `type_payment`, `status_provision`, `reason_reject`) VALUES
(2, 5, 'Уксивт', '+79867074777', 1, '', '2025-01-30', '09:55:00', 'наличными', 'услуга отменена', 'слишком рано'),
(4, 12, 'Ветошников 50/2', 'Олегов Максим, +79654131558', 1, 'Нужен общий клиниг, но в образовательном учреждении, и обязательно условие что данная уборка будет быстрой и тщательной', '2025-01-30', '16:00:00', 'банковская карта', 'услуга отменена', 'У нас нехватка сотрудников, поэтому вынуждены отклонить вашу заявку');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`) VALUES
(1, 'Общий клининг', 'Уборка жилых и офисных помещений с основным набором услуг'),
(2, 'Генеральная уборка', 'Полная уборка с чисткой ковров и мебели'),
(3, 'Послестроительная уборка', 'Удаление строительного мусора и чистка помещений после ремонта'),
(4, 'Химчистка ковров и мебели', 'Профессиональная химчистка ковров и мягкой мебели');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fio`, `telephone`, `email`, `login`, `password`, `role`) VALUES
(5, 'Денис Витальевич Карпов', '+79867074777', 'lakos208@gmail.com', 'Denis128', '$2y$10$ZhprnzG4rNof3fhYrIjBZ.0nDdeQXPAKSOKjbO9bwcVma2RA31ziO', 'user'),
(8, 'Денис Витальевич Карпов', '+79867074777', 'honorxpremium75@gmail.com', 'admin128', '$2y$10$eHmGgdKRcdIjHbJ0klBJkOtTtYUuvQCVI4SGm1Cg96zHaSjEoSo.i', 'admin'),
(11, 'Карпов Денис Витальевич', '+79857074777', 'admin@mail.ru', 'adminka', '$2y$10$mu1FxlG47MneTT2fE9rj2.KTnVw05Vcwzyu7/5DluSo.GIN66y9Fm', 'admin'),
(12, 'Максимов Никита Сергеевич', '+79654131558', 'maksim@mail.ru', 'maksim', '$2y$10$GXi0deL8SewWPDR5yRTnxOATrfUcLDbh73JNtavrPciX8jnvwxx16', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_service` (`type_service_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`type_service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
