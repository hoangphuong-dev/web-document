-- Danh mục cấp 1
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(1, 'Giáo dục & Đào tạo', 1, 0, NULL, '11,12,13,14,15,16,17,18,19,20'),
(2, 'Khoa học & Kỹ thuật', 1, 0, NULL, '21,22,23,24,25,26,27,28'),
(3, 'Y tế & Sức khỏe', 1, 0, NULL, '31,32,33,34,35,36,37'),
(4, 'Nông nghiệp & Môi trường', 1, 0, NULL, '41,42,43,44,45,46,47,48'),
(5, 'Quản lý & Điều hành', 1, 0, NULL, '51,52,53,54,55,56,57'),
(6, 'Công nghệ thông tin', 1, 0, NULL, '61,62,63,64,65,66,67'),
(7, 'Đời sống & Xã hội', 1, 0, NULL, '71,72,73,74,75,76'),
(8, 'Thư viện mẫu', 1, 0, NULL, '81,82,83,84,85'),
(9, 'Hướng dẫn & Quy trình', 1, 0, NULL, '91,92,93,94,95'),
(10, 'Cộng đồng', 1, 0, NULL, '101,102,103,104,105');

-- Danh mục cấp 2 cho Giáo dục & Đào tạo (parent_id = 1)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(11, 'Phương pháp giảng dạy', 1, 1, NULL, ''),
(12, 'Quản lý lớp học', 1, 1, NULL, ''),
(13, 'Đánh giá học sinh', 1, 1, NULL, ''),
(14, 'Giáo dục đặc biệt', 1, 1, NULL, ''),
(15, 'Công nghệ trong giáo dục', 1, 1, NULL, ''),
(16, 'Sáng kiến mầm non', 1, 1, NULL, ''),
(17, 'Sáng kiến tiểu học', 1, 1, NULL, ''),
(18, 'Sáng kiến THCS', 1, 1, NULL, ''),
(19, 'Sáng kiến THPT', 1, 1, NULL, ''),
(20, 'Sáng kiến đại học', 1, 1, NULL, '');

-- Danh mục cấp 2 cho Khoa học & Kỹ thuật (parent_id = 2)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(21, 'Cải tiến quy trình sản xuất', 1, 2, NULL, ''),
(22, 'Tự động hóa', 1, 2, NULL, ''),
(23, 'Tiết kiệm năng lượng', 1, 2, NULL, ''),
(24, 'Sáng chế & Phát minh', 1, 2, NULL, ''),
(25, 'Vật liệu mới', 1, 2, NULL, ''),
(26, 'Kỹ thuật xây dựng', 1, 2, NULL, ''),
(27, 'Cơ khí & Chế tạo', 1, 2, NULL, ''),
(28, 'Điện - Điện tử', 1, 2, NULL, '');

-- Danh mục cấp 2 cho Y tế & Sức khỏe (parent_id = 3)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(31, 'Quy trình khám chữa bệnh', 1, 3, NULL, ''),
(32, 'Chăm sóc bệnh nhân', 1, 3, NULL, ''),
(33, 'Quản lý y tế', 1, 3, NULL, ''),
(34, 'Y học cộng đồng', 1, 3, NULL, ''),
(35, 'Dược phẩm & Điều chế', 1, 3, NULL, ''),
(36, 'Thiết bị y tế', 1, 3, NULL, ''),
(37, 'Vệ sinh an toàn', 1, 3, NULL, '');

-- Danh mục cấp 2 cho Nông nghiệp & Môi trường (parent_id = 4)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(41, 'Kỹ thuật canh tác', 1, 4, NULL, ''),
(42, 'Bảo vệ thực vật', 1, 4, NULL, ''),
(43, 'Chăn nuôi', 1, 4, NULL, ''),
(44, 'Bảo quản nông sản', 1, 4, NULL, ''),
(45, 'Nông nghiệp công nghệ cao', 1, 4, NULL, ''),
(46, 'Xử lý chất thải', 1, 4, NULL, ''),
(47, 'Năng lượng tái tạo', 1, 4, NULL, ''),
(48, 'Bảo tồn thiên nhiên', 1, 4, NULL, '');

-- Danh mục cấp 2 cho Quản lý & Điều hành (parent_id = 5)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(51, 'Quản lý nhân sự', 1, 5, NULL, ''),
(52, 'Tối ưu quy trình', 1, 5, NULL, ''),
(53, 'Dịch vụ khách hàng', 1, 5, NULL, ''),
(54, 'Quản lý dự án', 1, 5, NULL, ''),
(55, 'Chiến lược kinh doanh', 1, 5, NULL, ''),
(56, 'Cải cách hành chính', 1, 5, NULL, ''),
(57, 'Quản lý chất lượng', 1, 5, NULL, '');

-- Danh mục cấp 2 cho Công nghệ thông tin (parent_id = 6)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(61, 'Phát triển phần mềm', 1, 6, NULL, ''),
(62, 'Ứng dụng di động', 1, 6, NULL, ''),
(63, 'An toàn thông tin', 1, 6, NULL, ''),
(64, 'Hệ thống thông tin quản lý', 1, 6, NULL, ''),
(65, 'Trí tuệ nhân tạo', 1, 6, NULL, ''),
(66, 'Big Data & Phân tích', 1, 6, NULL, ''),
(67, 'Tối ưu hóa website', 1, 6, NULL, '');

-- Danh mục cấp 2 cho Đời sống & Xã hội (parent_id = 7)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(71, 'Giải pháp cộng đồng', 1, 7, NULL, ''),
(72, 'Phát triển đô thị', 1, 7, NULL, ''),
(73, 'An sinh xã hội', 1, 7, NULL, ''),
(74, 'Sáng kiến văn hóa', 1, 7, NULL, ''),
(75, 'Du lịch & dịch vụ', 1, 7, NULL, ''),
(76, 'Tiết kiệm gia đình', 1, 7, NULL, '');

-- Danh mục cấp 2 cho Thư viện mẫu (parent_id = 8)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(81, 'Mẫu báo cáo SKKN', 1, 8, NULL, ''),
(82, 'Mẫu đơn đăng ký', 1, 8, NULL, ''),
(83, 'Mẫu thuyết minh', 1, 8, NULL, ''),
(84, 'Mẫu đánh giá', 1, 8, NULL, ''),
(85, 'Mẫu theo lĩnh vực', 1, 8, NULL, '');

-- Danh mục cấp 2 cho Hướng dẫn & Quy trình (parent_id = 9)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(91, 'Cách viết báo cáo SKKN', 1, 9, NULL, ''),
(92, 'Quy trình đăng ký', 1, 9, NULL, ''),
(93, 'Tiêu chí đánh giá', 1, 9, NULL, ''),
(94, 'Bảo hộ sáng kiến', 1, 9, NULL, ''),
(95, 'Thương mại hóa sáng kiến', 1, 9, NULL, '');

-- Danh mục cấp 2 cho Cộng đồng (parent_id = 10)
INSERT INTO `categories` (`id`, `name`, `active`, `parent_id`, `parent_id_1`, `list_child_all`) VALUES
(101, 'Diễn đàn trao đổi', 1, 10, NULL, ''),
(102, 'Hỏi & Đáp', 1, 10, NULL, ''),
(103, 'Đánh giá & Bình luận', 1, 10, NULL, ''),
(104, 'Sự kiện & Hội thảo', 1, 10, NULL, ''),
(105, 'Nhà sáng tạo tiêu biểu', 1, 10, NULL, '');