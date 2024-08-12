-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 07:46 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `C_UserID` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`C_UserID`, `category`) VALUES
(1, 'عام'),
(2, 'خاص');

-- --------------------------------------------------------

--
-- Table structure for table `courselevels`
--

CREATE TABLE `courselevels` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `ImgLevel` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courselevels`
--

INSERT INTO `courselevels` (`UserID`, `CetegoryID`, `CourseID`, `TeacherID`, `Name`, `ImgLevel`, `Date`) VALUES
(10, 1, 37, 1, 'Information System', '4045_1702398866_ai-generated-8211245_1280.jpg', '2023-12-12'),
(13, 1, 37, 1, 'Computer Science', '4740_1702399422_artificial-intelligence-4389372_1280.jpg', '2023-12-12'),
(14, 1, 37, 1, 'Statistics', '7401_1702538207_statistics-3411473_1280.jpg', '2023-12-14'),
(15, 1, 37, 1, 'English', '3560_1702560093_english-2724442_1280.jpg', '2023-12-14'),
(16, 1, 39, 1, 'IT', '4614_1709848491_MY LOGO.png', '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Price` smallint(6) NOT NULL,
  `TypeCourse` int(11) NOT NULL,
  `Avatar` varchar(255) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `Describtion` varchar(255) NOT NULL,
  `Start` date NOT NULL,
  `End` date NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`UserID`, `Name`, `Status`, `TeacherID`, `Price`, `TypeCourse`, `Avatar`, `Title`, `Describtion`, `Start`, `End`, `Date`) VALUES
(37, 'حاسبات ترم أول', 1, 1, 0, 1, '771_1702397453_course-02.jpg', 'حاسبات ترم أول', 'شرح كلية حاسبات ترم أول', '2023-12-10', '2024-12-12', '2023-12-12'),
(39, 'مستقبلك', 1, 1, 0, 1, '4603_1709848416_MY LOGO.png', 'مستقلك', 'دورة مستقبلك', '2024-03-08', '2024-04-08', '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Free` tinyint(1) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jsontests`
--

CREATE TABLE `jsontests` (
  `UserID` int(11) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `SuperType` enum('Tahsily','Qudrat') NOT NULL,
  `TypeFile` enum('ep','em','ec','eb','cp','cm','cc','cb','ek','el','ck','cl') NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Note` varchar(255) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jsontests`
--

INSERT INTO `jsontests` (`UserID`, `FileName`, `SuperType`, `TypeFile`, `Name`, `Note`, `TeacherID`, `Date`) VALUES
(9, '389733_1_35_الإختبار الأول', 'Tahsily', 'ep', '', '', 1, '2023-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `TypeLesson` enum('video','link') NOT NULL,
  `Title` varchar(30) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Url` varchar(255) NOT NULL,
  `Free` tinyint(1) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`UserID`, `CetegoryID`, `CourseID`, `LevelID`, `SubjectID`, `TeacherID`, `TypeLesson`, `Title`, `FileName`, `Url`, `Free`, `Date`) VALUES
(19, 1, 37, 10, 13, 1, 'link', 'الدرس الأول', '', 'https://www.youtube.com/embed/psRrwdtES9M?si=FA4_3t6Rf3VXZpcn', 0, '2024-03-08'),
(20, 1, 37, 10, 13, 1, 'video', 'الدرس الثاني', '9532_1709847813_Mashle_.mp4', '', 0, '2024-03-08'),
(21, 1, 39, 16, 18, 1, 'video', 'الدرس الأول', '2321_1709848550_Mashle_.mp4', '', 0, '2024-03-08'),
(22, 1, 39, 16, 18, 1, 'link', 'الدرس الثاني', '', 'https://www.youtube.com/embed/psRrwdtES9M?si=-Yt8L_OCKauDz_pd\"title=\"YouTubevideoplayer', 0, '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `opinionsincourses`
--

CREATE TABLE `opinionsincourses` (
  `Opinon` varchar(255) NOT NULL,
  `Rating` tinyint(4) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opinionsinteachers`
--

CREATE TABLE `opinionsinteachers` (
  `Opinon` varchar(255) NOT NULL,
  `Rating` tinyint(4) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `O_UserID` int(11) NOT NULL,
  `O_TeacherID` int(11) NOT NULL,
  `O_StudentID` int(11) NOT NULL,
  `O_CourseID` int(11) NOT NULL,
  `O_RegStatus` tinyint(1) NOT NULL,
  `SerialNumber` int(11) NOT NULL,
  `Price` varchar(20) NOT NULL,
  `infringement` enum('net','notinfringement') NOT NULL,
  `O_DateOfStatr` date NOT NULL,
  `O_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`O_UserID`, `O_TeacherID`, `O_StudentID`, `O_CourseID`, `O_RegStatus`, `SerialNumber`, `Price`, `infringement`, `O_DateOfStatr`, `O_Date`) VALUES
(12, 1, 4, 35, 0, 0, '', 'net', '0000-00-00', '2023-09-26'),
(23, 1, 4, 37, 0, 0, '', 'net', '0000-00-00', '2023-12-12'),
(24, 1, 6, 37, 0, 0, '', 'net', '0000-00-00', '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `UserID` int(11) NOT NULL,
  `typeItem` enum('question','pargraph') NOT NULL,
  `theSection` enum('لفظي','كمي') NOT NULL,
  `secQuestion` varchar(30) NOT NULL,
  `math` enum('math','no-math') NOT NULL,
  `suffling` enum('shuffle','no-shuffle') NOT NULL,
  `multans` enum('multans','no-multans') NOT NULL,
  `title` text NOT NULL,
  `answeres` text NOT NULL,
  `rightAnsweres` varchar(100) NOT NULL,
  `explainQ` text NOT NULL,
  `theCode` varchar(20) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`UserID`, `typeItem`, `theSection`, `secQuestion`, `math`, `suffling`, `multans`, `title`, `answeres`, `rightAnsweres`, `explainQ`, `theCode`, `TeacherID`, `Date`) VALUES
(27, 'pargraph', 'لفظي', 'إستيعاب المقروء', 'math', 'shuffle', 'multans', 'ddd', '', '', '', '123', 1, '2023-09-18'),
(28, 'question', 'لفظي', 'إستيعاب المقروء', 'math', 'shuffle', 'no-multans', 'ييي', '[\"d\",\"d\"]', '[0]', 'aaaaa', '123', 1, '2023-09-18'),
(29, 'pargraph', 'لفظي', 'إستيعاب المقروء', 'math', 'shuffle', 'multans', 'sadfasdf', '', '', '', '123', 1, '2023-09-18'),
(30, 'question', 'لفظي', 'إستيعاب المقروء', 'no-math', 'shuffle', 'no-multans', 'dsafa', '[\"dsfadsf\",\"asdfdsf\"]', '[1]', 'dsaffasdf', '123', 1, '2023-09-18'),
(31, 'question', 'لفظي', 'تناظر لفظي', 'no-math', 'shuffle', 'no-multans', 'dasfs', '[\"dfasdfasd\",\"fasdf\",\"asdfasdf\",\"dfsafdf\"]', '[3]', 'sdfasdff', 'dsaf', 1, '2023-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Title` int(11) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_question`
--

CREATE TABLE `section_question` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `ImgSubject` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`UserID`, `CetegoryID`, `CourseID`, `TeacherID`, `LevelID`, `Name`, `ImgSubject`, `Date`) VALUES
(13, 1, 37, 1, 10, 'first term', '8982_1702398923_ai-generated-8211245_1280.jpg', '2023-12-12'),
(15, 1, 37, 1, 13, 'first term', '4192_1702399429_artificial-intelligence-4389372_1280.jpg', '2023-12-12'),
(16, 1, 37, 1, 14, 'first term', '1694_1702538412_statistics-3411473_1280.jpg', '2023-12-14'),
(17, 1, 37, 1, 15, 'First Term', '6834_1702560099_english-2724442_1280.jpg', '2023-12-14'),
(18, 1, 39, 1, 16, 'المستوى الأول', '2077_1709848506_MY LOGO.png', '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `UserID` int(11) NOT NULL,
  `CetegoryID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `CountAttempts` enum('infinity','oneattempt') NOT NULL,
  `CountQues` smallint(6) NOT NULL,
  `Duration` enum('one','tow','infinity') NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Free` tinyint(1) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`UserID`, `CetegoryID`, `CourseID`, `LevelID`, `SubjectID`, `TeacherID`, `Title`, `CountAttempts`, `CountQues`, `Duration`, `FileName`, `Free`, `Date`) VALUES
(27, 1, 37, 10, 13, 1, 'chapter 1', 'infinity', 38, 'one', '671662_37_1_chapter 1', 0, '2023-12-12'),
(28, 1, 37, 13, 15, 1, 'chapter 1', 'infinity', 21, 'one', '877065_37_1_chapter 1', 0, '2023-12-12'),
(29, 1, 37, 10, 13, 1, 'chapter 2', 'infinity', 31, 'one', '968558_37_1_chapter 2', 0, '2023-12-13'),
(30, 1, 37, 10, 13, 1, 'chapter 3', 'infinity', 35, 'one', '626877_37_1_chapter 3', 0, '2023-12-13'),
(31, 1, 37, 10, 13, 1, 'chapter 4', 'infinity', 41, 'one', '820350_37_1_chapter 4', 0, '2023-12-14'),
(32, 1, 37, 14, 16, 1, 'Old Questions', 'infinity', 45, 'one', '55784_37_1_Old Questions', 0, '2023-12-14'),
(33, 1, 37, 15, 17, 1, 'chapter 1', 'infinity', 54, 'one', '238774_37_1_chapter 1', 0, '2023-12-14'),
(34, 1, 37, 15, 17, 1, 'chapter 2', 'infinity', 63, 'one', '880080_37_1_chapter 2', 0, '2023-12-14'),
(35, 1, 37, 13, 15, 1, 'chapter 2', 'infinity', 22, 'one', '168168_37_1_chapter 2', 0, '2023-12-14'),
(36, 1, 37, 13, 15, 1, 'chapter 3', 'infinity', 31, 'one', '337293_37_1_chapter 3', 0, '2023-12-14'),
(37, 1, 37, 10, 13, 1, 'test', 'infinity', 0, 'one', '474842_37_1_test', 0, '2023-12-16'),
(38, 1, 37, 10, 13, 1, 'chapter 1 part 2', 'infinity', 33, 'one', '118302_37_1_chapter 1 part 2', 0, '2023-12-29'),
(39, 1, 37, 10, 13, 1, 'chapter 2 part 2', 'infinity', 32, 'one', '643611_37_1_chapter 2 part 2', 0, '2023-12-29'),
(40, 1, 37, 10, 13, 1, 'chapter 3 part 2', 'infinity', 21, 'one', '223747_37_1_chapter 3 part 2', 0, '2023-12-29'),
(41, 1, 37, 10, 13, 1, 'chapter 4 part 2', 'infinity', 52, 'one', '395302_37_1_chapter 4 part 2', 0, '2023-12-29'),
(42, 1, 37, 10, 13, 1, 'chapter 5 part 2', 'infinity', 16, 'one', '573609_37_1_chapter 5 part 2', 0, '2023-12-29'),
(43, 1, 37, 15, 17, 1, 'chapter 3', 'infinity', 73, 'one', '317850_37_1_chapter 3', 0, '2024-01-04'),
(44, 1, 37, 15, 17, 1, 'chapter 4', 'infinity', 67, 'one', '120584_37_1_chapter 4', 0, '2024-01-09'),
(45, 1, 39, 16, 18, 1, 'الإختبار الأول', 'infinity', 0, 'one', '213477_39_1_الإختبار الأول', 0, '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `UserID` int(11) NOT NULL,
  `FName` varchar(30) NOT NULL,
  `SName` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PassWord` varchar(255) NOT NULL,
  `LastChahgePassDate` date NOT NULL,
  `PhoneNumber` varchar(10) NOT NULL,
  `Avatar` varchar(255) NOT NULL,
  `TypeUser` enum('Student','Teacher','Admin','SuperAdmin') NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Sex` enum('man','woman') NOT NULL,
  `PersonalInfo` tinyint(1) NOT NULL,
  `Twitter` varchar(255) NOT NULL,
  `Facebook` varchar(255) NOT NULL,
  `Linkedin` varchar(255) NOT NULL,
  `Youtube` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`UserID`, `FName`, `SName`, `Email`, `PassWord`, `LastChahgePassDate`, `PhoneNumber`, `Avatar`, `TypeUser`, `FileName`, `Sex`, `PersonalInfo`, `Twitter`, `Facebook`, `Linkedin`, `Youtube`, `Date`) VALUES
(1, 'محمد', 'محمد', 'zkym4564@gmail.com', '$2y$10$eFmGk7zlgPsleYCr40gjLu5V0UcFtC/hB0uGpsl6EvVyFe6EnDmK2', '2023-06-10', '0508317091', '9720_1696604882_avatar.png', 'Teacher', '', 'man', 0, '', '', '', 'https://www.youtube.com/@ElzeroWebSchool', '2023-03-15'),
(2, 'أحمد', 'إسماعيل', 'ahmed@gmail.com', '$2y$10$jWpN9KxdSm4UtxPOsz2xBu6h5maUHhUorc4OdQLBys6jQaHy1qN8.', '0000-00-00', '0508317091', '', 'Student', '', 'man', 0, '', '', '', '', '2023-03-21'),
(3, 'أحمد', 'إسماعيل', 'dsafsdf', 'asdfd', '0000-00-00', '356535', '', '', '', '', 0, '', '', '', '', '0000-00-00'),
(4, 'محمد', 'محمد', 'zkyim4564@gmail.com', '$2y$10$eFmGk7zlgPsleYCr40gjLu5V0UcFtC/hB0uGpsl6EvVyFe6EnDmK2', '0000-00-00', '0508317091', '7154_1695339464_avatar.png', 'Student', '', 'man', 0, '', '', '', '', '2023-09-19'),
(6, 'محمد', 'محمد زكي', 'zkymii4564@gmail.com', '$2y$10$KvAfv/mV8mxi029lji.wOuZct0zqMIkOTHwYQsfE6r.4liqHC3co6', '0000-00-00', '1030269257', '7865_1709848270_MY LOGO.png', 'Student', '', 'man', 1, '', '', '', '', '2024-03-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`C_UserID`);

--
-- Indexes for table `courselevels`
--
ALTER TABLE `courselevels`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `CetegoryID` (`CetegoryID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `courselevels_ibfk_3` (`TeacherID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `courses_ibfk_1` (`TypeCourse`),
  ADD KEY `courses_ibfk_2` (`TeacherID`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `files_ibfk_1` (`CetegoryID`),
  ADD KEY `files_ibfk_2` (`CourseID`),
  ADD KEY `files_ibfk_3` (`LevelID`),
  ADD KEY `files_ibfk_4` (`SubjectID`),
  ADD KEY `files_ibfk_5` (`TeacherID`);

--
-- Indexes for table `jsontests`
--
ALTER TABLE `jsontests`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `lessons_ibfk_1` (`CetegoryID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `lessons_ibfk_3` (`LevelID`),
  ADD KEY `SubjectID` (`SubjectID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`O_UserID`);

--
-- Indexes for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `schedule_ibfk_1` (`CetegoryID`),
  ADD KEY `schedule_ibfk_2` (`CourseID`),
  ADD KEY `schedule_ibfk_3` (`LevelID`),
  ADD KEY `schedule_ibfk_4` (`SubjectID`),
  ADD KEY `schedule_ibfk_5` (`TeacherID`);

--
-- Indexes for table `section_question`
--
ALTER TABLE `section_question`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `CetegoryID` (`CetegoryID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `LevelID` (`LevelID`),
  ADD KEY `SubjectID` (`SubjectID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `CetegoryID` (`CetegoryID`),
  ADD KEY `subjects_ibfk_2` (`CourseID`),
  ADD KEY `LevelID` (`LevelID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `CetegoryID` (`CetegoryID`),
  ADD KEY `tests_ibfk_2` (`CourseID`),
  ADD KEY `tests_ibfk_3` (`LevelID`),
  ADD KEY `tests_ibfk_4` (`SubjectID`),
  ADD KEY `tests_ibfk_5` (`TeacherID`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `C_UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courselevels`
--
ALTER TABLE `courselevels`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jsontests`
--
ALTER TABLE `jsontests`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `O_UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_question`
--
ALTER TABLE `section_question`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courselevels`
--
ALTER TABLE `courselevels`
  ADD CONSTRAINT `courselevels_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courselevels_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`TypeCourse`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `files_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `courselevels` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `files_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `courselevels` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `courselevels` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `section_question`
--
ALTER TABLE `section_question`
  ADD CONSTRAINT `section_question_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `section_question_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `section_question_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `courselevels` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `section_question_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `courselevels` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`CetegoryID`) REFERENCES `category` (`C_UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_ibfk_3` FOREIGN KEY (`LevelID`) REFERENCES `courselevels` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
