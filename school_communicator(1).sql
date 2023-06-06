-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 06, 2023 at 01:35 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_communicator`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `maile`
--

CREATE TABLE `maile` (
  `mail_id` int(11) NOT NULL,
  `tytul` varchar(100) NOT NULL,
  `tresc` text NOT NULL,
  `nadawca` varchar(100) NOT NULL,
  `odbiorca` varchar(100) NOT NULL,
  `stan` varchar(100) NOT NULL,
  `data_nadania` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `maile`
--

INSERT INTO `maile` (`mail_id`, `tytul`, `tresc`, `nadawca`, `odbiorca`, `stan`, `data_nadania`) VALUES
(12, 'Cześć', 'Hejka co u Ciebie słychać !!', 'patryk123@o2.pl', 'joannakowalska2507@o2.pl', 'przeczytana', '2023-05-19 19:50:18'),
(15, 'dom', 'ddddd', 'joannakowalska2507@o2.pl', 'nowak@o2.pl', 'nadana', '2023-05-19 21:18:28'),
(17, 'hfhjgjgjh', 'Wpisz wiadomość', 'patryk123@o2.pl', 'joannakowalska2507@o2.pl', 'przeczytana', '2023-05-19 21:23:57'),
(35, 'eeee', 'eeeeee', 'patryk123@o2.pl', 'joannakowalska2507@o2.pl', 'przeczytana', '2023-05-24 17:20:29'),
(45, 'aa', 'Wpisz wiadomość', 'zadaniephp2023@gmail.com', 'joannakowalska2507@o2.pl', 'nadana', '2023-06-03 11:26:53'),
(46, 'wiedomość', 'Wpisz wiadomość', 'kowalska123@o2.pl', 'zadaniephp2023@gmail.com', 'nadana', '2023-06-05 21:32:06'),
(47, 'wiedomość', 'Wpisz wiadomość', 'kowalska123@o2.pl', 'Kamil@o2.pl', 'nadana', '2023-06-05 21:32:06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `haslo` varchar(100) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rodzajkonta` varchar(20) NOT NULL,
  `statuskonta` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownika`, `login`, `haslo`, `imie`, `nazwisko`, `email`, `rodzajkonta`, `statuskonta`) VALUES
(10, 'patryk123', '$2y$10$wtdicu9oInFMXcG8h7elzehigA80dyOiE7GBdBnZL7p2k3yagB8se', 'Patryk', 'Patryk', 'patryk123@o2.pl', 'admin', 'aktywne'),
(32, 'Nauczyciel1', '$2y$10$141pL8xCZK8npOvitShGfuXRkfU.Fa8fTOAAcl01DxIJUiJteUWQi', 'Zofia', 'Fiołkowska', 'zadaniephp2023@gmail.com', 'nauczyciel', 'aktywne'),
(58, 'Asia', '$2y$10$.zJ1AEFN3gtZTDZJJjdZTeQqQKyE2B0miUSR.Zqp/3g9keJswCSfq', 'Robert', 'Kowalski', 'jan.nowak@o2.pl', 'nauczyciel', 'aktywne'),
(59, 'Kamil123', '$2y$10$KXOiaxKI/xu9T69lmATljuGEBeIT1mBtOjpKFhDGeXXKvYKeQUgou', 'Kamil', 'Kowalski', 'Kamil@o2.pl', 'nauczyciel', 'aktywne'),
(62, 'Mirek123', '$2y$10$mZKfRlzuQOgy8B3JD8/Lz.JqVEylDtNprf/ruS.UwIgmiMlbTnpzO', 'Mirosław', 'Lewandowski', 'miroslaw123@o2.pl', 'rodzic', 'aktywne');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `maile`
--
ALTER TABLE `maile`
  ADD PRIMARY KEY (`mail_id`),
  ADD KEY `odbiorca` (`odbiorca`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`) USING BTREE,
  ADD UNIQUE KEY `login` (`login`,`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `maile`
--
ALTER TABLE `maile`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
