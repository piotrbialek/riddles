-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Gru 2017, 00:16
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `riddles`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `riddles`
--

CREATE TABLE `riddles` (
  `id` int(11) NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `riddle` text COLLATE utf8_polish_ci NOT NULL,
  `riddleLevel` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `accepted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `riddles`
--

INSERT INTO `riddles` (`id`, `category`, `description`, `riddle`, `riddleLevel`, `author_id`, `accepted`) VALUES
(122, 'Sport', 'Słynny jamajski lekkoatleta', 'Usain Bolt', 0, 18, 1),
(123, 'Filmy', 'Tonący statek', 'Titanic', 8, 1, 0),
(125, 'Przysłowia', 'chwyta się jej tonący', 'brzytwa', 2, 18, 1),
(126, 'Przysłowia', 'kto pod kim dołki kopie', 'ten sam w nie wpada', 13, 17, 1),
(128, 'muzyka', 'popularny instrument strunowy szarpany', 'gitara', 10, 1, 1),
(129, 'Język polski', 'Czytany od tyłu brzmi tak samo (kajak, zaraz)', 'palindrom', 18, 18, 1),
(145, 'Owoce i warzywa', 'Kwaśna w smaku', 'cytryna', 9, 17, 1),
(146, 'Świat', 'Czerwony we fladze Kanady', 'Liść klonu', 8, 17, 1),
(152, 'Kucnie świata', 'popularne danie kuchni włoskiej', 'pizza', 3, 1, 1),
(153, 'obyczaje', 'symbol szczęścia', 'podkowa', 3, 1, 1),
(154, 'obyczaje', 'każdy Polak zajada się nimi w tłusty czwartek', 'pączki', 4, 1, 1),
(155, 'przyroda', 'zrzuca igły na zimę', 'modrzew', 5, 1, 1),
(158, 'Kuchnia', 'Może być na miękko i na twardo', 'jajko', 3, 20, 1),
(159, 'Obyczaje', 'świętujemy je w polsce jedenastego listopada', 'święto niepodległości', 15, 1, 1),
(162, 'inne', 'biały puch spadający na zimę', 'śnieg', 1, 1, 1),
(163, 'inne', 'nadchodzi tuż po zimie', 'wiosna', 3, 1, 1),
(164, 'inne', 'kolor, który powstaje po połączeniu barwy zielonej i czerwonej', 'żółty', 3, 1, 1),
(165, 'inne', 'kolor, który powstaje po połączeniu barwy czerwonej i niebieskiej', 'fioletowy', 3, 1, 1),
(166, 'inne', 'bieg w samochodzie oznaczony literą R', 'wsteczny', 4, 1, 1),
(167, 'Sport', 'najczęstszy triumfator Pucharu Polski w piłce nożnej', 'legia warszawa', 7, 1, 1),
(168, 'chemia', 'popularna nazwa nadtlenku wodoru', 'woda utleniona', 17, 1, 1),
(169, 'chemia', 'powstają z połączenia zasad i kwasów', 'sole', 16, 1, 1),
(170, 'inne', 'można ją zobaczyć po deszczu', 'tęcza', 5, 1, 1),
(171, 'obyczaje', 'szkocka sukienka w kratę', 'kilt', 2, 1, 1),
(173, 'Geografia', 'morze z którym graniczy polska', 'morze bałtyckie', 6, 1, 1),
(174, 'Sport', 'polski skoczek narciarski', 'kamil stoch', 0, 22, 1),
(175, 'sport', 'najlepszy piłkarz na ue', 'mateusz motyka', 0, 1, 1),
(177, 'Geografia', 'popularnie kraj kwitnącej wiśni', 'japonia', 1, 22, 1),
(178, 'inne', 'symbol szczęścia', 'czterolistna koniczyna', 14, 22, 1),
(179, 'inne', 'symbol szczęścia', 'podkowa', 10, 22, 1),
(180, 'język polski', 'rozbudowana apostrofa otwierająca utwór literacki', 'inwokacja', 17, 22, 1),
(181, 'inne', 'bóg zmarłych z mitologii greckiej', 'hades', 15, 22, 1),
(182, 'piłka nożna', 'mawiał, że piłka jest okrągła, a bramki są dwie', 'kazimierz górski', 16, 22, 1),
(183, 'sport', 'może być obronny lub błyskawiczny', 'zamek', 19, 22, 1),
(184, 'inne', 'wytwarzany z pomidorów', 'keczup', 11, 22, 1),
(185, 'matematyka', 'figura, której dotyczy twierdzenie pitagorasa', 'trójkąt prostokątny', 12, 22, 1),
(186, 'matematyka', 'dwa plus dwa razy dwa', 'sześć', 13, 22, 1),
(187, 'PRãBA', 'SPRãBUJMY WIELKIMI LITERAMI', 'TEXT UPPERCASE', 2, 22, 0),
(189, 'ŻÓŁĆ', 'żãłW', 'TEXT UPPERCASE', 2, 22, 0),
(190, 'ŻÓŁĆ', 'SPRÓBUJMY WIELKIMI LITERAMI', 'AĄEĘIOUYŻŹĆŃŁ', 1, 22, 0),
(191, 'ŻÓŁĆ', 'SPRÓBUJMY WIELKIMI LITERAMI', 'AĄEĘIOUYŻŹĆŃŁ', 1, 22, 0),
(192, 'SDASDA', 'ADSASD', 'ASDADS', 3, 22, 0),
(193, 'DASDA', 'DASSDA', 'DASDA', 3, 27, 0),
(194, 'PRÓBA', 'ŹRÓDLANY ŻÓŁTY', 'ŻŹĆŃŁÓĘŚĄ', 1, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_unicode_ci NOT NULL,
  `pass` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `level` text COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `email`, `level`, `admin`) VALUES
(1, 'piterpiter', '$2y$10$uvuwKfhF9M4EpoyI/Gzq9OVXVOeY3XMRd6LcDEq0x7kY2RetBWFyO', 'pi@pi.qw', '20', 1),
(17, 'mati', '$2y$10$he0TeaixC6D9EN2pone6AeJ8o3oEkV6F5pPn/Eh7oIF150siEj/w2', 'mati@konto.pl', '1', 1),
(18, 'marcin', '$2y$10$WzC00mJ9VtkTK6n736hXTOfgkXg/blv70DIE/gM6NVNpdoIkX3zY6', 'no@no.pl', '3', 0),
(19, 'pipipi', '$2y$10$kVCAOyN94eZa1kaZFuH3ReVV6EP1eYvBTuA3twolrrwDEEOtJrrLG', 'pi@pi.pl', '0', 0),
(20, 'pipipi2', '$2y$10$ol.ZI.KWUsIcNA9gJzl4pOSbw5AHOlC1LF5ci3Q//IgZ3/nzG2SkC', 'pi@pi.pls', '2', 0),
(21, 'piotrbialek', '$2y$10$nAppOz1X0XDzva7PHHqLsuTSnnvHAaJbIFdKU7hWmc5AB812oPR5i', 'pi@p.pl', '1', 0),
(22, 'mateo', '$2y$10$Eg0bgZJtA4Na2aPSOlix9uXLmCnCAWHMZJ.V7Ing5leUbQu502y4m', 'karlaj@lajlaj.com', '18', 0),
(23, 'dasads', '$2y$10$1zGWRcfVOb7Rqw1J4oGOo.oV67nwnfqW85ur6v2eWmrtApJkkq6y6', 'asds@daasd.dasdas', '0', 0),
(24, 'dasdas', '$2y$10$AteypyYIxWz1/ehfDqm5wuD7yxUW24RNYT9Zib1DN9Yw.sdh2ImA.', 'adsdas@wp.pl', '0', 0),
(25, 'nowekonto2', '$2y$10$xEO3npI1XrFpRtJnAao6/OVsgfG0nrDYCJ03L/Xs1y9mPLx6FUfdu', 'pi@pp.pl', '0', 0),
(26, 'admin', '$2y$10$isVNf4NgipuTyjTdtQOW9OV6o1X.LQFqYPu8gYT2LmJZYIHsGkTG.', 'admin@a.pl', '16', 0),
(27, 'piter', '$2y$10$1t/F3cJ9grcqAXkt7N7cDOeDhqdbAfKxJum.bltVVzGMfgU8Hb91G', 'piter@p.pl', '0', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `riddles`
--
ALTER TABLE `riddles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `riddles`
--
ALTER TABLE `riddles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
