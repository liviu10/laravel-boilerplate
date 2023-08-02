-- Create table roles_and_permissions
CREATE TABLE `roles_and_permissions` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` varchar(255) NOT NULL,
    `bg_color` varchar(255) DEFAULT NULL,
    `text_color` varchar(255) DEFAULT NULL,
    `slug` varchar(255) NOT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `roles_and_permissions_name_unique` (`name`),
    KEY `idx_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table users
CREATE TABLE `users` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `full_name` varchar(255) NOT NULL,
    `first_name` varchar(255) NOT NULL,
    `last_name` varchar(255) NOT NULL,
    `nickname` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    `profile_image` varchar(255) DEFAULT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `roles_and_permissions_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    KEY `idx_id` (`id`),
    KEY `idx_roles_and_permissions_id` (`roles_and_permissions_id`),
    CONSTRAINT `idx_roles_and_permissions_id` FOREIGN KEY (`roles_and_permissions_id`) REFERENCES `roles_and_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table failed_jobs
CREATE TABLE `failed_jobs` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `connection` text NOT NULL,
    `queue` text NOT NULL,
    `payload` longtext NOT NULL,
    `exception` longtext NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table migrations
CREATE TABLE `migrations` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) NOT NULL,
    `batch` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table password_reset_tokens
CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table personal_access_tokens
CREATE TABLE `personal_access_tokens` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `tokenable_type` varchar(255) NOT NULL,
    `tokenable_id` bigint(20) unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `token` varchar(64) NOT NULL,
    `abilities` text DEFAULT NULL,
    `last_used_at` timestamp NULL DEFAULT NULL,
    `expires_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
    KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table telescope_entries
CREATE TABLE `telescope_entries` (
    `sequence` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `uuid` char(36) NOT NULL,
    `batch_id` char(36) NOT NULL,
    `family_hash` varchar(255) DEFAULT NULL,
    `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
    `type` varchar(20) NOT NULL,
    `content` longtext NOT NULL,
    `created_at` datetime DEFAULT NULL,
    PRIMARY KEY (`sequence`),
    UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
    KEY `telescope_entries_batch_id_index` (`batch_id`),
    KEY `telescope_entries_family_hash_index` (`family_hash`),
    KEY `telescope_entries_created_at_index` (`created_at`),
    KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB AUTO_INCREMENT=2862 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table telescope_entries_tags
CREATE TABLE `telescope_entries_tags` (
    `entry_uuid` char(36) NOT NULL,
    `tag` varchar(255) NOT NULL,
    KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
    KEY `telescope_entries_tags_tag_index` (`tag`),
    CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table telescope_monitoring
CREATE TABLE `telescope_monitoring` (
    `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table accepted_domains
CREATE TABLE `accepted_domains` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `domain` varchar(50) NOT NULL,
    `type` varchar(50) NOT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `domain` (`domain`),
    KEY `idx_id` (`id`),
    KEY `idx_accepted_domains_user_id` (`user_id`),
    CONSTRAINT `idx_accepted_domains_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1423 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table contact_subjects
CREATE TABLE `contact_subjects` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` varchar(255) DEFAULT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `user_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_id` (`id`),
    KEY `idx_contact_subjects_user_id` (`user_id`),
    CONSTRAINT `idx_contact_subjects_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Create table contact_messages
CREATE TABLE `contact_messages` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `full_name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `message` varchar(255) NOT NULL,
    `privacy_policy` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `contact_subject_id` bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_id` (`id`),
    KEY `idx_contact_messages_contact_subject_id` (`contact_subject_id`),
    CONSTRAINT `idx_contact_messages_contact_subject_id` FOREIGN KEY (`contact_subject_id`) REFERENCES `contact_subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
