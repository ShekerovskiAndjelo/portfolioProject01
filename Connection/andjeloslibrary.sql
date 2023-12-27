-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2023 at 05:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andjeloslibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`, `bio`, `is_deleted`) VALUES
(6, 'Dale', 'Carnegie', 'Dale Carnegie (1888-1955) was an American author and self-improvement guru, renowned for his book \"How to Win Friends and Influence People,\" promoting interpersonal skills and success principles.', NULL),
(7, 'James', 'Clear', 'James Clear is an author and productivity expert known for \"Atomic Habits,\" emphasizing small changes for significant personal and professional growth.', NULL),
(8, 'Dan', 'Brown', 'Dan Brown is an American author famous for his bestselling thriller novels, including \"The Da Vinci Code,\" known for its intricate conspiracies and code-breaking.', 0),
(9, 'Stephen', 'King', 'Stephen King, a prolific American author of horror, supernatural fiction, and suspense, has written numerous bestsellers, including \"The Shining\" and \"It.\"', 0),
(10, 'Robert T', 'Kiyosaki', 'Robert T. Kiyosaki is an American entrepreneur and author of \"Rich Dad Poor Dad,\" advocating financial education and investment strategies for financial independence.', 0),
(11, 'Howard', 'Zinn', 'Howard Zinn (1922-2010) was a historian and social activist, renowned for \"A People\'s History of the United States,\" advocating for marginalized voices in history.', 0),
(12, 'Gillian', 'Flynn', 'Gillian Flynn, born in 1971, is a bestselling author known for gripping psychological thrillers like \"Gone Girl\" and \"Sharp Objects.\"', 0);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author_id`, `release_year`, `pages`, `image_url`, `category_id`, `is_deleted`) VALUES
(5, 'How to win friends and influence people', 6, 1936, 291, 'https://m.media-amazon.com/images/I/71vK0WVQ4rL._AC_UF1000,1000_QL80_.jpg', 5, 0),
(6, 'Angels and Demons', 8, 2000, 768, 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9780743493468/angels-demons-9780743493468_hr.jpg', 7, 0),
(7, 'The Da Vinci Code', 8, 2003, 689, 'https://m.media-amazon.com/images/I/91Q5dCjc2KL._AC_UF1000,1000_QL80_.jpg', 7, 0),
(8, 'Atomic Habits', 7, 2018, 320, 'https://m.media-amazon.com/images/I/91bYsX41DVL._AC_UF1000,1000_QL80_.jpg', 5, 0),
(9, 'Rich Dad Poor Dad', 10, 1997, 336, 'https://m.media-amazon.com/images/I/81bsw6fnUiL._AC_UF1000,1000_QL80_.jpg', 10, 0),
(10, 'IT', 9, 1986, 1138, 'https://upload.wikimedia.org/wikipedia/commons/1/1a/It_%281986%29_front_cover%2C_first_edition.jpg', 8, 0),
(11, 'A People\'s History of the United States', 11, 1980, 729, 'https://m.media-amazon.com/images/I/71Zb-D8NaGL._AC_UF1000,1000_QL80_.jpg', 9, 0),
(12, 'Gone Girl', 12, 2012, 432, 'https://m.media-amazon.com/images/I/71FZo7-3BnL._AC_UF1000,1000_QL80_.jpg', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `is_deleted`) VALUES
(5, 'Self-help', 0),
(6, 'Thriller', 0),
(7, 'Novel', 0),
(8, 'Horror', 0),
(9, 'History', 0),
(10, 'Finance', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `pending` tinyint(1) DEFAULT 1,
  `is_denied` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `book_id`, `user_id`, `is_approved`, `pending`, `is_denied`, `is_deleted`) VALUES
(39, 'Super kniga', 12, 1, 0, 0, 0, 1),
(40, 'Okej e', 11, 1, 1, 0, 0, 0),
(41, 'Int e', 10, 1, 1, 0, 0, 0),
(42, 'Komentar od drug user test action col', 12, 2, 0, 0, 0, 1),
(43, 'posle pending izbrishan komentar test', 12, 2, 1, 0, 0, 0),
(44, 'lorem', 7, 2, 1, 0, 0, 0),
(45, 'drug user test', 11, 2, 1, 0, 0, 0),
(46, 'posledno test so drug user naredno pending', 10, 2, 1, 0, 0, 0),
(47, 'ostavam pending comment', 8, 2, 0, 1, 0, 0),
(48, 'test', 12, 1, 0, 0, 0, 1),
(49, 'test', 12, 1, 0, 0, 0, 1),
(50, 'test', 12, 1, 0, 0, 0, 1),
(51, 'da dodam komentar', 6, 1, 0, 1, 0, 0),
(52, 'test pak posleden pred bekap', 12, 1, 1, 0, 0, 1),
(53, 'raboti', 12, 1, 0, 0, 0, 1),
(54, 'raboti', 12, 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `book_id`, `content`, `created_at`, `is_deleted`) VALUES
(1, 1, 12, 'aaa', '2023-09-03 12:24:35', 1),
(2, 1, 12, 'aaa', '2023-09-03 12:24:36', 1),
(3, 1, 12, 'test', '2023-09-03 12:26:34', 1),
(4, 1, 12, 'test novo note', '2023-09-03 12:32:36', 1),
(5, 1, 9, 'pak novo note za robert t kiosaki', '2023-09-03 12:33:00', 0),
(6, 2, 12, 'notes od user02', '2023-09-03 12:33:35', 0),
(7, 1, 12, 'aj pak', '2023-09-03 12:42:46', 1),
(8, 1, 12, 'testiram note\n', '2023-09-03 12:47:23', 1),
(9, 1, 12, 'test', '2023-09-03 12:50:41', 1),
(10, 1, 12, 'aaaa', '2023-09-03 12:50:58', 1),
(11, 1, 12, 'aaaa', '2023-09-03 12:51:00', 1),
(12, 1, 12, 'test', '2023-09-03 13:05:04', 1),
(13, 1, 12, 'test note\n', '2023-09-03 13:17:38', 1),
(14, 1, 12, 'raboti ova\n', '2023-09-03 13:17:42', 1),
(15, 1, 12, 'okej e sega\n', '2023-09-03 13:17:49', 0),
(16, 1, 11, 'testiram ushte edno\n', '2023-09-03 13:36:50', 0),
(17, 1, 11, 'asd\n', '2023-09-03 13:37:00', 0),
(18, 1, 10, 'asdasdasdasd', '2023-09-03 13:37:11', 0),
(19, 2, 10, 'test na user02', '2023-09-03 13:37:33', 1),
(20, 2, 10, 'user02 asasdasdasdasd', '2023-09-03 13:37:43', 0),
(21, 2, 10, 'test drug', '2023-09-03 13:37:48', 0),
(22, 1, 12, 'test', '2023-09-03 13:45:02', 1),
(23, 2, 12, 'test posledno', '2023-09-03 14:44:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_Admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `is_Admin`) VALUES
(1, 'user01', '$2y$10$6mZ6YL6ZWfy0NBWuYSckGePKi4biHVYepBS6fFin5xtBQ4g0gyV2i', 'user01@gmail.com', 0),
(2, 'user02', '$2y$10$m93aZQ0oBsgWb8qR7B6kzeOoxdzfxq8dOSJmfTunHnWq6MqS5Gk6O', 'user02@gmail.com', 0),
(3, 'admin1', '$2y$10$/X7pK2SFgCLiu/4gk18niu5k5sDeRyn0pusGeC6pykqSWh/IUizre', 'admin1@example.com', 1),
(4, 'admin2', '$2y$10$YccMrOGaO/LgSt1ZtP2W4egUSgG3Kn4JO8K/Hq8WAI4r7v5zea3Fm', 'admin2@example.com', 1),
(5, 'user05', '$2y$10$qbRi./kddw9IpmiERq8Yl.ck4.5ts7DLDWT7GhhlFohCYz8CGOMT6', 'user05@gmail.com', 0),
(6, 'test01', '$2y$10$k8zRlPUFU2vX.fHQzKetNuzgKi9rce04bhOHKsRFgPR7bT1eN4lBy', 'testtest@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
