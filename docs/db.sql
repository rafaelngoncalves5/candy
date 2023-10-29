CREATE DATABASE database_name;

USE database_name;

CREATE TABLE `users` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) UNIQUE NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Naturally, it will be hashed',
  `is_admin` boolean DEFAULT false,
  `created_at` timestamp DEFAULT now()
);

CREATE TABLE `posts` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) DEFAULT "I'm thinking about...",
  `body` text NOT NULL COMMENT 'Content of the post',
  `created_at` timestamp DEFAULT now(),
  `user_id` integer,
  `likes_counter` integer DEFAULT 0 COMMENT 'It is incremented by 1 each new \'users_posts\' instance'
);

CREATE TABLE `users_posts` (
  `user_id` integer,
  `post_id` integer,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
);

ALTER TABLE `posts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

-- Later added
ALTER TABLE posts ADD picture TEXT;

-- Clean
DROP DATABASE database_name;