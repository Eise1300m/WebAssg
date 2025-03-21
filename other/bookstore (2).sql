-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 08:21 PM
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
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `AddressID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `PostalCode` varchar(20) NOT NULL,
  `Country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddressID`, `UserID`, `Street`, `City`, `State`, `PostalCode`, `Country`) VALUES
(1, 3, '45, Jalan Bunga Raya', 'George Town', 'Penang', '10200', 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `BookNo` int(11) NOT NULL,
  `BookName` varchar(60) NOT NULL,
  `BookPrice` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `Author` varchar(50) NOT NULL,
  `BookImage` varchar(255) DEFAULT NULL,
  `SubcategoryNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`BookNo`, `BookName`, `BookPrice`, `Description`, `Author`, `BookImage`, `SubcategoryNo`) VALUES
(1, 'Funny Story', 12.99, 'Funny Story is a romance novel that follows librarian Daphne and Miles, whose exes are dating each other. As they navigate their intertwined lives, they discover unexpected connections and humor in their shared circumstances.', 'Emily Henry', NULL, 101),
(2, 'Book Lovers', 9.99, 'Book Lovers centers on literary agent Nora Stephens, who agrees to a holiday escape to the country. There, she keeps running into Charlie Lastra, a bookish, hard-headed, and arrogant editor she knows from Manhattan. Their repeated encounters lead to a deeper understanding of each other and themselves.', 'Emily Henry', NULL, 101),
(3, 'The Notebook', 8.99, 'The Notebook is an achingly tender story about the enduring power of love. It follows the lives of Noah Calhoun and Allie Nelson, who fall deeply in love one summer but are separated by social differences and war. Years later, they reunite, rekindling a love that withstands the test of time. The narrative also explores their later years, where Noah reads their story to Allie, who suffers from dementia, highlighting themes of memory and devotion.', 'Nicholas Sparks', NULL, 101),
(4, 'The Kiss Quotient', 6.99, 'The Kiss Quotient is an ownvoices book about Stella Lane, who has Asperger\'s syndrome. Stella believes that the best way to improve her dating life is to practice, so she hires escort Michael Phan to teach her about intimacy. Their arrangement leads to unexpected feelings, challenging their perceptions of love and relationships.', 'Helen Hoang', NULL, 101),
(5, 'Lovelight Farms', 10.99, 'In Lovelight Farms, two best friends fake date to reach their holiday happily ever after. Set in a charming small town, the story explores themes of friendship, love, and the magic of the holiday season as the characters navigate their evolving feelings for each other.', 'B.K. Borison', NULL, 101),
(6, 'Red, White & Royal Blue', 3.99, 'Red, White & Royal Blue follows Alex Claremont-Diaz, the First Son of the United States, and Prince Henry of Wales. After a public altercation, they\'re forced to fake a friendship to prevent a diplomatic crisis. Their relationship evolves from fake friendship to a secret romance, challenging their public roles and personal identities. The novel delves into themes of love, duty, and self-discovery.', 'Casey McQuiston', NULL, 101),
(7, 'The Hating Game', 7.99, 'The Hating Game has been cited as a book that has reinvigorated the romantic comedy genre. It tells the story of Lucy Hutton and Joshua Templeman, coworkers who engage in a daily battle of wits and passive-aggressive antics. As they compete for the same promotion, their rivalry takes an unexpected turn, revealing underlying tensions and attractions.', 'Sally Thorne', NULL, 101),
(8, 'Me Before You', 5.99, 'Me Before You is the story of Louisa Clark, a young woman who becomes the caretaker of Will Traynor, a quadriplegic man who is both charming and brash. Their relationship transforms both their lives as they confront challenges, personal growth, and the complexities of love and choice.', 'Jojo Moyes', NULL, 101),
(9, 'Love, Theoretically', 55.99, 'Love, Theoretically follows the many lives of theoretical physicist Elsie Hannaway, who balances her career in academia with a secret job as a fake girlfriend. Her worlds collide when she encounters Jack Smith, a physicist who challenges her professional and personal boundaries, leading to unexpected developments in her life and career.', 'Ali Hazelwood', NULL, 101),
(10, 'Love and Other Words', 10.99, 'Love and Other Words tells a story of two teens, Macy Sorensen and Elliot Petropoulos, bonding through all the angst and fury of life\'s pubescent horrors and wonders. Their deep connection, forged over a shared love of books and words, faces challenges as they grow older and confront past mistakes. The novel alternates between past and present, unraveling the complexities of first love and second chances.', 'Christina Lauren', NULL, 101);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryNo` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryNo`, `CategoryName`) VALUES
(1, 'Novel'),
(2, 'Comic'),
(3, 'Children'),
(4, 'Education');

-- --------------------------------------------------------

--
-- Table structure for table `orderaddress`
--

CREATE TABLE `orderaddress` (
  `OrderAddressID` int(11) NOT NULL,
  `OrderNo` int(11) NOT NULL,
  `AddressID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderaddress`
--

INSERT INTO `orderaddress` (`OrderAddressID`, `OrderNo`, `AddressID`) VALUES
(1, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderNo` int(11) NOT NULL,
  `BookNo` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL CHECK (`Quantity` > 0),
  `Price` decimal(10,2) DEFAULT NULL CHECK (`Price` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderNo`, `BookNo`, `Quantity`, `Price`) VALUES
(4, 4, 1, 6.99),
(4, 9, 2, 11.98),
(5, 1, 1, 12.99),
(5, 4, 1, 6.99),
(6, 5, 5, 54.95),
(7, 1, 1, 12.99),
(7, 5, 1, 10.99),
(7, 6, 1, 3.99),
(7, 10, 1, 10.99),
(8, 1, 3, 38.97),
(9, 9, 1, 5.99),
(10, 1, 1, 12.99),
(11, 2, 1, 9.99),
(12, 1, 1, 12.99),
(12, 9, 1, 55.99),
(13, 1, 1, 12.99),
(14, 1, 1, 12.99),
(15, 1, 1, 12.99),
(16, 10, 3, 32.97),
(17, 1, 2, 25.98),
(18, 1, 1, 12.99),
(20, 5, 1, 10.99),
(20, 9, 1, 55.99),
(20, 10, 1, 10.99);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderNo` int(11) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `PaymentType` enum('Cash','Credit Card','Debit Card','E-Wallet','Bank Transfer') NOT NULL,
  `UserID` int(11) NOT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `OrderStatus` enum('Preparing','Delivering','Complete','Cancelled') NOT NULL DEFAULT 'Preparing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderNo`, `OrderDate`, `TotalQuantity`, `TotalAmount`, `PaymentType`, `UserID`, `AddressID`, `OrderStatus`) VALUES
(4, '2025-03-16 07:46:28', 3, 18.97, 'Credit Card', 3, 1, 'Complete'),
(5, '2025-03-16 08:52:45', 2, 19.98, 'Bank Transfer', 3, 1, 'Complete'),
(6, '2025-03-16 13:23:21', 5, 54.95, '', 3, 1, 'Complete'),
(7, '2025-03-16 18:53:37', 4, 38.96, 'Credit Card', 3, 1, 'Complete'),
(8, '2025-03-16 18:54:28', 3, 38.97, 'Bank Transfer', 3, 1, 'Complete'),
(9, '2025-03-16 18:55:11', 1, 5.99, 'Bank Transfer', 3, 1, 'Complete'),
(10, '2025-03-18 12:27:38', 1, 12.99, 'Cash', 3, 1, 'Complete'),
(11, '2025-03-18 20:12:39', 1, 9.99, 'Cash', 3, NULL, 'Preparing'),
(12, '2025-03-21 17:51:14', 2, 68.98, '', 3, NULL, 'Preparing'),
(13, '2025-03-21 18:07:10', 1, 12.99, '', 3, NULL, 'Preparing'),
(14, '2025-03-21 18:09:58', 1, 12.99, '', 3, NULL, 'Preparing'),
(15, '2025-03-21 18:38:49', 1, 12.99, 'Debit Card', 3, NULL, 'Preparing'),
(16, '2025-03-21 18:41:07', 3, 32.97, 'Cash', 3, NULL, 'Preparing'),
(17, '2025-03-21 18:44:47', 2, 25.98, 'Credit Card', 3, NULL, 'Preparing'),
(18, '2025-03-21 18:47:53', 1, 12.99, 'Cash', 3, NULL, 'Preparing'),
(20, '2025-03-21 19:18:22', 3, 77.97, 'Cash', 3, NULL, 'Preparing');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BookNo` int(11) NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` between 1 and 5),
  `ReviewText` text DEFAULT NULL,
  `ReviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `SubcategoryNo` int(11) NOT NULL,
  `SubcategoryName` varchar(100) NOT NULL,
  `CategoryNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`SubcategoryNo`, `SubcategoryName`, `CategoryNo`) VALUES
(101, 'Romance', 1),
(102, 'Mystery & Thriller', 1),
(103, 'Science Fiction', 1),
(104, 'Fantasy', 1),
(105, 'Horror', 1),
(201, 'Superhero', 2),
(202, 'Horror', 2),
(203, 'Romance', 2),
(204, 'Comedy', 2),
(205, 'Adventure', 2),
(301, 'Mathematics', 3),
(302, 'History', 3),
(303, 'Language Learning', 3),
(304, 'Computer Science', 3),
(305, 'Business & Economics', 3),
(306, 'Psychology', 3),
(401, 'Pictures', 4),
(402, 'Fairy Tales', 4),
(403, 'Educational Stories', 4),
(404, 'Moral Stories', 4),
(405, 'Animal Stories', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ContactNo` varchar(20) NOT NULL,
  `Role` enum('admin','customer') NOT NULL,
  `ProfilePic` varchar(255) DEFAULT '../upload/icon/UnknownUser.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `ContactNo`, `Role`, `ProfilePic`) VALUES
(1, 'admin1', '$2y$10$Hp.BM/NsaE9d1uXM3JH2huUgQeYWW4qrfRgGVwQE5Aj0qqoK.Xhxe', 'admin@bookshop.com', '0123456789', 'admin', '../upload/icon/UnknownUser.jpg'),
(2, 'john', '$2y$10$jrIiJLqUYkdvQvKrn5Xt9.EGrN1F6rKFmGZf3u4bUB8pJQmwOBvx.', 'john.reader@example.com', '0187654321', 'customer', '../upload/icon/UnknownUser.jpg'),
(3, 'Jiajia', '$2y$10$IXAOe7GNNWPz8nJfnGGHoOhBuH2G5ngaZK6fuVlHIe9Y8E2aTvRMG', 'adasd@gmail.com', '0123456789', 'customer', '../upload/customerPfp/3_1742294867.png'),
(4, 'Admin01', '$2y$10$tXaYNPCzpi.3AkeO./jRfeYspgWj8sZLJ11UZHU7PSRkSPFVWhLly', 'AhMan@gmail.com', '0120111222', 'admin', '../upload/adminPfp/4_1742294895.png'),
(5, 'dada', '$2y$10$08SLT3fJbW3flcVKAlwjvulSwW61UEASat7hq9tCcFa4L.denwdee', 'dada@gmail.com', '0158499568', 'customer', '../upload/icon/UnknownUser.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`BookNo`),
  ADD KEY `SubcategoryNo` (`SubcategoryNo`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryNo`);

--
-- Indexes for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD PRIMARY KEY (`OrderAddressID`),
  ADD KEY `OrderNo` (`OrderNo`),
  ADD KEY `AddressID` (`AddressID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderNo`,`BookNo`),
  ADD KEY `BookNo` (`BookNo`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderNo`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `orders_address_fk` (`AddressID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD UNIQUE KEY `UserID` (`UserID`,`BookNo`),
  ADD KEY `BookNo` (`BookNo`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`SubcategoryNo`),
  ADD KEY `CategoryNo` (`CategoryNo`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `BookNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orderaddress`
--
ALTER TABLE `orderaddress`
  MODIFY `OrderAddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `SubcategoryNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`SubcategoryNo`) REFERENCES `subcategory` (`SubcategoryNo`);

--
-- Constraints for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD CONSTRAINT `orderaddress_ibfk_1` FOREIGN KEY (`OrderNo`) REFERENCES `orders` (`OrderNo`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderaddress_ibfk_2` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderNo`) REFERENCES `orders` (`OrderNo`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`BookNo`) REFERENCES `book` (`BookNo`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_fk` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`BookNo`) REFERENCES `book` (`BookNo`) ON DELETE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`CategoryNo`) REFERENCES `category` (`CategoryNo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
