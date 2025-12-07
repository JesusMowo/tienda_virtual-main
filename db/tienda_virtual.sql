-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 01:39 PM
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
-- Database: `tienda_virtual`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `user_id`, `total_price`, `created_at`) VALUES
(1, 3, 500.00, '2025-12-07 04:59:42'),
(2, 3, 500.00, '2025-12-07 05:01:02'),
(3, 3, 120.50, '2025-12-07 06:49:46'),
(4, 3, 120.50, '2025-12-07 06:55:27'),
(5, 3, 500.00, '2025-12-07 07:28:28'),
(6, 4, 222.00, '2025-12-07 08:16:17'),
(7, 4, 15.99, '2025-12-07 08:50:50'),
(8, 1, 100.00, '2025-12-07 08:56:31'),
(9, 4, 300.00, '2025-12-07 08:57:41'),
(10, 4, 200.00, '2025-12-07 09:30:33'),
(11, 3, 45.00, '2025-12-07 10:54:37'),
(12, 1, 80.00, '2025-12-07 11:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `nfts`
--

CREATE TABLE `nfts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `owner_id` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `is_listed` tinyint(1) DEFAULT 1,
  `status` varchar(20) DEFAULT 'active',
  `supply` int(11) DEFAULT 1,
  `ban_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nfts`
--

INSERT INTO `nfts` (`id`, `name`, `description`, `price`, `image_path`, `user_id`, `created_at`, `owner_id`, `creator_id`, `is_listed`, `status`, `supply`, `ban_reason`) VALUES
(1, 'Genesis Decano #001', 'El primer token acuñado. Una pieza invaluable.', 111.00, 'https://picsum.photos/id/237/500/500', NULL, '2025-12-07 04:44:13', 4, 1, 0, 'active', 1, NULL),
(2, 'Cyber Arepa Gold', 'Gastronomía venezolana llevada al metaverso.', 120.50, 'https://picsum.photos/id/1080/500/500', NULL, '2025-12-07 04:44:13', 3, 3, 0, 'active', 1, NULL),
(3, 'Neon Samurai', 'Guerrero del futuro. Arte conceptual.', 45.00, 'https://picsum.photos/id/1060/500/500', NULL, '2025-12-07 04:44:13', 3, 3, 0, 'active', 1, NULL),
(4, 'Abstract Thoughts', 'Colores vibrantes y caos ordenado.', 300.00, 'https://picsum.photos/id/870/500/500', NULL, '2025-12-07 04:44:13', 1, 1, 1, 'active', 1, NULL),
(5, 'Code Monkey 404', 'Vive en el servidor y se alimenta de bugs.', 2939.00, 'https://picsum.photos/id/1074/500/500', NULL, '2025-12-07 04:44:13', 1, 2, 1, 'active', 1, NULL),
(6, 'Etherum Blue Sky', 'Paisaje relajante inspirado en Nueva Esparta.', 1000.00, 'https://picsum.photos/id/10/500/500', NULL, '2025-12-07 04:44:13', 1, 1, 1, 'active', 1, NULL),
(7, 'AMOR', 'EL gran FRANKILN D ROOSEVELT', 10000.00, 'assets/products/nft_69350de22407a.jpg', 3, '2025-12-07 05:17:22', 4, 3, 1, 'active', 1, NULL),
(8, 'asdasd [BANEADO]', 'cas', 200.00, 'assets/products/nft_69350ded609cd.jpg', 3, '2025-12-07 05:17:33', 4, 3, 0, 'banned', 1, NULL),
(9, 'aa', '', 0.00, 'assets/products/nft_69350f70d565c.jpg', 3, '2025-12-07 05:24:00', 3, 3, 1, 'active', 1, NULL),
(10, 'PEPE', '', 132.00, 'assets/products/nft_69356236ca8a6.jpg', 3, '2025-12-07 11:17:10', 3, 3, 1, 'active', 1, NULL),
(36, 'Luz de Neón #88', 'Arte abstracto futurista que simula una ciudad bajo la lluvia.', 150.00, 'https://picsum.photos/id/11/500/500', 1, '2025-12-07 12:38:22', 2, 1, 1, 'active', 1, NULL),
(37, 'El Ciber-Viajero', 'Personaje épico de la colección \"Caminantes del Vórtice\".', 320.50, 'https://picsum.photos/id/10/500/500', 2, '2025-12-07 12:38:22', 3, 2, 1, 'active', 1, NULL),
(38, 'Paisaje de Marte I', 'Fotografía generativa de un atardecer marciano, tonos rojos y ocres.', 89.99, 'https://picsum.photos/id/14/500/500', 3, '2025-12-07 12:38:22', 4, 3, 1, 'active', 10, NULL),
(39, 'Soundscape: Océano Profundo', 'Token de audio. Pista ambiental para meditación.', 45.00, 'https://picsum.photos/id/15/500/500', 4, '2025-12-07 12:38:22', 1, 4, 1, 'active', 5, NULL),
(40, 'Pixel-Cat #007', 'Mascota pixelada ultra rara con gafas de sol.', 999.00, 'https://picsum.photos/id/16/500/500', 1, '2025-12-07 12:38:22', 2, 1, 1, 'active', 1, NULL),
(41, 'Vector Flame', 'Diseño de logotipo animado para startups tecnológicas.', 550.00, 'https://picsum.photos/id/17/500/500', 2, '2025-12-07 12:38:22', 3, 2, 1, 'active', 1, NULL),
(42, 'Tierra en 3050', 'Ilustración del planeta Tierra después de la terraformación.', 1200.00, 'https://picsum.photos/id/18/500/500', 3, '2025-12-07 12:38:22', 4, 3, 1, 'active', 1, NULL),
(43, 'Código Binario Fractal', 'Visualización de un algoritmo de compresión de datos.', 175.25, 'https://picsum.photos/id/19/500/500', 4, '2025-12-07 12:38:22', 1, 4, 1, 'active', 1, NULL),
(44, 'La Hora del Té', 'Animación GIF de baja fidelidad sobre la rutina matutina.', 25.00, 'https://picsum.photos/id/20/500/500', 1, '2025-12-07 12:38:22', 2, 1, 1, 'active', 20, NULL),
(45, 'Guerrero Azul', 'Personaje mítico de la colección de Fantasía Digital.', 450.00, 'https://picsum.photos/id/21/500/500', 2, '2025-12-07 12:38:22', 3, 2, 1, 'active', 1, NULL),
(46, 'Ruta Estelar', 'Mapa celestial interactivo generado en 3D.', 680.75, 'https://picsum.photos/id/22/500/500', 3, '2025-12-07 12:38:22', 4, 3, 1, 'active', 1, NULL),
(47, 'Ciudad Flotante', 'Concepto de arquitectura post-apocalíptica.', 1800.00, 'https://picsum.photos/id/23/500/500', 4, '2025-12-07 12:38:22', 1, 4, 1, 'active', 1, NULL),
(48, 'El Despertar', 'Obra que representa la conciencia en la IA.', 90.00, 'https://picsum.photos/id/24/500/500', 1, '2025-12-07 12:38:22', 2, 1, 1, 'active', 10, NULL),
(49, 'Ritmo 130 BPM', 'Token de derechos de autor de un loop de batería.', 30.00, 'https://picsum.photos/id/25/500/500', 2, '2025-12-07 12:38:22', 3, 2, 1, 'active', 50, NULL),
(50, 'Robot Vintage Beta', 'Diseño de robot de los años 80, aspecto desgastado.', 130.00, 'https://picsum.photos/id/26/500/500', 3, '2025-12-07 12:38:22', 4, 3, 1, 'active', 1, NULL),
(51, 'Portal al Vacío', 'Imagen estática que genera profundidad y vértigo.', 210.00, 'https://picsum.photos/id/27/500/500', 4, '2025-12-07 12:38:22', 1, 4, 1, 'active', 1, NULL),
(52, 'Geometría Sagrada', 'Patrón de mandala complejo generado por algoritmo.', 110.00, 'https://picsum.photos/id/28/500/500', 1, '2025-12-07 12:38:22', 2, 1, 1, 'active', 3, NULL),
(53, 'Aurora Boreal', 'Un paisaje natural hiperrealista con movimientos lentos.', 750.00, 'https://picsum.photos/id/29/500/500', 2, '2025-12-07 12:38:22', 3, 2, 1, 'active', 1, NULL),
(54, 'Cripto-Skull', 'Calavera con motivos de circuito impreso y luces LED.', 425.50, 'https://picsum.photos/id/30/500/500', 3, '2025-12-07 12:38:22', 4, 3, 1, 'active', 1, NULL),
(55, 'Retrato de Hacker', 'Estilo low-poly, oscuro y enigmático.', 199.99, 'https://picsum.photos/id/31/500/500', 4, '2025-12-07 12:38:22', 1, 4, 1, 'active', 5, NULL),
(56, 'Lluvia de Monedas', 'Animación corta de monedas cayendo (ideal para juegos).', 75.00, 'https://picsum.photos/id/32/500/500', 1, '2025-12-07 12:38:22', 2, 1, 1, 'active', 10, NULL),
(57, 'Montañas Moradas', 'Diseño minimalista de un paisaje de fantasía.', 60.00, 'https://picsum.photos/id/33/500/500', 2, '2025-12-07 12:38:22', 3, 2, 1, 'active', 1, NULL),
(58, 'El Fénix Digital', 'Símbolo de resurgimiento y evolución tecnológica.', 1500.00, 'https://picsum.photos/id/34/500/500', 3, '2025-12-07 12:38:22', 4, 3, 1, 'active', 1, NULL),
(59, 'NFT Excluido', 'Pieza de prueba para simular contenido no listado.', 20.00, 'https://picsum.photos/id/35/500/500', 4, '2025-12-07 12:38:22', 1, 4, 0, 'active', 1, NULL),
(60, 'NFT BANEADO TEST', 'Contenido marcado como spam o prohibido por el moderador.', 10.00, 'https://picsum.photos/id/36/500/500', 1, '2025-12-07 12:38:22', 2, 1, 0, 'banned', 1, 'Contenido inapropiado y reportado.');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `counterparty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `user_id`, `amount`, `description`, `reference_id`, `created_at`, `counterparty_id`) VALUES
(1, 'deposit', 3, 11.00, 'Recarga de saldo vía Crypto', NULL, '2025-12-07 07:32:52', NULL),
(2, 'deposit', 3, 11.00, 'Recarga de saldo vía Crypto', NULL, '2025-12-07 07:33:52', NULL),
(3, 'deposit', 3, 11.00, 'Recarga de saldo vía Crypto', NULL, '2025-12-07 07:33:57', NULL),
(4, 'deposit', 4, 111.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 07:51:49', NULL),
(5, 'deposit', 4, 111.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 08:16:05', NULL),
(6, 'purchase', 4, -222.00, 'Compra de NFTs', NULL, '2025-12-07 08:16:17', NULL),
(7, 'sale', 3, 105.45, 'Venta de NFT: Genesis Decano #001', 1, '2025-12-07 08:16:17', NULL),
(8, 'fee', 1, 5.55, 'Comisión (5%) por venta de: Genesis Decano #001', 1, '2025-12-07 08:16:17', NULL),
(9, 'deposit', 3, 5.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 08:35:38', NULL),
(10, 'deposit', 4, 199.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 08:50:26', NULL),
(11, 'purchase', 4, -15.99, 'Compra de NFTs', NULL, '2025-12-07 08:50:50', NULL),
(12, 'sale', 2, 15.19, 'Venta de NFT: Code Monkey 404', 5, '2025-12-07 08:50:50', 4),
(13, 'fee', 1, 0.80, 'Comisión (5%) por venta de: Code Monkey 404', 5, '2025-12-07 08:50:50', 4),
(14, 'purchase', 4, -15.99, 'Compra de NFT: Code Monkey 404', 5, '2025-12-07 08:50:50', 2),
(15, 'deposit', 1, 200.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 08:56:21', NULL),
(16, 'purchase', 1, -100.00, 'Compra de NFTs', NULL, '2025-12-07 08:56:31', NULL),
(17, 'sale', 4, 95.00, 'Venta de NFT: Code Monkey 404', 5, '2025-12-07 08:56:31', 1),
(18, 'fee', 1, 5.00, 'Comisión (5%) por venta de: Code Monkey 404', 5, '2025-12-07 08:56:31', 1),
(19, 'purchase', 1, -100.00, 'Compra de NFT: Code Monkey 404', 5, '2025-12-07 08:56:31', 4),
(20, 'deposit', 4, 100.00, 'Recarga de saldo vía Crypto', NULL, '2025-12-07 08:57:29', NULL),
(21, 'purchase', 4, -300.00, 'Compra de NFTs', NULL, '2025-12-07 08:57:41', NULL),
(22, 'sale', 3, 285.00, 'Venta de NFT: AMOR', 7, '2025-12-07 08:57:41', 4),
(23, 'fee', 1, 15.00, 'Comisión (5%) por venta de: AMOR', 7, '2025-12-07 08:57:41', 4),
(24, 'purchase', 4, -300.00, 'Compra de NFT: AMOR', 7, '2025-12-07 08:57:41', 3),
(25, 'deposit', 1, 200000.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 09:29:30', NULL),
(26, 'deposit', 4, 311.00, 'Recarga de saldo vía Credit card', NULL, '2025-12-07 09:30:21', NULL),
(27, 'sale', 3, 190.00, 'Venta de NFT: asdasd', 8, '2025-12-07 09:30:33', 4),
(28, 'fee', 1, 10.00, 'Comisión (5%) por venta de: asdasd', 8, '2025-12-07 09:30:33', 4),
(29, 'purchase', 4, -200.00, 'Compra de NFT: asdasd', 8, '2025-12-07 09:30:33', 3),
(30, 'deposit', 4, 200.00, 'Reembolso por Garantía (NFT Ilegal Baneado)', 8, '2025-12-07 09:31:33', NULL),
(31, 'purchase', 1, -200.00, 'Pago de Garantía a Usuario #4', 8, '2025-12-07 09:31:33', NULL),
(32, 'sale', 2, 42.75, 'Venta de NFT: Neon Samurai', 3, '2025-12-07 10:54:37', 3),
(33, 'fee', 1, 2.25, 'Comisión (5%) por venta de: Neon Samurai', 3, '2025-12-07 10:54:37', 3),
(34, 'purchase', 3, -45.00, 'Compra de NFT: Neon Samurai', 3, '2025-12-07 10:54:37', 2),
(35, 'purchase', 1, -80.00, 'Compra de NFT: Etherum Blue Sky', 6, '2025-12-07 11:10:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `wallet_balance` decimal(10,2) DEFAULT 0.00,
  `status` varchar(20) DEFAULT 'active',
  `banned_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `wallet_balance`, `status`, `banned_until`) VALUES
(1, 'Flavio', 'decano@gmail.com', '$2y$10$IMjcenSMcdYJMF/4yXOVXOPi6VYpuCiM0MVWQDwSI7wa6XrWIbt8a', 'owner', '2025-12-07 07:53:00', 199858.60, 'active', NULL),
(2, 'Gino', 'as@as', '$2y$10$3KeoA8v.D9LTZHZHp5uuqeXjrRyFY.uIn/.nrHhtk9jV0Sy10/DDq', 'admin', '2025-12-07 02:52:39', 57.94, 'active', NULL),
(3, 'CHR-35', 'chr-35@gmail.com', '$2y$10$tqkeOEQjE1G1ud0NpnGSEOmCyf076ICGb8/xuR8NgujyhTs0olgmW', 'admin', '2025-12-07 04:39:32', 573.45, 'active', NULL),
(4, 'PEPE', 'pepe@gmail.com', '$2y$10$mB8KdlXOoMheA3B.bsQw4.bvO4nVtM.w15UOHQ0QMfBHQu4qOQjby', 'user', '2025-12-07 07:41:08', 389.01, 'active', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nfts`
--
ALTER TABLE `nfts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nfts`
--
ALTER TABLE `nfts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `nfts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `nfts`
--
ALTER TABLE `nfts`
  ADD CONSTRAINT `nfts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
