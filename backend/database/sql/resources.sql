CREATE TABLE `resources` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `type` enum('Menu','API') NOT NULL,
    `path` varchar(255) NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    `component` varchar(255) DEFAULT NULL,
    `layout` varchar(255) DEFAULT NULL,
    `title` varchar(255) DEFAULT NULL,
    `caption` varchar(255) DEFAULT NULL,
    `icon` varchar(255) DEFAULT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 0,
    `requires_auth` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_id` (`id`),
    KEY `idx_resources_user_id` (`user_id`),
    CONSTRAINT `idx_resources_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

