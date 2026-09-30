-- Database structure and initial seed data for Admin Dashboard
CREATE DATABASE IF NOT EXISTS `bidyarthi_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bidyarthi_db`;

-- 1. Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `role` VARCHAR(20) DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default admin user (username: admin, password: password123)
-- Password hash generated with password_hash('password123', PASSWORD_BCRYPT)
INSERT INTO `admin_users` (`id`, `username`, `password`, `full_name`, `email`) 
VALUES (1, 'admin', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFz2Wd7vW8a0C/J1vO1V8Rz9N2G/8k6S', 'System Admin', 'admin@bidyarthi.com')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 2. Website Settings & Contact Details
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` INT PRIMARY KEY DEFAULT 1,
  `site_name` VARCHAR(150) DEFAULT 'Bidyabharati Classes',
  `logo_path` VARCHAR(255) DEFAULT 'uploads/logo.png',
  `favicon_path` VARCHAR(255) DEFAULT 'assets/images/bidyarthilogo.png',
  `phone` VARCHAR(50) DEFAULT '+91 98765 43210',
  `email` VARCHAR(100) DEFAULT 'info@bidyarthiclasses.com',
  `address` TEXT,
  `working_hours` VARCHAR(255) DEFAULT '10:00 AM – 10:00 PM (Monday - Sunday)',
  `map_iframe` TEXT,
  `facebook_url` VARCHAR(255) DEFAULT 'https://facebook.com',
  `twitter_url` VARCHAR(255) DEFAULT 'https://twitter.com',
  `instagram_url` VARCHAR(255) DEFAULT 'https://instagram.com',
  `linkedin_url` VARCHAR(255) DEFAULT 'https://linkedin.com',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`id`, `site_name`, `phone`, `email`, `address`, `working_hours`)
VALUES (1, 'Bidyabharati Classes', '+91 98765 43210', 'info@bidyarthiclasses.com', '709 Honey Creek Dr., New York, NY 10028', '10:00 AM – 10:00 PM (Monday - Sunday)')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 3. Gallery Table
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) DEFAULT 'General',
  `image_path` VARCHAR(255) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `designation` VARCHAR(150) DEFAULT 'Student',
  `image_path` VARCHAR(255) DEFAULT '',
  `rating` INT DEFAULT 5,
  `message` TEXT NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Faculties Table
CREATE TABLE IF NOT EXISTS `faculties` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `designation` VARCHAR(150) NOT NULL,
  `qualification` VARCHAR(255) DEFAULT '',
  `experience` VARCHAR(100) DEFAULT '',
  `bio` TEXT,
  `image_path` VARCHAR(255) DEFAULT '',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Achievers Table
CREATE TABLE IF NOT EXISTS `achievers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_name` VARCHAR(150) NOT NULL,
  `exam_name` VARCHAR(150) NOT NULL,
  `rank_score` VARCHAR(100) NOT NULL,
  `year` VARCHAR(10) DEFAULT '2025',
  `image_path` VARCHAR(255) DEFAULT '',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Download Documents Table
CREATE TABLE IF NOT EXISTS `documents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) DEFAULT 'General',
  `file_path` VARCHAR(255) NOT NULL,
  `file_size` VARCHAR(50) DEFAULT '',
  `file_type` VARCHAR(50) DEFAULT 'pdf',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Hero Sliders Table
CREATE TABLE IF NOT EXISTS `hero_sliders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `subtitle` VARCHAR(255) DEFAULT 'LEARN ANYTHING, ANYTIME, ANYWHERE',
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `btn1_text` VARCHAR(50) DEFAULT 'View Course',
  `btn1_url` VARCHAR(255) DEFAULT 'course-1.php',
  `btn2_text` VARCHAR(50) DEFAULT 'Get Started',
  `btn2_url` VARCHAR(255) DEFAULT 'contact.php',
  `image_path` VARCHAR(255) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Events Table
CREATE TABLE IF NOT EXISTS `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `event_date` DATE NOT NULL,
  `event_time` VARCHAR(100) DEFAULT '10:00 AM',
  `location` VARCHAR(255) DEFAULT 'Baripada Campus',
  `description` TEXT,
  `rating` INT DEFAULT 5,
  `image_path` VARCHAR(255) DEFAULT '',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default events
INSERT INTO `events` (`id`, `title`, `event_date`, `event_time`, `location`, `description`, `rating`, `image_path`) VALUES
(1, 'Student Leadership & Career Workshop', '2026-12-26', '10:00 AM', 'Main Auditorium', 'Interactive workshop on career pathways, leadership skills, and exam preparation.', 5, 'assets/images/courses/event-1.jpg'),
(2, 'The Best Coaching & Annual Conference', '2026-12-28', '11:00 AM', 'Conference Hall', 'Annual academic conference celebrating student milestones and honors.', 5, 'assets/images/courses/event-2.jpg'),
(3, 'The Ultimate Future Skills Program', '2026-12-21', '09:30 AM', 'Lab Hall', 'Specialized session on logical reasoning, science experiments, and problem solving.', 5, 'assets/images/courses/event-3.jpg'),
(4, 'National Science & Technology Innovation Expo', '2026-12-15', '10:00 AM', 'Exhibition Ground', 'Student project exhibition highlighting science models and creative innovations.', 5, 'assets/images/courses/event-1.jpg')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 10. Notices & Announcements Table
CREATE TABLE IF NOT EXISTS `notices` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) DEFAULT 'Academic announcement',
  `notice_date` DATE NOT NULL,
  `content` TEXT,
  `attachment_path` VARCHAR(255) DEFAULT '',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default notices
INSERT INTO `notices` (`id`, `title`, `category`, `notice_date`, `content`) VALUES
(1, 'IMPORTANT ANNOUNCEMENT FOR NEW ADMISSION LEARNERS', 'Academic announcement', '2026-11-15', 'Admissions open for new academic session Class III to XII. Register early for batch selection.'),
(2, 'IMPORTANT ANNOUNCEMENT FOR ALL NEW BATCH LEARNING SESSIONS', 'Academic announcement', '2026-12-15', 'New evening batch commencing for Class IX & X Science and Mathematics.'),
(3, 'IMPORTANT ANNOUNCEMENT FOR ALL SEMESTER EXAMINATIONS', 'Examination announcement', '2026-12-13', 'Mock Board examination schedule published. Check your syllabus coverage.'),
(4, 'SCHOLARSHIP APPLICATION FOR MERIT STUDENTS OPEN', 'Scholarship announcement', '2026-12-08', 'Merit test applications open. Waiver up to 100% for top scorers.')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 11. Enrollments & Admission Applications Table
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) DEFAULT '',
  `course` VARCHAR(150) NOT NULL,
  `message` TEXT,
  `status` ENUM('pending', 'contacted', 'enrolled', 'cancelled') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
