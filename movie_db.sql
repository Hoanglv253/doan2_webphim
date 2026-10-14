-- Database schema for the PHP movie website.
-- Import this file with phpMyAdmin or: mysql -u root -p < movie_db.sql

CREATE DATABASE IF NOT EXISTS `movie_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `movie_db`;

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(150) NOT NULL,
  `username` VARCHAR(80) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `password` VARCHAR(255) NOT NULL COMMENT 'PHP password_hash() output',
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_username` (`username`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `movies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `image_url` VARCHAR(255) NOT NULL DEFAULT 'no-image.jpg',
  `episode_badge` VARCHAR(100) NOT NULL DEFAULT 'Full HD',
  `is_hot` TINYINT(1) NOT NULL DEFAULT 0,
  `schedule_day` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=no schedule; 2=Mon ... 8=Sun',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_movies_is_hot_id` (`is_hot`, `id`),
  KEY `idx_movies_schedule_day_id` (`schedule_day`, `id`),
  KEY `idx_movies_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `genres` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_genres_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `movie_genres` (
  `movie_id` INT UNSIGNED NOT NULL,
  `genre_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`movie_id`, `genre_id`),
  KEY `idx_movie_genres_genre_id` (`genre_id`),
  CONSTRAINT `fk_movie_genres_movie`
    FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_movie_genres_genre`
    FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `episodes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `movie_id` INT UNSIGNED NOT NULL,
  `episode_name` VARCHAR(100) NOT NULL,
  `content_url` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_episodes_movie_id_id` (`movie_id`, `id`),
  CONSTRAINT `fk_episodes_movie`
    FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `favorites` (
  `user_id` INT UNSIGNED NOT NULL,
  `movie_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `movie_id`),
  KEY `idx_favorites_movie_id` (`movie_id`),
  CONSTRAINT `fk_favorites_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_favorites_movie`
    FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `movie_id` INT UNSIGNED NOT NULL,
  `content` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_comments_movie_id_id` (`movie_id`, `id`),
  KEY `idx_comments_user_id` (`user_id`),
  KEY `idx_comments_created_at` (`created_at`),
  CONSTRAINT `fk_comments_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_movie`
    FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `genres` (`id`, `name`) VALUES
  (1, 'Huyền Huyễn'),
  (2, 'Xuyên Không'),
  (3, 'Trùng Sinh'),
  (4, 'Tiên Hiệp'),
  (5, 'Cổ Trang'),
  (6, 'Hài Hước'),
  (7, 'Kiếm Hiệp'),
  (8, 'Hiện Đại');

