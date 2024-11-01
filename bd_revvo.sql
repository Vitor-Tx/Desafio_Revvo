-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/10/2024 às 23:54
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_revvo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `images`, `link`, `created_at`) VALUES
(4, 'HTML & CSS Fundamentals', 'Build beautiful websites using HTML and CSS.', 'uploads/html_css_thumbnail.jpg', '[\"uploads/html_intro_1.jpg\", \"uploads/css_intro_2.jpg\"]', 'https://example.com/html-css', '2024-10-31 14:00:39'),
(5, 'MySQL for Beginners', 'Understand the basics of database management with MySQL.', 'uploads/mysql_thumbnail.jpg', '[\"uploads/mysql_intro_1.jpg\", \"uploads/mysql_intro_2.jpg\"]', 'https://example.com/mysql', '2024-10-31 14:00:39'),
(7, 'React for Beginners', 'An introduction to building user interfaces with React.', 'uploads/react_thumbnail.jpg', '[\"uploads/react_intro_1.jpg\", \"uploads/react_intro_2.jpg\"]', 'https://example.com/react', '2024-10-31 14:00:39'),
(8, 'Node.js for Beginners', 'Learn how to build backend applications using Node.js.', 'uploads/nodejs_thumbnail.jpg', '[\"uploads/nodejs_intro_1.jpg\", \"uploads/nodejs_intro_2.jpg\"]', 'https://example.com/nodejs', '2024-10-31 14:00:39'),
(9, 'Laravel Essentials', 'Get started with the Laravel PHP framework.', 'uploads/laravel_thumbnail.jpg', '[\"uploads/laravel_intro_1.jpg\", \"uploads/laravel_intro_2.jpg\"]', 'https://example.com/laravel', '2024-10-31 14:00:39'),
(10, 'Angular Fundamentals', 'Discover the core concepts of Angular framework.', 'uploads/angular_thumbnail.jpg', '[\"uploads/angular_intro_1.jpg\", \"uploads/angular_intro_2.jpg\"]', 'https://example.com/angular', '2024-10-31 14:00:39'),
(11, 'Web Development Bootcamp', 'A comprehensive course on web development from start to finish.', 'uploads/webdev_thumbnail.jpg', '[\"uploads/webdev_intro_1.jpg\", \"uploads/webdev_intro_2.jpg\"]', 'https://example.com/webdev', '2024-10-31 14:00:39'),
(12, 'UX/UI Design Basics', 'Learn the principles of User Experience and User Interface design.', 'uploads/uxui_thumbnail.jpg', '[\"uploads/uxui_intro_1.jpg\", \"uploads/uxui_intro_2.jpg\"]', 'https://example.com/uxui', '2024-10-31 14:00:39'),
(14, 'API Development with PHP', 'Learn how to build and consume APIs with PHP.', 'uploads/api_thumbnail.jpg', '[\"uploads/api_intro_1.jpg\", \"uploads/api_intro_2.jpg\"]', 'https://example.com/api', '2024-10-31 14:00:39'),
(15, 'Introduction to DevOps', 'Understand the fundamentals of DevOps practices.', 'uploads/devops_thumbnail.jpg', '[\"uploads/devops_intro_1.jpg\", \"uploads/devops_intro_2.jpg\"]', 'https://example.com/devops', '2024-10-31 14:00:39'),
(19, 'Blockchain Basics2', 'Understand the basics of blockchain technology.', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://example.com/blockchain2', '2024-10-31 14:00:39'),
(21, 'Mobile App Development', 'Create mobile applications with modern frameworks.', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://example.com/mobile2', '2024-10-31 14:00:39'),
(23, 'Updated PHP Basics', 'Learn the fundamentals of PHP programming with updates.', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://example.com/react-basics', '2024-10-31 14:37:13'),
(54, 'PHP Basics', 'Learn the fundamentals of PHP programming.', 'uploads/php_basics_thumbnail.jpg', '[\"uploads\\/php_intro_1.jpg\",\"uploads\\/php_intro_2.jpg\"]', 'https://example.com/php-basics', '2024-10-31 16:27:31'),
(57, 'PHP Advanced2', 'Advanced PHP programming concepts.', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'invalid-url', '2024-10-31 16:30:20'),
(61, 'PHP Basics', 'Learn the fundamentals of PHP programming.', 'uploads/php_basics_thumbnail.jpg', '[\"uploads\\/php_intro_1.jpg\",\"uploads\\/php_intro_2.jpg\"]', 'https://example.com/php-basics', '2024-10-31 16:56:07'),
(65, 'teste', 'sdfsdfdsf', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://gsfsadf.com', '2024-10-31 20:14:10'),
(66, 'zdxvdf', 'dfgdf', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://gsfsadf.com', '2024-10-31 21:37:28'),
(67, 'novo teste', 'teste', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://gsfsadf.com', '2024-10-31 22:25:01'),
(68, 'novo teste 2', 'asdas', 'thumbnail.jpg', '[\"uploads\\/react1.jpg\",\"uploads\\/react2.jpg\"]', 'https://gsfsadf.com', '2024-10-31 22:27:25');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
