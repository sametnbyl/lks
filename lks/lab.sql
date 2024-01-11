-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Oca 2024, 14:00:32
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `lab`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `logs`
--

CREATE TABLE `logs` (
  `l_id` int(11) NOT NULL,
  `l_lab` enum('114','116') DEFAULT '114',
  `l_type` int(255) NOT NULL,
  `l_desc` longtext NOT NULL,
  `l_data` varchar(255) NOT NULL,
  `l_nfc` enum('0','1') NOT NULL DEFAULT '0',
  `l_date` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(999) NOT NULL,
  `u_surname` varchar(999) NOT NULL,
  `u_no` int(255) NOT NULL,
  `u_uid` varchar(50) NOT NULL,
  `u_nick` text NOT NULL,
  `u_pass` text NOT NULL,
  `u_rank` text NOT NULL DEFAULT 'uye',
  `u_status` text NOT NULL DEFAULT 'out',
  `u_status116` text NOT NULL DEFAULT 'out',
  `u_pp` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_surname`, `u_no`, `u_uid`, `u_nick`, `u_pass`, `u_rank`, `u_status`, `u_status116`, `u_pp`) VALUES
(1, 'Samet', 'Tunaboylu', 201213052, '14615315568', 'sametnbyl', 'c4ca4238a0b923820dcc509a6f75849b', 'admin', 'in', 'out', 9);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`l_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `logs`
--
ALTER TABLE `logs`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
