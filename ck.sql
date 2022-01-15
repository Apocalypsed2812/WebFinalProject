-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2022 at 10:45 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ck`
--

-- --------------------------------------------------------

--
-- Table structure for table `dayoff`
--

CREATE TABLE `dayoff` (
  `id` int(11) NOT NULL,
  `numberoff` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attach` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tentk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `day_request` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dayoff`
--

INSERT INTO `dayoff` (`id`, `numberoff`, `reason`, `attach`, `status`, `tentk`, `day_request`, `token`, `role`, `id_department`) VALUES
(2, 1, 'Gia đình có việc', 'minhchung.docx', 'refused', 'anhthu', '2021/11/23', 1, 'employee', 'PB001'),
(51, 2, 'Bệnh', 'báo-cáo.pptx', 'refused', 'nguyenhung', '2022/01/02', 1, 'employee', 'PB002'),
(56, 2, 'Đi chơi', 'download.jpg', 'approved', 'anhtien', '2022/01/07', 1, 'manager', 'PB001'),
(61, 2, 'Bệnh', 'oppo-f3-plus-1-1-400x460.png', 'waiting', 'anhtien', '2022/01/15', 1, 'manager', 'PB001'),
(64, 2, 'Đi chơi', 'itachi.png', 'waiting', 'nguyenhung', '2022/01/15', 1, 'employee', 'PB002'),
(71, 1, 'Đi chơi', '51900444_Phạm Huỳnh Anh Tiến.docx', 'waiting', 'anhthu', '2022/01/15', 1, 'employee', 'PB001');

-- --------------------------------------------------------

--
-- Table structure for table `dayoff_employee`
--

CREATE TABLE `dayoff_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tentk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tongso` int(11) NOT NULL,
  `ngaydasudung` int(11) NOT NULL,
  `ngayconlai` int(11) NOT NULL,
  `id_department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dayoff_employee`
--

INSERT INTO `dayoff_employee` (`id`, `name`, `tentk`, `tongso`, `ngaydasudung`, `ngayconlai`, `id_department`) VALUES
(1, 'Anh Tiến', 'anhtien', 15, 6, 9, 'PB001'),
(2, 'Nguyễn Hưng', 'nguyenhung', 12, 6, 6, 'PB002'),
(10, 'Anh Thư', 'anhthu', 12, 8, 4, 'PB001'),
(12, 'Phạm Hoàng', 'phamhoang', 12, 0, 12, 'PB002'),
(13, 'Phạm Toàn', 'phamtoan', 12, 0, 12, 'PB003'),
(14, 'Trung Hiếu', 'trunghieu', 12, 0, 12, 'PB004'),
(15, 'Nguyễn Khánh', 'nguyenkhanh', 12, 0, 12, 'PB003'),
(16, 'Nguyễn Trung', 'nguyentrung', 12, 0, 12, 'PB004'),
(18, 'Tien pham', 'admin123', 12, 0, 12, 'PB001');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manager` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `manager`, `contact`, `phone`, `description`) VALUES
('PB001', 'Nhân Sự', 'Anh Tiến', 'a@gmail.com', '0582564325', 'Quản lý nhân sự'),
('PB002', 'Kế Toán', 'Phạm Hoàng', 'b@gmail.com', '0123456780', 'Quản lý kế toán'),
('PB003', 'Hành Chính', 'Trần Tuấn', 'c@gmail.com', '0342415520', 'Quản lý hành chính\r\n\r\n'),
('PB004', 'Tài Chính', 'Nguyễn Trung', 'd@gmail.com', '0234781267', 'Quản lý tài chính');

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE `director` (
  `ID` int(50) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `director`
--

INSERT INTO `director` (`ID`, `username`, `password`, `role`, `email`, `token`) VALUES
(1, 'giamdoc', '$2y$10$dk165GpTV/NQ0Hf/l1AAi.vQHUxDGJzfp2f9bOGs1DCgRy2gBUP9i', 'admin', 'phamhuynhanhtien123@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `idnv` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_department` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `indentity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`idnv`, `name`, `username`, `position`, `department`, `id_department`, `email`, `phone`, `indentity`, `gender`, `image`, `password`, `role`) VALUES
('NV001', 'Anh Tiến', 'anhtien', 'Manager', 'Nhân Sự', 'PB001', 'anhtien@gmail.com', '0582564362', '123456', 'Male', 'nokia-8-1-400x460.png', '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'manager'),
('NV002', 'Anh Thư', 'anhthu', 'employee', 'Nhân Sự', 'PB001', 'anhthu@gmail.com', NULL, NULL, NULL, 'iphone-6s-128gb-hong-1-400x450.png', '$2y$10$cS5Z0WdJxYa97nQvBBw7nO0C2Xh.S77DAquGghC7FFGdphZZO.ND6', 'employee'),
('NV003', 'Nguyễn Hưng', 'nguyenhung', 'employee', 'Kế Toán', 'PB002', 'nguyenhung@gmail.com', '0902378456', '11111222', 'Male', 'samsung-galaxy-j7-plus-1-400x460.png', '$2y$10$cs/WX/W9iykkMblogj7Ic.fFJxAaJqsLsa3T9Fn3iHyifaLqJd8SO', 'employee'),
('NV004', 'Phạm Hoàng', 'phamhoang', 'Manager', 'Kế Toán', 'PB002', 'phamhoang@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'manager'),
('NV005', 'Trung Hiếu', 'trunghieu', 'employee', 'Tài Chính', 'PB004', 'trunghieu@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'employee'),
('NV006', 'Nguyễn Trung', 'nguyentrung', 'Manager', 'Hành CHính', 'PB004', 'nguyentrung@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'employee'),
('NV007', 'Phạm Toàn', 'phamtoan', 'Manager', 'Tài Chính', 'PB003', 'phamtoan@gmail.com', '0123456789', '0902362561', 'male', 'oppo-a71-400x460.png', '$2y$10$.Xau2M3eIHToVUTOGEgj2unqwvJ.pUwZauh7KN847VTVMh8Q3XOQy', 'manager'),
('NV008', 'Nguyễn Khánh', 'nguyenkhanh', 'Employee', 'Hành CHính', 'PB003', 'nguyenkhanh@gmail.com', '0982543727', '0923456782', 'male', 'oppo-f3-plus-1-1-400x460.png', '$2y$10$.Xau2M3eIHToVUTOGEgj2unqwvJ.pUwZauh7KN847VTVMh8Q3XOQy', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `reject`
--

CREATE TABLE `reject` (
  `id` int(11) NOT NULL,
  `idtask` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idnv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `day` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reject`
--

INSERT INTO `reject` (`id`, `idtask`, `idnv`, `status`, `day`, `count`) VALUES
(45, 'T001', 'NV002', 'Submit', '2022-01-12', 1),
(46, 'T001', 'NV002', 'Rejected', '2022-01-12', 1),
(47, 'T001', 'NV002', 'Submit', '2022-01-12', 2),
(48, 'T001', 'NV002', 'Completed', '2022-01-12', 0),
(49, 'T003', 'NV002', 'Submit', '2022-01-12', 1),
(50, 'T003', 'NV002', 'Rejected', '2022-01-12', 1),
(51, 'T003', 'NV002', 'Submit', '2022-01-12', 2),
(52, 'T003', 'NV002', 'Completed', '2022-01-12', 0),
(53, 'T001', 'NV002', 'Submit', '2022-01-13', 3),
(54, 'T001', 'NV002', 'Rejected', '2022-01-13', 2),
(55, 'T001', 'NV002', 'Submit', '2022-01-13', 4),
(56, 'T001', 'NV002', 'Completed', '2022-01-13', 0),
(57, 'T007', 'NV002', 'Submit', '2022-01-15', 1),
(58, 'T007', 'NV002', 'Rejected', '2022-01-15', 1),
(59, 'T007', 'NV002', 'Submit', '2022-01-15', 2),
(60, 'T007', 'NV002', 'Completed', '2022-01-15', 0),
(61, 'T006', 'NV002', 'Submit', '2022-01-15', 1),
(62, 'T006', 'NV002', 'Rejected', '2022-01-15', 1),
(63, 'T001', 'NV002', 'Rejected', '2022-01-15', 3);

-- --------------------------------------------------------

--
-- Table structure for table `request_reset`
--

CREATE TABLE `request_reset` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `request_reset`
--

INSERT INTO `request_reset` (`id`, `username`, `email`, `token`) VALUES
(1, 'thu', 'thu@gmail.com', 0),
(2, 'hung', 'hung@gmail.com', 0),
(5, 'tien', 'phamhuynhanhtien123@gmail.com', 1),
(8, 'tien', 'phamhuynhanhtien123@gmail.com', 1),
(26, 'anhthu', 'phamhuynhanhtien1235@gmail.com', 0),
(30, 'anhthu', 'phamhuynhanhtien1235@gmail.com', 0),
(31, 'anhthu', 'anhthu@gmail.com', 0),
(32, 'nguyenhung', 'nguyenhung@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reset_token`
--

INSERT INTO `reset_token` (`email`, `token`, `expire_on`) VALUES
('mvmanh@gmail.com', '', 0),
('mvmanh@it.tdt.edu.vn', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Quyền admin'),
(2, 'manager', 'Quyền quản lý'),
(3, 'employee', 'Quyền nhân viên'),
(4, 'user', 'Tài khoản mới tạo yêu cầu đổi mật khẩu');

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `idsm` int(11) NOT NULL,
  `idnv` varchar(55) NOT NULL,
  `idtask` varchar(55) NOT NULL,
  `attach` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `day_submit` varchar(255) DEFAULT NULL,
  `deadline` varchar(255) DEFAULT NULL,
  `turnin` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`idsm`, `idnv`, `idtask`, `attach`, `description`, `day_submit`, `deadline`, `turnin`, `token`) VALUES
(1, 'NV003', 'T002', 'haha.png', 'em vua nop file nha sep', '2022-01-07', NULL, 'late', 1),
(2, 'NV002', 'T004', '220103_gk_dot-8_ta_thi-thang-01-2022_clc_211-(20220103_083010_849).pdf', 'nop task sep oi', '2022-02-06', NULL, 'normal', 1),
(3, 'NV002', 'T001', 'haha.png', 'em vua nop file nha sep', '2022-01-12', NULL, 'normal', 0),
(44, 'NV002', 'T001', 'samsung-galaxy-j3-2017-2-400x460.png', 'nop task sep oi', '2022-01-12', '2022-01-28', 'normal', 0),
(45, 'NV002', 'T001', 'nokia-8-1-400x460.png', 'nop task sep oi', '2022-01-12', '2022-01-22', 'normal', 0),
(46, 'NV002', 'T001', 'oppo-a71-400x460.png', 'nop task sep oi', '2022-01-12', '2022-02-05', 'normal', 0),
(47, 'NV002', 'T001', 'samsung-galaxy-j3-2017-2-400x460.png', 'em nop lai task thi truong', '2022-01-12', '2022-02-05', 'normal', 0),
(48, 'NV002', 'T003', 'oppo-f3-plus-1-1-400x460.png', 'nop task sep oi', '2022-01-12', '2022-02-01', 'normal', 0),
(49, 'NV002', 'T003', 'oppo-a71-400x460.png', 'nop task sep oi', '2022-01-12', '2022-02-05', 'normal', 0),
(50, 'NV002', 'T001', 'iphone-7-plus-128gb-de-400x460.png', 'nop task sep oi', '2022-01-13', '2022-02-05', 'normal', 0),
(51, 'NV002', 'T001', 'samsung-galaxy-j3-2017-2-400x460.png', 'em nop lai task thi truong', '2022-01-13', '2022-02-04', 'normal', 0),
(52, 'NV002', 'T007', 'Những-vấn-đề-cần-khắc-phục.txt', 'em nop lai task thi truong', '2022-01-15', '2022-01-15', 'normal', 0),
(53, 'NV002', 'T007', '[Phieu Danh Gia] DoAnCuoiKi-HK1-2021-2022.docx', 'em nop lai task thi truong', '2022-01-15', '2022-01-29', 'normal', 0),
(54, 'NV002', 'T006', 'ck.sql', 'em nop lai task thi truong', '2022-01-15', '2022-01-19', 'normal', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `idtask` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idnv` varchar(55) NOT NULL,
  `dueto` varchar(255) DEFAULT NULL,
  `id_department` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  `evaluate` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `attach` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`idtask`, `name`, `status`, `description`, `idnv`, `dueto`, `id_department`, `token`, `evaluate`, `note`, `attach`) VALUES
('T001', 'Báo cáo thị trường', 'Rejected', 'Thu thập thông tin về thị trường tiêu thụ sản phẩm', 'NV002', '2022-01-19', 'PB002', 1, 'Good', 'sep gui em ne1235', 'ck.sql'),
('T002', 'Tạo app', 'Canceled', 'Tạo ứng dụng cho di động 123', 'NV002', '2022-01-27', 'PB001', 0, NULL, NULL, NULL),
('T003', 'Code Web', 'Completed', 'Code Full One Page Website', 'NV002', '2022-02-05', 'PB001', 1, 'OK', 'sep gui em ne', 'oppo-a71-400x460.png'),
('T004', 'Code se', 'Canceled', 'code project software emgineering 123', 'NV002', '2022-01-29', 'PB001', 0, 'OK', NULL, NULL),
('T005', 'Tien pham', 'In progress', 'code project software emgineering', 'NV002', '2022-01-13', 'PB001', 1, NULL, 'làm lại footer', 'SLIDE.ppxt'),
('T006', 'Tien pham', 'Rejected', 'Code Full One Page Website', 'NV002', '2022-01-19', 'PB001', 1, NULL, 'sep gui em ne', 'Những-vấn-đề-cần-khắc-phục.txt'),
('T007', 'Anh Tuan', 'Completed', 'Code Full App Mobile', 'NV002', '2022-01-29', 'PB001', 1, 'OK', 'sep gui em ne1235', 'báo-cáo (1).pptx'),
('T009', 'Tài Chính', 'Canceled', 'Code Full One Page Website', 'NV002', '2022-01-29', 'PB001', 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dayoff`
--
ALTER TABLE `dayoff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dayoff_employee`
--
ALTER TABLE `dayoff_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`idnv`);

--
-- Indexes for table `reject`
--
ALTER TABLE `reject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_reset`
--
ALTER TABLE `request_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`idsm`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`idtask`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dayoff`
--
ALTER TABLE `dayoff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `dayoff_employee`
--
ALTER TABLE `dayoff_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reject`
--
ALTER TABLE `reject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `request_reset`
--
ALTER TABLE `request_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `idsm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
