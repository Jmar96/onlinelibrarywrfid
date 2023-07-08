-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 07, 2017 at 03:29 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `olsrfid`
--
CREATE DATABASE IF NOT EXISTS `olsrfid` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `olsrfid`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminId` varchar(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `address` varchar(60) NOT NULL,
  `contactNo` int(11) NOT NULL,
  `emailAddress` varchar(40) NOT NULL,
  `retrieve` varchar(80) NOT NULL,
  `userPic` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminId`, `username`, `password`, `fullname`, `address`, `contactNo`, `emailAddress`, `retrieve`, `userPic`) VALUES
(1, '1', 'admin', 'admin', 'admin admin', 'address', 324234324, 'kalsdjfasdklfj@askdfj', 'admin', ''),
(2, '2', 'jaymar', 'jaymar', 'askldjflkjdsa', 'lkjdaskljf', 234234, 'kadlsjfkjasdkfj@f', 'jaymar', ''),
(3, '3', 'recelle', 'recelle', 'recella', 'kljfklajsd', 3423423, 'recelle@sadkfjkdsaj', 'ako ang admin d2', ''),
(5, '24234234', 'adfasdfdasfasd', 'fsadfasdfasdfsdafsadf', 'asdfasdfsadfasdf', 'asdfsdafasdfadsf', 234234234, 'asdfdsafsdafasdf', 'sadfdsafsdaf23r', ''),
(6, '24234234', 'adsfdasfasdfsadf', 'adsfdsafasdf', 'sdafasdfdsafasd', 'fasdfsadfsadf', 111111111, 'asdfdasfads@aaa', 'asdfdasfsdafdsfdfdfdfd', '');

-- --------------------------------------------------------

--
-- Table structure for table `bcategories`
--

CREATE TABLE IF NOT EXISTS `bcategories` (
  `catId` int(11) NOT NULL AUTO_INCREMENT,
  `catTitle` varchar(40) NOT NULL,
  PRIMARY KEY (`catId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `bcategories`
--

INSERT INTO `bcategories` (`catId`, `catTitle`) VALUES
(1, 'General'),
(2, 'Philosophy and Psychology'),
(3, 'Religion'),
(4, 'Social Sciences'),
(5, 'Language'),
(6, 'Natural Science and Maths'),
(7, 'Technology'),
(8, 'Arts'),
(9, 'Literature'),
(10, 'Geography and History'),
(11, 'Adventure'),
(12, 'Sci-Fi and Fantasy'),
(13, 'Supernatural'),
(14, 'Romance');

-- --------------------------------------------------------

--
-- Table structure for table `bookrecord`
--

CREATE TABLE IF NOT EXISTS `bookrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookId` int(11) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `bookTitle` varchar(20) NOT NULL,
  `author` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `bookStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bookrecord`
--

INSERT INTO `bookrecord` (`id`, `bookId`, `isbn`, `bookTitle`, `author`, `category`, `bookStatus`) VALUES
(1, 123456, '98765', 'Test2', 'Test2', 'Technology', 'available'),
(2, 123456, '5623', 'Test2', 'Test2', 'Technology', 'available'),
(3, 123456, '123456789', 'Test2', 'Test2', 'Technology', 'available'),
(4, 123789, '65656565', 'test3', 'test3', 'Social Sciences', 'available'),
(5, 123789, '787878', 'test3', 'test3', 'Social Sciences', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(30) NOT NULL,
  `bookName` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `quantity` int(20) NOT NULL,
  `bookStatus` varchar(20) NOT NULL,
  `bookPic` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `isbn`, `bookName`, `author`, `category`, `description`, `quantity`, `bookStatus`, `bookPic`) VALUES
(7, '66666666', 'zombie2', '3453453453', '45354345', '345354354', 1, 'unavailable', '872717.jpg'),
(8, '656565656', 'zombie1', 'afdsafdsaf', 'asdfdsafasd', 'fdsafdsafdsa', 2, 'available', '462056.jpg'),
(9, '234234324324', 'fakfakfak', 'fakfakfak', 'fak', 'fak', 1, 'unavailable', '749427.jpg'),
(11, '542323525', 'sexy', 'ko', 'Arts', 'taebaho', 5, 'available', '871528.png'),
(12, '23423423', 'gasgg', 'ahahah', 'hahaha', 'hahahah', 2, 'available', '364223.png'),
(13, '8789798798', 'kdslajfkljdsafkj', 'kladsjfkljsad', 'pakpak', 'palaks hjadshf', 5, 'available', '914179.jpg'),
(14, '654654', 'bf', 'gf', 'Technology', 'gf gawa bf ginawa gf', 13, 'available', '313279.jpg'),
(24, '51651611', 'borland', 'borlando', 'Technology', 'lkadsjfkljdsafj\r\nasdfdsafdsa\r\nfdsa\r\nfsdaf\r\nsdafsdafsdafsad\r\nsdagsdag\r\nsdagsdag', 8, 'available', '671868.jpg'),
(25, '1398733770730', 'Triangle (Book of Lists)', 'unknown', 'General', 'Triangle Business Journal\r\n-as essential tool for doing business in the Triangle.', 12, 'available', '567389.jpg'),
(26, '7019204423684', 'Nashville (Book of Lists)', 'unknown', 'General', 'Nashville Business Journal 2016-2017', 12, 'available', '144502.jpg'),
(27, '5240287021861', 'The Pocket Book of General Ignorance', 'by John Lloyd & John', 'General', 'A handy paperback version of the number-one bestseller, complete with the long-awaited index. Translated into 23 languages, it has sold over 800,000 copies worldwide.', 12, 'available', '362942.jpg'),
(28, '9888691902582', 'The Book of General Ignorance', 'Stephen Fry & Alan D', 'General', 'The Book of General Ignorance for ingnorance', 12, 'available', '385686.jpg'),
(29, '8853225240262', 'A Sensible Vision', 'Barbara Louw', 'General', 'A practical model to effeciently support people to put ****** behind them.', 12, 'available', '443764.jpg'),
(30, '2127232107791', 'Incognito', 'David Eagleman', 'Philosophy and Psychology', 'The secrets lives of the brain..', 12, 'available', '245384.jpg'),
(31, '3457111977668', 'The Brain', 'David Eagleman', 'Philosophy and Psychology', 'The story of you..', 12, 'available', '832474.jpg'),
(32, '7406703767706', 'The Philosophy Book', 'unknown', 'Philosophy and Psychology', 'Big Ideas Simply Explained', 12, 'available', '639765.jpg'),
(33, '6682724130154', 'What it is means to be HUMAN', 'Joanna Bourke', 'Philosophy and Psychology', 'What is means to be Human', 12, 'available', '697111.jpg'),
(34, '8308841159199', 'The Philosophy of Moral Development', 'Lawrence Kohlberg', 'Philosophy and Psychology', 'Essay on Moral Development', 12, 'available', '559584.jpg'),
(35, '2805141377836', 'Critical Thinking in Psychology', 'John Ruscio', 'Philosophy and Psychology', 'Separating Sense from Nonsense', 12, 'available', '582876.jpg'),
(38, '7536924407418', 'The Religious Test', 'Damon Linker', 'Religion', 'Why we must question the belief of our leader.', 12, 'available', '294377.jpg'),
(39, '7282687781945', 'Terror in the Mind of God', 'Mark Juergensmeyer', 'Religion', 'The global rise of religious violence.', 12, 'available', '396570.jpg'),
(40, '7792716133574', 'Evolution and Religion', 'Michael Ruse', 'Religion', 'A dialogue', 12, 'available', '403063.jpg'),
(41, '6974416389662', 'The Book of Joy', 'Dalai Lama & Desmond', 'Religion', 'Lasting happiness in a changing world', 12, 'available', '178434.jpg'),
(42, '1557909357546', 'Religious Literacy', 'Stephen Prothero', 'Religion', 'What every american needs to know and what doesnt.', 12, 'available', '791499.jpg'),
(43, '7792318287456', 'God is not One', 'Stephen Prothero', 'Religion', 'The eight rival religions that run the world', 12, 'available', '112643.jpg'),
(44, '3336117606037', 'Writing for Social Science', 'Howard S. Becker', 'Social Sciences', 'How to start and finish your thesis, book or article.', 12, 'available', '90235.jpg'),
(45, '2857855021205', 'Theories, Practices and examples of Community and ', 'Tom Denison, Mauro Sarrica and Larry Stillman', 'Social Sciences', 'Theories, Practices and examples of Community and Social Informatics', 12, 'available', '683331.jpg'),
(46, '0561316780300', 'Case Study & Theory Development in the Social Scie', 'Alexander L. George & Andrew Bennett', 'Social Sciences', 'Case Study & Theory Development in the Social Sciences', 12, 'available', '190141.jpg'),
(47, '0337579981850', 'Applied Multivariate Statistics for the Social Sci', 'Keenan A. Pituch & James P. Stevens', 'Social Sciences', 'Applied Multivariate Statistics for the Social Science (Analyses with SAS  and IBM''S SPSS)', 12, 'available', '591900.jpg'),
(48, '8858883432013', 'The C++ Programming Language', 'Bjarne Stroustrup', 'Language', 'Fourth Edition', 12, 'available', '755829.jpg'),
(49, '7261897474341', 'Books of Figurative Language', 'unknown', 'Language', 'Books of Figurative Language', 12, 'available', '542450.jpg'),
(50, '8808889877073', 'Domain Specific Language', 'Martin Fowler with Rebecca Parsons', 'Language', 'A Martin Fowler signature book', 12, 'available', '740007.jpg'),
(51, '1712233124190', 'Programming Language Fundamental by Example', 'D. E. Stevenson', 'Language', 'Programming Language Fundamental by Example', 12, 'available', '576748.jpg'),
(52, '0285644172790', 'Mathematics for Computer Scientists', 'Gareth Janaceck; Mark Lemmon Close', 'Natural Science and Maths', 'Mathematics for Computer Scientists', 12, 'available', '259804.jpg'),
(53, '7753946443812', 'Electricity, Magnetism, Optics and Modern Psysics', 'Daniel Gebreselasie', 'Natural Science and Maths', 'Electricity, Magnetism, Optics and Modern Psysics', 12, 'available', '754031.jpg'),
(54, '7273823165231', 'Fundamentals of Chemistry', 'Romain Elsair', 'Natural Science and Maths', 'Fundamentals of Chemistry', 12, 'available', '599461.jpg'),
(55, '6649493763906', 'Engineering Thermodynamics Solutions Manual', 'Prof. T.T. Al-Shemmeri', 'Natural Science and Maths', 'Engineering Thermodynamics Solutions Manual', 12, 'available', '251847.jpg'),
(56, '8619966246154', 'Foundation of Physics for Scientists and Engineers', 'Ali R. Fazely', 'Natural Science and Maths', 'Foundation of Physics for Scientists and Engineers', 12, 'available', '243738.jpg'),
(57, '0966025403920', 'Modified Atmosphere and Active Packaging Technolog', 'Ioannis S. Arvanitoyannis', 'Technology', 'Modified Atmosphere and Active Packaging Technologies', 12, 'available', '767658.jpg'),
(58, '4799942762940', 'CryENGINE Game Programming with C++, C# and Lua', 'Filip Lundgren & Ruan Pearce_Authers', 'Technology', 'Get to grips with the essential tools for developing games with the awesome and powerful CryEngine.', 12, 'available', '16731.jpg'),
(59, '3052070578898', 'Arduino by Example', 'Adith Jagadish', 'Technology', 'Design and build fantastic project and devices using the arduino platform', 12, 'available', '531140.jpg'),
(60, '0658659788086', 'Android Game Programming', 'John Horton', 'General', '', 12, 'available', '567541.jpg'),
(61, '5030088071934', 'Programming Windows Runtime ', 'Jeremy Likness & John Garland', 'Technology', 'Programming Windows Runtime by examples', 12, 'available', '992836.jpg'),
(62, '1343342204323', 'Grande Illusions', 'Tom Savini', 'Arts', 'The art and techniques of special make-up effects.', 12, 'available', '979269.jpg'),
(63, '5843752154735', 'Mounting Frustration', 'Susan E. Cahan', 'Arts', 'The art museum in the age of black power`', 12, 'available', '740037.jpg'),
(64, '1359666301433', 'The Art Book', 'Phaidon', 'Arts', 'The Art Book (Phaidon)', 12, 'available', '392515.jpg'),
(65, '7463701870546', 'Hand Book for MOMS', 'mom', 'Arts', 'Handbook for moms', 12, 'available', '871894.jpg'),
(66, '5487031972642', 'Primitivism', 'unknown', 'Arts', 'In 20th century art\r\nThe museum  of modern art, new york', 12, 'available', '997623.jpg'),
(67, '5940147427632', 'Literature Theory', 'Terry Eagleton', 'Literature', 'Literature Theory 2nd edition', 12, 'available', '666960.jpg'),
(68, '4347225571958', 'A spy in the house of love', 'unknown', 'Literature', 'spy', 12, 'available', '688636.jpg'),
(69, '5830202526023', 'Legend of Pineaaple', 'unknown', 'Literature', 'Ang alamat ng pinya', 12, 'available', '586443.jpg'),
(70, '1960139900031', 'Bukas Luwalhating Kay Ganda', 'E. San Juan, Jr.', 'Literature', 'Tomorrow with glorious beauty', 12, 'available', '207946.jpeg'),
(71, '3716921760004', 'A tale for the time being', 'Ruth Ozeki', 'Literature', 'A tale for the time being', 12, 'available', '857321.jpg'),
(72, '5888070285220', 'History', 'unknown', 'Geography and History', 'National Geography , da vinci, the dead sea scrolls, seven wonders, pompeii and pettersburg', 12, 'available', '394557.jpg'),
(73, '6035268152258', 'The Colonize Model of the World', 'J. M. Blaut', 'Geography and History', 'The Colonize Model of the World', 12, 'available', '934179.jpg'),
(74, '1189821128664', '20 Historical Fiction Pictures books', 'unknown', 'Geography and History', '20 Historical Fiction Pictures books', 12, 'available', '642021.jpg'),
(75, '6728709094704', 'Atlas of the World', 'unknown', 'Geography and History', 'Atlas of the World tenth edition', 12, 'available', '37675.jpg'),
(76, '1087840647499', 'Geography of Religion', 'Archbishop Desmond Tutu', 'Geography and History', 'Where Gods lives, Where Pilgrims Walk', 12, 'available', '82949.jpg'),
(77, '6113370801395', 'Prisoners of Geography', 'Tim Marshall', 'Geography and History', 'Ten maps the explain everything in the world\r\nShows how geography shapes not history but destiny.', 12, 'available', '554828.jpg'),
(78, '3049185747763', 'The Mystery of Chimney Rock', 'Edward Packard', 'Adventure', 'Choose your own adventure', 20, 'available', '457086.jpg'),
(79, '9234305451635', '20,000 League under the Sea', 'Jules Verne', 'Adventure', 'Complete and unabridged', 12, 'available', '739580.jpg'),
(80, '7553766880753', 'Farewell Leicester Square', 'Jon Kilkade', 'Adventure', 'A superb thriller', 12, 'available', '710952.jpg'),
(81, '8972273305532', 'Treasure Island', 'unknown', 'Adventure', 'Treasure treasure treasure', 12, 'available', '681563.jpg'),
(82, '3515876080159', 'Luna New Moon', 'IAN McDonald', 'Sci-Fi and Fantasy', 'Luna New Moon', 12, 'available', '390533.jpg'),
(83, '4806500372066', 'Space Ranger', 'Issac Asimov', 'Sci-Fi and Fantasy', 'ipis', 12, 'available', '805584.jpg'),
(84, '8453328672435', 'Hoyle the incandecent ones', 'Fed & Geoffrey', 'Sci-Fi and Fantasy', '???space???', 12, 'available', '862870.jpg'),
(85, '9981356157048', 'Enders Game', 'unknown', 'Sci-Fi and Fantasy', 'space', 12, 'available', '180629.jpg'),
(86, '5688878265837', 'From the Earth to the Moon', 'Jules Verne', 'Sci-Fi and Fantasy', 'earth moon', 12, 'available', '446324.jpg'),
(87, '2031783226477', 'Science Fiction', 'Agis Budris', 'Sci-Fi and Fantasy', 'Science fiction stories', 12, 'available', '355259.jpg'),
(88, '8079122604163', 'Daughter of Smoke & Bone', 'Laini Taylor', 'Supernatural', 'Daughter of Smoke and Bone is a fantasy novel written by Laini Taylor. It was published in September 2011 by Hachette Book Group, an imprint of Little, Brown and Company. The story follows Karou, a seventeen-year-old Prague art student.', 12, 'available', '967227.jpg'),
(89, '5059969539799', 'unknonwn', 'unknown', 'Supernatural', 'trololol', 1, 'unavailable', '710739.jpg'),
(90, '1831786069467', 'Supernatural', 'Peter Johnson', 'Supernatural', 'Origins', 12, 'available', '107217.jpg'),
(91, '0523633064445', 'The Vampire', 'John William Polidori', 'Supernatural', 'Vampirism', 12, 'available', '66638.jpg'),
(92, '3001822635600', 'Black Moon Draw', 'Lizzy Ford', 'Supernatural', 'Black moon', 12, 'available', '227244.jpg'),
(93, '0351194524537', 'Human Sacrifice', 'Lawrence E. Y. Mbogoni', 'Supernatural', 'Human sacrifice and the supernatural in african history', 12, 'available', '29444.jpg'),
(94, '8993504438176', 'The Darkest Night', 'Gena ShoWalter', 'Supernatural', '...', 12, 'available', '722995.jpg'),
(95, '4996560389326', 'What she doesn''t know', 'G. Harrison', 'Romance', 'Secret', 12, 'available', '318827.jpg'),
(96, '3590049738562', 'Worth the Wait', 'Karen Witemeyer', 'Romance', 'wait for a while', 12, 'available', '414069.jpg'),
(97, '7362480397312', 'The Countess takes a Lover', 'Bonnie Dee', 'Romance', 'lover', 12, 'available', '372302.jpg'),
(98, '6805280650020', 'No man''s misstress', 'Mary Balogh', 'Romance', 'He promise her everything except the one thing she wanted most', 12, 'available', '523365.jpg'),
(99, '0510323142478', 'Lovestorm', 'Judith French', 'Romance', 'blah blah blah', 12, 'available', '28133.jpg'),
(100, '4434353581759', 'The Mark of the King', 'Jocelyn Green', 'Romance', 'Mark my ass', 15, 'available', '789213.jpg'),
(101, '0105001017732', 'The Nature of Technology', 'W. Brian Arthur', 'Technology', 'The Nature of Technology', 12, 'available', '775158.jpg'),
(102, '8139049233385', 'High Technology Companies', 'Michael E. McGrath', 'Technology', 'Product Strategy for High Technology Companies \r\nAccelerating your business to web speed.', 12, 'available', '758756.jpg'),
(103, '0743482998015', 'PC, Phones and the Internet', 'Robert Kraut, Malcolm Brynin, Sara Kiesler', 'Technology', 'The Social Impact of Information Technology', 12, 'available', '294590.jpg'),
(104, '6518644457263', 'The Second Machine Age', 'Erik Brynjolfson, Andrew McAfee', 'Technology', 'Work, progress, and prosperity in a time of brilliant technologies', 12, 'available', '238098.jpg'),
(105, '8414342235401', 'The Digital Person', 'Daniel J. Solove', 'Technology', 'A fascinating journey into the almost surreal ways personal information is hoarded, used, and abused in the digital age.', 12, 'available', '691685.jpg'),
(106, '8363685229525', 'Illusions of Freedom', 'Jeffrey M. Shaw', 'Technology', 'Illusions of Freedom', 12, 'available', '356296.jpg'),
(107, '2288054420851', 'Science, Technology, and Society', 'Robert E. McGinn', 'Technology', 'Science, Technology, and Society', 12, 'available', '981525.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `booktitle`
--

CREATE TABLE IF NOT EXISTS `booktitle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookId` int(11) NOT NULL,
  `bookTitle` varchar(20) NOT NULL,
  `author` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` varchar(500) NOT NULL,
  `bookPic` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `booktitle`
--

INSERT INTO `booktitle` (`id`, `bookId`, `bookTitle`, `author`, `category`, `description`, `bookPic`) VALUES
(1, 12345, 'Test', 'Test', 'Sci-Fi and Fantasy', 'this is a test', '989330.jpg'),
(2, 123456, 'Test2', 'Test2', 'Sci-Fi and Fantasy', 'Test2', '33682.jpg'),
(3, 123789, 'test3', 'test3', 'Social Sciences', 'this si the test3', '869729.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cancelledreserve`
--

CREATE TABLE IF NOT EXISTS `cancelledreserve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfidNu` varchar(40) NOT NULL,
  `cancelBy` varchar(20) NOT NULL,
  `bookId` varchar(40) NOT NULL,
  `bookTitle` varchar(40) NOT NULL,
  `dateReserve` datetime NOT NULL,
  `dateCancelled` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cancelledreserve`
--

INSERT INTO `cancelledreserve` (`id`, `rfidNu`, `cancelBy`, `bookId`, `bookTitle`, `dateReserve`, `dateCancelled`) VALUES
(1, 'jaymar jaymar', 'jaymar jaymar', '654654', 'bf', '2017-02-04 11:35:18', '2017-02-04 12:03:12'),
(2, '0005106405', 'jaymar jaymar', '654654', 'bf', '2017-02-04 12:04:30', '2017-02-04 12:04:35'),
(3, '0005106405', 'jaymar jaymar', '23423423', 'gasgg', '2017-02-04 20:23:27', '2017-02-04 20:36:19'),
(4, '0005106405', 'jaymar jaymar', '542323525', 'sexy', '2017-02-04 20:23:32', '2017-02-04 21:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `issuedbook`
--

CREATE TABLE IF NOT EXISTS `issuedbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfid` varchar(40) NOT NULL,
  `borrowedBy` varchar(20) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `bookTitle` varchar(20) NOT NULL,
  `dateReserve` datetime NOT NULL,
  `dateIssued` datetime NOT NULL,
  `returnDuedate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `issuedbook`
--

INSERT INTO `issuedbook` (`id`, `rfid`, `borrowedBy`, `isbn`, `bookTitle`, `dateReserve`, `dateIssued`, `returnDuedate`) VALUES
(9, '0005106405', 'jaymar jaymar', '8789798798', 'kdslajfkljdsafkj', '2017-02-01 20:13:06', '2017-02-01 20:21:06', '2017-02-08 20:21:06');

-- --------------------------------------------------------

--
-- Table structure for table `librarian`
--

CREATE TABLE IF NOT EXISTS `librarian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libId` varchar(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `address` varchar(40) NOT NULL,
  `contactNo` int(11) NOT NULL,
  `emailAddress` varchar(40) NOT NULL,
  `userStatus` varchar(20) NOT NULL,
  `retrieve` varchar(80) NOT NULL,
  `userPic` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `librarian`
--

INSERT INTO `librarian` (`id`, `libId`, `username`, `password`, `fullname`, `address`, `contactNo`, `emailAddress`, `userStatus`, `retrieve`, `userPic`) VALUES
(2, '1234567890', 'jaymar', 'jaymar', 'ako tuh jmar', 'k1 balara', 123456, 'jaymar@mar', 'active', 'akosijaymar', '208921.jpg'),
(3, '2147483647', 'recellel', 'recellel', 'lkadsjfklj', 'kljalksjfj', 42134, 'lkjflkjasd@halsdf', 'active', 'kasjdfkljsadlf', '1396.jpg'),
(4, '24234234', 'paulrits', 'paulrits', 'salkdjfklj', 'lkfjasklj', 234324, 'laskdfjklsadjf@ksajf', 'deactive', 'laskdfjklsadjf@ksajf', ''),
(7, '12345', 'librarian', 'librarian', 'librarian ako', 'sakldjfsdlkjvaksjv', 24234234, 'fdsafdas@adsf', 'active', 'librarian', '752628.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` varchar(11) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `address` varchar(40) NOT NULL,
  `contactNo` int(11) NOT NULL,
  `emailAddress` varchar(40) NOT NULL,
  `userStatus` varchar(20) NOT NULL,
  `retrieve` varchar(80) NOT NULL,
  `userPic` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `memberId`, `password`, `fullname`, `address`, `contactNo`, `emailAddress`, `userStatus`, `retrieve`, `userPic`) VALUES
(1, '0005106405', 'jaymar', 'jaymar jaymar', 'jaymar jaymar', 243234234, 'jaymar@akopa', 'active', 'alksjdflksadjf', '343705.jpg'),
(2, '0005106406', 'recelle', 'asdfasdfsda', 'fsadfsadf', 2147483647, 'recelle@yugo', 'deactive', 'asdfsadfasdf', ''),
(3, '0005106407', 'member', 'im a member', 'lasdlfjlkj', 656262, 'member@sm', 'active', 'member', ''),
(4, '0005134640', '0005134640', 'paul', '', 2147483647, 'paul@sya', 'active', '0005134640', '387119.jpg'),
(5, '0005188108', '', 'rita', '', 2147483647, '', 'deactive', '', '\r\n'),
(6, '234234', 'password', 'fusadkljf', '', 0, 'lfsa@sdalkfj', 'deactive', '', ''),
(7, 'emberId', 'ssword', 'oMem', '', 0, 'ailAddress@asd', 'deactive', 'trieve', '');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reportFrom` varchar(40) NOT NULL,
  `details` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL,
  `daytime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reportFrom`, `details`, `status`, `daytime`) VALUES
(2, '265', 'asdsad', 'old', '2017-01-29 22:55:44'),
(3, 'sdafsdaf', 'sdfsdfdsafgagag\r\nsaf\r\ndsaf', 'old', '2017-01-28 20:18:35'),
(8, 'admin', 'fdsfasdgadsfsavsfa', 'new', '2017-01-29 13:39:27'),
(9, 'admin', 'sadfav brata\r\navs\r\n\r\ntavs\r\nt\r\na\r\nt', 'new', '2017-01-29 13:39:32'),
(10, 'jaymar jaymar', 'dsfj\r\nsdafkjsa\r\nsdfkdsjaf\r\ntang ina mo admin and librarian', 'new', '2017-01-29 22:55:40'),
(11, 'jaymar jaymar', 'tang ina mo admin d mo ko pinapansin! lagi k nlng ganyan sa akin! paku malaki!', 'new', '2017-01-29 22:56:17'),
(12, 'jaymar jaymar', 'admin ayusin mo tung libro na binigay ni librarian gago ka\r\n', 'new', '2017-01-30 20:27:10'),
(13, 'jaymar jaymar', 'TANG INA MO \r\n', 'new', '2017-02-02 21:51:47'),
(14, 'jaymar jaymar', 'TANG INA NMN ADMIN\r\n', 'new', '2017-02-02 22:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfidNo` varchar(40) NOT NULL,
  `reserveBy` varchar(50) NOT NULL,
  `bookId` varchar(50) NOT NULL,
  `bookTitle` varchar(50) NOT NULL,
  `dateReserve` datetime NOT NULL,
  `reserveExp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `returnbook`
--

CREATE TABLE IF NOT EXISTS `returnbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rfidNumber` varchar(40) NOT NULL,
  `returnBy` varchar(20) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `bookTitle` varchar(20) NOT NULL,
  `dateReserve` datetime NOT NULL,
  `dateIssued` datetime NOT NULL,
  `dateReturn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `returnbook`
--

INSERT INTO `returnbook` (`id`, `rfidNumber`, `returnBy`, `isbn`, `bookTitle`, `dateReserve`, `dateIssued`, `dateReturn`) VALUES
(1, '0005106408', 'jaymar', '23423432', 'DSAFDSAFS', '2017-01-14 13:06:30', '2017-01-14 14:39:32', '2017-01-24 21:21:28'),
(2, '0005106408', 'jaymar', '23423432', 'DSAFDSAFS', '2017-01-14 13:06:30', '2017-01-14 14:39:32', '2017-01-24 21:22:07'),
(3, '56151135', 'jaymar', 'sdlkjfkdsj', 'jfkldsjf', '0000-00-00 00:00:00', '2017-01-09 19:26:26', '2017-01-24 21:22:53'),
(4, '545641561', 'jaymar', '4234324234', 'fasdfsdafdsaf', '2017-01-14 13:06:57', '2017-01-14 14:29:32', '2017-01-24 21:43:10'),
(5, '0015106405', 'librarian', '654654', 'bf', '2017-01-26 08:37:51', '2017-01-26 08:39:28', '2017-01-26 08:51:10'),
(6, '0005106405', 'jaymar jaymar', '654654', 'bf', '2017-01-29 10:39:13', '2017-01-29 10:47:22', '2017-01-29 12:45:54'),
(7, '09089787', 'jaymar', '51651611', 'borland', '2017-01-26 14:27:48', '2017-01-26 14:28:57', '2017-02-04 20:56:37'),
(8, '0005106405', 'jaymar jaymar', '51651611', 'borland', '2017-01-28 20:21:13', '2017-01-28 22:36:12', '2017-02-04 20:57:11'),
(9, '234324324', '234324324', '234324324', 'bf', '2017-01-28 20:41:18', '2017-01-28 22:35:02', '2017-02-04 20:58:25'),
(10, '0005106405', 'jaymar jaymar', '51651611', 'borland', '2017-01-29 08:13:08', '2017-01-29 10:14:26', '2017-02-04 20:59:10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
