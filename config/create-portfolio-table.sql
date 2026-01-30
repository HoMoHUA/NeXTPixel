-- جدول مدیریت پروژه‌های نمونه کاری
CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL COMMENT 'عنوان پروژه',
  `description` TEXT COMMENT 'توضیح پروژه',
  `category` VARCHAR(50) NOT NULL COMMENT 'دسته‌بندی: store, service, landing, other',
  `thumbnail` VARCHAR(500) NOT NULL COMMENT 'مسیر تصویر بندانگشتی',
  `thumbnail_local_path` VARCHAR(500) COMMENT 'مسیر تصویر محلی (برای استفاده به جای URL)',
  `project_url` VARCHAR(500) COMMENT 'لینک وبسایت پروژه',
  `demo_type` ENUM('external', 'internal', 'both') NOT NULL DEFAULT 'external' COMMENT 'نوع دمو: external (خارجی), internal (محلی), both (هر دو)',
  `internal_demo_url` VARCHAR(500) COMMENT 'لینک دمو داخلی/محلی',
  `image_alt_text` VARCHAR(500) COMMENT 'متن alt برای تصویر',
  `technologies` JSON COMMENT 'تکنولوژی‌های استفاده شده',
  `client_name` VARCHAR(255) COMMENT 'نام کلاینت',
  `completion_date` DATE COMMENT 'تاریخ تکمیل پروژه',
  `featured` BOOLEAN DEFAULT FALSE COMMENT 'آیا در صفحه اصلی نمایش داده شود؟',
  `display_order` INT(11) DEFAULT 0 COMMENT 'ترتیب نمایش',
  `status` ENUM('active', 'inactive', 'draft') NOT NULL DEFAULT 'active' COMMENT 'وضعیت نمایش',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT(11) DEFAULT NULL COMMENT 'شناسه کاربری که پروژه را اضافه کرده',
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`),
  KEY `idx_featured` (`featured`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- درج نمونه داده‌ها
INSERT INTO `portfolios` (`title`, `description`, `category`, `thumbnail`, `project_url`, `demo_type`, `image_alt_text`, `client_name`, `featured`, `display_order`, `status`) VALUES
('عطر هات چاکلت', 'عرضه انواع عطر های وارداتی بدون واسطه و اولین تست هوشمند شخصیت شناسی عطر', 'store', '/src/hchperfume.png', 'https://hchperfume.ir', 'external', 'سایت عطر هات چاکلت', 'هات چاکلت', TRUE, 1, 'active'),
('کفش ردپا مشهد', 'نمایندگی رسمی کفش ردپا در مشهد و ارائه بهترین و با کیفیت ترین ها', 'store', '/src/radepamashhad.png', 'https://radepamashhad.ir', 'external', 'سایت کفش ردپا مشهد', 'ردپا مشهد', TRUE, 2, 'active'),
('دوچرخه آس باد', 'مرکز فروش و تعمیرات تخصصی دوچرخه', 'store', '/src/aasbad.png', 'https://aasbad.ir', 'external', 'فروشگاه دوچرخه آس باد', 'آس باد', TRUE, 3, 'active'),
('زیبایی مهناز حلمی', 'ارائه دهنده خدمات تخصصی زیبایی و آرایشی در فریمان', 'service', '/src/mahnazbeauty.png', 'https://mahnazhelmi.ir', 'external', 'مجموعه زیبایی مهناز حلمی', 'مهناز حلمی', TRUE, 4, 'active'),
('عرضه انواع گجت', 'ارائه بروز ترین گجت ها و چت بات تعمیر آنلاین گوشی با هوش مصنوعی', 'service', '/src/jahanphone.png', 'https://wpun.ir', 'external', 'جهان فون', 'جهان فون', TRUE, 5, 'active');
