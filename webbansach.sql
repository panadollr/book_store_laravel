-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 08, 2023 lúc 05:36 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbansach`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_isbn` varchar(255) NOT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_author` varchar(60) DEFAULT NULL,
  `book_image` varchar(255) DEFAULT NULL,
  `book_descr` varchar(255) DEFAULT NULL,
  `book_price` int(55) NOT NULL,
  `publisherid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`id`, `book_isbn`, `book_title`, `book_author`, `book_image`, `book_descr`, `book_price`, `publisherid`) VALUES
(1, '978-0-7303-1484-4', 'Doing Good By Doing Good', 'Peter Baines', 'https://media.wiley.com/product_data/coverImage300/47/07303148/0730314847.jpg', 'Doing Good by Doing Good sẽ cho các công ty cách cải thiện lợi nhuận bằng cách triển khai một chương trình hấp dẫn, chân thực và nâng cao kinh doanh giúp nhân viên và doanh nghiệp phát triển. Cố vấn CSR quốc tế Peter Baines rút ra bài học kinh nghiệm từ n', 180000, 2),
(4, '978-1-44937-019-0', 'Learning Web App Development', 'Semmy Purewal', 'https://m.media-amazon.com/images/I/71Q8O4J8e6L._AC_UF1000,1000_QL80_.jpg', 'Nắm bắt các nguyên tắc cơ bản về phát triển ứng dụng web bằng cách xây dựng một ứng dụng đơn giản dựa trên cơ sở dữ liệu được hỗ trợ từ đầu, sử dụng HTML, JavaScript và các công cụ nguồn mở khác. Thông qua các hướng dẫn thực hành, hướng dẫn thực tế này ch', 280000, 3),
(5, '978-1-44937-075-6', 'Beautiful JavaScript', 'Anton Kovalyov', 'https://learning.oreilly.com/library/cover/9781449371142/360h/', 'JavaScript được cho là ngôn ngữ lập trình phân cực và bị hiểu nhầm nhất trên thế giới. Nhiều người đã cố gắng thay thế nó thành ngôn ngữ của Web, nhưng JavaScript vẫn tồn tại, phát triển và phát triển mạnh mẽ. Tại sao một ngôn ngữ được tạo ra một cách vội', 170000, 3),
(7, '978-1-484216-40-8', 'Android Studio New Media Fundamentals', 'Wallace Jackson', 'https://media.springernature.com/full/springer-static/cover-hires/book/978-1-4842-9867-1', 'Android Studio New Media Fundamentals là một phần mềm truyền thông mới bao gồm các khái niệm trung tâm sản xuất đa phương tiện cho Android bao gồm hình ảnh kỹ thuật số, âm thanh kỹ thuật số, video kỹ thuật số, minh họa kỹ thuật số và 3D, sử dụng các gói p', 240000, 4),
(8, '978-1-484217-26-9', 'C++ 14 Quick Syntax Reference, 2nd Edition', 'Mikael Olsson', 'https://m.media-amazon.com/images/I/415ZCbLHdxL.jpg', 'Hướng dẫn C ++ 14 nhanh tiện dụng được cập nhật này là một tham chiếu mã và cú pháp cô đọng dựa trên bản phát hành C ++ 14 mới được cập nhật của ngôn ngữ lập trình phổ biến. Nó trình bày cú pháp C ++ cơ bản ở định dạng được tổ chức tốt có thể được sử dụng', 340000, 4),
(9, '978-1-49192-706-9', 'C# 6.0 in a Nutshell, 6th Edition', 'Joseph Albahari, Ben Albahari', 'https://m.media-amazon.com/images/I/81yCa4VZsGL.jpg', 'Khi bạn có câu hỏi về C # 6.0 hoặc .NET CLR và các hội đồng Framework cốt lõi của nó, hướng dẫn bán chạy nhất này có câu trả lời bạn cần. C # đã trở thành một ngôn ngữ có độ linh hoạt và rộng lớn khác thường kể từ khi ra mắt vào năm 2000, nhưng sự phát tr', 190000, 3),
(10, '978-1794217010', 'Python Programming from Beginner to Intermediate', 'Cal Baron', 'https://m.media-amazon.com/images/I/61p6wH9GrQL._AC_UF1000,1000_QL80_.jpg', 'Python là một ngôn ngữ lập trình cực kỳ linh hoạt và mạnh mẽ, nhưng chỉ khi bạn biết cách sử dụng nó ! /nPython có thể được sử dụng để tạo bất kỳ loại dự án lập trình nào mà bạn có thể tưởng tượng. Khi bạn hiểu cách lập trình bằng Python, bạn sẽ mở ra một', 420000, 6),
(12, '978-1617298677', 'The Programmers Brain: What every programmer needs to know a', 'Dr. Felienne Hermans', 'https://m.media-amazon.com/images/I/41tgCgc378L._SX397_BO1,204,203,200_.jpg', 'The Programmers Brain mở ra cách chúng ta nghĩ về mã. Nó cung cấp các kỹ thuật hợp lý một cách khoa học có thể cải thiện hoàn toàn cách bạn làm chủ công nghệ mới, hiểu mã và ghi nhớ cú pháp. Bạn sẽ học cách hưởng lợi từ cuộc đấu tranh hiệu quả và biến sự', 190000, 9),
(13, '978-1593279523', 'The Linux Command Line, 2nd Edition: A Complete Introduction', 'Dr. Felienne Hermans', 'https://m.media-amazon.com/images/I/81tKmn7KX1L._AC_UF1000,1000_QL80_.jpg', 'The Linux Command Line đưa bạn từ những lần gõ phím đầu tiên đầu tiên đến việc viết các chương trình đầy đủ trong Bash, trình bao (hoặc dòng lệnh) phổ biến nhất của Linux. Trên đường đi, bạn sẽ học được các kỹ năng vượt thời gian được truyền lại bởi các t', 390000, 7),
(15, '978-1636100005', 'HTML and CSS QuickStart Guide: The Simplified Beginners Guide to Developing a Strong Coding Foundation, Building Responsive Websites, and Mastering ... of Modern Web Design (QuickStart Guides)', 'David DuRocher', 'https://m.media-amazon.com/images/I/71bHK-h6HsL.jpg', 'QuickStart Guides là sách dành cho người mới bắt đầu, được viết bởi các chuyên gia. Với hơn 500.000 bản được bán trên toàn thế giới và hàng nghìn xếp hạng và đánh giá tích cực, QuickStart Guides là bộ sách giáo dục hàng đầu được thiết kế riêng cho người m', 480000, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2019_08_19_000000_create_failed_jobs_table', 1),
(15, '2021_09_21_085107_create_books_table', 2),
(16, '2021_09_28_054733_create_publisher_table', 3),
(17, '2021_09_28_060511_create_publishers_table', 4),
(18, '2021_10_09_012548_tbl_shipping', 5),
(19, '2021_10_09_045209_tbl_payment', 6),
(20, '2021_10_09_062043_tbl_order', 7),
(21, '2021_10_09_062151_tbl_order_details', 7),
(22, '2021_10_09_093427_tbl_paypal', 8),
(23, '2021_10_13_011857_create_tbl_admin_table', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_comment`
--
-- Error reading structure for table webbansach.post_comment: #1932 - Table 'webbansach.post_comment' doesn't exist in engine
-- Error reading data for table webbansach.post_comment: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `webbansach`.`post_comment`' at line 1

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `publishers`
--

CREATE TABLE `publishers` (
  `publisherid` int(10) UNSIGNED NOT NULL,
  `publisher_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `publishers`
--

INSERT INTO `publishers` (`publisherid`, `publisher_name`, `created_at`, `updated_at`) VALUES
(1, 'Wrox', NULL, NULL),
(2, 'Wiley', NULL, NULL),
(3, 'O\'Reilly Media', NULL, NULL),
(4, 'Apress', NULL, NULL),
(5, 'Packt Publishing', NULL, NULL),
(6, 'Addison-Wesley', NULL, NULL),
(7, 'No Starch Press; 1st edition', NULL, NULL),
(8, 'Pearson', NULL, NULL),
(9, 'Manning Publications', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_email` varchar(191) NOT NULL,
  `admin_password` varchar(191) NOT NULL,
  `admin_name` varchar(191) NOT NULL,
  `admin_phone` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_email`, `admin_password`, `admin_name`, `admin_phone`, `created_at`, `updated_at`) VALUES
(4, 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Lân Nguyễn', '231231', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_card_payment`
--

CREATE TABLE `tbl_card_payment` (
  `card_payment_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `card_name` varchar(191) NOT NULL,
  `card_number` int(11) NOT NULL,
  `exp_month` int(11) NOT NULL,
  `exp_year` int(11) NOT NULL,
  `cvv` int(11) NOT NULL,
  `card_status` varchar(191) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `comment_rating` int(11) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_comment`
--

INSERT INTO `tbl_comment` (`comment_id`, `book_id`, `user_id`, `comment_content`, `comment_rating`, `comment_date`) VALUES
(1, 15, 2, 'asdas', 5, '2023-06-21 04:29:21'),
(2, 15, 2, 'd', 1, '2023-06-21 04:29:24'),
(3, 15, 2, 'asdsa', 3, '2023-06-27 10:10:07'),
(4, 15, 2, 'dsadas', 4, '2023-06-27 10:10:32'),
(5, 15, 2, 'hay qewq', 4, '2023-06-27 10:10:38'),
(6, 15, 2, '5545', 5, '2023-06-27 13:16:43'),
(7, 15, 2, 'das', 4, '2023-06-27 13:18:01'),
(8, 15, 2, 'dasda', 4, '2023-06-27 13:18:04'),
(9, 15, 2, 'dsada', 5, '2023-06-27 13:18:15'),
(10, 15, 2, 'asda', 5, '2023-06-27 13:19:03'),
(11, 15, 2, 'asda', 5, '2023-06-27 13:19:07'),
(12, 15, 2, 'asda', 5, '2023-06-27 13:19:29'),
(13, 15, 2, '123', 3, '2023-06-27 13:19:35'),
(14, 15, 1, '9.06 2/7/2023', 1, '2023-07-02 14:07:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `order_total` varchar(255) NOT NULL,
  `order_status` varchar(191) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order`
--

INSERT INTO `tbl_order` (`order_id`, `payment_id`, `order_total`, `order_status`, `date`) VALUES
(144, 2, '390000', 'Đã giao hàng', '2023-05-05 02:01:36'),
(148, 6, '430000', 'Đang chờ xác nhận', '2023-05-06 02:47:09'),
(149, 7, '850000', 'Đang chờ xác nhận', '2023-05-06 03:16:34'),
(150, 8, '6800000', 'Đã giao hàng', '2023-05-14 13:12:41'),
(151, 9, '5040000', 'Đang chờ xác nhận', '2023-05-14 15:26:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `order_details_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(355) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_sales_quantity` varchar(191) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`order_details_id`, `order_id`, `product_id`, `product_name`, `product_price`, `product_sales_quantity`, `date`) VALUES
(160, 144, '13', 'The Linux Command Line, 2nd Edition: A Complete Introduction', '390000', '1', '2023-05-05 02:01:37'),
(163, 148, '12', 'The Programmers Brain: What every programmer needs to know a', '190000', '1', '2023-05-06 02:47:09'),
(164, 148, '7', 'Android Studio New Media Fundamentals', '240000', '1', '2023-05-06 02:47:09'),
(165, 149, '8', 'C++ 14 Quick Syntax Reference, 2nd Edition', '340000', '1', '2023-05-06 03:16:34'),
(166, 149, '5', 'Beautiful JavaScript', '170000', '3', '2023-05-06 03:16:34'),
(167, 150, '8', 'C++ 14 Quick Syntax Reference, 2nd Edition', '340000', '20', '2023-05-14 13:12:41'),
(168, 151, '10', 'Python Programming from Beginner to Intermediate', '420000', '12', '2023-05-14 15:26:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_payment`
--

INSERT INTO `tbl_payment` (`payment_id`, `payment_method`) VALUES
(2, 'Thanh toán khi nhận hàng'),
(6, 'Thanh toán khi nhận hàng'),
(7, 'Thanh toán khi nhận hàng'),
(8, 'Thanh toán khi nhận hàng'),
(9, 'Thanh toán khi nhận hàng'),
(11, 'Thanh toán khi nhận hàng'),
(12, 'Thanh toán khi nhận hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_reply_comment`
--

CREATE TABLE `tbl_reply_comment` (
  `reply_comment_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `reply_comment_content` varchar(255) NOT NULL,
  `reply_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_shipping`
--

CREATE TABLE `tbl_shipping` (
  `shipping_id` int(10) UNSIGNED NOT NULL,
  `shipping_name` varchar(191) NOT NULL,
  `shipping_address` varchar(191) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_note` varchar(191) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_shipping`
--

INSERT INTO `tbl_shipping` (`shipping_id`, `shipping_name`, `shipping_address`, `shipping_city`, `shipping_note`, `order_id`, `user_id`) VALUES
(30, 'Nguyen Van Lan', 'abc', 'Hà Nội', 'Không có', 144, 1),
(34, 'Nguyen Van Lan', '123', 'Hà Nội', 'Không có', 148, 1),
(35, 'Nguyen Van Lan', '123', 'Hà Nội', 'Không có', 149, 1),
(36, 'Nguyen Van Lan', '123', 'Hà Nội', 'Không có', 150, 1),
(37, 'Nguyen Van Lan', '123', 'Hà Nội', 'Không có', 151, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `email`, `password`, `phone`) VALUES
(1, 'lan2k2', 'lan2k2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '0905914203'),
(2, 'hieu2k2', 'hieu2k2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '01223686604');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publisherid` (`publisherid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisherid`);

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_card_payment`
--
ALTER TABLE `tbl_card_payment`
  ADD PRIMARY KEY (`card_payment_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Chỉ mục cho bảng `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `payment_id_2` (`payment_id`);

--
-- Chỉ mục cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Chỉ mục cho bảng `tbl_reply_comment`
--
ALTER TABLE `tbl_reply_comment`
  ADD PRIMARY KEY (`reply_comment_id`);

--
-- Chỉ mục cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `customer_id` (`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisherid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_card_payment`
--
ALTER TABLE `tbl_card_payment`
  MODIFY `card_payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT cho bảng `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `order_details_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT cho bảng `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tbl_reply_comment`
--
ALTER TABLE `tbl_reply_comment`
  MODIFY `reply_comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  MODIFY `shipping_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`publisherid`) REFERENCES `publishers` (`publisherid`);

--
-- Các ràng buộc cho bảng `tbl_card_payment`
--
ALTER TABLE `tbl_card_payment`
  ADD CONSTRAINT `tbl_card_payment_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `tbl_payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `tbl_payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD CONSTRAINT `tbl_order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_shipping`
--
ALTER TABLE `tbl_shipping`
  ADD CONSTRAINT `tbl_shipping_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
