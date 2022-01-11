-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 05, 2022 lúc 02:02 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ck`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dayoff`
--

CREATE TABLE `dayoff` (
  `id` int(11) NOT NULL,
  `numberoff` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attach` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tentk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `day_request` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dayoff`
--

INSERT INTO `dayoff` (`id`, `numberoff`, `reason`, `attach`, `status`, `tentk`, `day_request`, `token`) VALUES
(2, 1, 'Gia đình có việc', 'minhchung.docx', 'approved', 'anhthu', '2021/11/23', 1),
(51, 2, 'Bệnh', 'báo-cáo.pptx', 'approved', 'nguyenhung', '2022/01/02', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dayoff_employee`
--

CREATE TABLE `dayoff_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tentk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tongso` int(11) NOT NULL,
  `ngaydasudung` int(11) NOT NULL,
  `ngayconlai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dayoff_employee`
--

INSERT INTO `dayoff_employee` (`id`, `name`, `tentk`, `tongso`, `ngaydasudung`, `ngayconlai`) VALUES
(1, 'Anh Tiến', 'anhtien', 12, 0, 12),
(2, 'Nguyễn Hưng', 'nguyenhung', 12, 4, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department`
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
-- Đang đổ dữ liệu cho bảng `department`
--

INSERT INTO `department` (`id`, `name`, `manager`, `contact`, `phone`, `description`) VALUES
('PB001', 'Nhân Sự', 'Anh Tiến', 'a@gmail.com', '0582564325', 'Quản lý nhân sự'),
('PB002', 'Kế Toán', 'Phạm Hoàng', 'b@gmail.com', '0123456780', 'Quản lý kế toán'),
('PB003', 'Hành Chính', 'Trần Tuấn', 'c@gmail.com', '0342415520', 'Quản lý hành chính\r\n\r\n'),
('PB004', 'Tài Chính', 'Nguyễn Trung', 'd@gmail.com', '0234781267', 'Quản lý tài chính');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `director`
--

CREATE TABLE `director` (
  `ID` int(50) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `director`
--

INSERT INTO `director` (`ID`, `username`, `password`, `role`, `email`) VALUES
(1, 'giamdoc', '$2y$10$M3rz9K9.qGJ.rugiwWKw.OkUMfOdkzM9hJxw8n1.ejKiJtPaPN6kW', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
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
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`idnv`, `name`, `username`, `position`, `department`, `id_department`, `email`, `phone`, `indentity`, `gender`, `image`, `password`, `role`) VALUES
('NV001', 'Anh Tiến', 'anhtien', 'Manager', 'Nhân Sự', 'PB001', 'anhtien@gmail.com', '0582564362', '123456', 'Male', 'xiaomi-redmi-4x-400-400x460.png', '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'manager'),
('NV002', 'Anh Thư', 'anhthu', 'employee', 'Nhân Sự', 'PB001', 'anhthu@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$j7XuXPu2WEqhorPehtupUeifc01XGbgdRmn/eLm7OrJShZJIUaN1.', 'employee'),
('NV003', 'Nguyễn Hưng', 'nguyenhung', 'employee', 'Kế Toán', 'PB002', 'nguyenhung@gmail.com', '0902378456', '11111222', 'Male', 'samsung-galaxy-j7-plus-1-400x460.png', '$2y$10$4DR7snER5iqZir2CyEQlU.Iu776Qfn0lzyXOB2vKo0SPYjsUp/7r6', 'employee'),
('NV004', 'Phạm Hoàng', 'phamhoang', 'Manager', 'Kế Toán', 'PB002', 'phamhoang@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'employee'),
('NV005', 'Trung Hiếu', 'trunghieu', 'employee', 'Tài Chính', 'PB004', 'trunghieu@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'employee'),
('NV006', 'Nguyễn Trung', 'nguyentrung', 'Manager', 'Tài Chính', 'PB004', 'nguyentrung@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'employee'),
('NV007', 'Phạm Toàn', 'phamtoan', 'employee', 'Hành Chính', NULL, 'phamtoan@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Mh.mBWlG0nk8ba7Fuh6Q6.FjjHSnIyzVV9Cpk9aBTvQwmm4GV5odu', 'employee');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manager`
--

CREATE TABLE `manager` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `manager`
--

INSERT INTO `manager` (`id`, `name`, `department`) VALUES
('TP001', 'Anh Tiến', 'Nhân Sự'),
('TP002', 'Trần Tuấn', 'Hành Chính'),
('TP003', 'Phạm Hoàng', 'Kế Toán'),
('TP004', 'Nguyễn Trung', 'Tài Chính');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `request_reset`
--

CREATE TABLE `request_reset` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `request_reset`
--

INSERT INTO `request_reset` (`id`, `username`, `email`, `token`) VALUES
(1, 'thu', 'thu@gmail.com', 0),
(2, 'hung', 'hung@gmail.com', 0),
(5, 'tien', 'phamhuynhanhtien123@gmail.com', 1),
(8, 'tien', 'phamhuynhanhtien123@gmail.com', 1),
(26, 'anhthu', 'phamhuynhanhtien1235@gmail.com', 0),
(30, 'anhthu', 'phamhuynhanhtien1235@gmail.com', 0),
(31, 'anhthu', 'anhthu@gmail.com', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `username`) VALUES
(1, 'admin', 'Quyền admin', NULL),
(2, 'manager', 'Quyền quản lý', NULL),
(3, 'employee', 'Quyền nhân viên', NULL),
(4, 'user', 'Tài khoản mới tạo yêu cầu đổi mật khẩu', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submission`
--

CREATE TABLE `submission` (
  `idsm` int(11) NOT NULL,
  `idnv` varchar(55) NOT NULL,
  `idtask` varchar(55) NOT NULL,
  `attach` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `submission`
--

INSERT INTO `submission` (`idsm`, `idnv`, `idtask`, `attach`, `description`) VALUES
(1, 'NV001', 'T001', 'haha.png', 'em vua nop file nha sep'),
(2, 'NV003', 'T002', 'haha.png', 'em vua nop file nha sep');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task`
--

CREATE TABLE `task` (
  `idtask` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idnv` varchar(55) NOT NULL,
  `due to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `task`
--

INSERT INTO `task` (`idtask`, `name`, `status`, `description`, `idnv`, `due to`) VALUES
('T001', 'Báo cáo thị trường', 'New', 'Thu thập thông tin về thị trường tiêu thụ sản phẩm', 'NV003', '2022-01-12'),
('T002', 'Tạo app', 'New', 'Tạo ứng dụng cho di động', 'NV001', '2022-01-12');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dayoff`
--
ALTER TABLE `dayoff`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dayoff_employee`
--
ALTER TABLE `dayoff_employee`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`idnv`);

--
-- Chỉ mục cho bảng `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `request_reset`
--
ALTER TABLE `request_reset`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`idsm`);

--
-- Chỉ mục cho bảng `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`idtask`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dayoff`
--
ALTER TABLE `dayoff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `request_reset`
--
ALTER TABLE `request_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `submission`
--
ALTER TABLE `submission`
  MODIFY `idsm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
