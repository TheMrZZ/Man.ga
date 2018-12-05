-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2018 at 12:23 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `man.ga`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STRING` (`s` VARCHAR(1024), `del` CHAR(1), `i` INT) RETURNS VARCHAR(1024) CHARSET utf8 BEGIN

        DECLARE n INT ;

        -- get max number of items
        SET n = LENGTH(s) - LENGTH(REPLACE(s, del, '')) + 1;

        IF i > n THEN
            RETURN NULL ;
        ELSE
            RETURN SUBSTRING_INDEX(SUBSTRING_INDEX(s, del, i) , del , -1 ) ;        
        END IF;

    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `average_rating`
-- (See below for the actual view)
--
CREATE TABLE `average_rating` (
`mangaID` int(11)
,`avgRating` decimal(14,4)
,`votes` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `mangaID` int(11) NOT NULL,
  `comment` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `userID`, `mangaID`, `comment`) VALUES
(2, 1, 1, 'I must take some time to read it!'),
(3, 5, 1, 'One of the best manga you\'ll find. Epic actions, incredible battles, and the protagonists are juste the best. Luffy is dumb sometimes, but this manga will show you what real friendship is, and make you wish you were a pirate.'),
(4, 2, 2, 'The story is extremely compelling. It\'s fantastic.'),
(5, 3, 3, 'Too bad it\'s over.'),
(6, 9, 3, 'I find it annoying that all fights are won thanks to the \"power of friendship\"'),
(7, 4, 4, 'I look forward to the rest.'),
(8, 6, 4, 'The story is far too bloody and horrible for me, NOT FOR ME!'),
(9, 5, 5, 'The character is extremely atachant, this seinen is really a masterpiece'),
(10, 6, 6, 'He\'s one of my top 3 favorite mangas'),
(11, 3, 6, 'I grew up with naruto, it\'s probably one of the best memories of my childhood, I recommend it to anyone who doesn\'t know it'),
(12, 7, 7, 'The first part of the manga is pure genius, a pity that the second part leaves something to be desired. An excellent work that I still recommend'),
(13, 8, 8, 'It\'s an excellent work that\'s even older than me, too bad the pace of publication is so slow.'),
(14, 9, 9, 'I love it, it\'s so much fun.'),
(15, 1, 9, 'Do you know when season 2 of the anime is coming out ?'),
(16, 10, 10, 'who still reads this manga in 2018 ?'),
(17, 6, 10, 'I have all the manga in paper form at home, it\'s my brother and I\'s favorite manga.'),
(18, 1, 11, 'the beginning of the story is really too sad'),
(19, 2, 12, 'It\'s the best Josei I know.'),
(20, 3, 13, 'The main characters are really too cute'),
(21, 4, 14, 'Excellent shojo that I recommend to all people who want to try this style of manga');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `mangaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'action'),
(2, 'adventure'),
(3, 'romance'),
(4, 'drama'),
(5, 'fantasy'),
(6, 'comedy'),
(7, 'slice of life'),
(8, 'supernatural'),
(9, 'magic'),
(10, 'horror'),
(11, 'scifi'),
(12, 'psychological'),
(13, 'mystery');

-- --------------------------------------------------------

--
-- Table structure for table `manga`
--

CREATE TABLE `manga` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `typeID` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `chapters` int(11) NOT NULL,
  `last_update` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manga`
--

INSERT INTO `manga` (`id`, `name`, `author`, `typeID`, `status`, `description`, `chapters`, `last_update`) VALUES
(1, 'One Piece', 'Eichiiro Oda', 1, 'ongoing', 'The manga focuses on Monkey D. Luffy, a young man who, inspired by his childhood idol and powerful pirate \"Red Haired\" Shanks, sets off on a journey from the East Blue Sea to find the famed treasure One Piece and proclaim himself the King of the Pirates.', 926, '4 days ago'),
(2, 'Tower of God', 'SIU	', 1, 'ongoing', 'Bam, who was alone all his life has entered the tower to chase after his only friend, Rachel, but how will he survive without having any special strength or power?\"What do you desire? Money and wealth? Honor and pride? Authority and power? Revenge? Or something that transcends them all? Whatever you desire-it\'s here.\"', 330, '1 day ago'),
(3, 'Fairy Tail', 'Mashima Hiro', 1, 'ongoing', 'Celestial wizard Lucy wants to join the Fairy Tail, a guild for the most powerful wizards. But instead, her ambitions land her in the clutches of a gang of unsavory pirates led by a devious magician. Her only hope is Natsu, a strange boy she happens to meet on her travels. Natsu\'s not your typical hero - but he just might be Lucy\'s best hope.', 545, '1 year ago'),
(4, 'Shingeki no Kyojin', 'Isayama Hajime', 3, 'ongoing', 'Several hundred years ago, humans were nearly exterminated by giants. Giants are typically several stories tall, seem to have no intelligence, devour human beings and, worst of all, seem to do it for the pleasure rather than as a food source. A small percentage of humanity survived by walling themselves in a city protected by extremely high walls, even taller than the biggest of giants. Flash forward to the present and the city has not seen a giant in over 100 years. Teenage boy Eren and his foster sister Mikasa witness something horrific as one of the city walls is damaged by a 60 meter (196.85 feet) giant causing a breach in the wall. As the smaller giants flood the city, the two kids watch in horror the tragic events that follow. Eren vows that he will wipe out every single giant and take revenge for all of mankind.', 111, '1 month ago'),
(5, 'Tokyo Ghoul', 'Ishida Sui', 3, 'completed', 'Strange murders are happening in Tokyo. Due to liquid evidence at the scene, the police conclude the attacks are the results of \'eater\' type ghouls. College buddies Kaneki and Hide come up with the idea that ghouls are imitating humans so that\'s why they haven\'t ever seen one. Little did they know that their theory may very well become reality.', 143, '2 years ago'),
(6, 'Naruto', 'Kishimoto Masachi', 1, 'completed', 'Before Naruto\'s birth, a great demon fox had attacked the Hidden Leaf Village. The 4th Hokage from the leaf village sealed the demon inside the newly born Naruto, causing him to unknowingly grow up detested by his fellow villagers. Despite his lack of talent in many areas of ninjutsu, Naruto strives for only one goal: to gain the title of Hokage, the strongest ninja in his village. Desiring the respect he never received, Naruto works toward his dream with fellow friends Sasuke and Sakura and mentor Kakashi as they go through many trials and battles that come with being a ninja.', 700, '4 years ago'),
(7, 'Death Note', 'Ohba Tsugumi', 3, 'completed', 'A shinigami, as a god of death, can kill any person-provided they see their victim\'s face and write their victim\'s name in a notebook called a Death Note. One day, Ryuk, bored by the shinigami lifestyle and interested in seeing how a human would use a Death Note, drops one into the human realm.High school student and prodigy Light Yagami stumbles upon the Death Note and-since he deplores the state of the world-tests the deadly notebook by writing a criminal\'s name in it. When the criminal dies immediately following his experiment with the Death Note, Light is greatly surprised and quickly recognizes how devastating the power that has fallen into his hands could be.With this divine capability, Light decides to extinguish all criminals in order to build a new world where crime does not exist and people worship him as a god. Police, however, quickly discover that a serial killer is targeting criminals and, consequently, try to apprehend the culprit. To do this, the Japanese investigators count on the assistance of the best detective in the world: a young and eccentric man known only by the name of L.', 112, '10 years ago'),
(8, 'Berserk', 'Mirua Kentaro', 3, 'ongoing', 'Guts, known as the Black Swordsman, seeks sanctuary from the demonic forces attracted to him and his woman because of a demonic mark on their necks, and also vengeance against the man who branded him as an unholy sacrifice. Aided only by his titanic strength gained from a harsh childhood lived with mercenaries, a gigantic sword, and an iron prosthetic left hand, Guts must struggle against his bleak destiny, all the while fighting with a rage that might strip him of his humanity.', 357, '3 months ago'),
(9, 'One Punch-Man', 'ONE', 1, 'ongoing', 'After rigorously training for three years, the ordinary Saitama has gained immense strength which allows him to take out anyone and anything with just one punch. He decides to put his new skill to good use by becoming a hero. However, he quickly becomes bored with easily defeating monsters, and wants someone to give him a challenge to bring back the spark of being a hero.', 155, '2 days ago'),
(10, 'Dragon Ball', 'Toriyama Akira', 1, 'completed', 'Dragon Ball follows the adventures of Goku from his childhood through adulthood as he trains in martial arts and explores the world in search of the seven mystical orbs known as the Dragon Balls, which can summon a wish-granting dragon when gathered. Along his journey, Goku makes several friends and battles a wide variety of villains, many of whom also seek the Dragon Balls for their own desires. Along the way becoming the strongest warrior in the universe.', 519, '18 years ago'),
(11, 'Nana', 'Yazawa Ai', 4, 'ongoing', 'Nana Komatsu is a young woman who\'s endured an unending string of boyfriend problems. Moving to Tokyo, she\'s hoping to take control of her life and put all those messy misadventures behind her. She\'s looking for love and she\'s hoping to find it in the big city.', 147, '1 year ago'),
(12, 'Paradise Kiss', 'Yazawa Ai', 4, 'completed', 'Yukari wants nothing more than to make her parents happy by studying hard and getting into a good college. One afternoon, however, she is kidnapped by a group of self-styled fashion-obsessed artists who call themselves \"Paradise Kiss.\" Yukari suddenly finds herself flung into the roller-coaster life of the fashion world, guided by George, art-snob extraordinaire. In a glamorous makeover of body, mind and soul, she is turned from a hapless bookworm into her friends own exclusive clothing model.', 48, '15 years ago'),
(13, 'Fruits Basket', 'Takaya Natsuki', 2, 'completed', 'Tohru Honda, an orphaned high school girl, is taken in by the wealthy Shigure Sohma when he realizes she has nowhere else to go. However, the Sohma family shares a secret, and it isn\'t long before Tohru discovers that there\'s a reason why her classmates, Yuki and Kyo Sohma, never let girls get near them, and never talk about their lives before they lived with Shigure. And before she knows it, Tohru has become so tangled up in the lives of each member of the Sohma family that she couldn\'t leave even if she wanted to.', 161, '1 year ago'),
(14, 'Ao Haru Ride', 'Sakisaki Io', 2, 'completed', 'Yoshioka Futaba has a few reasons why she wants to \"reset\" her image and life as a new high-school student. Because she\'s cute, she was ostracized by her female friends in junior high, and because of a misunderstanding, she couldn\'t get her feeling across to the one boy she has always liked, Tanaka-kun. Now in high school, she is determined to be as unladylike as possible so that her friends won\'t be jealous of her. While living her life this way contentedly, she meets Tanaka-kun again, but he now goes under the name of Mabuchi Kou. He tells her that he felt the same way as she did when they were younger, but now things can never be the same again. Will Futaba be able to continue her love that never even started from three years ago?', 49, '8 months ago');

-- --------------------------------------------------------

--
-- Stand-in structure for view `mangabydate`
-- (See below for the actual view)
--
CREATE TABLE `mangabydate` (
`id` int(11)
,`name` varchar(100)
,`author` varchar(100)
,`typeID` int(11)
,`status` varchar(100)
,`description` varchar(2000)
,`chapters` int(11)
,`last_update` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `mangagenre`
--

CREATE TABLE `mangagenre` (
  `id` int(11) NOT NULL,
  `mangaID` int(11) NOT NULL,
  `genreID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mangagenre`
--

INSERT INTO `mangagenre` (`id`, `mangaID`, `genreID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 8),
(4, 1, 5),
(5, 1, 6),
(6, 2, 1),
(7, 2, 2),
(8, 2, 6),
(9, 2, 13),
(10, 2, 5),
(11, 2, 12),
(12, 3, 1),
(13, 3, 2),
(14, 3, 4),
(15, 3, 5),
(16, 3, 8),
(17, 4, 1),
(18, 4, 4),
(19, 4, 5),
(20, 4, 10),
(21, 4, 8),
(22, 5, 1),
(23, 5, 4),
(24, 5, 10),
(25, 5, 13),
(26, 5, 12),
(27, 5, 8),
(28, 6, 1),
(29, 6, 2),
(30, 6, 5),
(31, 6, 6),
(32, 7, 4),
(33, 7, 13),
(34, 7, 12),
(35, 7, 8),
(36, 8, 1),
(37, 8, 2),
(38, 8, 4),
(39, 8, 5),
(40, 8, 10),
(41, 8, 12),
(42, 8, 8),
(43, 9, 1),
(44, 9, 6),
(45, 9, 11),
(46, 9, 8),
(47, 10, 1),
(48, 10, 2),
(49, 10, 6),
(50, 10, 5),
(51, 1, 1),
(52, 1, 2),
(53, 1, 8),
(54, 1, 5),
(55, 1, 6),
(56, 2, 1),
(57, 2, 2),
(58, 2, 6),
(59, 2, 13),
(60, 2, 5),
(61, 2, 12),
(62, 3, 1),
(63, 3, 2),
(64, 3, 4),
(65, 3, 5),
(66, 3, 8),
(67, 4, 1),
(68, 4, 4),
(69, 4, 5),
(70, 4, 10),
(71, 4, 8),
(72, 5, 1),
(73, 5, 4),
(74, 5, 10),
(75, 5, 13),
(76, 5, 12),
(77, 5, 8),
(78, 6, 1),
(79, 6, 2),
(80, 6, 5),
(81, 6, 6),
(82, 7, 4),
(83, 7, 13),
(84, 7, 12),
(85, 7, 8),
(86, 8, 1),
(87, 8, 2),
(88, 8, 4),
(89, 8, 5),
(90, 8, 10),
(91, 8, 12),
(92, 8, 8),
(93, 9, 1),
(94, 9, 6),
(95, 9, 11),
(96, 9, 8),
(97, 10, 1),
(98, 10, 2),
(99, 10, 6),
(100, 10, 5),
(101, 10, 11),
(102, 10, 8),
(103, 11, 6),
(104, 11, 4),
(105, 11, 3),
(106, 11, 7),
(107, 12, 6),
(108, 12, 4),
(109, 12, 7),
(110, 12, 3),
(111, 13, 6),
(112, 13, 4),
(113, 13, 3),
(114, 13, 7),
(115, 13, 8),
(116, 14, 6),
(117, 14, 4),
(118, 14, 3),
(119, 14, 7);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `mangaID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `mangaID`, `userID`, `rating`) VALUES
(2, 1, 1, 4),
(3, 1, 4, 3),
(4, 1, 5, 5),
(5, 2, 9, 5),
(6, 2, 5, 4),
(7, 2, 6, 3),
(8, 2, 2, 5),
(9, 3, 3, 4),
(10, 3, 2, 5),
(11, 3, 1, 3),
(12, 3, 5, 5),
(13, 4, 2, 2),
(14, 4, 1, 5),
(15, 4, 8, 5),
(16, 5, 10, 3),
(17, 5, 7, 4),
(18, 5, 5, 5),
(19, 5, 6, 5),
(20, 5, 1, 4),
(21, 6, 10, 3),
(22, 6, 5, 1),
(23, 6, 3, 5),
(24, 6, 2, 4),
(25, 6, 9, 3),
(26, 6, 1, 4),
(27, 7, 8, 5),
(28, 7, 10, 5),
(29, 7, 2, 5),
(30, 7, 6, 5),
(31, 8, 3, 1),
(32, 8, 2, 4),
(33, 8, 7, 3),
(34, 8, 5, 3),
(35, 9, 1, 5),
(36, 9, 5, 5),
(37, 9, 2, 5),
(38, 10, 9, 4),
(39, 10, 6, 3),
(40, 11, 1, 4),
(41, 11, 10, 4),
(42, 11, 4, 1),
(43, 11, 2, 3),
(44, 11, 8, 4),
(45, 12, 6, 5),
(46, 12, 10, 5),
(47, 12, 2, 5),
(48, 12, 6, 3),
(49, 12, 4, 2),
(50, 12, 3, 1),
(51, 13, 4, 5),
(52, 13, 3, 4),
(53, 13, 1, 3),
(54, 13, 8, 1),
(55, 13, 7, 3),
(56, 13, 2, 4),
(57, 14, 8, 5),
(58, 14, 4, 4),
(59, 14, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'shonen'),
(2, 'shojo'),
(3, 'seinen'),
(4, 'josei'),
(5, 'kodomomuke');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `passwd`, `email`, `username`) VALUES
(1, '$2y$10$GdGr5zIgy8rwP5cbQ95SieV..QS3l3mgUiL4z8phf9..jYpuDIPvK', 'Peter.Scott@gmail.com', 'Petsco'),
(2, '$2y$10$fDe0VeiRQE5iyX4BO78ph.OE.7za1UIaq4HH9emM2VC6LlJXfWWIa', 'Mark.Martin@gmail.com', 'Mmtin'),
(3, '$2a$04$30Td6OiTEaf3yuFPQq4VCuMtoJGVyCje1RC.t2Tlb6dHuznMdTwbO', 'Christine.Dupont@gmail.com', 'Christoche'),
(4, '$2y$10$o5Atv7MW1qm9wwMehJ694.NSo54B7uoeboVuY8w2UCDEqePVr3pHG', 'Jean.Smith@gmail.com', 'Fan-task-tik'),
(5, '$2y$10$PwalA/EeXPZfJekbVYCABeyq2Xjjk985fxPWt46dvAczs5rwwcNZ.', 'Pauk.Kent@gmail.com', 'Kotei'),
(6, '$2y$10$MbUAKsxpNA27hjqmhvYQTuarpgwpNAEup2RAfo5nShEXE8xfVJHEq', 'Peter.Scott@gmail.com', 'Jiji24'),
(7, '$2y$10$XA1is/V1oiOY5aGooRlGF.OlGEKxeU9cvd82sIbsI6r.W1blArbCK', 'Anne.Bayne@gmail.com', 'Luffy-space'),
(8, '$2y$10$wkwc5P.9at7zxotM5hFRqO8esbB0FOT7zWQYS4nLDirIGk.YwloUy', 'Camille.Rodriguez@gmail.com', 'Camcam'),
(9, '$2y$10$brqL4MSgSeE14sJRGd4XKuCKHSFjZcXSfZkxXs2D37vPBIQA5cUw6', 'Frederic.Mcgrath@gmail.com', 'Fred-naruto'),
(10, '$2y$10$.xi7zZB/vVE6JtfUFFfVUes4hLdE6NpHI3L6SKsVdluc4vcoX3cSi', 'MaxBoisser.BGdu94@gmail.com', 'Maxou');

-- --------------------------------------------------------

--
-- Structure for view `average_rating`
--
DROP TABLE IF EXISTS `average_rating`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `average_rating`  AS  select `rating`.`mangaID` AS `mangaID`,avg(`rating`.`rating`) AS `avgRating`,count(`rating`.`rating`) AS `votes` from `rating` group by `rating`.`mangaID` ;

-- --------------------------------------------------------

--
-- Structure for view `mangabydate`
--
DROP TABLE IF EXISTS `mangabydate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mangabydate`  AS  select `manga`.`id` AS `id`,`manga`.`name` AS `name`,`manga`.`author` AS `author`,`manga`.`typeID` AS `typeID`,`manga`.`status` AS `status`,`manga`.`description` AS `description`,`manga`.`chapters` AS `chapters`,`manga`.`last_update` AS `last_update` from `manga` order by (case when ((right(left(`manga`.`last_update`,2),1) = ' ') and (right(left(`manga`.`last_update`,3),1) = 'd')) then 0 when ((right(left(`manga`.`last_update`,2),1) = ' ') and (right(left(`manga`.`last_update`,3),1) = 'w')) then 1 when ((right(left(`manga`.`last_update`,2),1) = ' ') and (right(left(`manga`.`last_update`,3),1) = 'm')) then 2 when ((right(left(`manga`.`last_update`,2),1) = ' ') and (right(left(`manga`.`last_update`,3),1) = 'y')) then 3 else 5 end),`manga`.`last_update` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `mangaID` (`mangaID`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `mangaID` (`mangaID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `typeID` (`typeID`);

--
-- Indexes for table `mangagenre`
--
ALTER TABLE `mangagenre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mangaID` (`mangaID`),
  ADD KEY `genreID` (`genreID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mangaID` (`mangaID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `manga`
--
ALTER TABLE `manga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mangagenre`
--
ALTER TABLE `mangagenre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `MANGA_COMMENT_FK` FOREIGN KEY (`mangaID`) REFERENCES `manga` (`id`),
  ADD CONSTRAINT `USER_COMMENT_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `MANGA_FAVORITE_FK` FOREIGN KEY (`mangaID`) REFERENCES `manga` (`id`),
  ADD CONSTRAINT `USER_FAVORITE_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `manga`
--
ALTER TABLE `manga`
  ADD CONSTRAINT `TYPE_MANGA_FK` FOREIGN KEY (`typeID`) REFERENCES `type` (`id`);

--
-- Constraints for table `mangagenre`
--
ALTER TABLE `mangagenre`
  ADD CONSTRAINT `GENRE_MANGAGENRE_FK` FOREIGN KEY (`genreID`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `MANGA_MANGAGENRE_FK` FOREIGN KEY (`mangaID`) REFERENCES `manga` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `MANGA_RATING_FK` FOREIGN KEY (`mangaID`) REFERENCES `manga` (`id`),
  ADD CONSTRAINT `USER_RATING_FK` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
