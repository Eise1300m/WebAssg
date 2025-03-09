-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 12:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `secretshelf`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `BookNo` int(11) NOT NULL,
  `BookName` varchar(255) NOT NULL,
  `BookPrice` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `Author` varchar(100) NOT NULL,
  `BookImage` varchar(255) DEFAULT NULL,
  `SubcategoryNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`BookNo`, `BookName`, `BookPrice`, `Description`, `Author`, `BookImage`, `SubcategoryNo`) VALUES
(1, 'Spongebob', 12.99, 'A yellow Sponge who live in the sea', 'Ai Dun No', '../upload/bookPfp/SpongeBob.jpg', 401),
(2, 'Bleach', 18.00, 'Bleach (stylized in all caps) is a Japanese anime television series based on Tite Kubo\'s original manga series Bleach. It was produced by Pierrot and directed by Noriyuki Abe. The series aired on TV Tokyo from October 2004 to March 2012, spanning 366 episodes. The story follows the adventures of Ichigo Kurosaki after he obtains the powers of a Soul Reaper', '	\r\nMasashi Sogo', '../upload/bookPfp/image1.jpg', 205),
(3, 'Hunter x Hunter', 18.00, 'Gon Freecss aspires to become a Hunter, an exceptional being capable of greatness. With his friends and his potential, he seeks out his father, who left him when he was younger. Gon Freecss aspires to become a Hunter, an exceptional being capable of greatness.', 'Yoshihiro Togashi\r\n\r\n', '../upload/bookPfp/image2.jpg', 205);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`BookNo`),
  ADD KEY `SubcategoryNo` (`SubcategoryNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `BookNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`SubcategoryNo`) REFERENCES `subcategory` (`SubcategoryNo`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
