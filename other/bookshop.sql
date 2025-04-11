-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 10:09 PM
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
  `PostalCode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddressID`, `UserID`, `Street`, `City`, `State`, `PostalCode`) VALUES
(1, 1, '45, Jalan Bunga Raya', 'George Town', 'Penang', '10200'),
(2, 11, 'No. 25, Jalan Meranti 3, Taman Bukit Indah', 'Johor Bahru', 'Johor', '81200'),
(3, 12, 'No. 18, Lorong Cempaka 5, Taman Sri Muda', 'Shah Alam', 'Selangor', '40400'),
(4, 13, 'No. 10, Jalan Anggerik 7, Taman Desa', 'Kuala Lumpur', 'Wilayah Persekutuan', '58100'),
(5, 14, 'Jalan Melati Indah 2, Taman Seri Puteri', 'Ipoh', 'Perak', '31400'),
(6, 4, 'No.9, Jalan Melawati 6, Taman Buaya', 'Kajang', 'Selangor', '43000'),
(7, 5, 'kk16, Jalan Tambahan 8, Taman Belakang', 'Alor Setar', 'Kedah', '06550'),
(8, 6, 'M4, Jalan kbk/15, Taman Ikan Bilis', 'Muar', 'Johor', '77400'),
(9, 7, 'Y16, Jalan Port Dickson, Taman Sungai Malim', 'Seremban', 'Negeri Sembilan', '70000'),
(10, 8, 'T14, Jalan Tanah Tinggi, Taman Kantan', 'Cameron Highlands', 'Pahang', '39000'),
(11, 3, '123 Jalan Bunga Raya', 'Kuala Lumpur', 'Wilayah Persekutuan', '52200');

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
(1, 'Funny Story', 22.00, 'Daphne always loved the way her fiancé, Peter, told their story. How they met, fell in love, and moved back to his lakeside hometown to begin their life together. He really was good at telling it... right up until the moment he realized he was actually in love with his childhood best friend Petra.', 'Emily Henry', '../upload/bookPfp/Funny Story.png', 101),
(2, 'Book Lovers', 19.99, 'Nora Stephens’ life is books—she’s read them all—and she is not that type of heroine. Not the plucky one, not the laidback dream girl, and especially not the sweetheart. In fact, the only people Nora is a heroine for are her clients, for whom she lands enormous deals as a cutthroat literary agent, and her beloved little sister Libby.', 'Emily Henry', '../upload/bookPfp/Book Lovers.png', 101),
(3, 'The Notebook', 18.99, 'The Notebook is an achingly tender story about the enduring power of love. It follows the lives of Noah Calhoun and Allie Nelson, who fall deeply in love one summer but are separated by social differences and war. Years later, they reunite, rekindling a love that withstands the test of time. The narrative also explores their later years, where Noah reads their story to Allie, who suffers from dementia, highlighting themes of memory and devotion.', 'Nicholas Sparks', '../upload/bookPfp/The Notebook.png', 101),
(4, 'The Kiss Quotient', 16.99, 'The Kiss Quotient is an ownvoices book about Stella Lane, who has Asperger\'s syndrome. Stella believes that the best way to improve her dating life is to practice, so she hires escort Michael Phan to teach her about intimacy. Their arrangement leads to unexpected feelings, challenging their perceptions of love and relationships.', 'Helen Hoang', '../upload/bookPfp/The Kiss Quotient.png', 101),
(5, 'Lovelight Farms', 10.99, 'In Lovelight Farms, two best friends fake date to reach their holiday happily ever after. Set in a charming small town, the story explores themes of friendship, love, and the magic of the holiday season as the characters navigate their evolving feelings for each other.', 'B.K. Borison', '../upload/bookPfp/Lovelight Farms.png', 101),
(6, 'Red, White & Royal Blue', 23.99, 'Red, White & Royal Blue follows Alex Claremont-Diaz, the First Son of the United States, and Prince Henry of Wales. After a public altercation, they\'re forced to fake a friendship to prevent a diplomatic crisis. Their relationship evolves from fake friendship to a secret romance, challenging their public roles and personal identities. The novel delves into themes of love, duty, and self-discovery.', 'Casey McQuiston', '../upload/bookPfp/Red, White & Royal Blue.png', 101),
(7, 'The Hating Game', 47.99, 'The Hating Game has been cited as a book that has reinvigorated the romantic comedy genre. It tells the story of Lucy Hutton and Joshua Templeman, coworkers who engage in a daily battle of wits and passive-aggressive antics. As they compete for the same promotion, their rivalry takes an unexpected turn, revealing underlying tensions and attractions.', 'Sally Thorne', '../upload/bookPfp/The Hating Game.png', 101),
(8, 'Me Before You', 45.99, 'Me Before You is the story of Louisa Clark, a young woman who becomes the caretaker of Will Traynor, a quadriplegic man who is both charming and brash. Their relationship transforms both their lives as they confront challenges, personal growth, and the complexities of love and choice.', 'Jojo Moyes', '../upload/bookPfp/Me Before You.png', 101),
(9, 'Love, Theoretically', 25.99, 'Love, Theoretically follows the many lives of theoretical physicist Elsie Hannaway, who balances her career in academia with a secret job as a fake girlfriend. Her worlds collide when she encounters Jack Smith, a physicist who challenges her professional and personal boundaries, leading to unexpected developments in her life and career.', 'Ali Hazelwood', '../upload/bookPfp/Love Theoretically.png', 101),
(10, 'Love and Other Words', 10.99, 'Love and Other Words tells a story of two teens, Macy Sorensen and Elliot Petropoulos, bonding through all the angst and fury of life\'s pubescent horrors and wonders. Their deep connection, forged over a shared love of books and words, faces challenges as they grow older and confront past mistakes. The novel alternates between past and present, unraveling the complexities of first love and second chances.', 'Christina Lauren', '../upload/bookPfp/Love and Other Words.png', 101),
(11, 'Famous Last Words', 14.99, 'It is June 21st, the longest day of the year, and new mother Camilla’s life is about to change forever. After months of maternity leave, she will drop her infant daughter off at daycare for the first time and return to her job as a literary agent. Finally, But, when she wakes, her husband Luke isn’t there, and in his place is a cryptic note.', 'Gillian McAllister', '../upload/bookPfp/Famous Last Words.png', 102),
(12, 'Listen to Your Sister', 12.99, 'The story is centered around three siblings—Calla, Dre, and Jamie and the horrors they experience at a remote cabin. 25-year-old Calla Williams is struggling to raise her reckless teenage brother, Jamie, while their other brother, Dre, phones in his promise to help.', 'Neena Viel', '../upload/bookPfp/Listen to Your Sister.png', 102),
(13, 'Close Your Eyes and Count to 10', 12.99, 'When the real game begins, who will make it to the count of 10? Charismatic daredevil and extreme adventurer Maverick Dillan invites you to the ultimate game of hide-and-seek. But as the players gather on Falcao Island, the event quickly spirals into a chilling test of survival.', 'Lisa Unger', '../upload/bookPfp/Close Your Eyes and Count to 10.png', 102),
(14, 'The Locked Door', 28.99, 'While eleven-year-old Nora Davis was up in her bedroom doing homework, she had no idea her father was killing women in the basement. Until the day the police arrived at their front door. Decades later, Nora\'s father is spending his life behind bars, and Nora is a successful surgeon with a quiet, solitary existence.', 'Freida McFadden', '../upload/bookPfp/The Locked Door.png', 102),
(15, 'The Woman in the Cabin', 10.99, 'The brand-new thriller from the bestselling author of The Girl Beyond the Gate! Deep in the woods, you can hide more than secrets... Every day, in a remote cabin hidden deep in the woods in the Scottish Highlands, Mary wakes up before dawn to make breakfast from scratch. She tends the garden and feeds the animals.', 'Becca Day', '../upload/bookPfp/The Woman in the Cabin.png', 102),
(16, 'Something in the Walls', 14.99, 'This witchy story follows Mina, a newly certified child psychologist. She takes on a peculiar case of a thirteen-year-old girl who claims to be haunted by a witch. This book is a truly unique and unputdownable reading experience. The plot has thick, foreboding tension dripping from the pages from start to finish.', 'Daisy Pearce', '../upload/bookPfp/Something in the Walls.png', 102),
(17, 'You Are Fatally Invited', 13.99, 'Six thriller authors have been invited to the remote house of anonymous author J.R. Alastor to take part in a writer\'s retreat. Featuring dinner games and writing tips, this was an opportunity not to be missed. But when a writer goes missing, the authors realise the stakes may be higher than they expected…', 'Ande Pliego', '../upload/bookPfp/You Are Fatally Invited.png', 102),
(18, 'The Quiet Librarian', 14.99, 'Hana Babic is a quiet, middle-aged librarian in Minnesota who wants nothing more than to be left alone. But when a detective arrives with the news that her best friend has been murdered, Hana knows that something evil has come for her, a dark remnant of the past she and her friend had shared.', 'Allen Eskens', '../upload/bookPfp/The Quiet Librarian.png', 102),
(19, 'The Otherwhere Post', 10.99, 'The Otherwhere Post is a mysterious dark academia novel that centers around Maeve Abenthy, who could lose her freedom with a single mistake. Seven years ago, a terrible beast attacked one of the three known worlds. To stop the danger from spreading, the Written Doors that connected the worlds were burned.', 'Emily J.Taylor', '../upload/bookPfp/The Otherwhere Post.png', 102),
(20, 'The Meadowbrook Murders', 10.99, 'A page-turning murder mystery set at a prestigious New England boarding school and the dark secrets a killer desperately wants hidden. Secrets don\'t die when you do. It\'s the first week of senior year at Meadowbrook Academy.', 'Jessica Goodman', '../upload/bookPfp/The Meadowbrook Murders.png', 102),
(21, 'The Dark Mirror', 11.99, 'As she makes her way back to the revolution, her journey takes her to Venice, where she learns a dangerous secret – one that could change the face of the war between humans and immortals. Before she can return to London, she must help the Domino Programme unravel the sinister Operation Ventriloquist.', 'Samantha Shannon', '../upload/bookPfp/The Dark Mirror.png', 103),
(22, 'The Fourth Consert', 14.99, 'The Fourth Consort is a sci-fi novel set in a universe where the earth is still very much like the present, but part of the space-faring Unity, after aliens showed up to make sure humans don\'t destroy the planet. But the Unity isn\'t quite that altruistic and they always get something in return.', 'Edward Ashton', '../upload/bookPfp/The Fourth Consort.png', 103),
(23, 'Ambessa', 29.99, 'All who know the name Medarda respect and fear the family\'s leader, Ambessa. As a Noxian general, she embodies a deadly combination of ruthless strength and fearless resolve in battle. Her role as matriarch is no different, requiring great cunning to empower the Medardas while leaving no room for failure or compassion.', 'C.L.Clark', '../upload/bookPfp/Ambessa.png', 103),
(24, 'Why on Earth: An Alien Invasion Anthology', 24.99, 'With tales of disguised extraterrestrials stuck in theme parks, starship engineers hitchhiking to get home, and myth-inspired intergalactic sibling reunions, each story in this multi-author anthology explores the universal desire to be loved and understood, no matter where you come from.', 'Vania Stoyanova', '../upload/bookPfp/Why on Earth - An Alien Invasion Anthology.png', 103),
(25, 'Casual', 34.99, 'Casual is a stark and cutting glance at a near future that looks uncannily like our present, exploring themes of bodily autonomy and the struggle for mental health in a world increasingly divided. “Complex, compelling, and incredibly imagined.', 'Koji A.Dae', '../upload/bookPfp/Casual.png', 103),
(26, 'The Strange Case of Jane O', 13.99, 'A young woman, Jane O., arrives in a psychiatrist\'s office. She\'s been suffering a series of worrying episodes: amnesia, premonitions, hallucinations and an inexplicable sense of dread. But as the psychiatrist struggles to solve the mystery of what is happening in Jane\'s mind, she suddenly goes missing.', 'Karen Thompson Walker', '../upload/bookPfp/The Strange Case of Jane O.png', 103),
(27, 'All Better Now', 12.99, 'From New York Times bestselling author Neal Shusterman comes a young adult thriller about a world where happiness is contagious but the risks of catching it may be just as dangerous as the cure. A deadly and unprecedented virus is spreading.', 'Neal Shusterman', '../upload/bookPfp/All Better Now.png', 103),
(28, 'Whiteout', 14.99, 'It’s been four months since glaciologist Rachael Beckett left her husband and daughter to join an urgent research trip to a remote field station deep in the Antarctic. But after losing all communication with her crew at base camp, she’s trapped and alone – and running out of supplies.', 'R.S.Burnett', '../upload/bookPfp/Whiteout.png', 103),
(29, 'The Frozen People', 25.99, 'Ali Dawson and her cold case team investigate crimes so old, they\'re frozen—or so their inside joke goes. Nobody knows that her team has a secret: they can travel back in time to look for evidence.', 'Elly Griffiths', '../upload/bookPfp/The Frozen People.png', 103),
(30, 'Code Noir: Fictions', 15.99, 'The original Code had fifty-nine articles; Code Noir has fifty-nine short, linked fictions that present vivid, unforgettable, multi-layered fragments of Black life as it really existed and still exists, winding in and around, over and under the official decrees, refusing to be contained or ruled.', 'Canisia Lubrin', '../upload/bookPfp/Code Noir - Fictions.png', 103),
(31, 'Rebel Witch', 28.99, 'Gideon won\'t allow the Republic to fall to the witches and be plunged back into the nightmares of the past. In order to protect this new world he fought for, every last witch must die―especially Rune Winters. When Rune makes Gideon an offer he can\'t refuse, the two must pair up to accomplish dangerous goals.', 'Kristen Ciccarelli', '../upload/bookPfp/Rebel Witch.png', 104),
(32, 'Our Infinite Fates', 31.50, 'Our Infinite Fates follows Evelyn, a young woman who is cursed with the knowledge that she will die before her eighteenth birthday. How does she know this? Because it\'s happened to her in every lifetime she\'s lived for centuries as a reincarnated soul.', 'Laura Steven', '../upload/bookPfp/Our Infinite Fates.png', 104),
(33, 'Wings of Starlight', 20.50, 'Wings of Starlight by bestselling author Allison Saft is a teen romance based on the Disney Fairies franchise. Clarion, the Queen-to-be of Pixie Hollow, must form an alliance with the mysterious winter fairies to stop an ancient evil. The book has some mild romance like kissing and embracing.', 'Allison Saft', '../upload/bookPfp/Wings of Starlight.png', 104),
(34, 'The Sirens', 12.99, 'A story of sisters separated by hundreds of years but bound together in more ways than they can imagine. A breathtaking tale of female resilience, The Sirens is an extraordinary novel that captures the sheer power of sisterhood and the indefinable magic of the sea.', 'Emilia Hart', '../upload/bookPfp/The Sirens.png', 104),
(35, 'Junie', 13.99, 'Sixteen years old and enslaved since she was born, Junie has spent her life on Bellereine Plantation in Alabama, cooking and cleaning alongside her family, and tending to the white master\'s daughter, Violet.', 'Erin Crosby Eckstine', '../upload/bookPfp/Junie.png', 104),
(36, 'Emily Wilde\'s Compendium of Lost Tales', 38.99, 'A renowned dryadologist, she has documented hundreds of species of Folk in her Encyclopaedia of Faeries. Now she is about to embark on her most dangerous academic project yet: studying the inner workings of a faerie realm—as its queen.', 'Heather Fawcett', '../upload/bookPfp/Emily Wilde\'s Compendium of Lost Tales.png', 104),
(37, 'Black Woods, Blue Sky', 13.99, 'Black Woods, Blue Sky chases that pursuit of wildness to the most dizzying, dangerous heights. Set in rural Alaska, it follows the journey of a young mother, Birdie, and her daughter, Emaleen, as they venture out from a dull roadside lodge into the remote Alaskan backcountry, joined by a mysterious man named Arthur.', 'Eowyn Ivey', '../upload/bookPfp/Black Woods, Blue Sky.png', 104),
(38, 'The Rose Bargain', 21.99, 'Every citizen of England is granted one bargain from their immortal fae queen. High society girls are expected to bargain for qualities that will win them suitors: a rare talent for piano in exchange for one\'s happiest childhood memory. A perfect smile for one\'s ability to taste.', 'Sasha Peyton Smitch', '../upload/bookPfp/The Rose Bargain.png', 104),
(39, 'The Beasts We Bury', 26.50, 'This is a compelling dark YA romantasy about Mancella, who is heir to the throne, and whose magic allows her to summon animals, but only after she\'s killed them with her bare hands. Her father is a monster and a tyrant, and in her bid to escape his control, she meets Silver, a charming, sarcastic, thief and liar', 'D.L.Taylor', '../upload/bookPfp/The Beasts We Bury.png', 104),
(40, 'Under the Same Stars', 12.99, 'Under the Same Stars weaves together the stories of six teenagers across 80 years. It begins on a winter night in 1941. Best friends Sophie and Hanna have come to the forest outside of their small town in Germany to retrieve an envelope hidden deep in an old oak tree when they hear \"something\" coming.', 'Libba Bray', '../upload/bookPfp/Under the Same Stars.png', 104),
(41, 'Lightfall', 28.50, 'An epic fantasy of vampires, werewolves and sorcerers, Lightfall is the debut novel of Ed Crocker, for fans of Jay Kristoff\'s Empire of the Vampire and Richard Swan\'s The Justice of Kings. No humans here. Just immortals: their politics, their feuds—and their long buried secrets.', 'Ed Crocker', '../upload/bookPfp/Lightfall.png', 105),
(42, 'Victorian Psycho', 17.99, 'The title actually works as a succinct but sufficient summary: In Victorian-era England, a psychotic governess, Winifred, is bent on revenge and murder, and she narrates her evils over the course of three months leading up to Christmas.', 'Virginia Feito', '../upload/bookPfp/Victorian Psycho.png', 105),
(43, 'Clever Little Thing', 14.99, 'Clever Little Thing is a sharp and unflinching twist on mom noir—part psychological thriller, part supernatural horror, this is a perfectly unnerving story with something to say about the collision of motherhood\'s love and fear, maternal instinct, and the bond between mothers and daughters..', 'Helena Echlin', '../upload/bookPfp/Clever Little Thing.png', 105),
(44, 'Mask of the Deer Woman', 14.99, 'In the past decade, too many young women have disappeared from the rez. Some have ended up dead, others just… gone. Now local college student Chenoa Cloud is missing, and Starr falls into an investigation that leaves her drowning in memories of her daughter—the girl she failed to save.', 'Laurie L.Dove', '../upload/bookPfp/Mask of the Deer Woman.png', 105),
(45, 'Our Winter Monster', 34.99, 'For the last year, Holly and Brian have been out of sync. Neither can forget what happened that one winter evening; neither can forgive what’s happened since. Tonight, Holly and Brian race toward Pinebuck, New York, trying to outrun a blizzard on their way to the ski village getaway they hope will save their relationship. But soon they lose control of the car—and then of themselves.', 'Dennis A Mahoney', '../upload/bookPfp/Our Winter Monster.png', 105),
(46, 'It', 52.99, 'It is a 1986 horror novel by American author Stephen King. It was King\'s 22nd book and the 17th novel written under his own name. The story follows the experiences of seven children terrorized by an evil entity that exploits the fears of its victims to disguise itself while hunting its prey.', 'Stephen King', '../upload/bookPfp/It.png', 105),
(47, 'The Shining', 30.99, 'A family heads to an isolated hotel for the winter, where a sinister presence influences the father into violence. At the same time, his psychic son sees horrifying forebodings from both the past and the future.', 'Stephen King', '../upload/bookPfp/The Shining.png', 105),
(48, 'Dracula', 75.99, 'When Jonathan Harker visits Transylvania to help Count Dracula with the purchase of a London house, he makes a series of horrific discoveries about his client. Soon afterwards, various bizarre incidents unfold in England: an apparently unmanned ship is wrecked off the coast of Whitby; a young woman discovers strange puncture marks on her neck.', 'Bram Stoker', '../upload/bookPfp/Dracula.png', 105),
(49, 'Carrie', 41.99, 'A modern classic, Carrie introduced a distinctive new voice in American fiction -- Stephen King. The story of misunderstood high school girl Carrie White, her extraordinary telekinetic powers, and her violent rampage of revenge, remains one of the most barrier-breaking and shocking novels of all time.', 'Stephen King', '../upload/bookPfp/Carrie.png', 105),
(50, 'Doctor Sleep', 48.50, 'On highways across America, a tribe of people called The True Knot travel in search of sustenance. They look harmless - mostly old, lots of polyester, and married to their RVs. But as Dan Torrance knows, and spunky 12-year-old Abra Stone learns, The True Knot are quasi-immortal, living off the \"steam\" that children with the \"shining\" produce when they are slowly tortured to death.', 'Stephen King', '../upload/bookPfp/Doctor Sleep.png', 105),
(101, 'Lore Olympus', 20.99, 'An ingenious take on the Greek Pantheon, Lore Olympus is a modern update on the story of Hades and Persephone. Follow the propulsive love story of two Greek gods, told with lavish artwork and contemporary sensibilities.', 'Rachel Smythe', '../upload/bookPfp/Lore Olympus.png', 201),
(102, 'Lunar New Year Love Story', 21.99, 'Val is ready to give up on love. It\'s led to nothing but secrets and heartbreak, and she\'s pretty sure she\'s cursed—no one in her family, for generations, has ever had any luck with love. But then a chance encounter with a pair of cute lion dancers sparks something in Val. Is it real love?', 'Gene Luen Yang', '../upload/bookPfp/Lunar New Year Love Story.png', 201),
(103, 'Fangs', 58.50, 'Elsie the vampire is three hundred years old, but in all that time, she has never met her match. This all changes one night in a bar when she meets Jimmy, a charming werewolf with a wry sense of humor and a fondness for running wild during the full moon.', 'Sarah Anderson', '../upload/bookPfp/Fangs.png', 201),
(104, 'Be Kind, My Neighbor', 40.99, 'Be Kind, My Neighbor is set in 1973 in the small American town of Baths. Here Mr. Neighbor, an endearingly friendly rag doll, forms a friendship with Wegg, a travelling busker, after the latter is the victim of a street assault.', 'Yugo Limbo', '../upload/bookPfp/Be Kind, My Neighbor.png', 201),
(105, 'Jaehon Hwangho', 22.99, 'Navier, the perfect empress of the Eastern Empire. When she finds out that her husband, the emperor, is trying to make his wife the empress, she decides to divorce. And she decides. If she can\'t be the empress here, she\'ll be the empress somewhere else.', 'Alphatart', '../upload/bookPfp/Jaehon Hwangho.png', 201),
(106, 'Insomniacs After School', 67.00, 'In the small city of Nanao, insomniac Ganta Nakami tries to catch a nap in his school\'s abandoned astronomical observatory. There he stumbles upon a sociable and carefree girl named Isaki Magari who has the same problem. The two form an awkward friendship and reestablish their school\'s defunct astronomy club.', 'Makoto Ojiro', '../upload/bookPfp/Insomniacs After School.png', 201),
(107, 'A Galaxy Next Door', 19.99, 'A struggling manga artist starts a romance with his new assistant, who turns out to be an extraterrestrial being in hiding. A struggling manga artist starts a romance with his new assistant, who turns out to be an extraterrestrial being in hiding.', 'Gido Amagakure', '../upload/bookPfp/A Galaxy Next Door.png', 201),
(108, 'Crazy in Love', 25.00, 'I caved and gave Harrison Decker my number anyway. He just chose not to use it. Four years later, his job brings him back into my world looking more handsome than ever and now making an effort to befriend me. Is my heart willing to take another chance on that man?', 'Lani Diane Rich', '../upload/bookPfp/Crazy in Love.png', 201),
(109, 'Crazy For You', 16.99, 'The story of Quinn, who decides to adopt a dog–such a little change–and sparks changes in the lives of her best friends, her parents, her students, and the two men who love her. On animals: Katie is taken directly from my dog, Rosie, an equally anxious, equally nervous, equally endearing rescue dog.', 'Jennifer Cruise', '../upload/bookPfp/Crazy For You.png', 201),
(110, 'Julie and Romeo Get Lucky', 13.99, 'Julie Roseman and Romeo Cacciamani know a thing or two about good fortune. For generations, their families were rival florists and bitter enemies. Then Julie and Romeo met by chance, just as each became single again, and they fell in love.', 'Jeanne Ray', '../upload/bookPfp/Julie and Romeo Get Lucky.png', 201),
(111, 'From Hell', 32.99, 'Is a gripping graphic novel that delves into the infamous Jack the Ripper murders. Moore weaves a complex and immersive narrative that offers a unique and chilling perspective on the case.', 'Alan Moore', '../upload/bookPfp/From Hell.png', 202),
(112, 'Through the Woods', 13.99, 'Journey through the woods in this sinister, compellingly spooky collection that features four brand-new stories and one phenomenally popular tale in print for the first time. These are fairy tales gone seriously wrong, where you can travel to “Our Neighbor\'s House”—though coming back might be a problem.', 'Emily Carroll', '../upload/bookPfp/Through the Woods.png', 202),
(113, 'Uzumaki', 88.00, 'The series tells the story of the citizens of Kurôzu-cho, a fictional city plagued by a supernatural curse involving spirals. The story for Uzumaki spiraled out of the idea that of people living in a long row house, and Ito making the house into a spiral to reach his desired length.', 'Junji Ito, Yuji Oniki', '../upload/bookPfp/Uzumaki.png', 202),
(114, 'THE BONE ORCHARD MYTHOS', 39.99, 'From the acclaimed creative team behind GIDEON FALLS and PRIMORDIAL comes the first book in a bold and ambitious new shared horror universe! When a geologist is sent to a remote lighthouse to investigate strange phenomena, he finds a seemingly endless pit in the rocks. What lurks within—and how will he escape its pull?\r\n\r\nTHE PASSAGEWAY is the first book in the new BONE ORCHARD MYTHOS from LEMIRE & SORRENTINO! This universe will feature self-contained graphic novels and limited series about the horrors lurking within the Bone Orchard, just waiting to be discovered.', 'Steve Niles', '../upload/bookPfp/The Bone Orchard Mythos.jpg', 202),
(115, 'Wytches, Volume 1', 49.99, 'Wytches takes the mythology of witches to a far creepier, bone-chilling place than readers have dared venture before. When the Rooks family moves to the remote town of Litchfield, NH to escape a haunting trauma, they\'re hopeful about starting over. But something evil is waiting for them in the woods just beyond town.', 'Scott Snyder', '../upload/bookPfp/Wytches, Volume 1.png', 202),
(116, 'The Crow', 22.50, 'The night before his wedding, musician Eric Draven and his fiancée are brutally murdered by members of a violent gang. On the anniversary of their death, Eric rises from the grave and assumes the mantle of the Crow, a supernatural avenger.', 'James O\'Barr', '../upload/bookPfp/The Crow.png', 202),
(117, 'Tomie', 52.99, 'Tomie is a malevolent, regenerative entity with the unexplained ability to cause anyone, particularly men, to be instantly attracted to her. These actions inevitably lead to violence, usually resulting in the murder of Tomie herself (allowing her to replicate herself), or others.', 'Junji Ito', '../upload/bookPfp/Tomie.png', 202),
(118, 'Fragments of Horror', 68.99, 'An old wooden mansion that turns on its inhabitants. A dissection class with a most unusual subject. A funeral where the dead are definitely not laid to rest. Ranging from the terrifying to the comedic, from the erotic to the loathsome, these stories showcase Junji Ito\'s long-awaited return to the world of horror.', 'Junji Ito', '../upload/bookPfp/Fragments of Horror.png', 202),
(119, 'Panorama of Hell', 74.50, 'An artist describes his work, consisting of hellish views he paints using his own blood. He then introduces the reader to his unconventional family, and tells stories about his abusive parents, who escaped from Manchuria after World War II, and his violent childhood.', 'Hideshi Hino', '../upload/bookPfp/Panorama of Hell.png', 202),
(120, 'Severed', 58.99, 'Severed follows the story of Jack Garron, a 12-year old who runs away from home in order to find his father when he discovers the truth about his own identity. What Garron discovers, however, is that as exciting as life on the road can be, it can also be a place of hardship, heartbreak, and, indeed, terror.', 'Scott Snyder', '../upload/bookPfp/Severed.png', 202),
(121, 'Watchmen', 60.99, 'Watchmen depicts an alternate history in which superheroes emerged in the 1940s and 1960s and their presence changed history so that the United States won the Vietnam War and the Watergate scandal was never exposed.', 'Alan Moore', '../upload/bookPfp/Watchmen.png', 203),
(122, 'Batman: The Dark Knight Returns', 84.99, 'The Dark Knight Returns is a Batman story written by Frank Miller with illustrations by Miller, Klaus Janson, and Lynn Varley in 1986. It is a limited series set in a possible future, portrayed as Batman\'s last adventure. The story depicts Bruce Wayne as an old man, coming out of retirement to be Batman again.', 'Frank Miller', '../upload/bookPfp/Batman - The Dark Knight Returns.png', 203),
(123, 'Kingdom Come', 42.99, 'In a future where metahumans run rampant and are a menace to society, Superman, Wonder Woman, Batman, and other traditional superheroes attempt to contain the escalating disaster and prevent a metahuman war.', 'Mark Waid', '../upload/bookPfp/Kingdom Come.png', 203),
(124, 'Marvels', 114.99, 'Welcome to New York. Here, burning figures roam the streets, men in brightly colored costumes scale the glass and concrete walls, and creatures from space threaten to devour our world. This is the Marvel Universe, where the ordinary and fantastic interact daily. This is the world of Marvels.', 'Kurt Busiek', '../upload/bookPfp/Marvels.png', 203),
(125, 'Identity Crisis', 70.50, 'The story begins with the shocking murder of Sue Dibny, the wife of superhero Ralph Dibny, also known as the Elongated Man. This event sends ripples through the superhero community, prompting an investigation led by Green Arrow and involving other prominent characters from the Justice League.', 'Braz Melter', '../upload/bookPfp/Identity Crisis.png', 203),
(126, 'Batman: Hush', 88.50, 'The story depicts a mysterious stalker called Hush who seems intent on sabotaging Batman from afar, and it includes many guest appearances by Batman\'s villains, as well as various members of the Batman Family and Batman\'s close ally Superman. It also explores the romantic potential between Batman and Catwoman.', 'Jeph Loeb', '../upload/bookPfp/Batman - Hush.png', 203),
(127, 'Marvel 1602', 77.99, 'The eight-part series takes place in a timeline where Marvel superheroes exist in the Elizabethan era; faced with the destruction of their world by a mysterious force, the heroes must fight to save their universe.', 'Neil Gaiman', '../upload/bookPfp/Marvel 1602.png', 203),
(128, 'All-Star Superman, Vol.1', 112.99, 'Superman\'s arch nemesis Lex Luthor has finally devised a way to kill the Man of Steel, and so far it seems as if Luthor may have finally succeeded. During all this, Superman reveals his identity to Lois Lane as well before taking flight against Luthor and ultimately saving the day.', 'Grant Morrison', '../upload/bookPfp/All-Star Superman, Vol.1.png', 203),
(129, 'House of M', 29.99, 'House of M is a story of grief, grandeur, and god-like powers. It is one of the most iconic Marvel story arcs, roping in the X-Men, the Avengers, and every other group of heroes across Marvel Comics.', 'Brian Michael Bendis', '../upload/bookPfp/House of M.png', 203),
(130, 'Superman for All Seasons', 100.00, 'This book takes a look at the life of a young Clark Kent as he begins to develop strange powers. Living in a small Kansas town, the boy who would grow to be the Man of Steel must come to terms with his true origin and his uncanny abilities.', 'Jeph Loeb', '../upload/bookPfp/Superman for All Seasons.png', 203),
(131, 'The Spellman Files', 32.00, 'A spirited, funny debut from screenwriter Lutz that mixes chick-lit, mystery and a dose of TV nostalgia. Isabel Spellman has family issues. Her parents are a mismatched pair of private investigators who routinely run credit and background checks on their older daughter\'s dates.', 'Lisa Lutz', '../upload/bookPfp/The Spellman Files.png', 204),
(132, 'Coyote Doggirl', 62.99, 'Coyote is a dreamer and a drama queen, brazen and brave, faithful yet fiercely independent. She beats her own drum and sews her own crop tops. A gifted equestrian, she\'s half dog, half coyote, and all power.', 'Lisa Hanawalt', '../upload/bookPfp/Coyote Doggirl.png', 204),
(133, 'French Exit', 14.99, 'Set in New York City and Paris, the novel follows a dysfunctional mother and son duo who are forced to relocate after their fortunes fall. The title French Exit refers to the expression also known as french leave of an abrupt or hasty departure made without informing anyone.', 'Patrick deWitt', '../upload/bookPfp/French Exit.png', 204),
(134, 'Savage Season', 48.00, 'Tricia Stevens, a young and beautiful woman, has a normal life. Suddenly, she finds herself in a world where there is no sense. Tricia Stevens, a young and beautiful woman, has a normal life.', 'Joe R.Lansdale', '../upload/bookPfp/Savage Season.png', 204),
(135, 'Dad Is Fat', 75.00, '\"Dad Is Fat\" describes a comedian and author\'s humorous perspective on the common experience of men, often in their \"dad era,\" carrying a bit of extra weight, particularly around the midsection. The term \"Dad Bod,\" popularized by comedian Jim Gaffigan, refers to men in their late 20s to 50s who have a more relaxed physique with a tendency to be slightly overweight. ', 'Jim Gaffigan', '../upload/bookPfp/Dad Is Fat.png', 204),
(136, 'Breakfast of Champions', 38.99, 'Breakfast of Champions follows misanthropic sci-fi author Kilgore Trout, whose stories tend to be published in, er, adult magazines. One day, Dwayne Hoover, a car dealer who is losing his mind, will take Trout\'s fiction seriously and do something terrible, and it will alter the course of Trout\'s life.', 'Kurt Vonnegut Jr', '../upload/bookPfp/Breakfast of Champions.png', 204),
(137, 'Calvin and Hobbes', 26.99, 'The strip follows six-year-old Calvin and his best friend, a tiger named Hobbes. Calvin and Hobbes draws heavily upon Watterson\'s experiences growing up in CHAGRIN FALLS, a neighborhood of Cleveland, Ohio.', 'Bill Watterson', '../upload/bookPfp/Calvin and Hobbes.png', 204),
(138, 'Food: A Love Story', 22.99, 'Bacon, McDonalds, Cinnabon, Hot Pockets, Kale. Stand-up comedian and author Jim Gaffigan has made his career rhapsodizing over the most treasured dishes of the American diet (“choking on bacon is like getting murdered by your lover”) and decrying the worst offenders (“kale is the early morning of foods”).', 'Jim Gaffigan', '../upload/bookPfp/Food - A Love Story.png', 204),
(139, 'Undermajordomo Minor', 40.00, 'Undermajordomo Minor is an ink-black comedy of manners, an adventure, and a mystery, and a searing portrayal of rural Alpine bad behaviour, but above all it is a love story. And Lucy must be careful, for love is a violent thing.', 'Patrick deWitt', '../upload/bookPfp/Undermajordomo Minor.png', 204),
(140, 'T-Rex Trying', 24.99, 'Though the T-Rex may struggle, you\'ll never struggle with finding dinosaur gifts again! This hilarious and perfectly giftable book is perfect for anyone who has ever wondered how a T-Rex could get anything done with such tiny arms.', 'Hugh Murphy', '../upload/bookPfp/T-Rex Trying.png', 204),
(141, 'Velvet', 42.50, 'A slick and sexy new take on the cold war spy genre. What if the secretary to the man running the world\'s most top secret spy agency was actually their most dangerous weapon, once upon a time?', 'Ed Brubaker', '../upload/bookPfp/Velvet.png', 205),
(142, 'Vacancy', 30.00, 'Is a dystopian story about the sometimes opposing needs for safety and companionship. Lee\'s style is bold and the action leaps through the graphic frames. It speaks not just to the fears of survival but a deep fear of isolation.', 'Jen Lee', '../upload/bookPfp/Vacancy.png', 205),
(143, 'Guts', 68.50, 'Raina wakes up one night with a terribly upset stomach. Her mom has one, too, so it\'s probably just a bug. Raina eventually returns to school, where she\'s dealing with the usual highs and lows: friends, not-friends, and classmates who think the school year is just one long gross-out session.', 'Raina Telgemeier', '../upload/bookPfp/Guts.png', 205),
(144, 'Gyo', 69.99, 'In Gyo, a single fish crawls on to the Okinawa shore. . . but it has legs, weird, and then more and more, 400 pages of obsessive nightmare fish, sharks with legs, crawling up and killing people and smashing things.', 'Junji Ito', '../upload/bookPfp/Gyo.png', 205),
(145, 'Cabin Fever', 58.00, 'Greg Heffley is in big trouble. School property has been damaged, and Greg is the prime suspect. But the crazy thing is, he’s innocent. Or at least sort of. The authorities are closing in, but when a surprise blizzard hits, the Heffley family is trapped indoors.', 'Jeff Kinney', '../upload/bookPfp/Cabin Fever.png', 205),
(146, 'Super Mario Adventures', 99.99, 'Super Mario Adventures is an anthology of comics that ran in Nintendo Power throughout 1992, featuring the characters from Nintendo\'s Mario series and based loosely on Super Mario World.', 'Kentaro Takekuma', '../upload/bookPfp/Super Mario Adventures.png', 205),
(147, 'Percy Gloom', 26.99, 'The titular character is a little sad sack of a lazy-eyed guy who suffers mightily in a strange world where he is afflicted by everything from an Orwellian bureaucracy to an impossibly weak stomach.', 'Cathy Malkasian', '../upload/bookPfp/Percy Gloom.png', 205),
(148, 'Jane Austen: An Illustrated Biography', 39.99, 'Enchanting illustrations and handwritten text featuring excerpts from Austen\'s personal letters outline the intimate details of the literary icon\'s life—her childhood on a farm, the writing of her first novella, her marital woes, the inspiration behind Sense and Sensibility and Pride and Prejudice, and more.', 'Zena Alkayat', '../upload/bookPfp/Jane Austen - An Illustrated Biography.png', 205),
(149, 'Dogs Rule Nonchalantly', 45.50, 'is a collection of twenty years worth of whimsical dog paintings complemented by hand-written observations of dog behavior and first person experiences garnered over a lifetime of being a “dog person”…', 'Mark Ulriksen', '../upload/bookPfp/Dogs Rule Nonchalantly.png', 205),
(150, 'A Dog\'s Life', 80.00, 'This is a charming tale of life in Provence as seen through the eyes of Peter Mayle\'s dog, one of Provence\'s best-known former residents. It is a witty view of life from three-feet off the ground, with the dog sharing his ups and downs, positive and negative encounters, lovelife, and general world view!', 'Peter Mayle', '../upload/bookPfp/A Dog\'s Life.png', 205),
(201, 'The Very Hungry Caterpillar', 68.50, 'Is a story about a small caterpillar who emerges from an egg and begins eating everything in sight. After six days of eating fruits, sweets, and “junk” food, he gets a stomach ache. On the seventh day, the caterpillar eats a “nice leaf” and feels much better.', 'Eric Carle', '../upload/bookPfp/The Very Hungry Caterpillar.png', 301),
(202, 'Green Eggs and Ham', 40.99, 'Is about Sam-I-Am\'s attempt to convince the narrator to try green eggs and ham. He spends most of the book offering the unnamed narrator different locations and dining partners to try the delicacy. In the end, the narrator relents and eats the green eggs and ham and ends up loving the food.', 'Dr Seuss', '../upload/bookPfp/Green Eggs and Ham.png', 301),
(203, 'Goodnight Moon', 29.99, 'Tells the story of a rabbit getting ready for bed, bidding adieu to a series of items in his bedroom: a little toy house and a young mouse, “a comb and a brush and a bowl full of mush and a quiet old lady who was whispering \'hush.', 'Margaret Wise Brown', '../upload/bookPfp/Goodnight Moon.png', 301),
(204, 'The Giving Tree', 18.99, 'The story is about the life and friendship of an apple tree and a little boy, who develop a beautiful relationship with one another. The tree was very “giving” in nature, and eventually, the boy evolves into a “receiving” little kid, then a teenager, to a middle-aged man, and finally, an old man.', 'Shel Silverstein', '../upload/bookPfp/The Giving Tree.png', 301),
(205, 'The Lorax', 37.00, 'Long before saving the earth became a global concern, Dr. Seuss, speaking through his character the Lorax, warned against mindless progress and the danger it posed to the earth\'s natural beauty.', 'Dr Seuss', '../upload/bookPfp/The Lorax.png', 301),
(206, 'If You Give a Mouse a Cookie', 38.50, 'This story describes a set of events that occurs after a boy gives a mouse a cookie. Once the mouse is given the cookie, he asks for a glass of milk, which ends up leading to a series of additional requests.', 'Laura Joffe Numeroff', '../upload/bookPfp/If You Give a Mouse a Cookie.png', 301),
(207, 'Corduroy', 30.99, 'This beloved book tells the story of Corduroy, a stuffed teddy bear, as he waits on a shelf for the love of a child. When a mother won\'t buy Corduroy for her little girl because he is missing a button from his overalls, the little bear goes on a nighttime adventure in the store to look for it.', 'Don Freeman', '../upload/bookPfp/Corduroy.png', 301),
(208, 'Chicka Chicka Boom Boom', 77.00, 'Is a vibrant and engaging book that\'s perfect for introducing young children to the alphabet. This beloved classic combines catchy rhymes with colorful, lively illustrations that bring the letters of the alphabet to life.', 'Bill Martin Jr', '../upload/bookPfp/Chicka Chicka Boom Boom.png', 301),
(209, 'Are You My Mother?', 89.99, 'Is a story about a hatchling bird. His mother, thinking her egg will stay in her nest where she left it, leaves her egg alone and flies off to find food. The baby bird hatches while the mother is away.', 'P.D.Eastman', '../upload/bookPfp/Are You My Mother.png', 301),
(210, 'Stellaluna', 45.00, 'It is about a young fruit bat, Stellaluna, who becomes separated from her mother and finds her way to a nest of birds. She is adopted by them and learns bird-like behavior.', 'Janell Cannon', '../upload/bookPfp/Stellaluna.png', 301),
(211, 'Peter Pan', 54.50, 'A free-spirited and mischievous young boy who can fly and never grows up, Peter Pan spends his never-ending childhood having adventures on the mythical island of Neverland as the leader of the Lost Boys, interacting with fairies, pirates, mermaids, Native Americans, and occasionally ordinary children from the world.', 'J.M.Barrie', '../upload/bookPfp/Peter Pan.png', 302),
(212, 'The Little Mermaid', 25.99, 'The Little Mermaid\" by Hans Christian Andersen was written in 1836. Anderson tells the story of a young sea princess who longs to become human. She has a deep desire to go above the shore even from an early age, but her desire becomes stronger when she falls in love with a handsome prince.', 'Hans Christian Andersen', '../upload/bookPfp/The Little Mermaid.png', 302),
(213, 'The Little Prince', 33.50, 'The story follows a young prince who visits various planets, including Earth, and addresses themes of loneliness, friendship, love, and loss. Despite its style as a children\'s book, The Little Prince makes observations about life, adults, and human nature.', 'Antoine de Saint-Exupery', '../upload/bookPfp/The Little Prince.png', 302),
(214, 'Cinderella and the Furry Slippers', 95.99, 'Cinderella is dying to go to the ball. She\'s seen pictures of the fancy castle and the handsome prince, she\'s heard the fairy tales about true love, she\'s found the perfect dress in Princess magazine and she\'s even found an ad for a Fairy Godmother. She\'s all set.', 'Davide Cali', '../upload/bookPfp/Cinderella and the Furry Slippers.png', 302),
(215, 'Goatilocks and the Three Bears', 30.00, 'Once upon a time, there was a kid named Goatilocks. She lived down the road from a family of bears... Goatilocks can\'t resist sampling first Papa Bear\'s porridge, then Mama Bear\'s porridge, then Baby Bear\'s porridge—and his bowl and spoon, too. And it turns out Goatilocks has a taste for chairs and beds as well.', 'Erica S.Perl', '../upload/bookPfp/Goatilocks and the Three Bears.png', 302),
(216, 'The Snow Queen', 82.00, 'It is one of Andersen\'s longest stories and is divided into seven chapters. It tells the story of a mirror fashioned by demons that is shattered. A piece of the glass enters the eye and the heart of a little boy named Kai. He is carried by the Snow Queen to her palace in the far north.', 'Hans Christian Andersen', '../upload/bookPfp/The Snow Queen.png', 302),
(217, 'The White Cat', 34.99, 'The White Cat is about a world changed by magic. The White Cat helps the youngest prince win his father\'s throne.', 'Errol Le Cain', '../upload/bookPfp/The White Cat.png', 302),
(218, 'The Reluctant Dragon', 52.00, 'In Grahame\'s story, a young boy discovers an erudite, poetry-loving dragon living in the Downs above his home. The two become friends, but soon afterwards the dragon is discovered by the townsfolk, who send for St George to rid them of him.', 'Kenneth Grahame', '../upload/bookPfp/The Reluctant Dragon.png', 302),
(219, 'Red Riding Hood', 14.99, 'So begins Beatrix Potter\'s retelling of Red Riding Hood. A darkly delicious adaptation of the classic tale, filled with trademark Potter wit and flourishes, little Red Riding Hood sets off to Granny\'s house with a very hungry wolf in tow. But nobody saw her pass.', 'Beatrix Potter', '../upload/bookPfp/Red Riding Hood.png', 302),
(220, 'The Frog in the Wall', 78.99, 'In The Frog in the Well, Tresselt and Duvoisin offer a sweet tale of a frog who beats his fears and explores the world. Once upon a time there was a frog who lived at the bottom of a well. The well was the frog\'s whole world, until the day the well ran dry and the bugs began to disappear.', 'Alvin Tresselt', '../upload/bookPfp/The Frog in the Wall.png', 302),
(221, 'Punctuation Takes a Vacation', 25.99, 'After a lesson goes awry on the hottest, stickiest day of the year, Punctuation decides to go on vacation. Maybe if the kids have to live without punctuation for a while, they\'ll appreciate all the hard work commas, apostrophes, exclamation points, and question marks do!', 'Robin Pulvel', '../upload/bookPfp/Punctuation Takes a Vacation.png', 303),
(222, 'The Grapes of Math', 55.99, 'The Grapes Of Math by Greg Tang is a book that encourages groupings of numbers in order to assist in quick addition. It shows a different way of looking at a group of objects - snails, grapes, fish etc.', 'Greg Tang', '../upload/bookPfp/The Grapes of Math.png', 303),
(223, 'Zero the Hero', 61.99, 'Zero. Zip. Zilch. Nada. That\'s what all the other numbers think of Zero. He doesn\'t add anything in addition. He\'s of no use in division. And don\'t even ask what he does in multiplication. ( Poof! ) But Zero knows he\'s worth a lot, and when the other numbers get into trouble, he swoops in to prove that his talents are innumerable.', 'Joan Holub', '../upload/bookPfp/Zero the Hero.png', 303),
(224, 'Math Curse', 46.99, 'Math Curse is a children\'s picture book written by Jon Scieszka and illustrated by Lane Smith. Published in 1995 through Viking Press, the book tells the story of a student who is cursed by the manner in which mathematics is connected to everyday life.', 'Jon Scieszka', '../upload/bookPfp/Math Curse.png', 303),
(225, 'How Much Is a Million?', 35.99, 'Knocks complex numbers down to size in a fun, humorous way, helping children conceptualize a difficult mathematical concept. It\'s a math class you\'ll never forget.', 'David M.Schwartz', '../upload/bookPfp/How Much Is a Million.png', 303),
(226, 'Dr.Seuss\'s ABC', 47.50, 'Seuss\'s ABC, otherwise referred to as The ABC, is a 1963 English language alphabet book written by Dr. Seuss starring two anthropomorphic yellow rabbits named Ichabod and Izzy as they journey through the alphabet and meet characters whose names begin with each letter.', 'Dr Suess', '../upload/bookPfp/Dr.Seuss\'s ABC.png', 303),
(227, 'The Stone Lions', 84.00, 'The Stone Lions is a story about a lifelike stone lion that sits outside the library day in and day out. Intertwined in a mystery of math, art and magic, Ara races to find the seven broken symmetries before time runs out.', 'Gwen Dandridge', '../upload/bookPfp/The Stone Lions.png', 303),
(228, 'Weather Or Not', 26.99, 'Weather is one of the most talked about subjects in the world. Here, Trafford invites kids, parents and teachers to join the conversation. Understanding climate change is critical but difficult. The complex issues surrounding climate change are simplified so that all readers can understand the very real threat to our planet.', 'Caren Trafford', '../upload/bookPfp/Weather Or Not.png', 303),
(229, 'The Last Honey Bee', 28.50, 'Manderlee is a very sad honey bee. Humans destroyed the thriving bee colony she lived in with fire and poison. The queen bee, drones, and worker bees perished, but Manderlee survived. She had to travel far to seek a new colony and was almost made into honey bee cake by Kala Kaghee, an angry seagull.', 'Wayne Gerard Trotman', '../upload/bookPfp/The Last Honey Bee.png', 303),
(230, 'Eat Your Math Homework', 35.00, 'This collection of yummy recipes and fun math facts is sure to tempt taste buds and make you hungry for more. Explore patterns in nature while you chomp on Fibonacci Stack Sticks. Amaze your friends with delicious Variable Pizza Pi! Wash down your geometry assignment with some Milk and Tangram Cookies.', 'Ann McCallum Staats', '../upload/bookPfp/Eat Your Math HomeWork.png', 303),
(231, 'Charlotte\'s Web', 47.00, 'Charlotte\'s Web is a story of friendship, courage, and self-sacrifice. Wilbur is a pig who finds out that he is destined for slaughter. His friend, a spider named Charlotte who lives in the doorway of his pigpen, determines to save him; she accomplishes this by spinning words about him in her web.', 'E.B.White', '../upload/bookPfp/Charlotte\'s Web.png', 304),
(232, 'Winnie-the-Pooh', 88.50, 'The book is set in the fictional Hundred Acre Wood, with a collection of short stories following the adventures of an anthropomorphic teddy bear, Winnie-the-Pooh, and his friends Christopher Robin, Piglet, Eeyore, Owl, Rabbit, Kanga, and Roo.', 'A.A.Milne', '../upload/bookPfp/Winnie-the-Pooh.png', 304);
INSERT INTO `book` (`BookNo`, `BookName`, `BookPrice`, `Description`, `Author`, `BookImage`, `SubcategoryNo`) VALUES
(233, 'A Day in the Life of a Muslim Child', 32.50, 'This beautiful book describes a day in the life of a Muslim Child. From waking up to going to bed at night it goes over all the basic dua\'s that should be recited in our daily lives.', 'Abdul Malik Mujahid', '../upload/bookPfp/A Day in the Life of a Muslim Child.png', 304),
(234, 'The Lion, the Witch and the Wardrobe', 35.50, 'Peter, Susan, Edmund and Lucy Pevensie are evacuated from London in 1940, to escape the Blitz, and sent to live with Professor Digory Kirke at a large house in the English countryside. While exploring the house, Lucy enters a wardrobe and discovers the magical world of Narnia.', 'C.S.Lewis', '../upload/bookPfp/The Lion, the Witch and the Wardrobe.png', 304),
(235, 'The Raven\'s Nest', 27.99, 'Sev the Raven has left his Mama’s nest to build his own home and start a new chapter in his life. As he meets new animals, visits friends and discovers new interests, he also learns the balance between moderation and greed. But will he learn this lesson too late.', 'Razan Dozom', '../upload/bookPfp/The Raven\'s Nest.png', 304),
(236, 'Stargirl', 34.99, 'Stargirl is a new girl in school who is different from the other kids and doesn\'t quite fit in. She thrives on standing out and being different. She is kind and caring and the other students struggle to understand her.', 'Jerry Spinelli', '../upload/bookPfp/Stargirl.png', 304),
(237, 'Matilda', 77.00, 'Matilda is a 1988 children\'s novel by British author Roald Dahl. It was published by Jonathan Cape. The story features Matilda Wormwood, a precocious child with an uncaring mother and father, and her time in a school run by the tyrannical headmistress Miss Trunchbull.', 'Roald Dahl', '../upload/bookPfp/Matilda.png', 304),
(238, 'The Ice Maiden\'s Tale', 13.99, 'When Johanna and Casper must spend the afternoon at her house, there’s nothing to do, except listen to a story. While the siblings await their mother’s return from the hospital where she’s visiting their ailing father, Mrs. Kinder reads them a story of adventure, magic and music.', 'Lisa Preziosi', '../upload/bookPfp/The Ice Maiden\'s Tale.png', 304),
(239, 'Born to Run', 37.99, 'When Patrick saves a greyhound puppy from drowning in the canal, he gives his beloved new pet the only name that feels right: Best Mate. But despite Patrick\'s promise to look after Best Mate forever, it isn\'t long before the greyhound is thrust into a new life and threatened with a fate he will have to fight to escape.', 'Michael Morpurgo', '../upload/bookPfp/Born to Run.png', 304),
(240, 'Sad Simon', 38.50, 'Sad Simon is all about a young Bassett Hound. Like all of us, he sometimes feels sad. Simon explains that for some the sadness can last much longer and have a bigger effect on life. Luckily he gets in touch with this friend Mindful Millie who helps to teach him ways to use Mindfulness to feel better.', 'Louise Tribble', '../upload/bookPfp/Sad Simon.png', 304),
(241, 'The Tale of Peter Rabbit', 29.99, 'It follows Peter Rabbit on the day his mother tells him and sisters Flopsy, Mopsy, and Cotton-Tail to avoid Mr. McGregor\'s garden because he killed their father. While his siblings obey their mother, Peter doesn\'t.', 'Beatrix Potter', '../upload/bookPfp/The Tale of Peter Rabbit.png', 305),
(242, 'Babe: The Gallent Pig', 24.99, 'When Babe arrives at Hogget Farm, Mrs. Hogget\'s thoughts turn to sizzling bacon and juicy pork chops. But before long, Babe reveals a talent no one could have expected: he can handle Farmer Hogget\'s stubborn flock better than any sheepdog ever could!', 'Dick King-Smitch', '../upload/bookPfp/Babe - The Gallent Pig.png', 305),
(243, 'a Home for Abigail', 16.99, 'Alone and abandoned on a deserted street, a dog tries her best to tell people she needs help. When she has almost given up—a kind lady stops. Join Abigail on her journey as she becomes a beloved family member in a forever home.', 'S.Marriott Cook', '../upload/bookPfp/A Home for Abigail.png', 305),
(244, 'Where the Red Fern Grows', 27.50, 'Where the Red Fern Grows is a 1961 children\'s novel by Wilson Rawls about a boy who buys and trains two Redbone Coonhounds for hunting. It is a work of autobiographical fiction based on Rawls\' childhood in the Ozarks', 'Wilson Rawls', '../upload/bookPfp/Where the Red Fern Grows.png', 305),
(245, 'Make Way for Ducklings', 58.00, 'Is about a family of ducks looking for a home in the city of Boston. When Mr. and Mrs. Mallard target the Public Garden as their new home, they are driven away by the dangers they discover as bicycles zoom past them across the sidewalk.', 'Robert McCloskey', '../upload/bookPfp/Make Way for Ducklings.png', 305),
(246, 'The Call of the Wild', 32.99, 'The story opens at a ranch in Santa Clara Valley, California, when Buck is stolen from his home and sold into service as a sled dog in Alaska. He becomes progressively more primitive and wild in the harsh environment, where he is forced to fight to survive and dominate other dogs.', 'Jack London', '../upload/bookPfp/The Call of the Wild.png', 305),
(247, 'Old Yeller', 39.99, 'The stray dog was ugly, and a thieving rascal, too. But he sure was clever, and a smart dog could be a big help on the wild Texas frontier, especially with Papa away on a long cattle drive up to Abilene. Strong and courageous, Old Yeller proved that he could protect Travis\'s family from any sort of danger.', 'Fred Gipson', '../upload/bookPfp/Old Yeller.png', 305),
(248, 'Andy and The Pharaoh\'s Cat', 46.99, 'Andy has a starring role in his school play! He\'s playing the Pharaoh, the most important person. Little does he know a mischievous cat will bring him face to face with the real Pharaoh in an exciting Egyptian adventure he\'ll never forget!', 'Carolyn Watson-Dubisch', '../upload/bookPfp/Andy and The Pharaoh\'s Cat.png', 305),
(249, 'Sunshine\'s Excellent Adventures', 19.99, 'Sunshine began his life as a kitten, under a pier on Topsail Island, North Carolina. His wonderful mommy was called Mama Motley and she adored her baby Sunshine. Sunshine spent many happy and loving years with Reggie and Anita. He was the smartest and sweetest cat imaginable. He made many friends both humans and animals during his precious life.', 'Reggie Hill', '../upload/bookPfp/Sunshine\'s Excellent Adventures.png', 305),
(250, 'Cranky Bear Wakes Up', 25.00, 'Initially selfish and indifferent to the troubles of the forest creatures around him, such as Fish, Robin, and Bee, he gradually learns that we are all part of one great, interconnected ecosystem.', 'Shawn StJean', '../upload/bookPfp/Cranky Bear Wakes Up.png', 305),
(301, 'Mathematic For Human Flourishing', 14.99, 'In this profound book, written for a wide audience but especially for those disenchanted by their past experiences, and award-winning mathematician and educator weaves parables, puzzles, and personal reflections to show how mathematics meets basic human desires - such as for play, beauty, freedom, justice, and love - and cultivates virtues essential for human flourishing.', 'Francis Su', '../upload/bookPfp/Mathematic For Human Flourishing.png', 401),
(302, 'Making Number Talks Matter', 31.99, 'Making the transition to student-centered learning begins with finding ways to get students to share their thinking, something that can be particularly challenging for math class.', 'Ruth Paker', '../upload/bookPfp/Making Number Talks Matter.png', 401),
(303, 'Math Girls', 16.99, 'Math Girls is a unique introduction to advanced mathematics, delivered through the eyes of three students as they learn to deal with problems seldom found in textbooks.', 'Hiroshi Yuki', '../upload/bookPfp/Math Girls.png', 401),
(304, 'Basic Mathematics', 52.99, 'It provides a firm foundation in basic principles of mathematics and thereby acts as a springboard into calculus, linear algebra and other more advanced topics.', 'Serge Lang', '../upload/bookPfp/Basic Mathematics.png', 401),
(305, 'The Magic of Math: Solving for X and Figuring Out Why', 32.00, 'The Magic of Math is the math book you wish you had in school. Using a delightful assortment of examples-from ice-cream scoops and poker hands to measuring mountains and making magic squares-this book revels in key mathematical fields including arithmetic, algebra, geometry, and calculus, plus Fibonacci numbers, infinity, and, of course, mathematical magic tricks. Known throughout the world as the \"mathemagician,\" Arthur Benjamin mixes mathematics and magic to make the subject fun, attractive, and easy to understand for math fans and math-phobic alike.', 'Arthur T.Benjamin', '../upload/bookPfp/The Magic of Math.png', 401),
(306, 'Make It Stick: The Science of Successful Learning', 18.99, 'To most of us, learning something “the hard way” implies wasted time and effort. Good teaching, we believe, should be creatively tailored to the different learning styles of students and should use strategies that make learning easier. Make It Stick turns fashionable ideas like these on their head. Drawing on recent discoveries in cognitive psychology and other disciplines, the authors offer concrete techniques for becoming more productive learners.', 'Peter C.Brown', '../upload/bookPfp/Make It Stick - The Science of Successful Learning.png', 402),
(307, 'How Humans Learn: The Science and Stories behind Effective C', 23.99, 'How Humans Learn aims to do just that by peering behind the curtain and surveying research in fields as diverse as developmental psychology, anthropology, and cognitive neuroscience for insight into the science behind learning.', 'Joshua R.Eyler', '../upload/bookPfp/How Human Learn - The Science and Stories behind Effective College Teaching.png', 402),
(308, 'Learn Like a Pro', 29.99, 'Building on insights from neuroscience and cognitive\r\npsychology, they give you a crash course to improve your ability to learn, no matter what the subject is. Through their decades of writing, teaching, and research on learning, the authors have developed deep connections with experts from a vast array of disciplines. And it\'s all honed with feedback from thousands of students who have themselves gone through the trenches of learning. Successful learners gradually add tools and techniques to their mental toolbox, and they think critically about their learning to determine when and how to best use their mental tools. That allows these learners to make the best use of their brains, whether those brains seem \"naturally\" geared toward learning or not. This book will teach you how you can do the same\r\n', 'Barbara Oakley', '../upload/bookPfp/Learn Like a Pro.png', 402),
(309, 'Peak: Secrets from the New Science of Expertise', 13.99, 'This book is a breakthrough, a lyrical, powerful, science-based narrative that actually shows us how to get better (much better) at the things we care about.', 'K.Anders Ericsson', '../upload/bookPfp/Peak - Secrets from the New Science of Expertise.png', 402),
(310, 'Understanding How We Learn: A Visual Guide', 15.99, 'The book explores exactly what constitutes good evidence for effective learning and teaching strategies, how to make evidence-based judgments instead of relying on intuition, and how to apply findings from cognitive psychology directly to the classroom.', 'Yana Weinstein', '../upload/bookPfp/Understanding How We Learn - A Visual Guide.png', 402),
(311, 'American Boarding Schools: A Historical Study', 27.99, 'This is the story and history of the schools and the figures prominent in national and international affairs - authors, politicians, educators.Includes the background and histories of many schools including Groton, Phillips Exeter, St. Paul\'s, St. Mark\'s, Choate, Deerfield Academy, Kent School, Hotchkiss School and more!', 'James McLachlan', '../upload/bookPfp/American Boarding Schools - A Historical Study.png', 403),
(312, 'A History Of Education In Antiquity', 29.99, 'Marrou shows how education, once formed as a way to train young warriors, eventually became increasingly philosophical and secularized as Christianity took hold in the Roman Empire.', 'Henri-Irenee Marrou', '../upload/bookPfp/A History Of Education In Antiquity.png', 403),
(313, 'Paris Undercover', 43.00, 'In researching this story, Matthew Goodman uncovered military records, personal testimonies, and Etta Shiber’s own never-before-seen wartime letters. Together they reveal, for the first time, the shocking truth behind Etta\'s bestselling memoir and the unexpected, far-reaching consequences of its publication. More than just a story of two women’s remarkable courage, Paris Undercover is also a vivid, gripping account of deceit, betrayal, and personal redemption.', 'Matthew Goodman', '../upload/bookPfp/Paris Undercover.png', 403),
(314, 'Perfect Victims: And the Politics of Appeal', 49.99, 'Palestine is a microcosm of the on fire, stubborn, fragmented, dignified. While a settler colonial state continues to inflict devastating violence, fundamental truths are deliberately obscured—the perpetrators are coddled while the victims are blamed and placed on trial.Masterfully combining candid testimony, history, and reportage, Perfect Victims presents a powerfully simple dignity for the Palestinian.', 'Mohammed El-Kurd', '../upload/bookPfp/Perfect Victims - And the Politics of Appeal.png', 403),
(315, 'The World After Gaza: A Short History', 15.99, 'From one of our foremost public intellectuals, an essential reckoning with the war in Gaza that reframes our understanding of the ongoing conflict, its historical roots, and the fractured global response.', 'Pankaj Mishra', '../upload/bookPfp/The World After Gaza - A Short History.png', 403),
(316, 'Memory: What Every Language Teacher Should Know', 26.99, 'If teachers understand how memory works, there is more chance of helping students do well through effective curriculum and lesson planning. This book is an introduction to memory written specifically with language teachers in mind. Taking evidence from the fields cognitive science and second language acquisition, the authors examine a range of important aspects of memory. These include working memory, phonological memory, long-term memory, cognitive load, implicit and explicit knowledge, prospective memory, metamemory, learning from mistakes, the emotional factors affecting retention and curriculum design with memory in mind.', 'Steve Smitch', '../upload/bookPfp/Memory - What Every Language Teacher Should Know.png', 404),
(317, 'Languages Are Good For Us', 23.99, 'This is a book about languages and the people who love them. It is about the strange and wonderful ways in which humans have used languages since the days of the earliest clay records. About the linguistic threads that connect us all. Above all, it is about pleasure.', 'Sophie Hardach', '../upload/bookPfp/Languages Are Good For Us.png', 404),
(318, 'An Introduction to Language', 77.99, 'An Introduction to Language is ideal for use at all levels and in many different areas of instruction including education, languages, psychology, anthropology, teaching English as a Second Language (TESL), and linguistics.', 'Victoria A.Fromkin', '../upload/bookPfp/An Introduction to Language.png', 404),
(319, 'The English Language: A Guided Tour of the Language', 20.99, 'This fascinating books explores the way the language has developed, and examines the factors that unify it and the variations that divide it both nationwide and worldwide.', 'David Crystal', '../upload/bookPfp/The English Language - A Guided Tour of the Language.png', 404),
(320, 'Word by Word: The Secret Life of Dictionaries', 42.99, 'She explains why small words are the most difficult to define (have you ever tried to define is ?), how it can take nine months to define a single word, and how our biases about language and pronunciation can have tremendous social influence. Throughout, Stamper brings to life the hallowed halls (and highly idiosyncratic cubicles) of Merriam-Webster, a world inhabited by quirky, erudite individuals who quietly shape the way we communicate. A sure delight for all lovers of words, Word by Word might also quietly improve readers grasp and use of the English language.', 'Kory Stamper', '../upload/bookPfp/Word by Word - The Secret Life of Dictionaries.png', 404),
(321, 'Python Programming for Young Coders', 64.99, 'Python Programming for Young Coders breaks down complex programming concepts into easy-to-understand chunks, relating them to real-life examples that resonate with young minds.', 'Anand Pandey', '../upload/bookPfp/Python Programming for Young Coders.png', 405),
(322, 'System Design Interview', 37.99, 'This book provides a step-by-step framework for how to tackle a system design question. It includes many real-world examples to illustrate the systematic approach, with detailed steps that you can follow.', 'Alex Xu', '../upload/bookPfp/System Design Interview.png', 405),
(323, 'Java For Dummies', 56.00, 'Java For Dummies gives you the essential tools you need to understand the programming language that 17 million software developers rely on. This beginner-friendly guide simplifies every step of the learning process. You\'ll learn the basics of Java and jump into writing your own programs. Along the way, you\'ll gain the skills you need to reuse existing code, create new objects, troubleshoot when things go wrong, and build working programs from the ground up. Java For Dummies will help you become a Java developer, even if you\'re brand new to the world of coding.', 'Barry Burd', '../upload/bookPfp/Java For Dummies.png', 405),
(324, 'PHP Crash Course', 56.00, 'Whether you’re building your first dynamic website or modernizing legacy systems, PHP Crash Course gives you a complete, practical foundation for writing professional web applications.', 'Matt Smitch', '../upload/bookPfp/PHP Crash Course.png', 405),
(325, 'SQL QuickStart Guide', 73.50, 'SQL is the workhorse programming language that forms the backbone of modern data management and interpretation. Any database management professional will tell you that despite trendy data management languages that come and go, SQL remains the most widely used and most reliable to date, with no signs of stopping. It doesn’t matter if you are learning SQL to upgrade your career, taking on a new data management role at your current job, or just someone who wants to learn a lucrative and in-demand tech skill - this book will teach you everything you need to master SQL fundamentals.', 'Walter Shields', '../upload/bookPfp/SQL QuickStart Guide.png', 405),
(326, 'Statistics for Business and Economics', 62.55, 'Statistics for Business and Economics is a comprehensive textbook on Statistics that caters to the needs of students doing a course of any level in the subject.', 'R.P.Hooda', '../upload/bookPfp/Statistics for Business and Economics.png', 406),
(327, 'The Business and Economics of Linux and Open Source', 19.99, 'The book begins with an overview of the business motivations for deploying Linux and Open Source applications in the enterprise, then covers the details of what Linux is, understanding the effect of open source licenses on business and a view into the wide ranging open source communities doing active development.', 'Martin Fink', '../upload/bookPfp/The Business and Economics of Linux and Open Source.png', 406),
(328, 'On Business & Economics', 34.99, 'In this anthology of essays, speeches, and reflections, we see Kuyper\'s attempts to think positively and creatively about the calling and potential of business. Included are his ideas about economic freedom, the eternal value of earthly work, stewardship and philanthropy, economic globalization, the workings of God\'s grace in business, and the social function of money.', 'Abraham Kuyper', '../upload/bookPfp/On Business & Economics.png', 406),
(329, 'Games for Business and Economics', 84.99, 'This innovative book shows students how to set up and solve games, particularly those in economics and business, using game theory. Gardner\'s unique approach helps students develop strong modeling skills by using proven applications and examples of setups. The book also features a variety of examples, including many from business, politics, economics, and history.', 'Roy Gardner', '../upload/bookPfp/Games for Business and Economics.png', 406),
(330, 'Dictionary of Business and Economics Terms', 59.99, 'This pocket-sized guide is a helpful reference for business students, business managers, and general readers seeking advice and information on specific business subjects.', 'Jack P.Friedman', '../upload/bookPfp/Dictionary of Business and Economics Terms.png', 406),
(331, 'The Design of Everyday Things', 33.99, 'The ultimate guide to human-centered design Even the smartest among us can feel inept as we fail to figure out which light switch or oven burner to turn on, or whether to push, pull, or slide a door. The fault, argues this ingenious -- even liberating -- book, lies not in ourselves, but in product design that ignores the needs of users and the principles of cognitive psychology. The problems range from ambiguous and hidden controls to arbitrary relationships between controls and functions, coupled with a lack of feedback or other assistance and unreasonable demands on memorization. The Design of Everyday Things shows that good, usable design is possible. The rules are make things visible, exploit natural relationships that couple function and control, and make intelligent use of constraints. The guide the user effortlessly to the right action on the right control at the right time. The Design of Everyday Things is a powerful primer on how -- and why -- some products satisfy customers while others only frustrate them.', 'Donald A.Norman', '../upload/bookPfp/The Design of Everyday Things.png', 407),
(332, 'How To Build a Car', 52.99, 'How to Build a Car explores the story of Adrian’s unrivalled 35-year career in Formula One through the prism of the cars he has designed, the drivers he has worked alongside and the races in which he’s been involved.', 'Adrian Newey', '../upload/bookPfp/How To Build a Car.png', 407),
(333, 'Structures: Or Why Things Don\'t Fall Down', 32.50, 'In a book that Business Insider noted as one of the \"14 Books that inspired Elon Musk,\" J.E. Gordon strips engineering of its confusing technical terms, communicating its founding principles in accessible, witty prose.', 'J.E. Gordan', '../upload/bookPfp/Structures - Or Why Things Don\'t Fall Down.png', 407),
(334, 'The Art of Electronics', 101.00, 'Widely accepted as the authoritative text and reference on electronic circuit design, both analog and digital, this book revolutionized the teaching of electronics by emphasizing the methods actually used by circuit designers a combination of some basic laws, rules of thumb, and a large bag of tricks.', 'Paul Horowitz', '../upload/bookPfp/The Art of Electronics.png', 407),
(335, 'Practical Electronics for Inventors', 20.99, 'A favorite memory-jogger for working electronics engineers, Practical Electronics for Inventors is also the ideal manual for those just getting started in circuit design. If you want to succeed in turning your ideas into workable electronic gadgets and inventions, is THE book. Starting with a light review of electronics history, physics, and math, the book provides an easy-to-understand overview of all major electronic elements, Basic passive components o Resistors, capacitors, inductors, transformers o Discrete passive circuits o Current-limiting networks, voltage dividers, filter circuits, attenuators o Discrete active devices o Diodes, transistors, thrysistors o Microcontrollers o Rectifiers, amplifiers, modulators, mixers, voltage regulators ENTHUSIASTIC READERS HELPED US MAKE THIS BOOK EVEN BETTER This revised, improved, and completely updated second edition reflects suggestions offered by the loyal hobbyists and inventors who made the first edition a bestseller. Reader-suggested improvements in this guide.', 'Paul Scherz', '../upload/bookPfp/Practical Electronics for Inventors.png', 407),
(336, 'The Mother Next Door: Medicine, Deception, and Munchausen by', 34.99, 'The Mother Next Door offers a groundbreaking look at MBP from an unlikely duo: a Seattle novelist whose own family was torn apart by it, and the Texas detective who has worked on more medical child abuse cases than anyone in the nation.', 'Andrea Dunlop', '../upload/bookPfp/The Mother Next Door - Medicine, Deception, and Munchausen by Proxy.png', 408),
(337, 'How to Be Enough: Self-Acceptance for Self-Critics and Perfe', 24.99, 'She delivers seven shifts—including from self-criticism to kindness, control to authenticity, procrastination to productivity, comparison to contentment—to find self-acceptance, rewrite the Inner Rulebook, and most of all, cultivate the authentic human connections we’re all craving.', 'Ellen Hendriksen', '../upload/bookPfp/How to Be Enough - Self-Acceptance for Self-Critics and Perfectionists.png', 408),
(338, 'The Age of Choice: A History of Freedom in Modern Life', 25.99, 'Drawing on a wealth of sources ranging from novels and restaurant menus to the latest scientific findings about choice in psychology and economics, The Age of Choice urges us to rethink the meaning of choice and its promise and limitations in modern life.', 'Sophie Rosenfeld', '../upload/bookPfp/The Age of Choice - A History of Freedom in Modern Life.png', 408),
(339, 'The Wisdom of Your Heart: Discovering the God-given Purpose ', 39.99, 'Christians believe many myths about Emotions lead you astray. Emotions aren’t spiritual. And the biggest God is not emotional. The truth is emotions are a God-given source of wisdom when we know how to interpret them. Marc Alan Schelske. The Wisdom of Your Heart provides a path for listening to the spiritual insights that your emotions offer every day.', 'Marc Alan Schelske', '../upload/bookPfp/The Wisdom of Your Heart - Discovering the God-given Purpose and Power of Your Emotions.png', 408),
(340, 'The Psychology of Money', 48.99, 'In The Psychology of Money, award-winning author Morgan Housel shares 19 short stories exploring the strange ways people think about money and teaches you how to make better sense of one of life\'s most important topics.', 'Morgan Housel', '../upload/bookPfp/The Psychology of Money.png', 401),
(341, 'Hunter x Hunter', 20.00, 'The story focuses on a young boy named Gon Freecss who discovers that his father, who left him at a young age, is actually a world-renowned Hunter, a licensed professional who specializes in fantastical pursuits such as locating rare or unidentified animal species, treasure hunting, surveying unexplored enclaves, or hunting down lawless individuals. Gon departs on a journey to become a Hunter and eventually find his father. Along the way, Gon meets various other Hunters and encounters the paranormal.', 'Yoshiro Togashi', '../upload/bookPfp/Hunterxhunter.jpg', 205);

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
(1, 122, 1, 12.99),
(1, 126, 6, 53.94),
(1, 129, 1, 19.99),
(2, 106, 1, 67.00),
(2, 245, 1, 58.00),
(2, 316, 1, 26.99),
(3, 107, 1, 19.99),
(3, 122, 1, 84.99),
(3, 201, 1, 68.50),
(3, 241, 1, 29.99),
(3, 242, 1, 24.99),
(4, 124, 1, 114.99),
(4, 341, 1, 20.00),
(5, 24, 1, 24.99),
(5, 137, 1, 26.99),
(5, 139, 1, 40.00),
(5, 205, 1, 37.00),
(5, 206, 1, 38.50),
(5, 208, 1, 77.00),
(5, 336, 1, 34.99),
(5, 339, 1, 39.99),
(6, 145, 1, 58.00),
(6, 230, 1, 35.00),
(7, 307, 1, 23.99),
(7, 321, 1, 64.99),
(7, 323, 1, 56.00),
(7, 329, 1, 84.99),
(8, 122, 1, 84.99),
(8, 124, 1, 114.99),
(8, 126, 1, 88.50),
(8, 128, 1, 112.99),
(8, 130, 1, 100.00),
(9, 104, 1, 40.99),
(9, 146, 1, 99.99),
(9, 229, 1, 28.50),
(10, 142, 1, 30.00),
(11, 202, 1, 40.99),
(11, 237, 1, 77.00),
(12, 33, 1, 20.50),
(12, 223, 1, 61.99),
(12, 235, 1, 27.99),
(13, 105, 1, 22.99),
(13, 129, 1, 29.99),
(13, 203, 1, 29.99),
(13, 304, 1, 52.99),
(14, 149, 1, 45.50),
(14, 210, 1, 45.00),
(14, 219, 1, 14.99),
(14, 230, 1, 35.00),
(14, 236, 1, 34.99),
(15, 102, 1, 21.99),
(15, 140, 1, 24.99),
(15, 209, 1, 89.99),
(15, 210, 1, 45.00),
(15, 317, 1, 23.99),
(16, 242, 1, 24.99),
(16, 304, 1, 52.99),
(17, 107, 1, 19.99),
(17, 233, 1, 32.50),
(18, 136, 1, 38.99),
(19, 104, 1, 40.99),
(20, 248, 1, 46.99),
(20, 304, 1, 52.99),
(20, 330, 1, 59.99),
(21, 150, 1, 80.00),
(22, 23, 2, 59.98),
(22, 311, 2, 55.98),
(23, 118, 1, 68.99),
(23, 230, 1, 35.00),
(24, 43, 1, 14.99),
(24, 214, 1, 95.99),
(25, 2, 1, 19.99),
(26, 107, 1, 19.99),
(27, 108, 2, 50.00),
(27, 135, 1, 75.00),
(28, 50, 1, 48.50),
(28, 132, 1, 62.99),
(28, 149, 1, 45.50),
(29, 150, 1, 80.00),
(30, 13, 1, 12.99),
(31, 36, 1, 38.99),
(31, 230, 1, 35.00),
(31, 243, 1, 16.99);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderNo` int(11) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `PaymentType` enum('ewallet','credit card','debit card','bank transfer') NOT NULL,
  `UserID` int(11) NOT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `OrderStatus` enum('Preparing','Delivering','Collected','Complete','Cancelled') NOT NULL DEFAULT 'Preparing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderNo`, `OrderDate`, `TotalQuantity`, `TotalAmount`, `PaymentType`, `UserID`, `AddressID`, `OrderStatus`) VALUES
(1, '2025-03-30 06:50:45', 8, 74.54, 'ewallet', 1, 1, 'Complete'),
(2, '2025-03-31 15:32:47', 3, 126.59, 'ewallet', 4, 6, 'Complete'),
(3, '2025-03-31 15:38:22', 5, 187.77, 'debit card', 5, 7, 'Complete'),
(4, '2025-03-31 15:42:56', 2, 112.99, 'credit card', 6, 8, 'Complete'),
(5, '2025-03-31 15:57:19', 8, 260.57, 'bank transfer', 7, 9, 'Complete'),
(6, '2025-03-31 16:06:37', 2, 79.40, 'debit card', 8, 10, 'Complete'),
(7, '2025-03-31 16:09:31', 4, 188.98, 'bank transfer', 11, 2, 'Complete'),
(8, '2025-03-31 16:11:41', 5, 406.18, 'credit card', 12, 3, 'Complete'),
(9, '2025-03-31 16:13:15', 3, 140.58, 'ewallet', 13, 4, 'Complete'),
(10, '2025-03-31 16:14:39', 1, 29.00, 'debit card', 14, 5, 'Complete'),
(11, '2025-03-31 16:16:28', 2, 122.99, 'bank transfer', 7, 9, 'Complete'),
(12, '2025-03-31 16:18:48', 3, 115.48, 'ewallet', 4, 6, 'Complete'),
(13, '2025-03-31 16:20:07', 4, 140.96, 'debit card', 8, 10, 'Complete'),
(14, '2025-03-31 16:21:40', 5, 180.48, 'credit card', 12, 3, 'Complete'),
(15, '2025-03-31 16:23:22', 5, 210.96, 'ewallet', 13, 4, 'Complete'),
(16, '2025-04-05 14:19:20', 2, 107.97, 'credit card', 1, 1, 'Complete'),
(17, '2025-04-05 16:10:51', 2, 46.99, 'bank transfer', 3, 11, 'Complete'),
(18, '2025-04-08 08:52:42', 1, 43.99, 'debit card', 1, 1, 'Complete'),
(19, '2025-04-08 09:16:13', 1, 45.99, 'ewallet', 3, 11, 'Complete'),
(20, '2025-04-08 09:45:05', 3, 164.97, 'debit card', 1, 1, 'Collected'),
(21, '2025-04-08 12:20:04', 1, 85.00, 'debit card', 1, 1, 'Complete'),
(22, '2025-04-08 12:20:26', 4, 90.97, 'credit card', 1, 1, 'Complete'),
(23, '2025-04-10 18:49:00', 2, 108.99, 'credit card', 1, 1, 'Cancelled'),
(24, '2025-04-10 20:08:02', 2, 115.98, 'ewallet', 1, 1, 'Complete'),
(25, '2025-04-11 09:44:07', 1, 24.99, 'bank transfer', 11, 2, 'Complete'),
(26, '2025-04-11 09:54:38', 1, 24.99, 'credit card', 11, 2, 'Collected'),
(27, '2025-04-11 09:59:59', 3, 130.00, 'ewallet', 11, 2, 'Collected'),
(28, '2025-04-11 10:06:25', 3, 161.99, 'ewallet', 11, 2, 'Collected'),
(29, '2025-04-11 10:07:56', 1, 85.00, 'debit card', 11, 2, 'Collected'),
(30, '2025-04-11 11:34:27', 1, 17.99, 'bank transfer', 11, 2, 'Complete'),
(31, '2025-04-11 20:03:08', 3, 95.98, 'credit card', 1, 1, 'Delivering');

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `UserID`, `BookNo`, `Rating`, `ReviewText`, `ReviewDate`) VALUES
(1, 1, 13, 5, 'ok', '2025-03-26 11:04:00'),
(2, 1, 1, 5, 'Love It, Absolutely amazing!', '2025-03-26 15:46:48'),
(3, 1, 150, 3, 'I love it', '2025-03-27 05:38:14'),
(4, 3, 150, 5, 'Wholesome', '2025-03-29 19:53:15'),
(5, 13, 124, 5, 'Strong Characters', '2025-03-31 16:34:56'),
(6, 7, 307, 4, 'Beautiful Writing', '2025-03-31 16:38:29'),
(7, 8, 122, 5, 'Totally Worth It!', '2025-03-31 16:40:40'),
(8, 11, 321, 5, 'Very Helpful to me', '2025-03-31 16:43:08'),
(9, 12, 230, 4, 'Very funny', '2025-03-31 16:45:52'),
(10, 14, 142, 5, 'Captivating Plot!', '2025-03-31 16:47:23'),
(11, 1, 107, 2, '10/10!', '2025-04-01 17:46:22'),
(12, 11, 304, 5, 'This help me. So much', '2025-04-11 11:26:57'),
(13, 1, 312, 4, 'Good Book', '2025-04-11 12:45:12');

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
(102, 'Mystery', 1),
(103, 'ScienceFiction', 1),
(104, 'Fantasy', 1),
(105, 'Horror', 1),
(201, 'Romance', 2),
(202, 'Horror', 2),
(203, 'Superhero', 2),
(204, 'Comedy', 2),
(205, 'Adventure', 2),
(301, 'Pictures', 3),
(302, 'FairyTales', 3),
(303, 'Educational', 3),
(304, 'Moral', 3),
(305, 'Animal', 3),
(401, 'Mathematic', 4),
(402, 'Science', 4),
(403, 'History', 4),
(404, 'Language', 4),
(405, 'ComputerScience', 4),
(406, 'Business', 4),
(407, 'Engineering', 4),
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
(1, 'Jiajia', '$2y$10$0paAgfRsRyEr17PnP5tTj.KiLep0Wq0gBw8t3GWrbK49Y9NSqo/tm', 'adasd@gmail.com', '0123455466', 'customer', '../upload/customerPfp/1_1742969603.png'),
(2, 'Admin01', '$2y$10$SxwY4SNad8SB52jernXVB.XwsdZW4C4FFGXD6voRAxw5e1R3EZu6O', 'AhMan@gmail.com', '0120111285', 'admin', '../upload/adminPfp/2_1743167524.jpg'),
(3, 'Dada', '$2y$10$mww2cs24M2AoG9ic9aqj0O69rRwOWtivJX6ohFE5EETBKvkQNqa26', 'dada@gmail.com', '0158499888', 'customer', '../upload/customerPfp/3_1743870281.png'),
(4, 'Lingangu', '$2y$10$SoVntdOnTKt7beicvhjjTeQmM5cBkY1hQ.GZmMNLC94WpeRbeH4A.', 'lingangu@gmail.com', '01123456789', 'customer', '../upload/icon/UnknownUser.jpg'),
(5, 'Meme', '$2y$10$VpHT2wbNtx9GCalka5kXOeUUH8lqkkHn23KDdfe2Snvm3G2boqfGO', 'meme@gmail.com', '0127894563', 'customer', '../upload/icon/UnknownUser.jpg'),
(6, 'Dora', '$2y$10$FKtTg2IavPDkT70naTeGoO//ZiLf4o2CbaEg5iTuFDtB7LPD9cDLO', 'dora@gmail.com', '0169987321', 'customer', '../upload/icon/UnknownUser.jpg'),
(7, 'Maggie', '$2y$10$4nC5qd214ndlGYbhvEJlQuEZMIY1LEy.2dOFWRCifZsnAZ1LT27H.', 'maggie@gmail.com', '0105569781', 'customer', '../upload/icon/UnknownUser.jpg'),
(8, 'Jojo', '$2y$10$mU4DnjcXTPlws1wOZ6O4a.8.l.lyFBEvlfmEWxf62UU5.cg5yO76u', 'jojo@gmail.com', '0146632557', 'customer', '../upload/icon/UnknownUser.jpg'),
(9, 'Admin02', '$2y$10$CUbzKXhsry33cnq9HMHZmOwxllWFTILef5clgxB58RYgLGiNdUkYO', 'Bobo@gmail.com', '0111433223', 'admin', '../upload/icon/UnknownUser.jpg'),
(11, 'Aimi', '$2y$10$HwJ9/XlAMEmNHCMYm014DuOlD7ym/5ubyD8I8spdxODCM/UUufIRy', 'Aimi@gmail.com', '0128974581', 'customer', '../upload/customerPfp/11_1744370933.jpg'),
(12, 'beklaozai', '$2y$10$Mdbg2cd2qUObwXvA592K.OJ.ZfcCgygbNGODUpIX4wx7udYPHdDOW', 'LaiChai@gmail.com', '0123455465', 'customer', '../upload/icon/UnknownUser.jpg'),
(13, 'OMG', '$2y$10$Q/PLnhOWROsPg31p5pC9c.1mBT/dPKRjhCwGzIX6NjsZPGoNwOraO', 'OMG@gmail.com', '01254894561', 'customer', '../upload/icon/UnknownUser.jpg'),
(14, 'amirmir', '$2y$10$JembV2fL5tQ0sF7xFrKgI.JkNktD54ngG9pUVFdOb8v0xwmCShxM2', 'amir@gmail.com', '0128974567', 'customer', '../upload/icon/UnknownUser.jpg'),
(15, 'aa', '$2y$10$be24xU/i/PscG1ngSC4PY.O/FVeiOR7oQe4PxnOiE.0CJArtekQge', 'aaa@gmail.com', '0145867985', 'customer', '../upload/icon/UnknownUser.jpg'),
(16, 'aloha', '$2y$10$fs4YasyOKunaThwgLrEl7u0Q0n7fcrzXdppz1am1V1CVwxOer1on.', 'alo@gmail.com', '0158499544', 'customer', '../upload/icon/UnknownUser.jpg');

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
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `BookNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `SubcategoryNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
