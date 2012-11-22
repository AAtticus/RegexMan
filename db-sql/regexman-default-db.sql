-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2012 at 01:33 AM
-- Server version: 5.1.65
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `atticus_regexman`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` date NOT NULL,
  `game_mode` varchar(255) NOT NULL,
  `points_collected` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `current_question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `completed_question_ids` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_questions`
--

CREATE TABLE IF NOT EXISTS `games_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=448 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `difficulty` int(11) NOT NULL,
  `pattern` varchar(512) NOT NULL,
  `input` text NOT NULL,
  `answer` text NOT NULL,
  `description` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `difficulty`, `pattern`, `input`, `answer`, `description`) VALUES
(1, 0, 'stop', 'Don''t stop me now.|I''m having such a good time.|I''m having a ball don''t stop me now.', '', 'The most basic regex is just a collection of characters. Evaluation function will match a string if it contains all the written characters in the given order. For this task, match all the strings that contain the word "stop".'),
(2, 1, '.', '2012|Never gonna give you up.|Sharing is caring.|9:48 AM|crybaby@aol.com', '', 'Regexes have a special wildcard .(dot). It matches any single character. Try it on these completely different strings. (Note: if you want to match an actual dot, use escape character .)'),
(3, 1, '\\d', 'Batman was wrong.|2012 is the end of you.|I got 99 problems but a match ain''t one!|Ten o''clock in the morning.|10 am, go to sleep.', '', 'Sometimes you need to select only digits. d will match any digit. Try selecting only the lines with at least one digit.'),
(4, 1, 'Q:\\s', 'Q:		When will icepas melt?|Q: Is 2012 the end?|Q: 		How come you''re not working?|Q:How old are you?|Q:Where did daddy go?', '', 's will select any whitespace in your regex, no matter the length of it. It could be a space _, new line \n, tab 	 or carriage return \r. In the lines below, see how "Q:s" regex selects only the lines which have any space after the "Q:" beginning.'),
(5, 1, '\\w', 'Tremendous fun I had today|@#$%^*!|H4x0rZ|(-,-)', '', 'w stands for alphanumeric character. It is either a letter or a number. Try it here, where you only skip lines that do not contain any letters or numbers.'),
(6, 2, '\\D', 'Batman was wrong.|2012|99085|99 problems but a match ain''t one!|Ten o''clock in the morning.|10 am, go to sleep.', '', 'For each special symbol you have seen, there is a negative upper-case counterpart. So, if d selects a digit, D will match anything that is not a digit. Try it on some new examples:'),
(7, 2, 'Q:\\S', 'Q:		When will icecaps melt?|Q: Is 2012 the end?|Q:     How come you''re not working?|Q:How old are you?|Q:Where did daddy go?', '', 'While s will select any whitespace, S will select anything that is not a whitespace. Check how "Q:S" now gives completely opposite results from before.'),
(8, 2, '\\W', 'Tremendous fun I had today!|@#$%^*!|H4x0rZ|(-,-)', '', 'In the same way W will select any non-alphanumeric character. However from example before, first line will still be selected as exclamation mark and spaces are not alphanumeric. Third line will be skipped.'),
(9, 3, 'Red\\d', 'This is Red1 come in Red12.|Red leader to blue leader!|Reddish11 is on the line.|This is Red1, get out of the way Reddish11.', '', 'Don''t forget that you can combine regular characters and special symbols like d, .(dot), s or w. Select the rows which have a word ''Red'' directly followed by number, as in ''Red1'' or ''Red15''.'),
(10, 3, '\\d\\d\\so\\''clock', 'Waking up at 07 o''clock.|Travelling to school at 08 o''clock.|Hoping I won''t die for next 30 minutes.|Returning at 15 o''clock.|Passing out in 20.|Waking up at 19 o''clock again.', '', 'This time, combine characters and special symbols to get only lines describing time, which go in a manner of "digit digit space o''clock.'),
(11, 4, '[dms]ad', 'dad|mad|sad|bad|lad|rad', '', 'To define a "one out of several" rule, use square brackets []. For example, [abc] will match a, b and c, but will skip anything else. Try matching just these three lines, where each line has the same -ad ending.'),
(12, 4, '[^dms]ad', 'dad|mad|sad|bad|rad|lad', '', 'Square brackets can also be used for negativity using a caret ^. For example, [^abc] will match anything that is not a, b or c. Just add negativity to your previous solution and see what happens.'),
(13, 4, 'Name: [A-M]', 'Name: Ana|Name: Bob|Name: Dennis|Name: Frank|Name: John|Name: Mark|Name: Roman|Name: Sandy|Name: Simon|Name: Timothy|Name: Willow', '', '[abc] looks good only because it has little options. But what if you have the whole alphabet? You could have [abcdefghijklmnopqrstuvwxyz], but easier solution is just using [a-z], so from a to z. For testing, process only lines where name starts with a letter from the first half of the alphabet, up to and including M. (Note that regex is case-sensitive, so use upper case.)'),
(14, 4, 'TX[^a-z]', 'TX!H3|TXbb34|TX34bb|TXAVG', '', 'Selecting range in square brackets also works well with negation, eg. [^0-9]. Try selecting the lines where TX is followed by anything that is not a lower-case letter.'),
(15, 5, 'waz{2,4}up', 'wazup|wazzup|wazzzup|wazzzzup|wazzzzzup|wazzzzzzzzup', '', 'Curly brackets can describe the amount of repetitions you want to do for the character. For example, instead of "aaaaa" you can write "a{5}". You can also set it for ranges like a{1,3}, which will match a, aa, aaa but not aaaa. Match the strings where z is repeated no less than two times, but no more than four.'),
(16, 6, 'wad?z*u+p', 'wadup|waddup|wadzup|wadzzuup|wadzzzzzp|wazup|wazzp|wazzzuuup|wazzzzup', '', 'Fore more ranging options, you can use special symbols ?, + and *. a? is the same as a{0,1}, so either one or zero. + will seek for one or more repetitions, while * will seek for 0 or more repetitions. Combine all of them and seek for a result that has zero or one d, zero ore more z''s and one or more u''s.'),
(17, 7, '(cats|dogs|penguins|polar bears)', 'I love cats.|I love dogs.|I love penguins|I love polar bears|I love logs.|I love php.|I love russian vodka', '', 'You have seen a selection of one out of several - [abc], but sometimes you need to apply one of several rules. Such rules should be enclosed in parentheses and divided by vertical bar, like (yellow|red|blue). Now match the following lines with only animal names.'),
(18, 7, 'wa(ds?|z{2,4})up', 'wadup|wadsup|wazzup|waup|waddup|wadzup|wazup|wadzup|wasup|wazzzzup|wazzzzzzup', '', 'Now, try to apply more complex rules into your choices. This time in the middle of wa_up there should be either exactly one d with optional s, or two to four z''s.'),
(19, 8, '^Mission: successful$', 'Mission: successful|Mission: successfully completed|Last Mission: successful', '', 'Regex can also check the beginning of a string with ^ and the end of the string with $ symbols. So regex "^cats$" will only match string "cats" but not the string "I love cats". Test it to match one single line Mission: Successful'),
(20, 8, '^\\[p\\].*\\[/p\\]$', '[p][/p]|[p]Hello world![/p]|[p]Not closed|Not opened[/p]|[p]Not the end[/p]of the string.|No tag at all!|I started before![p]dammit[/p]', '', 'For additional exercise, match the strings with opening and closing [p] [/p] tags. (Note: the .(dot) wildcard might come in handy here! Also, make sure you escape square brackets with [ and ]).'),
(21, 9, '^[a-zA-Z0-9-]{3,16}$', 'iLoveCats|@gmail.com|Ult1m4t3-h4X0Rz|Shades of Fury|TRANQUILITYMANIAC|Hit-me-baby-one-more-time', '', 'Well, you now know most of the regexes! Question is, how will you apply them. For a final test, validate these usernames: 3 to 16 symbols, digits, letter and hyphens only!.'),
(22, 15, '(c|C)ats?(\\s|\\.)', 'I love cats.|Caterpillars suck.|My cat is awesome.|Dogs are awful.|Cat is the best animal.|It is a weird category.|Nevertheless, I like dogs.|Where did my cat go?|Cats... dogs... whatever man.', '', 'I love cats. Everyone loves cats. Get me lines with cats!'),
(23, 20, '^[+\\-]?\\d+(,\\d+)*(\\.\\d+)?(e[+\\-]?\\d+)?$', '3.14529|-255.34|128|1.9e10|123,34.00|123.e64|+30e+10|5e-64|5ed64|720p|34x686|85/964e10|-e10|65e', '', 'Go ahead, fetch me the numbers. Ints, floats, with exponents, all of them!'),
(24, 15, '^([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$', '333|3545|fg5689|ff5689|ffccEE|f0C0e0', '', 'We need to validate hex values. They can either be quick, as 34f, or long, as 3242F2. Only that!'),
(25, 11, '^[\\w-]+$', 'ELEGON-36|--Hell-breaks-loose-in-Africa|Traffic-endangered|NO no no||no!weird@symbols', '', 'Our pages are indexed with slugs, I want you to catch them. It is a combination of letters, numbers and dashes. Get to work.'),
(26, 35, '^([a-z0-9_\\.-]+)@([\\da-z\\.-]+)\\.([a-z\\.]{2,6})$', 'fake@aol.com|super.fake@aol.america.nl|@what?|@hell.be|rk1649@yahoo.com|rk1649@yahoo', '', 'e-mail matching. O, the ultimate test! I hope you know what it is.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `uid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
