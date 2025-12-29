-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 02 Des 2025 pada 00.33
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ransum`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `image`, `author_id`, `category_id`, `status`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Presiden Umumkan Kebijakan Baru', 'presiden-umumkan-kebijakan-baru', 'Presiden hari ini mengumumkan kebijakan baru terkait investasi asing...', 'images/politik1.jpg', 2, 1, 'published', 150, '2025-10-02 17:12:04', '2025-11-30 15:12:34'),
(2, 'Timnas Indonesia Menang 3-0', 'timnas-indonesia-menang-3-0', 'Pertandingan persahabatan berakhir dengan skor 3-0 untuk Timnas Indonesia...', 'images/olahraga1.jpg', 2, 2, 'published', 320, '2025-10-02 17:12:04', '2025-11-30 15:12:38'),
(3, 'AI Mulai Dipakai di Perusahaan Lokal', 'ai-mulai-dipakai-perusahaan-lokal', 'Perusahaan-perusahaan di Indonesia mulai memanfaatkan AI untuk efisiensi...', 'images/teknologi1.jpg', 2, 3, 'published', 210, '2025-10-02 17:12:04', '2025-11-30 15:12:43'),
(4, 'Film Terbaru Marvel Pecahkan Rekor', 'film-terbaru-marvel-pecahkan-rekor', 'Film terbaru Marvel berhasil meraih pendapatan tertinggi minggu ini...', 'images/hiburan1.jpg', 2, 4, 'published', 500, '2025-10-02 17:12:04', '2025-11-30 15:12:48'),
(5, 'Ekonomi Indonesia Tumbuh 5%', 'ekonomi-indonesia-tumbuh-5', 'Data terbaru menunjukkan ekonomi Indonesia tumbuh sebesar 5% di kuartal ini...', 'images/ekonomi1.jpg', 2, 5, 'published', 180, '2025-10-02 17:12:04', '2025-11-30 15:12:52'),
(26, 'Kemendikdasmen Sebut Ada 1.009 Satuan Pendidikan Terdampak Bencana Di Aceh Sumut Sumbar', 'kemendikdasmen-sebut-ada-1009-satuan-pendidikan-terdampak-bencana-di-aceh-sumut-sumbar', '<p>Kemendikdasmen membuat sekolah darurat di beberapa titik bencana di 3 provinsi</p>\r\n<p>inijabar.com, Jakarta&ndash; Duka akibat bencana di tiga provinsi yakni Aceh, Sumatera Utara (Sumut), dan Sumatra Barat (Sumbar), berdampak luar biasa terhadap kehidupan masyarakat.&nbsp;</p>\r\n<p>Selain kerusakan bangunan, jatuhnya korban jiwa, dan hilangnya harta benda, nasib para korban musibah banjir diperparah dengan putusnya akses transportasi dan telekomunikasi selama lima hari pasca kejadian.</p>\r\n<p>Menteri Pendidikan Dasar dan Menengah (Mendikdasmen), Abdul Mu&rsquo;ti, mengatakan,&nbsp; akan terus berupaya melakukan mitigasi dan pemetaan, untuk memastikan kegiatan belajar-mengajar bagi para murid di daerah yang terdampak banjir dapat tetap dapat berjalan.&nbsp;</p>', 'image/zXssfYbN4T3BGh9KDUWjrPtuc6xw6FxTikLhHOUv.jpg', 1, 10, 'published', 0, '2025-11-30 15:35:40', '2025-11-30 16:26:11'),
(27, 'Kepala BNPB: Korban Meninggal Dunia Atas Bencana Hidrometeorologi Aceh, Sumut dan Sumbar Jadi 303 Jiwa', 'kepala-bnpb-korban-meninggal-dunia-atas-bencana-hidrometeorologi-aceh-sumut-dan-sumbar-jadi-303-jiwa', '<p>SILANGIT - Badan Nasional Penanggulangan Bencana (BNPB) bersama seluruh unsur pemerintah daerah, TNI, Polri, dan para relawan terus melakukan penanganan darurat bencana yang melanda sejumlah wilayah di Sumatera Utara, Aceh, dan Sumatera Barat. Penanganan darurat yang dipimpin langsung oleh Kepala BNPB Letjen TNI Dr. Suharyanto S.Sos., M.M ini difokuskan pada pencarian dan pertolongan korban, pemenuhan kebutuhan dasar pengungsi, pembukaan akses wilayah terisolir, serta percepatan distribusi logistik, baik melalui darat maupun udara.</p>\r\n<p>Pada hari ketiga setelah penetapan status tanggap darurat bencana di Provinsi Sumatera Utara, tercatat 166 korban meninggal dunia dan 143 orang masih dinyatakan hilang. Dampak terbesar terjadi di Kabupaten Tapanuli Tengah, Tapanuli Selatan, dan Kota Sibolga.</p>\r\n<p>&ldquo;Sumatra Utara sekarang menjadi 166 jiwa meninggal dunia. Dalam satu hari ini bertambah 60 korban jiwa berkat operasi pencarian dan pertolongan oleh tim gabungan yang dipimpin oleh Basarnas. Kemudian ada 103 jiwa yang masih hilang,&rdquo; ungkap Suharyanto, Sabtu (29/11).</p>\r\n<p>Sementara itu, ribuan warga mengungsi di berbagai titik akibat kondisi permukiman yang rusak dan akses yang terputus. Jumlah pengungsi mencapai ribuan jiwa di Tapanuli Selatan dan Kota Sibolga, serta ratusan hingga ribuan kepala keluarga di Mandailing Natal, Tapanuli Utara, dan Humbang Hasundutan.</p>\r\n<p>Akses transportasi di wilayah ini banyak mengalami kerusakan. Jalur nasional Sibolga&ndash;Padang Sidempuan serta Sibolga&ndash;Tarutung mengalami putus total dan tertutup longsor di banyak titik. Beberapa jembatan termasuk Jembatan Pandan dan jembatan pada ruas Sibolga&ndash;Manduamas, juga terputus.</p>\r\n<p>Sejumlah jalur kabupaten turut terputus dan belum dapat diperbaiki karena medan yang berat. Di Mandailing Natal, sedikitnya tujuh wilayah terisolir akibat tertutupnya jalur lintas provinsi, sementara beberapa desa hanya bisa dijangkau menggunakan alat berat atau transportasi udara.</p>\r\n<p>Untuk mempercepat penanganan, BNPB dan kementerian/lembaga telah mengerahkan berbagai alutsista, termasuk lima helikopter perbantuan yang ditempatkan di Bandara Silangit untuk distribusi logistik ke Tapanuli Tengah dan wilayah lain yang terisolasi.</p>\r\n<p>&ldquo;Seperti Sibolga sampai hari ketiga penanganan darurat belum bisa kita tembus lewat udara, tapi sudah bisa kita capai melalui udara untuk pendistribusian logistik,&rdquo; kata Suharyanto.</p>\r\n<p>Helikopter BNPB, Heli TNI AD Bell 412EPI, MI-17V5 dan helikopter bantuan mitra swasta telah beroperasi aktif mendukung pendistribusian bantuan. Selain itu, pesawat Cessna Caravan juga digunakan untuk pengiriman logistik dan personel.</p>\r\n<p>Alat berat dari berbagai instansi telah dikerahkan untuk membuka akses jalan. Dalam hal logistik, tahap pertama pengiriman ke Tapanuli Tengah, Tapanuli Selatan, Tapanuli Utara, dan Humbang Hasundutan telah terpenuhi 100 persen, sementara pengiriman ke Mandailing Natal masih terkendala akses darat. Bantuan Presiden berupa alat komunikasi, genset, LCR, tenda, dan bahan pangan juga telah diterima dan didistribusikan bertahap.</p>\r\n<p>\"Untuk transportasi Sibolga-Padang Sidempuan sudah kita lakukan pengerjaan pembukaan hingga sore hari ini dan seterusnya,&rdquo; jelas Kepala BNPB.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Korban Meninggal Dunia di Aceh 47 Jiwa</strong></p>\r\n<p>Pada hari kedua pascapenetapan status tanggap darurat bencana di Provinsi Aceh, ada sebanyak 47 korban meninggal dunia, 51 orang hilang, serta 8 orang luka-luka. Jumlah pengungsi mencapai 48.887 kepala keluarga yang tersebar di berbagai wilayah, dengan sebaran tertinggi di Aceh Utara, Bener Meriah, Aceh Tengah, dan Aceh Singkil.</p>\r\n<p>&ldquo;Untuk wilayah Aceh ada 47, kemudian 51 masih hilang dan 8 luka-luka. Ini akan berkembang terus datanya, karena ada operasi SAR gabungan yang kemungkinan akan terus menemukan korban,&rdquo; terang Suharyanto.</p>\r\n<p>Banyaknya kerusakan jembatan dan jalan nasional berdampak pada terputusnya akses utama, termasuk jalur Banda Aceh&ndash;Lhokseumawe serta jalur perbatasan Aceh&ndash;Sumatera Utara di Aceh Tamiang. Hingga kini, beberapa daerah seperti Gayo Lues, Aceh Tengah, dan Bener Meriah masih belum dapat diakses melalui jalur darat.</p>\r\n<p>BNPB telah mengaktifkan dukungan komunikasi darurat menggunakan jaringan satelit Starlink di sejumlah titik, terutama di wilayah yang terisolir jaringan. Pengiriman logistik dilakukan melalui udara menggunakan helikopter dan pesawat Cessna Caravan untuk menjangkau daerah yang tidak dapat diakses melalui jalur darat.</p>\r\n<p>Bantuan Presiden berupa alat komunikasi, tenda, genset, perahu karet, makanan siap saji, dan perlengkapan keluarga telah tiba di Aceh dan sebagian besar telah didistribusikan ke 17 kabupaten/kota terdampak. Dua helikopter BNPB juga telah dikerahkan dari Bandara Sultan Iskandar Muda untuk mendukung distribusi ke titik-titik kritis.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Di Sumatra Barat, Korban Meninggal Dunia 90 Jiwa</strong></p>\r\n<p>Sementara itu, dua hari setelah penetapan status tanggap darurat bencana di Provinsi Sumatera Barat, tercatat 90 korban meninggal dunia, 85 orang hilang, dan 10 orang mengalami luka-luka. Kabupaten Agam mencatat jumlah korban tertinggi.</p>\r\n<p>&ldquo;Korban jiwanya ada 90 yang meninggal dunia, 85 hilang dan 10 luka-luka,&rdquo; jelas Suharyanto.</p>\r\n<p>Data sementara menunjukkan sebanyak 11.820 kepala keluarga atau sekitar 77.918 jiwa mengungsi, terutama di Kota Padang dan Kabupaten Pesisir Selatan. Sejumlah jalur provinsi dan nasional terputus akibat longsor dan kerusakan jembatan, sehingga menyulitkan akses distribusi. Meski demikian, logistik dari Padang Pariaman dan Pesisir Selatan telah tiba, dan delapan titik tambahan dalam proses pengiriman dengan pengawalan kepolisian.</p>\r\n<p>BNPB telah menempatkan 24 personel untuk mendampingi percepatan penanganan di Sumatera Barat. Bantuan darurat dari Presiden RI berupa alat komunikasi, genset, tenda, LCR, dan ribuan dus makanan siap saji telah tiba di Bandara Minangkabau. Pesawat Caravan serta helikopter Bell 505 juga telah digerakkan untuk mendukung distribusi ke wilayah yang belum dapat diakses melalui darat.</p>\r\n<p>BNPB memastikan seluruh upaya penanganan darurat terus dipercepat melalui koordinasi erat dengan pemerintah daerah, kementerian/lembaga, TNI, Polri, dan para relawan. Percepatan pembukaan akses, pendataan lanjutan korban dan kerusakan, serta pemenuhan kebutuhan dasar warga terdampak menjadi prioritas utama operasi penanganan bencana di tiga provinsi tersebut.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Abdul Muhari, Ph.D.</p>\r\n<p>Kepala Pusat Data, Informasi dan Komunikasi Kebencanaan BNPB</p>', 'image/e5uUGlScQuu946SwfDVfQmvFVz1uWJjO9DjHMjG6.webp', 1, 10, 'published', 0, '2025-11-30 16:25:05', '2025-11-30 16:27:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `article_tags`
--

CREATE TABLE `article_tags` (
  `id` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `tag_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `article_tags`
--

INSERT INTO `article_tags` (`id`, `article_id`, `tag_id`) VALUES
(9, 1, 1),
(10, 2, 1),
(11, 2, 2),
(12, 3, 1),
(13, 3, 3),
(14, 3, 5),
(15, 4, 4),
(16, 5, 1),
(17, 27, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Politik', 'politik', '2025-10-02 16:54:10', '2025-10-02 16:54:10'),
(2, 'Olahraga', 'olahraga', '2025-10-02 16:54:10', '2025-10-02 16:54:10'),
(3, 'Teknologi', 'teknologi', '2025-10-02 16:54:10', '2025-10-02 16:54:10'),
(9, 'Hiburan', 'hiburan', '2025-10-02 17:07:57', '2025-10-02 17:07:57'),
(10, 'Ekonomi', 'ekonomi', '2025-10-02 17:07:57', '2025-10-02 17:07:57'),
(12, 'Wisata', 'wisata', '2025-11-30 10:24:45', '2025-11-30 12:53:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Semoga kebijakan ini membawa dampak positif.', 'approved', '2025-10-02 17:13:43', '2025-10-02 17:13:43'),
(2, 2, 1, 'Keren banget Timnas mainnya!', 'approved', '2025-10-02 17:13:43', '2025-10-02 17:13:43'),
(3, 3, 1, 'AI memang masa depan industri.', 'approved', '2025-10-02 17:13:43', '2025-10-02 17:13:43'),
(4, 4, 1, 'Filmnya wajib nonton, efeknya keren.', 'approved', '2025-10-02 17:13:43', '2025-10-02 17:13:43'),
(5, 5, 1, 'Semoga pertumbuhan ini berkelanjutan.', 'pending', '2025-10-02 17:13:43', '2025-10-02 17:13:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `featured`
--

CREATE TABLE `featured` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `media`
--

CREATE TABLE `media` (
  `id` bigint(20) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `uploaded_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'Portal Berita Sumut'),
(2, 'site_description', 'Menyajikan berita terbaru, akurat, dan terpercaya.'),
(3, 'logo', 'uploads/logo.png'),
(4, 'contact_email', 'redaksi@portalnusantara.com'),
(5, 'facebook_url', 'https://facebook.com/portalnusantara'),
(6, 'twitter_url', 'https://twitter.com/portalnusantara'),
(7, 'instagram_url', '#'),
(8, 'linkedin_url', '#'),
(9, 'youtube_url', '#');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Indonesia', 'indonesia', '2025-10-02 16:54:10', '2025-10-02 16:54:10'),
(2, 'Sepak Bola', 'sepak-bola', '2025-10-02 16:54:10', '2025-10-02 16:54:10'),
(3, 'AI', 'ai', '2025-10-02 16:54:10', '2025-10-02 16:54:10'),
(9, 'Film', 'film', '2025-10-02 17:08:11', '2025-10-02 17:08:11'),
(10, 'Startup', 'startup', '2025-10-02 17:08:11', '2025-10-02 17:08:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Editor','Jurnalis','Pembaca','Staff') DEFAULT 'Pembaca',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Admin Portal', 'admin@gmail.com', '$2y$10$.zyv.mN4ewS36HGJcBDXWua88yylf2MwZRK3603IZfRfoNZhJEvHy', 'Admin', NULL, '2025-10-02 16:54:10', '2025-10-07 17:41:15'),
(2, 'Jurnalis A', 'jurnalis@news.com', '$2y$10$.zyv.mN4ewS36HGJcBDXWua88yylf2MwZRK3603IZfRfoNZhJEvHy', 'Jurnalis', NULL, '2025-10-02 16:54:10', '2025-10-02 17:14:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `article_tags`
--
ALTER TABLE `article_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `featured`
--
ALTER TABLE `featured`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indeks untuk tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `article_tags`
--
ALTER TABLE `article_tags`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `featured`
--
ALTER TABLE `featured`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
