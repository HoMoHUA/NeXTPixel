-- افزودن ستون status و ستون‌های مرتبط به جدول seller_reports
USE `gcifyhuc_NP`;

-- بررسی وجود ستون status
SET @col_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'gcifyhuc_NP' 
    AND TABLE_NAME = 'seller_reports' 
    AND COLUMN_NAME = 'status'
);

-- افزودن ستون status اگر وجود ندارد
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `seller_reports` ADD COLUMN `status` ENUM(\'pending\', \'approved\', \'rejected\') DEFAULT \'pending\' COMMENT \'وضعیت تایید فروش\' AFTER `no_sale_reason`',
    'SELECT "Column status already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- افزودن ستون approved_by
SET @col_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'gcifyhuc_NP' 
    AND TABLE_NAME = 'seller_reports' 
    AND COLUMN_NAME = 'approved_by'
);

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `seller_reports` ADD COLUMN `approved_by` INT(11) DEFAULT NULL COMMENT \'شناسه مدیر تاییدکننده\' AFTER `status`',
    'SELECT "Column approved_by already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- افزودن ستون approved_at
SET @col_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'gcifyhuc_NP' 
    AND TABLE_NAME = 'seller_reports' 
    AND COLUMN_NAME = 'approved_at'
);

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `seller_reports` ADD COLUMN `approved_at` TIMESTAMP NULL DEFAULT NULL COMMENT \'زمان تایید/رد\' AFTER `approved_by`',
    'SELECT "Column approved_at already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- افزودن ستون rejection_reason
SET @col_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'gcifyhuc_NP' 
    AND TABLE_NAME = 'seller_reports' 
    AND COLUMN_NAME = 'rejection_reason'
);

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `seller_reports` ADD COLUMN `rejection_reason` TEXT DEFAULT NULL COMMENT \'دلیل رد فروش\' AFTER `approved_at`',
    'SELECT "Column rejection_reason already exists" AS message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- افزودن ایندکس برای status
ALTER TABLE `seller_reports` ADD INDEX IF NOT EXISTS `idx_status` (`status`);
ALTER TABLE `seller_reports` ADD INDEX IF NOT EXISTS `idx_user_status` (`user_id`, `status`);

