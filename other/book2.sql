-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 04:48 PM
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
-- Database: `bookshop`
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
(1, 'Funny Story', 12.99, 'Funny Story is a romance novel that follows librarian Daphne and Miles, whose exes are dating each other. As they navigate their intertwined lives, they discover unexpected connections and humor in their shared circumstances.', 'Emily Henry', '../upload/bookPfp/Funny Story.png', 101),
(2, 'Book Lovers', 9.99, 'Book Lovers centers on literary agent Nora Stephens, who agrees to a holiday escape to the country. There, she keeps running into Charlie Lastra, a bookish, hard-headed, and arrogant editor she knows from Manhattan. Their repeated encounters lead to a deeper understanding of each other and themselves.', 'Emily Henry', '../upload/bookPfp/Book Lovers.png', 101),
(3, 'The Notebook', 8.99, 'The Notebook is an achingly tender story about the enduring power of love. It follows the lives of Noah Calhoun and Allie Nelson, who fall deeply in love one summer but are separated by social differences and war. Years later, they reunite, rekindling a love that withstands the test of time. The narrative also explores their later years, where Noah reads their story to Allie, who suffers from dementia, highlighting themes of memory and devotion.', 'Nicholas Sparks', '../upload/bookPfp/The Notebook.png', 101),
(4, 'The Kiss Quotient', 6.99, 'The Kiss Quotient is an ownvoices book about Stella Lane, who has Asperger\'s syndrome. Stella believes that the best way to improve her dating life is to practice, so she hires escort Michael Phan to teach her about intimacy. Their arrangement leads to unexpected feelings, challenging their perceptions of love and relationships.', 'Helen Hoang', '../upload/bookPfp/The Kiss Quotient.png', 101),
(5, 'Lovelight Farms', 10.99, 'In Lovelight Farms, two best friends fake date to reach their holiday happily ever after. Set in a charming small town, the story explores themes of friendship, love, and the magic of the holiday season as the characters navigate their evolving feelings for each other.', 'B.K. Borison', '../upload/bookPfp/Lovelight Farms.png', 101),
(6, 'Red, White & Royal Blue', 3.99, 'Red, White & Royal Blue follows Alex Claremont-Diaz, the First Son of the United States, and Prince Henry of Wales. After a public altercation, they\'re forced to fake a friendship to prevent a diplomatic crisis. Their relationship evolves from fake friendship to a secret romance, challenging their public roles and personal identities. The novel delves into themes of love, duty, and self-discovery.', 'Casey McQuiston', '../upload/bookPfp/Red, White & Royal Blue.png', 101),
(7, 'The Hating Game', 7.99, 'The Hating Game has been cited as a book that has reinvigorated the romantic comedy genre. It tells the story of Lucy Hutton and Joshua Templeman, coworkers who engage in a daily battle of wits and passive-aggressive antics. As they compete for the same promotion, their rivalry takes an unexpected turn, revealing underlying tensions and attractions.', 'Sally Thorne', '../upload/bookPfp/The Hating Game.png', 101),
(8, 'Me Before You', 5.99, 'Me Before You is the story of Louisa Clark, a young woman who becomes the caretaker of Will Traynor, a quadriplegic man who is both charming and brash. Their relationship transforms both their lives as they confront challenges, personal growth, and the complexities of love and choice.', 'Jojo Moyes', '../upload/bookPfp/Me Before You.png', 101),
(9, 'Love, Theoretically', 5.99, 'Love, Theoretically follows the many lives of theoretical physicist Elsie Hannaway, who balances her career in academia with a secret job as a fake girlfriend. Her worlds collide when she encounters Jack Smith, a physicist who challenges her professional and personal boundaries, leading to unexpected developments in her life and career.', 'Ali Hazelwood', '../upload/bookPfp/Love Theoretically.png', 101),
(10, 'Love and Other Words', 10.99, 'Love and Other Words tells a story of two teens, Macy Sorensen and Elliot Petropoulos, bonding through all the angst and fury of life\'s pubescent horrors and wonders. Their deep connection, forged over a shared love of books and words, faces challenges as they grow older and confront past mistakes. The novel alternates between past and present, unraveling the complexities of first love and second chances.', 'Christina Lauren', '../upload/bookPfp/Love and Other Words.png', 101),
(11, 'Famous Last Words', 14.99, 'It is June 21st, the longest day of the year, and new mother Camilla’s life is about to change forever.', 'Gillian McAllister', '../upload/bookPfp/Famous Last Words.png', 102),
(12, 'Listen to Your Sister', 12.99, 'When Jamie’s actions at a protest spiral out of control, the siblings must go on the run.', 'Neena Viel', '../upload/bookPfp/Listen to Your Sister.png', 102),
(13, 'Close Your Eyes and Count to 10', 12.99, 'An extreme game of hide-and-seek turns deadly in this riveting new thriller', 'Lisa Unger', '../upload/bookPfp/Close Your Eyes and Count to 10.png', 102),
(14, 'The Locked Door', 8.99, 'While eleven-year-old Nora Davis was up in her bedroom doing homework, she had no idea her father was killing women in the basement.', 'Freida McFadden', '../upload/bookPfp/The Locked Door.png', 102),
(15, 'The Woman in the Cabin', 10.99, 'Deep in the woods, you can hide more than secrets.', 'Becca Day', '../upload/bookPfp/The Woman in the Cabin.png', 102),
(16, 'Something in the Walls', 14.99, 'Newly minted child psychologist Mina has little experience.', 'Daisy Pearce', '../upload/bookPfp/Something in the Walls.png', 102),
(17, 'You Are Fatally Invited', 13.99, 'An exclusive thriller writer\'s retreat hosted on a private island turns lethal when one of the authors is found murdered in this twisty locked room mystery.', 'Ande Pliego', '../upload/bookPfp/You Are Fatally Invited.png', 102),
(18, 'The Quiet Librarian', 14.99, 'A librarian\'s search for answers leads back to her own dark secrets in this sweeping novel about a woman transformed by war, family, vengeance, and love.', 'Allen Eskens', '../upload/bookPfp/The Quiet Librarian.png', 102),
(19, 'The Otherwhere Post', 10.99, 'A deadly mystery that spans worlds and a teenage girl who must risk everything to uncover the truth.', 'Emily J.Taylor', '../upload/bookPfp/The Otherwhere Post.png', 102),
(20, 'The Meadowbrook Murders', 10.99, 'The Meadowbrook Murders is a gripping mystery about the inextricable way power, privilege, and secrets are linked, and how telling the truth can come at a deadly price.', 'Jessica Goodman', '../upload/bookPfp/The Meadowbrook Murders.png', 102),
(21, 'The Dark Mirror', 11.99, 'Paige Mahoney has no idea how she got to the free world.', 'Samantha Shannon', '../upload/bookPfp/The Dark Mirror.png', 103),
(22, 'The Fourth Consert', 14.99, 'Dalton Greaves is a hero', 'Edward Ashton', '../upload/bookPfp/The Fourth Consort.png', 103),
(23, 'Ambessa', 9.99, 'Ambessa Medarda: Warrior, general, mother.', 'C.L.Clark', '../upload/bookPfp/Ambessa.png', 103),
(24, 'Why on Earth: An Alien Invasion Anthology', 9.99, 'Why on Earth uses an accidental alien invasion to explore love and identity.', 'Vania Stoyanova', '../upload/bookPfp/Why on Earth - An Alien Invasion Anthology.png', 103),
(25, 'Casual', 4.99, 'Valya’s neural implant is amazing.', 'Koji A.Dae', '../upload/bookPfp/Casual.png', 103),
(26, 'The Strange Case of Jane O', 13.99, 'A young mother is struck by a mysterious psychological affliction that illuminates the eerie dimensions of the human mind.', 'Karen Thompson Walker', '../upload/bookPfp/The Strange Case of Jane O.png', 103),
(27, 'All Better Now', 12.99, 'A young adult thriller about a world where happiness becomes contagious and the teens caught in the conspiracy by the powers that be to bring back discontent.', 'Neal Shusterman', '../upload/bookPfp/All Better Now.png', 103),
(28, 'Whiteout', 14.99, 'As the city grinds to a halt, twelve teens band together to help a friend pull off the most epic apology of her life.', 'R.S.Burnett', '../upload/bookPfp/Whiteout.png', 103),
(29, 'The Frozen People', 5.99, 'Ali Dawson and her cold case team investigate crimes so old they\'re frozen—or so their inside joke goes.', 'Elly Griffiths', '../upload/bookPfp/The Frozen People.png', 103),
(30, 'Code Noir: Fictions', 15.99, 'A daring and inventive reimagining of the infamous set of laws, the Code Noir, that once governed Black lives.', 'Canisia Lubrin', '../upload/bookPfp/Code Noir - Fictions.png', 103),
(31, 'Rebel Witch', 8.99, 'Rune Winters is on the run.', 'Kristen Ciccarelli', '../upload/bookPfp/Rebel Witch.png', 104),
(32, 'Our Infinite Fates', 11.99, 'They\'ve loved each other in a thousand lifetimes. They\'ve killed each other in every one.', 'Laura Steven', '../upload/bookPfp/Our Infinite Fates.png', 104),
(33, 'Wings of Starlight', 10.99, 'A young fairy queen must form an unlikely alliance or risk an unspeakable danger destroying all she holds dear.', 'Allison Saft', '../upload/bookPfp/Wings of Starlight.png', 104),
(34, 'The Sirens', 12.99, 'A story of sisters separated by hundreds of years but bound together in more ways than they can imagine.', 'Emilia Hart', '../upload/bookPfp/The Sirens.png', 104),
(35, 'Junie', 13.99, 'A young girl must face a life-altering decision after awakening her sister’s ghost.', 'Erin Crosby Eckstine', '../upload/bookPfp/Junie.png', 104),
(36, 'Emily Wilde\'s Compendium of Lost Tales', 8.99, 'Emily Wilde has spent her life studying faeries.', 'Heather Fawcett', '../upload/bookPfp/Emily Wilde\'s Compendium of Lost Tales.png', 104),
(37, 'Black Woods, Blue Sky', 13.99, 'A novel with life-and-death stakes, about the love between a mother and daughter, and the allure of a wild life.', 'Eowyn Ivey', '../upload/bookPfp/Black Woods, Blue Sky.png', 104),
(38, 'The Rose Bargain', 11.99, 'Every citizen of England is granted one bargain from their immortal fae queen.', 'Sasha Peyton Smitch', '../upload/bookPfp/The Rose Bargain.png', 104),
(39, 'The Beasts We Bury', 6.99, 'It has a unique magic system, secret identities, and complex characters that feel like real people.', 'D.L.Taylor', '../upload/bookPfp/The Beasts We Bury.png', 104),
(40, 'Under the Same Stars', 12.99, 'In Spring 2020, New York City, best friends Miles and Chloe are slogging through the last few months of senior year when an unexpected package...', 'Libba Bray', '../upload/bookPfp/Under the Same Stars.png', 104),
(41, 'Lightfall', 8.99, 'No humans here. Just immortals: their politics, their feuds—and their long buried secrets.', 'Ed Crocker', '../upload/bookPfp/Lightfall.png', 105),
(42, 'Victorian Psycho', 11.99, 'This is a fascinating story about a bloodthirsty governess who learns the true meaning of revenge.', 'Virginia Feito', '../upload/bookPfp/Victorian Psycho.png', 105),
(43, 'Clever Little Thing', 14.99, 'A taut, powerful psychological thriller following a mother who must confront a sudden and terrifying change in her daughter after the abrupt death of their babysitter.', 'Helena Echlin', '../upload/bookPfp/Clever Little Thing.png', 105),
(44, 'Mask of the Deer Woman', 14.99, 'To find a missing young woman, the new tribal marshal must also find herself.', 'Laurie L.Dove', '../upload/bookPfp/Mask of the Deer Woman.png', 105),
(45, 'Our Winter Monster', 14.99, 'Chilling holiday horror about an unhappy couple running from their problems and straight into the maw of a terrifying beast.', 'Dennis A Mahoney', '../upload/bookPfp/Our Winter Monster.png', 105),
(46, 'It', 12.99, 'They were seven teenagers when they first stumbled upon the horror.', 'Stephen King', '../upload/bookPfp/It.png', 105),
(47, 'The Shining', 10.99, 'A family heads to an isolated hotel for the winter, where a sinister presence influences the father into violence.', 'Stephen King', '../upload/bookPfp/The Shining.png', 105),
(48, 'Dracula', 5.99, 'When Jonathan Harker visits Transylvania to help Count Dracula with the purchase of a London house, he makes a series of horrific discoveries about his client.', 'Bram Stoker', '../upload/bookPfp/Dracula.png', 105),
(49, 'Carrie', 11.99, 'The story of misunderstood high school girl Carrie White, her extraordinary telekinetic powers, and her violent rampage of revenge.', 'Stephen King', '../upload/bookPfp/Carrie.png', 105),
(50, 'Doctor Sleep', 8.99, 'A now-adult Dan Torrance must protect a young girl with similar powers from a cult known as The True Knot, who prey on children with powers to remain immortal.', 'Stephen King', '../upload/bookPfp/Doctor Sleep.png', 105),
(101, 'Lore Olympus', 10.99, 'An ingenious take on the Greek Pantheon, Lore Olympus is a modern update on the story of Hades and Persephone.', 'Rachel Smythe', '../upload/bookPfp/Lore Olympus.png', 201),
(102, 'Lunar New Year Love Story', 11.99, 'Valentina Tran was named after Valentine\'s Day, which used to be her favorite holiday.', 'Gene Luen Yang', '../upload/bookPfp/Lunar New Year Love Story.png', 201),
(103, 'Fangs', 8.99, 'A love story between a vampire and a werewolf.', 'Sarah Anderson', '../upload/bookPfp/Fangs.png', 201),
(104, 'Be Kind, My Neighbor', 10.99, 'It’s 1973, the town of Baths, cozy middle-of-nowhere American heartland.', 'Yugo Limbo', '../upload/bookPfp/Be Kind, My Neighbor.png', 201),
(105, 'Jaehon Hwangho', 12.99, 'In order to make the child in the womb a prince or princess, Moaeshu decides to make Ra, who creates stars, the empress.', 'Alphatart', '../upload/bookPfp/Jaehon Hwangho.png', 201),
(106, 'Insomniacs After School', 7.99, 'Ganta Nakami is a high school student who suffers from insomnia.', 'Makoto Ojiro', '../upload/bookPfp/Insomniacs After School.png', 201),
(107, 'A Galaxy Next Door', 9.99, 'After high school, Kuga Ichirou started his career as a manga artist.', 'Gido Amagakure', '../upload/bookPfp/A Galaxy Next Door.png', 201),
(108, 'Crazy in Love', 5.99, 'Daly is a hard working real estate tycoon.', 'Lani Diane Rich', '../upload/bookPfp/Crazy in Love.png', 201),
(109, 'Crazy For You', 6.99, 'When Quinn decides to change her life by adopting a stray dog over everyone\'s objections, everything begins to spiral out of control.', 'Jennifer Cruise', '../upload/bookPfp/Crazy For You.png', 201),
(110, 'Julie and Romeo Get Lucky', 13.99, 'Julie Roseman and Romeo Cacciamani know a thing or two about good fortune.', 'Jeanne Ray', '../upload/bookPfp/Julie and Romeo Get Lucky.png', 201),
(111, 'From Hell', 12.99, 'A dim, subconscious underworld.', 'Alan Moore', '../upload/bookPfp/From Hell.png', 202),
(112, 'Through the Woods', 13.99, 'It came from the woods. Most strange things do.', 'Emily Carroll', '../upload/bookPfp/Through the Woods.png', 202),
(113, 'Uzumaki', 8.99, 'Kurouzu-cho, a small fogbound town on the coast of Japan, is cursed.', 'Junji Ito, Yuji Oniki', '../upload/bookPfp/Uzumaki.png', 202),
(114, '30 Days of Night', 10.99, 'From the darkness, across the frozen wasteland, an evil will come that will bring the residents of Barrow to their knees.', 'Steve Niles', '../upload/bookPfp/30 Days of Night.png', 202),
(115, 'Wytches, Volume 1', 9.99, 'Everything you thought you knew about witches is wrong.', 'Scott Snyder', '../upload/bookPfp/Wytches, Volume 1.png', 202),
(116, 'The Crow', 12.99, 'Soulmates Eric and Shelly are brutally murdered.', 'James O\'Barr', '../upload/bookPfp/The Crow.png', 202),
(117, 'Tomie', 12.99, 'Tomie is a lovecraftian monstrosity trapped in the body of a stunningly beautiful girl.', 'Junji Ito', '../upload/bookPfp/Tomie.png', 202),
(118, 'Fragments of Horror', 8.99, 'An old wooden mansion that turns on its inhabitants.', 'Junji Ito', '../upload/bookPfp/Fragments of Horror.png', 202),
(119, 'Panorama of Hell', 4.99, 'Through the confessions of a fiendish Hell painter born in the aftermath of the bombing of Hiroshima, Hideshi Hino tells a nightmarish story.', 'Hideshi Hino', '../upload/bookPfp/Panorama of Hell.png', 202),
(120, 'Severed', 8.99, 'A man haunts the roads; a man with sharp teeth and a hunger for flesh.', 'Scott Snyder', '../upload/bookPfp/Severed.png', 202),
(121, 'Watchmen', 10.99, 'Watchmen, the groundbreaking series from award-winning.', 'Alan Moore', '../upload/bookPfp/Watchmen.png', 203),
(122, 'Batman: The Dark Knight Returns', 12.99, 'This masterpiece of modern comics storytelling brings to vivid life a dark world and an even darker man.', 'Frank Miller', '../upload/bookPfp/Batman - The Dark Knight Returns.png', 203),
(123, 'Kingdom Come', 12.99, 'In a future where metahumans run rampant and are a menace to society.', 'Mark Waid', '../upload/bookPfp/Kingdom Come.png', 203),
(124, 'Marvels', 14.99, 'Here, burning figures roam the streets, men in brightly colored costumes scale the glass and concrete walls.', 'Kurt Busiek', '../upload/bookPfp/Marvels.png', 203),
(125, 'Identity Crisis', 10.99, 'When the spouse of a JLA member is brutally murdered.', 'Braz Melter', '../upload/bookPfp/Identity Crisis.png', 203),
(126, 'Batman: Hush', 8.99, 'The story depicts a mysterious stalker called Hush who seems intent on sabotaging Batman from afar.', 'Jeph Loeb', '../upload/bookPfp/Batman - Hush.png', 203),
(127, 'Marvel 1602', 7.99, 'In Marvel 1602, award-winning writer Neil Gaiman presents a unique vision of the Marvel Universe set four hundred years in the past.', 'Neil Gaiman', '../upload/bookPfp/Marvel 1602.png', 203),
(128, 'All-Star Superman, Vol.1', 12.99, 'The world\'s greatest superhero must set his affairs in order, beginning by telling Lois Lane the truth about Clark Kent\'s secret identity.', 'Grant Morrison', '../upload/bookPfp/All-Star Superman, Vol.1.png', 203),
(129, 'House of M', 9.99, 'The Avengers and the X-Men are faced with a common foe that becomes their greatest threat: Wanda Maximoff!', 'Brian Michael Bendis', '../upload/bookPfp/House of M.png', 203),
(130, 'Superman for All Seasons', 10.99, 'This hardcover book takes a look at the life of a young Clark Kent as he begins to develop strange powers.', 'Jeph Loeb', '../upload/bookPfp/Superman for All Seasons.png', 203),
(131, 'The Spellman Files', 12.99, 'Meet Isabel \"Izzy\" Spellman, private investigator.', 'Lisa Lutz', '../upload/bookPfp/The Spellman Files.png', 204),
(132, 'Coyote Doggirl', 12.99, 'A gifted equestrian, Coyote Doggirl is half dog, half coyote, and a whole lot of attitude.', 'Lisa Hanawalt', '../upload/bookPfp/Coyote Doggirl.png', 204),
(133, 'French Exit', 14.99, 'A wealthy widow and her adult son who flee New York for Paris in the wake of scandal and financial disintegration.', 'Patrick deWitt', '../upload/bookPfp/French Exit.png', 204),
(134, 'Savage Season', 8.99, 'She was always trouble, but she had this laugh when she was happy in bed that could win Hap over every time.', 'Joe R.Lansdale', '../upload/bookPfp/Savage Season.png', 204),
(135, 'Dad Is Fat', 12.99, 'Jim Gaffigan never imagined he would have his own kids.', 'Jim Gaffigan', '../upload/bookPfp/Dad Is Fat.png', 204),
(136, 'Breakfast of Champions', 8.99, 'Murderously funny satire, as Vonnegut looks at war and pollution in America and reminds us how to see the truth.', 'Kurt Vonnegut Jr', '../upload/bookPfp/Breakfast of Champions.png', 204),
(137, 'Calvin and Hobbes', 6.99, 'Strip that features Calvin, a rambunctious 6-year-old boy, and his stuffed tiger, Hobbes, who comes charmingly to life.', 'Bill Watterson', '../upload/bookPfp/Calvin and Hobbes.png', 204),
(138, 'Food: A Love Story', 12.99, 'Stand-up comedian and author Jim Gaffigan has made his career rhapsodizing over the most treasured dishes of the American diet.', 'Jim Gaffigan', '../upload/bookPfp/Food - A Love Story.png', 204),
(139, 'Undermajordomo Minor', 10.99, 'Is an ink-black comedy of manners, an adventure, and a mystery, and a searing portrayal of rural Alpine bad behaviour.', 'Patrick deWitt', '../upload/bookPfp/Undermajordomo Minor.png', 204),
(140, 'T-Rex Trying', 4.99, 'The T-Rex Trying series features hilarious illustrations depicting the hapless T-Rex and family doing their best in a world made for creatures.', 'Hugh Murphy', '../upload/bookPfp/T-Rex Trying.png', 204),
(141, 'Velvet', 12.99, 'A slick new take on the cold war spy genre.', 'Ed Brubaker', '../upload/bookPfp/Velvet.png', 205),
(142, 'Vacancy', 10.99, 'In a disheveled and ransacked backyard, a dog named Simon has been forgotten by his owners.', 'Jen Lee', '../upload/bookPfp/Vacancy.png', 205),
(143, 'Guts', 8.99, 'Raina wakes up one night with a terrible upset stomach.', 'Raina Telgemeier', '../upload/bookPfp/Guts.png', 205),
(144, 'Gyo', 9.99, 'The floating smell of death hangs over the island.', 'Junji Ito', '../upload/bookPfp/Gyo.png', 205),
(145, 'Cabin Fever', 8.99, 'Greg Heffley is in big trouble', 'Jeff Kinney', '../upload/bookPfp/Cabin Fever.png', 205),
(146, 'Super Mario Adventures', 8.99, 'An adventure following the two super plumbers, Luigi and Mario.', 'Kentaro Takekuma', '../upload/bookPfp/Super Mario Adventures.png', 205),
(147, 'Percy Gloom', 6.99, 'The story begins with our hero bravely striking out on his own for the first time.', 'Cathy Malkasian', '../upload/bookPfp/Percy Gloom.png', 205),
(148, 'Jane Austen: An Illustrated Biography', 9.99, 'Beautifully illustrated and full of interesting facts, this book tells the story of who Jane Austen was from her birth right through to the end.', 'Zena Alkayat', '../upload/bookPfp/Jane Austen - An Illustrated Biography.png', 205),
(149, 'Dogs Rule Nonchalantly', 5.99, 'This humorous and heartwarming look at the everyday interactions between man and man\'s best friend.', 'Mark Ulriksen', '../upload/bookPfp/Dogs Rule Nonchalantly.png', 205),
(150, 'A Dog\'s Life', 10.99, 'This is a really entertaining and funny memoir written from the point of view of a canine of \"mysterious lineage\" named Boy.', 'Peter Mayle', '../upload/bookPfp/A Dog\'s Life.png', 205),
(201, 'The Very Hungry Caterpillar', 8.99, 'One sunny Sunday, the caterpillar was hatched out of a tiny egg.', 'Eric Carle', '../upload/bookPfp/The Very Hungry Caterpillar.png', 301),
(202, 'Green Eggs and Ham', 10.99, 'In this most famous of cumulative tales, the list of places to enjoy green eggs and ham, and friends to enjoy them with.', 'Dr Seuss', '../upload/bookPfp/Green Eggs and Ham.png', 301),
(203, 'Goodnight Moon', 9.99, 'In a great green room, tucked away in bed, is a little bunny.', 'Margaret Wise Brown', '../upload/bookPfp/Goodnight Moon.png', 301),
(204, 'The Giving Tree', 8.99, 'Once there was a tree...and she loved a little boy.', 'Shel Silverstein', '../upload/bookPfp/The Giving Tree.png', 301),
(205, 'The Lorax', 7.99, 'Long before saving the earth became a global concern, Dr. Seuss, speaking through his character the Lorax, warned against mindless progress and the danger it posed to the earth\'s natural beauty.', 'Dr Seuss', '../upload/bookPfp/The Lorax.png', 301),
(206, 'If You Give a Mouse a Cookie', 8.99, 'If a hungry little traveler shows up at your house, you might want to give him a cookie.', 'Laura Joffe Numeroff', '../upload/bookPfp/If You Give a Mouse a Cookie.png', 301),
(207, 'Corduroy', 10.99, 'Corduroy has been on the department store shelf for a long time...', 'Don Freeman', '../upload/bookPfp/Corduroy.png', 301),
(208, 'Chicka Chicka Boom Boom', 7.99, 'The 26 characters in this rhythmic, rhyming baby book are a lowercase alphabet with attitude.', 'Bill Martin Jr', '../upload/bookPfp/Chicka Chicka Boom Boom.png', 301),
(209, 'Are You My Mother?', 9.99, 'Tells a very simple story for children who have just started to read.', 'P.D.Eastman', '../upload/bookPfp/Are You My Mother.png', 301),
(210, 'Stellaluna', 15.99, 'Stellaluna is the tender story of a lost young bat who finally finds her way safely home to her mother and friends.', 'Janell Cannon', '../upload/bookPfp/Stellaluna.png', 301),
(211, 'Peter Pan', 4.99, 'A young boy who can fly and never grows up, Peter Pan spends his never-ending childhood having adventures on the mythical island of Neverland.', 'J.M.Barrie', '../upload/bookPfp/Peter Pan.png', 302),
(212, 'The Little Mermaid', 5.99, 'The story follows the journey of a young mermaid princess who is willing to give up her life in the sea as a mermaid to gain a human soul.', 'Hans Christian Andersen', '../upload/bookPfp/The Little Mermaid.png', 302),
(213, 'The Little Prince', 3.99, 'The story follows a young prince who visits various planets, including Earth, and addresses themes of loneliness, friendship, love, and loss.', 'Antoine de Saint-Exupery', '../upload/bookPfp/The Little Prince.png', 302),
(214, 'Cinderella and the Furry Slippers', 5.99, 'It is a fun take on the Cinderella story, and shows kids that getting what you want is not always the answer.', 'Davide Cali', '../upload/bookPfp/Cinderella and the Furry Slippers.png', 302),
(215, 'Goatilocks and the Three Bears', 10.99, 'This book begins with our main character, Goatilocks, sneaking into the home of her neighbors. Her neighbors were three bears.', 'Erica S.Perl', '../upload/bookPfp/Goatilocks and the Three Bears.png', 302),
(216, 'The Snow Queen', 2.99, 'The Snow Queen is a story about the strength and endurance of childhood friendship.', 'Hans Christian Andersen', '../upload/bookPfp/The Snow Queen.png', 302),
(217, 'The White Cat', 4.99, 'The White Cat is talk about a world changed by magic.', 'Errol Le Cain', '../upload/bookPfp/The White Cat.png', 302),
(218, 'The Reluctant Dragon', 2.99, 'In this beloved classic story, a young boy befriends a poetry-loving dragon living in the Downs above his home.', 'Kenneth Grahame', '../upload/bookPfp/The Reluctant Dragon.png', 302),
(219, 'Red Riding Hood', 14.99, 'Red Riding Hood is a European fairy tale about a young girl and a sly wolf.', 'Beatrix Potter', '../upload/bookPfp/Red Riding Hood.png', 302),
(220, 'The Frog in the Wall', 8.99, 'A tale about broadening one\'s horizons.', 'Alvin Tresselt', '../upload/bookPfp/The Frog in the Wall.png', 302),
(221, 'Punctuation Takes a Vacation', 5.99, 'This book teaches students the importance of the different types of punctuation and what will happen if your punctuation takes a vacation.', 'Robin Pulvel', '../upload/bookPfp/Punctuation Takes a Vacation.png', 303),
(222, 'The Grapes of Math', 5.99, 'The Grapes of Math is a fun book about learning basic math skills in elementary grades.', 'Greg Tang', '../upload/bookPfp/The Grapes of Math.png', 303),
(223, 'Zero the Hero', 11.99, 'Zero knows he\'s worth a lot, and when the other numbers get into trouble, he swoops in to prove that his talents are innumerable.', 'Joan Holub', '../upload/bookPfp/Zero the Hero.png', 303),
(224, 'Math Curse', 6.99, 'Math Curse is a clever, playful, interactive, and slightly distressing picture book demonstrating that everything in life can be a math problem.', 'Jon Scieszka', '../upload/bookPfp/Math Curse.png', 303),
(225, 'How Much Is a Million?', 5.99, 'Knocks complex numbers down to size in a fun, humorous way, helping children conceptualize a difficult mathematical concept.', 'David M.Schwartz', '../upload/bookPfp/How Much Is a Million.png', 303),
(226, 'Dr.Seuss\'s ABC', 7.99, 'Dr. Seuss\'s ABC is a 1963 children\'s A to Z alphabetical picture book.', 'Dr Suess', '../upload/bookPfp/Dr.Seuss\'s ABC.png', 303),
(227, 'The Stone Lions', 4.99, 'The Stone Lion by Margaret Wild is a story about a lifelike stone lion that sits outside the library day in and day out.', 'Gwen Dandridge', '../upload/bookPfp/The Stone Lions.png', 303),
(228, 'Weather Or Not', 6.99, 'Weather is one of the most talked about subjects in the world.', 'Caren Trafford', '../upload/bookPfp/Weather Or Not.png', 303),
(229, 'The Last Honey Bee', 8.99, 'Learn about Manderlee, an adventurous honey bee, and the challenges she must overcome in this beautifully illustrated rhyming story for ages 3+.', 'Wayne Gerard Trotman', '../upload/bookPfp/The Last Honey Bee.png', 303),
(230, 'Eat Your Math Homework', 5.99, 'This collection of yummy recipes and fun math facts is sure to tempt taste buds and make you hungry for more.', 'Ann McCallum Staats', '../upload/bookPfp/Eat Your Math HomeWork.png', 303),
(231, 'Charlotte\'s Web', 7.99, 'Charlotte\'s Web is the story of an unlikely friendship between a runt of a pig named Wilbur and a spider named Charlotte.', 'E.B.White', '../upload/bookPfp/Charlotte\'s Web.png', 304),
(232, 'Winnie-the-Pooh', 8.99, 'It brings to life the adventures of a beloved bear.', 'A.A.Milne', '../upload/bookPfp/Winnie-the-Pooh.png', 304),
(233, 'A Day in the Life of a Muslim Child', 2.99, 'This beautiful book describes a day in the life of a Muslim Child.', 'Abdul Malik Mujahid', '../upload/bookPfp/A Day in the Life of a Muslim Child.png', 304),
(234, 'The Lion, the Witch and the Wardrobe', 5.99, 'It is a fantasy novel for children, by C. S. Lewis, published by Geoffrey Bles in 1950.', 'C.S.Lewis', '../upload/bookPfp/The Lion, the Witch and the Wardrobe.png', 304),
(235, 'The Raven\'s Nest', 7.99, 'The Raven\'s Nest is a profoundly moving meditation on place, identity and how we might live in an era of environmental disruption.', 'Razan Dozom', '../upload/bookPfp/The Raven\'s Nest.png', 304),
(236, 'Stargirl', 4.99, 'Stargirl is an amazing book about individuality and nonconformism.', 'Jerry Spinelli', '../upload/bookPfp/Stargirl.png', 304),
(237, 'Matilda', 7.99, 'Matilda is a little girl who is far too good to be true.', 'Roald Dahl', '../upload/bookPfp/Matilda.png', 304),
(238, 'The Ice Maiden\'s Tale', 13.99, 'The Ice Maiden\'s Tale the perfect story-within-a-story with magic, adventure and romance.', 'Lisa Preziosi', '../upload/bookPfp/The Ice Maiden\'s Tale.png', 304),
(239, 'Born to Run', 7.99, 'At its heart, the story is about human endurance, compassion for others, and the theory that our bodies were \"born to run.', 'Michael Morpurgo', '../upload/bookPfp/Born to Run.png', 304),
(240, 'Sad Simon', 8.99, 'Sad Simon is all about a young Bassett Hound.', 'Louise Tribble', '../upload/bookPfp/Sad Simon.png', 304),
(241, 'The Tale of Peter Rabbit', 9.99, 'Follow the story of naughty Peter Rabbit as he squeezes—predictably—under the gate into Mr. McGregor\'s garden and finds himself in all kinds of trouble!', 'Beatrix Potter', '../upload/bookPfp/The Tale of Peter Rabbit.png', 305),
(242, 'Babe: The Gallent Pig', 4.99, 'When Babe arrives at Hogget Farm, Mrs. Hogget’s thoughts turn to sizzling bacon and juicy pork chops—until he reveals a surprising talent for sheepherding, that is.', 'Dick King-Smitch', '../upload/bookPfp/Babe - The Gallent Pig.png', 305),
(243, 'a Home for Abigail', 6.99, 'A Home for Abigail is based on a true story about an unwanted dog and her journey as she becomes a beloved family member.', 'S.Marriott Cook', '../upload/bookPfp/A Home for Abigail.png', 305),
(244, 'Where the Red Fern Grows', 7.99, 'A highly autobiographical and poignant account of a boy, his two hounds, and raccoon-hunting in the Ozark Mountains.', 'Wilson Rawls', '../upload/bookPfp/Where the Red Fern Grows.png', 305),
(245, 'Make Way for Ducklings', 8.99, 'It is about how a family of ducks tries to live in the city of Boston.', 'Robert McCloskey', '../upload/bookPfp/Make Way for Ducklings.png', 305),
(246, 'The Call of the Wild', 2.99, 'Is a tale about unbreakable spirit and the fight for survival in the frozen Alaskan Klondike.', 'Jack London', '../upload/bookPfp/The Call of the Wild.png', 305),
(247, 'Old Yeller', 9.99, 'Old Yeller is a coming of age story about a boy named Travis and his family living in Salt Lick, Texas in the 1860s.', 'Fred Gipson', '../upload/bookPfp/Old Yeller.png', 305),
(248, 'Andy and The Pharaoh\'s Cat', 6.99, 'A mischievous cat will bring him face to face with the real Pharaoh in an exciting Egyptian adventure he\'ll never forget!', 'Carolyn Watson-Dubisch', '../upload/bookPfp/Andy and The Pharaoh\'s Cat.png', 305),
(249, 'Sunshine\'s Excellent Adventures', 9.99, 'This little book is about a wonderful cat, who shared his life with his devoted adopted parents, Reggie and Anita.', 'Reggie Hill', '../upload/bookPfp/Sunshine\'s Excellent Adventures.png', 305),
(250, 'Cranky Bear Wakes Up', 5.99, 'In this book, we meet a cranky bear who is just waking up from his hibernation.', 'Shawn StJean', '../upload/bookPfp/Cranky Bear Wakes Up.png', 305),
(301, 'Mathematic For Human Flourishing', 14.14, 'An inclusive vision of Mathematics.', 'Francis Su', '../upload/bookPfp/Mathematic For Human Flourishing.png', 401),
(302, 'Making Number Talks Matter', 31.19, 'Making the transition to student-centered learning begins with finding ways to get students to share their thinking, something that can be particularly challenging for math class.', 'Ruth Paker', '../upload/bookPfp/Making Number Talks Matter.png', 401),
(303, 'Math Girls', 16.09, 'Math Girls is a unique introduction to advanced mathematics, delivered through the eyes of three students as they learn to deal with problems seldom found in textbooks.', 'Hiroshi Yuki', '../upload/bookPfp/Math Girls.png', 401),
(304, 'Basic Mathematics', 52.24, 'It provides a firm foundation in basic principles of mathematics and thereby acts as a springboard into calculus, linear algebra and other more advanced topics.', 'Serge Lang', '../upload/bookPfp/Basic Mathematics.png', 401),
(305, 'The Magic of Math: Solving for X and Figuring Out Why', 12.99, 'The Magic of Math is the math book you wish you had in school.', 'Arthur T.Benjamin', '../upload/bookPfp/The Magic of Math.png', 401),
(306, 'Make It Stick: The Science of Successful Learning', 18.70, 'Grappling with the impediments that make learning challenging leads both to more complex mastery and better retention of what was learned.', 'Peter C.Brown', '../upload/bookPfp/Make It Stick - The Science of Successful Learning.png', 402),
(307, 'How Humans Learn: The Science and Stories behind Effective C', 23.70, 'How Humans Learn aims to do just that by peering behind the curtain and surveying research in fields as diverse as developmental psychology, anthropology, and cognitive neuroscience for insight into the science behind learning.', 'Joshua R.Eyler', '../upload/bookPfp/How Human Learn - The Science and Stories behind Effective College Teaching.png', 402),
(308, 'Learn Like a Pro', 9.99, 'A book for learners of all ages containing the best and most updated advice on learning from neuroscience and cognitive psychology.', 'Barbara Oakley', '../upload/bookPfp/Learn Like a Pro.png', 402),
(309, 'Peak: Secrets from the New Science of Expertise', 13.99, 'This book is a breakthrough, a lyrical, powerful, science-based narrative that actually shows us how to get better (much better) at the things we care about.', 'K.Anders Ericsson', '../upload/bookPfp/Peak - Secrets from the New Science of Expertise.png', 402),
(310, 'Understanding How We Learn: A Visual Guide', 15.63, 'The book explores exactly what constitutes good evidence for effective learning and teaching strategies, how to make evidence-based judgments instead of relying on intuition, and how to apply findings from cognitive psychology directly to the classroom.', 'Yana Weinstein', '../upload/bookPfp/Understanding How We Learn - A Visual Guide.png', 402),
(311, 'American Boarding Schools: A Historical Study', 17.61, 'This is the story and history of the schools and the figures prominent in national and international affairs - authors, politicians, educators.', 'James McLachlan', '../upload/bookPfp/American Boarding Schools - A Historical Study.png', 403),
(312, 'A History Of Education In Antiquity', 29.95, 'Marrou shows how education, once formed as a way to train young warriors, eventually became increasingly philosophical and secularized as Christianity took hold in the Roman Empire.', 'Henri-Irenee Marrou', '../upload/bookPfp/A History Of Education In Antiquity.png', 403),
(313, 'Paris Undercover', 13.99, 'More than just a story of two women’s remarkable courage, Paris Undercover is also a vivid, gripping account of deceit, betrayal, and personal redemption.', 'Matthew Goodman', '../upload/bookPfp/Paris Undercover.png', 403),
(314, 'Perfect Victims: And the Politics of Appeal', 9.99, 'Masterfully combining candid testimony, history, and reportage, Perfect Victims presents a powerfully simple dignity for the Palestinian.', 'Mohammed El-Kurd', '../upload/bookPfp/Perfect Victims - And the Politics of Appeal.png', 403),
(315, 'The World After Gaza: A Short History', 15.99, 'From one of our foremost public intellectuals, an essential reckoning with the war in Gaza that reframes our understanding of the ongoing conflict, its historical roots, and the fractured global response.', 'Pankaj Mishra', '../upload/bookPfp/The World After Gaza - A Short History.png', 403),
(316, 'Memory: What Every Language Teacher Should Know', 26.15, 'This book is an introduction to memory written specifically with language teachers in mind.', 'Steve Smitch', '../upload/bookPfp/Memory - What Every Language Teacher Should Know.png', 404),
(317, 'Languages Are Good For Us', 13.56, 'This is a book about languages and the people who love them. It is about the strange and wonderful ways in which humans have used languages since the days of the earliest clay records. About the linguistic threads that connect us all. Above all, it is about pleasure.', 'Sophie Hardach', '../upload/bookPfp/Languages Are Good For Us.png', 404),
(318, 'An Introduction to Language', 77.49, 'An Introduction to Language is ideal for use at all levels and in many different areas of instruction including education, languages, psychology, anthropology, teaching English as a Second Language (TESL), and linguistics.', 'Victoria A.Fromkin', '../upload/bookPfp/An Introduction to Language.png', 404),
(319, 'The English Language: A Guided Tour of the Language', 10.99, 'This fascinating books explores the way the language has developed, and examines the factors that unify it and the variations that divide it both nationwide and worldwide.', 'David Crystal', '../upload/bookPfp/The English Language - A Guided Tour of the Language.png', 404),
(320, 'Word by Word: The Secret Life of Dictionaries', 4.99, 'A sure delight for all lovers of words, Word by Word might also quietly improve readers grasp and use of the English language.', 'Kory Stamper', '../upload/bookPfp/Word by Word - The Secret Life of Dictionaries.png', 404),
(321, 'Python Programming for Young Coders', 14.98, 'Python Programming for Young Coders breaks down complex programming concepts into easy-to-understand chunks, relating them to real-life examples that resonate with young minds.', 'Anand Pandey', '../upload/bookPfp/Python Programming for Young Coders.png', 405),
(322, 'System Design Interview', 37.99, 'This book provides a step-by-step framework for how to tackle a system design question. It includes many real-world examples to illustrate the systematic approach, with detailed steps that you can follow.', 'Alex Xu', '../upload/bookPfp/System Design Interview.png', 405),
(323, 'Java For Dummies', 24.97, 'Along the way, you\'ll gain the skills you need to reuse existing code, create new objects, troubleshoot when things go wrong, and build working programs from the ground up.', 'Barry Burd', '../upload/bookPfp/Java For Dummies.png', 405),
(324, 'PHP Crash Course', 56.33, 'Whether you’re building your first dynamic website or modernizing legacy systems, PHP Crash Course gives you a complete, practical foundation for writing professional web applications.', 'Matt Smitch', '../upload/bookPfp/PHP Crash Course.png', 405),
(325, 'SQL QuickStart Guide', 23.97, 'SQL is the workhorse programming language that forms the backbone of modern data management and interpretation.', 'Walter Shields', '../upload/bookPfp/SQL QuickStart Guide.png', 405),
(326, 'Statistics for Business and Economics', 62.55, 'Statistics for Business and Economics is a comprehensive textbook on Statistics that caters to the needs of students doing a course of any level in the subject.', 'R.P.Hooda', '../upload/bookPfp/Statistics for Business and Economics.png', 406),
(327, 'The Business and Economics of Linux and Open Source', 19.98, 'The book begins with an overview of the business motivations for deploying Linux and Open Source applications in the enterprise, then covers the details of what Linux is, understanding the effect of open source licenses on business and a view into the wide ranging open source communities doing active development.', 'Martin Fink', '../upload/bookPfp/The Business and Economics of Linux and Open Source.png', 406),
(328, 'On Business & Economics', 34.72, 'Included are his ideas about economic freedom, the eternal value of earthly work, stewardship and philanthropy, economic globalization, the workings of God\'s grace in business, and the social function of money.', 'Abraham Kuyper', '../upload/bookPfp/On Business & Economics.png', 406),
(329, 'Games for Business and Economics', 84.15, 'This innovative book shows students how to set up and solve games, particularly those in economics and business, using game theory.', 'Roy Gardner', '../upload/bookPfp/Games for Business and Economics.png', 406),
(330, 'Dictionary of Business and Economics Terms', 19.80, 'This pocket-sized guide is a helpful reference for business students, business managers, and general readers seeking advice and information on specific business subjects.', 'Jack P.Friedman', '../upload/bookPfp/Dictionary of Business and Economics Terms.png', 406),
(331, 'The Design of Everyday Things', 13.99, 'The Design of Everyday Things is a powerful primer on how -- and why -- some products satisfy customers while others only frustrate them.', 'Donald A.Norman', '../upload/bookPfp/The Design of Everyday Things.png', 407),
(332, 'How To Build a Car', 12.49, 'How to Build a Car explores the story of Adrian’s unrivalled 35-year career in Formula One through the prism of the cars he has designed, the drivers he has worked alongside and the races in which he’s been involved.', 'Adrian Newey', '../upload/bookPfp/How To Build a Car.png', 407),
(333, 'Structures: Or Why Things Don\'t Fall Down', 12.99, 'In a book that Business Insider noted as one of the \"14 Books that inspired Elon Musk,\" J.E. Gordon strips engineering of its confusing technical terms, communicating its founding principles in accessible, witty prose.', 'J.E. Gordan', '../upload/bookPfp/Structures - Or Why Things Don\'t Fall Down.png', 407),
(334, 'The Art of Electronics', 101.36, 'Widely accepted as the authoritative text and reference on electronic circuit design, both analog and digital, this book revolutionized the teaching of electronics by emphasizing the methods actually used by circuit designers a combination of some basic laws, rules of thumb, and a large bag of tricks.', 'Paul Horowitz', '../upload/bookPfp/The Art of Electronics.png', 407),
(335, 'Practical Electronics for Inventors', 10.98, 'The book that makes electronics make sense This intuitive, applications-driven guide to electronics for hobbyists, engineers, and students doesn\'t overload readers with technical detail.', 'Paul Scherz', '../upload/bookPfp/Practical Electronics for Inventors.png', 407),
(336, 'The Mother Next Door: Medicine, Deception, and Munchausen by', 14.99, 'The Mother Next Door offers a groundbreaking look at MBP from an unlikely duo: a Seattle novelist whose own family was torn apart by it, and the Texas detective who has worked on more medical child abuse cases than anyone in the nation.', 'Andrea Dunlop', '../upload/bookPfp/The Mother Next Door - Medicine, Deception, and Munchausen by Proxy.png', 408),
(337, 'How to Be Enough: Self-Acceptance for Self-Critics and Perfe', 14.99, 'She delivers seven shifts—including from self-criticism to kindness, control to authenticity, procrastination to productivity, comparison to contentment—to find self-acceptance, rewrite the Inner Rulebook, and most of all, cultivate the authentic human connections we’re all craving.', 'Ellen Hendriksen', '../upload/bookPfp/How to Be Enough - Self-Acceptance for Self-Critics and Perfectionists.png', 408),
(338, 'The Age of Choice: A History of Freedom in Modern Life', 25.99, 'Drawing on a wealth of sources ranging from novels and restaurant menus to the latest scientific findings about choice in psychology and economics, The Age of Choice urges us to rethink the meaning of choice and its promise and limitations in modern life.', 'Sophie Rosenfeld', '../upload/bookPfp/The Age of Choice - A History of Freedom in Modern Life.png', 408),
(339, 'The Wisdom of Your Heart: Discovering the God-given Purpose ', 9.99, 'The Wisdom of Your Heart provides a path for listening to the spiritual insights that your emotions offer every day.', 'Marc Alan Schelske', '../upload/bookPfp/The Wisdom of Your Heart - Discovering the God-given Purpose and Power of Your Emotions.png', 408),
(340, 'The Psychology of Money', 8.69, 'In The Psychology of Money, award-winning author Morgan Housel shares 19 short stories exploring the strange ways people think about money and teaches you how to make better sense of one of life\'s most important topics.', 'Morgan Housel', '../upload/bookPfp/The Psychology of Money.png', 408);

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
(10, 107, 1, 9.99),
(10, 122, 1, 12.99),
(10, 137, 1, 6.99),
(10, 146, 1, 8.99),
(10, 206, 1, 8.99),
(10, 223, 1, 11.99),
(10, 247, 1, 9.99),
(11, 50, 1, 8.99),
(11, 140, 1, 4.99),
(11, 220, 1, 8.99),
(11, 229, 1, 8.99),
(11, 329, 1, 84.15),
(11, 337, 1, 14.99),
(12, 23, 1, 9.99),
(12, 27, 1, 12.99),
(12, 45, 1, 14.99),
(12, 105, 1, 12.99),
(12, 303, 1, 16.09),
(12, 337, 1, 14.99),
(13, 104, 1, 10.99),
(13, 119, 1, 4.99),
(13, 135, 1, 12.99),
(13, 145, 1, 8.99),
(13, 223, 1, 11.99),
(13, 248, 1, 6.99),
(13, 307, 1, 23.70),
(13, 326, 1, 62.55),
(14, 130, 1, 10.99),
(14, 137, 2, 13.98),
(15, 136, 1, 8.99),
(15, 138, 1, 12.99),
(15, 230, 1, 5.99),
(15, 308, 1, 9.99),
(15, 317, 1, 13.56),
(16, 128, 1, 12.99),
(16, 140, 1, 4.99),
(16, 146, 1, 8.99),
(16, 235, 1, 7.99),
(16, 247, 1, 9.99),
(16, 314, 1, 9.99),
(16, 336, 1, 14.99),
(18, 1, 1, 12.99),
(18, 213, 1, 3.99),
(18, 318, 1, 77.49),
(19, 2, 1, 9.99),
(19, 12, 1, 12.99),
(19, 225, 1, 5.99),
(19, 323, 1, 24.97),
(20, 132, 1, 12.99),
(20, 142, 1, 10.99),
(20, 205, 1, 7.99),
(20, 220, 1, 8.99);

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
(10, '2025-03-21 08:02:40', 7, 69.93, 'Credit Card', 4, NULL, 'Complete'),
(11, '2025-03-21 15:30:24', 6, 131.10, 'Credit Card', 5, NULL, 'Complete'),
(12, '2025-03-22 13:33:33', 6, 82.04, 'Credit Card', 1, NULL, 'Delivering'),
(13, '2025-03-22 13:40:45', 8, 143.19, 'Credit Card', 3, NULL, 'Delivering'),
(14, '2025-03-22 13:45:01', 3, 24.97, 'Bank Transfer', 6, NULL, 'Delivering'),
(15, '2025-03-22 13:49:14', 5, 51.52, 'Bank Transfer', 7, NULL, 'Preparing'),
(16, '2025-03-22 13:57:03', 7, 69.93, 'Bank Transfer', 8, NULL, 'Preparing'),
(18, '2025-03-22 14:45:40', 3, 94.47, 'Bank Transfer', 7, NULL, 'Preparing'),
(19, '2025-03-22 14:50:06', 4, 53.94, 'Credit Card', 5, NULL, 'Preparing'),
(20, '2025-03-22 14:52:48', 4, 40.96, 'Bank Transfer', 6, NULL, 'Preparing');

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
(201, 'Romance', 2),
(202, 'Horror', 2),
(203, 'Superhero', 2),
(204, 'Comedy', 2),
(205, 'Adventure', 2),
(301, 'Pictures', 3),
(302, 'Fairy Tales', 3),
(303, 'Educational Stories', 3),
(304, 'Moral Stories', 3),
(305, 'Animal Stories', 3),
(401, 'Mathematic', 4),
(402, 'Science', 4),
(403, 'History', 4),
(404, 'Language Learning', 4),
(405, 'Computer Science', 4),
(406, 'Business & Economics', 4),
(407, 'Enginering', 4),
(408, 'Psychology', 4);

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
(1, 'Jiajia', '$2y$10$IXAOe7GNNWPz8nJfnGGHoOhBuH2G5ngaZK6fuVlHIe9Y8E2aTvRMG', 'adasd@gmail.com', '0123455465', 'customer', '../upload/customerPfp/3_1742146751.png'),
(2, 'Admin01', '$2y$10$tXaYNPCzpi.3AkeO./jRfeYspgWj8sZLJ11UZHU7PSRkSPFVWhLly', 'AhMan@gmail.com', '0120111285', 'admin', '../upload/icon/UnknownUser.jpg'),
(3, 'Dada', '$2y$10$08SLT3fJbW3flcVKAlwjvulSwW61UEASat7hq9tCcFa4L.denwdee', 'dada@gmail.com', '0158499568', 'customer', '../upload/icon/UnknownUser.jpg'),
(4, 'Lingangu', '$2y$10$SoVntdOnTKt7beicvhjjTeQmM5cBkY1hQ.GZmMNLC94WpeRbeH4A.', 'lingangu@gmail.com', '01123456789', 'customer', '../upload/icon/UnknownUser.jpg'),
(5, 'Meme', '$2y$10$VpHT2wbNtx9GCalka5kXOeUUH8lqkkHn23KDdfe2Snvm3G2boqfGO', 'meme@gmail.com', '0127894563', 'customer', '../upload/icon/UnknownUser.jpg'),
(6, 'Dora', '$2y$10$FKtTg2IavPDkT70naTeGoO//ZiLf4o2CbaEg5iTuFDtB7LPD9cDLO', 'dora@gmail.com', '0169987321', 'customer', '../upload/icon/UnknownUser.jpg'),
(7, 'Maggie', '$2y$10$4nC5qd214ndlGYbhvEJlQuEZMIY1LEy.2dOFWRCifZsnAZ1LT27H.', 'maggie@gmail.com', '0105569781', 'customer', '../upload/icon/UnknownUser.jpg'),
(8, 'Jojo', '$2y$10$mU4DnjcXTPlws1wOZ6O4a.8.l.lyFBEvlfmEWxf62UU5.cg5yO76u', 'jojo@gmail.com', '0146632557', 'customer', '../upload/icon/UnknownUser.jpg'),
(9, 'Admin02', '$2y$10$CUbzKXhsry33cnq9HMHZmOwxllWFTILef5clgxB58RYgLGiNdUkYO', 'Bobo@gmail.com', '0111433223', 'admin', '../upload/icon/UnknownUser.jpg');

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
  ADD KEY `UserID` (`UserID`);

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
  MODIFY `BookNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=602;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `SubcategoryNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderNo`) REFERENCES `orders` (`OrderNo`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`BookNo`) REFERENCES `book` (`BookNo`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
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
