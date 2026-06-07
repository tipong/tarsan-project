-- Insert users and orders generated from Google Forms data

START TRANSACTION;

-- Data for Ni Putu Sri Indah Damayanti (damayanti.2205551037@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (200, 'Ni Putu Sri Indah Damayanti', 'damayanti.2205551037@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 00:12:20', '2026-05-26 00:12:20');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (200, 'ORD-202605260001', 200, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 00:12:20', '2026-05-26 00:12:20');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (200, 200, 10, 1, 280000, 1, 280000, '2026-05-26 00:12:20', '2026-05-26 00:12:20');

-- Data for Ni Putu Ina Trisna Putri (putri.2207521051@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (201, 'Ni Putu Ina Trisna Putri', 'putri.2207521051@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 07:58:51', '2026-05-26 07:58:51');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (201, 'ORD-202605260002', 201, '2026-05-26', '2026-05-27', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 07:58:51', '2026-05-26 07:58:51');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (201, 201, 12, 1, 150000, 1, 150000, '2026-05-26 07:58:51', '2026-05-26 07:58:51');

-- Data for Ni Komang Septiani (septiani.2207511109@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (202, 'Ni Komang Septiani', 'septiani.2207511109@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 08:29:31', '2026-05-26 08:29:31');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (202, 'ORD-202605260003', 202, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 08:29:31', '2026-05-26 08:29:31');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (202, 202, 13, 1, 280000, 1, 280000, '2026-05-26 08:29:31', '2026-05-26 08:29:31');

-- Data for Laurensia Dini Marys Haryanto (dinimarys010304@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (203, 'Laurensia Dini Marys Haryanto', 'dinimarys010304@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 08:37:30', '2026-05-26 08:37:30');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (203, 'ORD-202605260004', 203, '2026-05-26', '2026-05-27', 1, 300000, 300000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 08:37:30', '2026-05-26 08:37:30');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (203, 203, 14, 1, 300000, 1, 300000, '2026-05-26 08:37:30', '2026-05-26 08:37:30');

-- Data for krismaria br munthe (munthe.2205551045@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (204, 'krismaria br munthe', 'munthe.2205551045@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 08:42:13', '2026-05-26 08:42:13');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (204, 'ORD-202605260005', 204, '2026-05-26', '2026-05-27', 1, 330000, 330000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 08:42:13', '2026-05-26 08:42:13');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (204, 204, 15, 1, 330000, 1, 330000, '2026-05-26 08:42:13', '2026-05-26 08:42:13');

-- Data for Komang Desi Riani (riani.2207511076@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (205, 'Komang Desi Riani', 'riani.2207511076@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 09:58:22', '2026-05-26 09:58:22');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (205, 'ORD-202605260006', 205, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 09:58:22', '2026-05-26 09:58:22');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (205, 205, 10, 1, 280000, 1, 280000, '2026-05-26 09:58:22', '2026-05-26 09:58:22');

-- Data for Dorteana elfin (dorteanae@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (206, 'Dorteana elfin', 'dorteanae@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 10:01:52', '2026-05-26 10:01:52');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (206, 'ORD-202605260007', 206, '2026-05-26', '2026-05-27', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 10:01:52', '2026-05-26 10:01:52');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (206, 206, 12, 1, 150000, 1, 150000, '2026-05-26 10:01:52', '2026-05-26 10:01:52');

-- Data for Ni Putu Risky Suantari (suantari.2207521063@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (207, 'Ni Putu Risky Suantari', 'suantari.2207521063@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 10:02:04', '2026-05-26 10:02:04');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (207, 'ORD-202605260008', 207, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 10:02:04', '2026-05-26 10:02:04');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (207, 207, 13, 1, 280000, 1, 280000, '2026-05-26 10:02:04', '2026-05-26 10:02:04');

-- Data for Ni Made Sumirati (sumiratinimade@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (208, 'Ni Made Sumirati', 'sumiratinimade@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 11:03:28', '2026-05-26 11:03:28');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (208, 'ORD-202605260009', 208, '2026-05-26', '2026-05-27', 1, 300000, 300000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 11:03:28', '2026-05-26 11:03:28');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (208, 208, 14, 1, 300000, 1, 300000, '2026-05-26 11:03:28', '2026-05-26 11:03:28');

-- Data for Ni Kadek Sinta Apriyani (apriyani.2207531182@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (209, 'Ni Kadek Sinta Apriyani', 'apriyani.2207531182@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 11:11:47', '2026-05-26 11:11:47');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (209, 'ORD-202605260010', 209, '2026-05-26', '2026-05-27', 1, 330000, 330000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 11:11:47', '2026-05-26 11:11:47');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (209, 209, 15, 1, 330000, 1, 330000, '2026-05-26 11:11:47', '2026-05-26 11:11:47');

-- Data for Ni Made Somawati (somawwy27@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (210, 'Ni Made Somawati', 'somawwy27@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 11:31:25', '2026-05-26 11:31:25');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (210, 'ORD-202605260011', 210, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 11:31:25', '2026-05-26 11:31:25');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (210, 210, 10, 1, 280000, 1, 280000, '2026-05-26 11:31:25', '2026-05-26 11:31:25');

-- Data for Nelvi Gissela Maria Surbakti (surbakti.2206541121@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (211, 'Nelvi Gissela Maria Surbakti', 'surbakti.2206541121@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 12:51:26', '2026-05-26 12:51:26');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (211, 'ORD-202605260012', 211, '2026-05-26', '2026-05-27', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 12:51:26', '2026-05-26 12:51:26');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (211, 211, 12, 1, 150000, 1, 150000, '2026-05-26 12:51:26', '2026-05-26 12:51:26');

-- Data for Sang Ayu Putu Apriliani (apriliani.2207511065@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (212, 'Sang Ayu Putu Apriliani', 'apriliani.2207511065@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 12:59:11', '2026-05-26 12:59:11');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (212, 'ORD-202605260013', 212, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 12:59:11', '2026-05-26 12:59:11');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (212, 212, 13, 1, 280000, 1, 280000, '2026-05-26 12:59:11', '2026-05-26 12:59:11');

-- Data for Johanes Fieldyo Ikun Bere (johanesdyo10@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (213, 'Johanes Fieldyo Ikun Bere', 'johanesdyo10@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 14:20:45', '2026-05-26 14:20:45');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (213, 'ORD-202605260014', 213, '2026-05-26', '2026-05-27', 1, 300000, 300000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 14:20:45', '2026-05-26 14:20:45');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (213, 213, 14, 1, 300000, 1, 300000, '2026-05-26 14:20:45', '2026-05-26 14:20:45');

-- Data for Theresia (coachnera1@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (214, 'Theresia', 'coachnera1@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 14:29:57', '2026-05-26 14:29:57');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (214, 'ORD-202605260015', 214, '2026-05-26', '2026-05-27', 1, 330000, 330000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 14:29:57', '2026-05-26 14:29:57');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (214, 214, 15, 1, 330000, 1, 330000, '2026-05-26 14:29:57', '2026-05-26 14:29:57');

-- Data for Paulus Herdyan Valentino (paulusherdyanvalentino110304@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (215, 'Paulus Herdyan Valentino', 'paulusherdyanvalentino110304@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 17:16:26', '2026-05-26 17:16:26');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (215, 'ORD-202605260016', 215, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 17:16:26', '2026-05-26 17:16:26');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (215, 215, 10, 1, 280000, 1, 280000, '2026-05-26 17:16:26', '2026-05-26 17:16:26');

-- Data for Gress Nola Siahaan (hugokasito@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (216, 'Gress Nola Siahaan', 'hugokasito@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 17:31:56', '2026-05-26 17:31:56');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (216, 'ORD-202605260017', 216, '2026-05-26', '2026-05-27', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 17:31:56', '2026-05-26 17:31:56');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (216, 216, 12, 1, 150000, 1, 150000, '2026-05-26 17:31:56', '2026-05-26 17:31:56');

-- Data for I Kade Adi Suka Pratama (pratama.2205571046@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (217, 'I Kade Adi Suka Pratama', 'pratama.2205571046@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 18:17:41', '2026-05-26 18:17:41');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (217, 'ORD-202605260018', 217, '2026-05-26', '2026-05-27', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 18:17:41', '2026-05-26 18:17:41');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (217, 217, 13, 1, 280000, 1, 280000, '2026-05-26 18:17:41', '2026-05-26 18:17:41');

-- Data for I Made Widi Angga Suputra (widisuputra@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (218, 'I Made Widi Angga Suputra', 'widisuputra@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-26 19:12:28', '2026-05-26 19:12:28');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (218, 'ORD-202605260019', 218, '2026-05-26', '2026-05-27', 1, 300000, 300000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-26 14:00:00', '2026-05-27 12:00:00', '2026-05-26 19:12:28', '2026-05-26 19:12:28');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (218, 218, 14, 1, 300000, 1, 300000, '2026-05-26 19:12:28', '2026-05-26 19:12:28');

-- Data for Muhammad Guslam Fajar (guslamfajar13@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (219, 'Muhammad Guslam Fajar', 'guslamfajar13@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-28 09:53:01', '2026-05-28 09:53:01');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (219, 'ORD-202605280020', 219, '2026-05-28', '2026-05-29', 1, 330000, 330000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-28 14:00:00', '2026-05-29 12:00:00', '2026-05-28 09:53:01', '2026-05-28 09:53:01');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (219, 219, 15, 1, 330000, 1, 330000, '2026-05-28 09:53:01', '2026-05-28 09:53:01');

-- Data for Maria Kristina Ngoe (mariakristinangoe@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (220, 'Maria Kristina Ngoe', 'mariakristinangoe@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-29 18:11:00', '2026-05-29 18:11:00');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (220, 'ORD-202605290021', 220, '2026-05-29', '2026-05-30', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-29 14:00:00', '2026-05-30 12:00:00', '2026-05-29 18:11:00', '2026-05-29 18:11:00');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (220, 220, 10, 1, 280000, 1, 280000, '2026-05-29 18:11:00', '2026-05-29 18:11:00');

-- Data for Ziauddin Sardar (muhammadsardar584@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (221, 'Ziauddin Sardar', 'muhammadsardar584@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-29 22:13:34', '2026-05-29 22:13:34');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (221, 'ORD-202605290022', 221, '2026-05-29', '2026-05-30', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-29 14:00:00', '2026-05-30 12:00:00', '2026-05-29 22:13:34', '2026-05-29 22:13:34');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (221, 221, 12, 1, 150000, 1, 150000, '2026-05-29 22:13:34', '2026-05-29 22:13:34');

-- Data for Marscheila Virghinie Arauna (115202302574@mhs.dinus.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (222, 'Marscheila Virghinie Arauna', '115202302574@mhs.dinus.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-29 22:14:42', '2026-05-29 22:14:42');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (222, 'ORD-202605290023', 222, '2026-05-29', '2026-05-30', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-29 14:00:00', '2026-05-30 12:00:00', '2026-05-29 22:14:42', '2026-05-29 22:14:42');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (222, 222, 13, 1, 280000, 1, 280000, '2026-05-29 22:14:42', '2026-05-29 22:14:42');

-- Data for Ulan Dermia (sumbayak.2207521205@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (223, 'Ulan Dermia', 'sumbayak.2207521205@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-29 22:33:00', '2026-05-29 22:33:00');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (223, 'ORD-202605290024', 223, '2026-05-29', '2026-05-30', 1, 300000, 300000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-05-29 14:00:00', '2026-05-30 12:00:00', '2026-05-29 22:33:00', '2026-05-29 22:33:00');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (223, 223, 14, 1, 300000, 1, 300000, '2026-05-29 22:33:00', '2026-05-29 22:33:00');

-- Data for Adventinus Putramaria Wiratama Meus (wiratamawiseshaput2@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (224, 'Adventinus Putramaria Wiratama Meus', 'wiratamawiseshaput2@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-29 22:40:54', '2026-05-29 22:40:54');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (224, 'ORD-202605290025', 224, '2026-05-29', '2026-05-30', 1, 330000, 330000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-05-29 14:00:00', '2026-05-30 12:00:00', '2026-05-29 22:40:54', '2026-05-29 22:40:54');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (224, 224, 15, 1, 330000, 1, 330000, '2026-05-29 22:40:54', '2026-05-29 22:40:54');

-- Data for Aldentus Jose Cupertino Dacosta (aldendacosta1142@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (225, 'Aldentus Jose Cupertino Dacosta', 'aldendacosta1142@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-05-31 16:38:48', '2026-05-31 16:38:48');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (225, 'ORD-202605310026', 225, '2026-05-31', '2026-06-01', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-05-31 14:00:00', '2026-06-01 12:00:00', '2026-05-31 16:38:48', '2026-05-31 16:38:48');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (225, 225, 10, 1, 280000, 1, 280000, '2026-05-31 16:38:48', '2026-05-31 16:38:48');

-- Data for Zola Fitra Fahlevi (fitrazola06@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (226, 'Zola Fitra Fahlevi', 'fitrazola06@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-06-01 14:18:46', '2026-06-01 14:18:46');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (226, 'ORD-202606010027', 226, '2026-06-01', '2026-06-02', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-06-01 14:00:00', '2026-06-02 12:00:00', '2026-06-01 14:18:46', '2026-06-01 14:18:46');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (226, 226, 12, 1, 150000, 1, 150000, '2026-06-01 14:18:46', '2026-06-01 14:18:46');

-- Data for Sekar ayu larasati (sekarayularasatu@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (227, 'Sekar ayu larasati', 'sekarayularasatu@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-06-01 14:59:58', '2026-06-01 14:59:58');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (227, 'ORD-202606010028', 227, '2026-06-01', '2026-06-02', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-06-01 14:00:00', '2026-06-02 12:00:00', '2026-06-01 14:59:58', '2026-06-01 14:59:58');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (227, 227, 13, 1, 280000, 1, 280000, '2026-06-01 14:59:58', '2026-06-01 14:59:58');

-- Data for Tarsisius Tarsan (tarsantarsisius001@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (228, 'Tarsisius Tarsan', 'tarsantarsisius001@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-06-01 15:04:32', '2026-06-01 15:04:32');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (228, 'ORD-202606010029', 228, '2026-06-01', '2026-06-02', 1, 300000, 300000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-06-01 14:00:00', '2026-06-02 12:00:00', '2026-06-01 15:04:32', '2026-06-01 15:04:32');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (228, 228, 14, 1, 300000, 1, 300000, '2026-06-01 15:04:32', '2026-06-01 15:04:32');

-- Data for Muhammad Uken Haru (ukenharu20@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (229, 'Muhammad Uken Haru', 'ukenharu20@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-06-02 02:11:58', '2026-06-02 02:11:58');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (229, 'ORD-202606020030', 229, '2026-06-02', '2026-06-03', 1, 330000, 330000, 'paid', 'checked_out', 'completed', 'card', 0, '2026-06-02 14:00:00', '2026-06-03 12:00:00', '2026-06-02 02:11:58', '2026-06-02 02:11:58');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (229, 229, 15, 1, 330000, 1, 330000, '2026-06-02 02:11:58', '2026-06-02 02:11:58');

-- Data for Agnestasya Sandrina Bartlen (bartlen.2208551042@student.unud.ac.id)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (230, 'Agnestasya Sandrina Bartlen', 'bartlen.2208551042@student.unud.ac.id', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-06-05 12:40:17', '2026-06-05 12:40:17');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (230, 'ORD-202606050031', 230, '2026-06-05', '2026-06-06', 1, 280000, 280000, 'paid', 'checked_out', 'completed', 'cash', 0, '2026-06-05 14:00:00', '2026-06-06 12:00:00', '2026-06-05 12:40:17', '2026-06-05 12:40:17');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (230, 230, 10, 1, 280000, 1, 280000, '2026-06-05 12:40:17', '2026-06-05 12:40:17');

-- Data for Flaviana Windya Bartlen (agnes070618@gmail.com)
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (231, 'Flaviana Windya Bartlen', 'agnes070618@gmail.com', '$2y$12$R.OsgW797uM15GleZl3bB.m1/gG2uW6sI8fLzC5kR2lD7U8m/LzN2', 'tamu', '2026-06-05 12:42:25', '2026-06-05 12:42:25');
INSERT INTO orders (id, order_code, user_id, check_in, check_out, nights, total_price, gross_amount, payment_status, booking_status, status, payment_method, is_walkin, checked_in_at, checked_out_at, created_at, updated_at) VALUES (231, 'ORD-202606050032', 231, '2026-06-05', '2026-06-06', 1, 150000, 150000, 'paid', 'checked_out', 'completed', 'bank_transfer', 0, '2026-06-05 14:00:00', '2026-06-06 12:00:00', '2026-06-05 12:42:25', '2026-06-05 12:42:25');
INSERT INTO order_items (id, order_id, room_id, qty, price_per_night, nights, subtotal, created_at, updated_at) VALUES (231, 231, 12, 1, 150000, 1, 150000, '2026-06-05 12:42:25', '2026-06-05 12:42:25');

COMMIT;
