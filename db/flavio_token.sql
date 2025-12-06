CREATE DATABASE IF NOT EXISTS `flavio_token` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `flavio_token`;


CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `collections` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `creator_id` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`creator_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `nfts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `token_id` VARCHAR(255) DEFAULT NULL,
  `collection_id` INT DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `image_path` VARCHAR(1000) DEFAULT NULL,
  `metadata_uri` VARCHAR(1000) DEFAULT NULL,
  `creator_id` INT DEFAULT NULL,
  `uploader_id` INT DEFAULT NULL,
  `owner_id` INT DEFAULT NULL,
  `price` DECIMAL(30,8) DEFAULT NULL,
  `supply` INT NOT NULL DEFAULT 1,
  `status` ENUM('draft','unlisted','listed','sold') NOT NULL DEFAULT 'draft',
  `is_listed` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `file_size` INT DEFAULT NULL,
  `width` INT DEFAULT NULL,
  `height` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX (`token_id`),
  FOREIGN KEY (`collection_id`) REFERENCES `collections`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`creator_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`uploader_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`owner_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nft_id` INT NOT NULL,
  `buyer_id` INT DEFAULT NULL,
  `seller_id` INT DEFAULT NULL,
  `price` DECIMAL(30,8) NOT NULL,
  `tx_hash` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`nft_id`) REFERENCES `nfts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`buyer_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`seller_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `favorites` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `nft_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_nft_unique` (`user_id`,`nft_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`nft_id`) REFERENCES `nfts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


