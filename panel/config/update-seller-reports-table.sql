-- به‌روزرسانی جدول seller_reports برای افزودن وضعیت تایید
USE `gcifyhuc_NP`;

-- افزودن ستون status برای وضعیت تایید فروش
ALTER TABLE `seller_reports` 
ADD COLUMN IF NOT EXISTS `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending' COMMENT 'وضعیت تایید فروش';

-- افزودن ستون approved_by برای شناسه مدیر تاییدکننده
ALTER TABLE `seller_reports` 
ADD COLUMN IF NOT EXISTS `approved_by` INT(11) DEFAULT NULL COMMENT 'شناسه مدیر تاییدکننده';

-- افزودن ستون approved_at برای تاریخ تایید
ALTER TABLE `seller_reports` 
ADD COLUMN IF NOT EXISTS `approved_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'تاریخ تایید';

-- افزودن ستون rejection_reason برای دلیل رد
ALTER TABLE `seller_reports` 
ADD COLUMN IF NOT EXISTS `rejection_reason` TEXT DEFAULT NULL COMMENT 'دلیل رد فروش';

-- ایجاد ایندکس برای جستجوی سریع‌تر
ALTER TABLE `seller_reports` ADD INDEX IF NOT EXISTS `idx_status` (`status`);
ALTER TABLE `seller_reports` ADD INDEX IF NOT EXISTS `idx_approved_by` (`approved_by`);

