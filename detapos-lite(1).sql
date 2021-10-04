-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2020 at 07:39 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `detapos-lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `setting_app`
--

CREATE TABLE `setting_app` (
  `id_setting` int(11) NOT NULL,
  `nama_toko` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `provinsi` int(11) NOT NULL,
  `kota` varchar(25) NOT NULL,
  `no_telpon` text NOT NULL,
  `email_toko` varchar(30) NOT NULL,
  `logo` text NOT NULL,
  `header` varchar(50) NOT NULL,
  `barcode` varchar(128) NOT NULL,
  `struk` varchar(128) NOT NULL,
  `zona` varchar(128) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_app`
--

INSERT INTO `setting_app` (`id_setting`, `nama_toko`, `alamat`, `provinsi`, `kota`, `no_telpon`, `email_toko`, `logo`, `header`, `barcode`, `struk`, `zona`, `token`) VALUES
(29, 'Garfield Petshop', 'Jl. H. B Jassin No. 107 Kota Gorontalo', 7, '130', '082188811161', 'regitasml@gmail.com', 'LOGO1.png', '', 'standart', 'biasa', 'Asia/Hong_Kong', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_akun`
--

CREATE TABLE `tb_akun` (
  `id_akun` int(11) NOT NULL,
  `kode_akun` varchar(32) NOT NULL,
  `nama_akun` varchar(256) NOT NULL,
  `kategori` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_akun`
--

INSERT INTO `tb_akun` (`id_akun`, `kode_akun`, `nama_akun`, `kategori`, `token`) VALUES
(43, '111', 'Kas', 'HL', 'DPVL3N5K7VYF7ZSR'),
(44, '411', 'Pendapatan', 'HT', 'DPVL3N5K7VYF7ZSR'),
(47, '213', 'ewq', 'HL', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_alert`
--

CREATE TABLE `tb_alert` (
  `kd_alert` int(11) NOT NULL,
  `sapaan` varchar(128) NOT NULL,
  `control` varchar(50) NOT NULL,
  `kalimat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_alert`
--

INSERT INTO `tb_alert` (`kd_alert`, `sapaan`, `control`, `kalimat`) VALUES
(1, 'Mohon Maaf!', 'Not Aktiv', 'Se-Malam Kami Melakukan Perubahan Sistem, Jika Ada Yang Kurang Di Mengerti Bisa Kontak Nomor Technical Support Kami. Terimakasih');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(64) NOT NULL,
  `nama_barang` varchar(225) NOT NULL,
  `slug` text DEFAULT NULL,
  `berat` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_input` date DEFAULT NULL,
  `tgl_tempo` date DEFAULT NULL,
  `harga_beli` int(50) DEFAULT NULL,
  `harga_jual` int(50) DEFAULT NULL,
  `persen` int(50) DEFAULT NULL,
  `profit` int(50) DEFAULT NULL,
  `harga_jual1` int(15) DEFAULT NULL,
  `persen1` int(15) DEFAULT NULL,
  `profit1` int(15) DEFAULT NULL,
  `harga_jual2` int(15) DEFAULT NULL,
  `persen2` int(15) DEFAULT NULL,
  `profit2` int(15) DEFAULT NULL,
  `id_kategori` char(30) DEFAULT NULL,
  `jml_stok` int(11) DEFAULT NULL,
  `minimal_stok` int(11) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `isi` int(15) DEFAULT NULL,
  `satuan1` varchar(25) DEFAULT NULL,
  `isi1` int(15) DEFAULT NULL,
  `satuan2` varchar(25) DEFAULT NULL,
  `isi2` int(15) DEFAULT NULL,
  `satuan3` varchar(25) DEFAULT NULL,
  `isi3` int(15) DEFAULT NULL,
  `kode_supplier` varchar(30) DEFAULT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `kode_barang`, `nama_barang`, `slug`, `berat`, `deskripsi`, `tgl_input`, `tgl_tempo`, `harga_beli`, `harga_jual`, `persen`, `profit`, `harga_jual1`, `persen1`, `profit1`, `harga_jual2`, `persen2`, `profit2`, `id_kategori`, `jml_stok`, `minimal_stok`, `satuan`, `isi`, `satuan1`, `isi1`, `satuan2`, `isi2`, `satuan3`, `isi3`, `kode_supplier`, `token`) VALUES
(7615, 'TJ001', 'The Javana', 'teh-javana', '150', '&lt;p&gt;tidak ada&lt;/p&gt;\r\n', '2020-11-21', '0000-00-00', 1000, 2000, 100, 1000, 4000, 300, 3000, 6000, 500, 5000, 'Pilih...', 49, 5, 'Botol', 1, 'Botol', 1, 'Botol', 1, 'Botol', 1, NULL, 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang_tmp`
--

CREATE TABLE `tb_barang_tmp` (
  `kd_barang_tmp` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `file_size` varchar(32) DEFAULT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_checkout`
--

CREATE TABLE `tb_checkout` (
  `kd_checkout` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` text NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `kode_unik` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `no_wa` varchar(15) NOT NULL,
  `email` varchar(128) NOT NULL,
  `provinsi` varchar(128) NOT NULL,
  `kota` varchar(128) NOT NULL,
  `kecamatan` varchar(128) NOT NULL,
  `ekspedisi` varchar(50) NOT NULL,
  `paket` varchar(25) NOT NULL,
  `ongkir` varchar(15) NOT NULL,
  `estimasi` varchar(15) NOT NULL,
  `gran_total` varchar(50) NOT NULL,
  `berat` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `kode_pos` varchar(8) NOT NULL,
  `status` int(11) NOT NULL,
  `status_bayar` int(1) NOT NULL,
  `no_resi` varchar(128) NOT NULL,
  `waktu` datetime NOT NULL,
  `waktu_proses` datetime DEFAULT NULL,
  `waktu_kirim` datetime DEFAULT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_checkout`
--

INSERT INTO `tb_checkout` (`kd_checkout`, `order_id`, `kode_barang`, `nama_barang`, `harga_jual`, `qty`, `total`, `kode_unik`, `nama_lengkap`, `no_wa`, `email`, `provinsi`, `kota`, `kecamatan`, `ekspedisi`, `paket`, `ongkir`, `estimasi`, `gran_total`, `berat`, `alamat`, `kode_pos`, `status`, `status_bayar`, `no_resi`, `waktu`, `waktu_proses`, `waktu_kirim`, `token`) VALUES
(141, 1641505190, 'TJ001', 'adfsfsadf', 2312321, 1, 2311431, 890, 'adfsa', '32123232213213', 'fadlan642@gmail.com', 'Jambi', 'Merangin', 'Pamenang Barat', 'jne', 'Layanan Reguler', '107000', '2-3 Hari', '2418431', 12, 'asdsadsa', '13222', 4, 1, 'MDN74465124', '2020-11-14 09:46:52', '2020-11-20 11:02:54', '2020-11-20 11:03:09', 'DPVL3N5K7VYF7ZSR'),
(142, 1404105430, 'TJ001', 'adfsfsadf', 2312321, 1, 2311746, 575, 'adfsa', '1424234323423', 'fadlan642@gmail.com', 'Gorontalo', 'Gorontalo', 'Bongomeme', 'jne', 'Layanan Reguler', '119000', '6-7 Hari', '2430746', 12, 'asdasd', '12312', 4, 1, 'GTLO1230002219', '2020-11-10 09:17:42', '2020-11-13 11:49:46', '2020-11-14 09:23:40', 'DPVL3N5K7VYF7ZSR'),
(143, 1117741657, 'TJ001', 'adfsfsadf', 2312321, 1, 2311429, 892, 'asdfas', '214234424124', 'fadlan642@gmail.com', 'DI Yogyakarta', 'Kulon Progo', 'Lendah', 'jne', 'Ongkos Kirim Ekonomis', '80000', '3-4 Hari', '2391429', 12, 'adfads', '43213', 4, 1, 'IDN45572156', '2020-11-10 15:34:34', '2020-11-18 12:15:16', '2020-11-14 10:03:59', 'DPVL3N5K7VYF7ZSR'),
(144, 1584895824, 'TJ001', 'adfsfsadf', 2312321, 1, 2311824, 497, 'asd', '78954547745687', 'fadlan642@gmail.com', 'Bengkulu', 'Bengkulu Utara', 'Ketahun', 'jne', 'Layanan Reguler', '119000', '6-7 Hari', '2430824', 12, 'dsada', '1232', 4, 1, 'EWE78132562', '2020-11-11 12:26:31', '2020-11-19 12:14:19', '2020-11-21 10:13:57', 'DPVL3N5K7VYF7ZSR'),
(145, 256367956, 'TJ001', 'The Javana', 2000, 1, 1708, 292, 'asdflksjaf', '0892130923929', 'fadlan642@gmail.com', 'Jawa Tengah', 'Blora', 'Cepu', 'jne', 'Layanan Reguler', '119000', '6-7 Hari', '120708', 150, 'asdfsfdsa sdsdfsds sdsdfds dssds ', '1231', 2, 1, '', '2020-11-23 08:16:29', '2020-11-23 12:13:03', NULL, 'DPVL3N5K7VYF7ZSR'),
(146, 586194397, 'TJ001', 'The Javana', 2000, 1, 1485, 515, 'hjkakjdhsfkj', '6545321323545', 'fadlan642@gmail.com', 'DKI Jakarta', 'Jakarta Selatan', 'Mampang Prapatan', 'tiki', 'Regular Service', '139000', '3 Hari', '140485', 150, 'asdasdas', '13221', 1, 2, '', '2020-11-23 10:48:24', NULL, NULL, 'DPVL3N5K7VYF7ZSR');

--
-- Triggers `tb_checkout`
--
DELIMITER $$
CREATE TRIGGER `after_insert_checkout` AFTER INSERT ON `tb_checkout` FOR EACH ROW BEGIN
	INSERT INTO tb_log(deskripsi, timestmp, token) 
	VALUES(CONCAT("<span class='text-primary'>Berhasil melakukan transaksi penjualan dengan nomor order : </span>", NEW.order_id), NEW.waktu, NEW.token);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_barang` BEFORE INSERT ON `tb_checkout` FOR EACH ROW BEGIN
UPDATE tb_barang SET jml_stok = jml_stok-NEW.qty
WHERE kode_barang = NEW.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_checkout_terima`
--

CREATE TABLE `tb_checkout_terima` (
  `kd_checkout_terima` int(11) NOT NULL,
  `order_id` varchar(128) NOT NULL,
  `no_resi` varchar(255) NOT NULL,
  `ulasan` text NOT NULL,
  `bukti_terima` varchar(255) NOT NULL,
  `timee` datetime NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_checkout_terima`
--

INSERT INTO `tb_checkout_terima` (`kd_checkout_terima`, `order_id`, `no_resi`, `ulasan`, `bukti_terima`, `timee`, `token`) VALUES
(173, '1404105430', 'GTLO1230002219', '', '', '2020-11-20 09:11:16', 'DPVL3N5K7VYF7ZSR'),
(174, '1117741657', 'IDN45572156', '', '', '0000-00-00 00:00:00', 'DPVL3N5K7VYF7ZSR'),
(175, '1584895824', 'EWE78132562', 'okey', 'Fadhlan.png', '2020-11-21 09:21:39', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_checkout_tmp`
--

CREATE TABLE `tb_checkout_tmp` (
  `kd_checkout_tmp` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `transfer_ke` varchar(50) NOT NULL,
  `tgl_transfer` date NOT NULL,
  `jml_transfer` varchar(128) NOT NULL,
  `bukti_transfer` text NOT NULL,
  `timee` datetime NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_checkout_tmp`
--

INSERT INTO `tb_checkout_tmp` (`kd_checkout_tmp`, `order_id`, `nama`, `transfer_ke`, `tgl_transfer`, `jml_transfer`, `bukti_transfer`, `timee`, `token`) VALUES
(11, '1641505190', 'fadlan', '12', '2020-11-11', '2418431', 'Desain_Kaos_Vektor.png', '2020-11-10 14:08:43', 'DPVL3N5K7VYF7ZSR'),
(12, '1404105430', 'asdasd', '18', '2020-11-10', '2430746', 'Family1.png', '2020-11-10 14:31:19', 'DPVL3N5K7VYF7ZSR'),
(13, '256367956', 'kljalkdjsf', '12', '2020-11-23', '120708', 'Fadhlan.png', '2020-11-23 08:17:11', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_pembelian`
--

CREATE TABLE `tb_detail_pembelian` (
  `kd_pembelian` int(11) NOT NULL,
  `no_faktur` varchar(128) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `harga_beli` double(10,2) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `harga_jual` double(10,2) NOT NULL,
  `petugas` varchar(11) NOT NULL,
  `timee` datetime NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_detail_pembelian`
--

INSERT INTO `tb_detail_pembelian` (`kd_pembelian`, `no_faktur`, `kode_barang`, `harga_beli`, `jumlah`, `harga_jual`, `petugas`, `timee`, `token`) VALUES
(354, '68', 'TJ001', 1000.00, 3, 2000.00, 'detapos', '2020-12-02 12:37:24', 'DPVL3N5K7VYF7ZSR');

--
-- Triggers `tb_detail_pembelian`
--
DELIMITER $$
CREATE TRIGGER `after_insert_delete_tmp1` AFTER INSERT ON `tb_detail_pembelian` FOR EACH ROW BEGIN
	DELETE FROM tb_detail_pembelian_tmp 
    WHERE kode_barang = NEW.kode_barang
    AND petugas = NEW.petugas;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update` AFTER INSERT ON `tb_detail_pembelian` FOR EACH ROW BEGIN
UPDATE tb_barang SET jml_stok=jml_stok+NEW.jumlah
WHERE kode_barang=NEW.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_pembelian_tmp`
--

CREATE TABLE `tb_detail_pembelian_tmp` (
  `id_pembelian` int(11) NOT NULL,
  `kode_barang` varchar(256) NOT NULL,
  `nama_barang` text NOT NULL,
  `harga_beli` double(10,2) NOT NULL,
  `harga_jual` varchar(128) NOT NULL,
  `jumlah` char(24) NOT NULL,
  `petugas` varchar(128) NOT NULL,
  `timee` datetime NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_penjualan`
--

CREATE TABLE `tb_detail_penjualan` (
  `kd_penjualan` int(11) NOT NULL,
  `no_transaksi` varchar(128) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `modal` double(10,2) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `qty` int(4) NOT NULL,
  `harga` double(10,2) NOT NULL,
  `potongan` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `petugas` varchar(11) NOT NULL,
  `timee` datetime NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_detail_penjualan`
--

INSERT INTO `tb_detail_penjualan` (`kd_penjualan`, `no_transaksi`, `kode_barang`, `modal`, `tgl_penjualan`, `qty`, `harga`, `potongan`, `total`, `petugas`, `timee`, `token`) VALUES
(342, 'DP19112000001', 'TJ001', 1000.00, '2020-11-19', 2, 2000.00, 0.00, 0.00, 'detapos', '2020-11-19 09:16:02', 'DPVL3N5K7VYF7ZSR');

--
-- Triggers `tb_detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `Update_stok` BEFORE INSERT ON `tb_detail_penjualan` FOR EACH ROW BEGIN
UPDATE tb_barang SET jml_stok = jml_stok-NEW.qty
WHERE kode_barang = NEW.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_delete_tmp` AFTER INSERT ON `tb_detail_penjualan` FOR EACH ROW BEGIN
	DELETE FROM tb_detail_penjualan_tmp 
	WHERE kode_barang = NEW.kode_barang 
	AND petugas = NEW.petugas;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_penjualan_tmp`
--

CREATE TABLE `tb_detail_penjualan_tmp` (
  `id_penjualan` int(11) NOT NULL,
  `kode_barang` varchar(256) NOT NULL,
  `nama_barang` text NOT NULL,
  `modal` double(10,2) NOT NULL,
  `harga` varchar(128) NOT NULL,
  `qty` char(24) NOT NULL,
  `potongan` varchar(10) NOT NULL,
  `petugas` varchar(128) NOT NULL,
  `timee` datetime NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--

CREATE TABLE `tb_jurnal` (
  `id_jurnal` int(11) NOT NULL,
  `no_jurnal` varchar(128) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tipe` varchar(2) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jurnal`
--

INSERT INTO `tb_jurnal` (`id_jurnal`, `no_jurnal`, `id_akun`, `nominal`, `tipe`, `token`) VALUES
(94, 'JU05102000001', 43, 8000, 'D', 'DPVL3N5K7VYF7ZSR'),
(95, 'JU05102000001', 44, 8000, 'K', 'DPVL3N5K7VYF7ZSR'),
(96, 'JU06102000001', 43, 4000, 'D', 'DPVL3N5K7VYF7ZSR'),
(97, 'JU06102000001', 44, 4000, 'K', 'DPVL3N5K7VYF7ZSR'),
(98, 'JU06102000002', 43, 11000, 'D', 'DPVL3N5K7VYF7ZSR'),
(99, 'JU06102000002', 44, 11000, 'K', 'DPVL3N5K7VYF7ZSR'),
(100, 'JU06102000003', 43, 11000, 'D', 'DPVL3N5K7VYF7ZSR'),
(101, 'JU06102000003', 44, 11000, 'K', 'DPVL3N5K7VYF7ZSR'),
(102, 'JU06102000004', 43, 5990, 'D', 'DPVL3N5K7VYF7ZSR'),
(103, 'JU06102000004', 44, 5990, 'K', 'DPVL3N5K7VYF7ZSR'),
(104, 'JU06102000005', 43, 5980, 'D', 'DPVL3N5K7VYF7ZSR'),
(105, 'JU06102000005', 44, 5980, 'K', 'DPVL3N5K7VYF7ZSR'),
(106, 'JU03112000001', 43, 500000, 'D', 'DPVL3N5K7VYF7ZSR'),
(107, 'JU03112000001', 44, 500000, 'K', 'DPVL3N5K7VYF7ZSR'),
(108, 'JU03112000002', 43, 540000, 'D', 'DPVL3N5K7VYF7ZSR'),
(109, 'JU03112000002', 44, 540000, 'K', 'DPVL3N5K7VYF7ZSR'),
(110, 'JU03112000003', 43, 642626, 'D', 'DPVL3N5K7VYF7ZSR'),
(111, 'JU03112000003', 44, 642626, 'K', 'DPVL3N5K7VYF7ZSR'),
(112, 'JU03112000004', 43, 84000, 'D', 'DPVL3N5K7VYF7ZSR'),
(113, 'JU03112000004', 44, 84000, 'K', 'DPVL3N5K7VYF7ZSR'),
(114, 'JU03112000005', 43, 963939, 'D', 'DPVL3N5K7VYF7ZSR'),
(115, 'JU03112000005', 44, 963939, 'K', 'DPVL3N5K7VYF7ZSR'),
(116, 'JU03112000006', 43, 700000, 'D', 'DPVL3N5K7VYF7ZSR'),
(117, 'JU03112000006', 44, 700000, 'K', 'DPVL3N5K7VYF7ZSR'),
(118, 'JU05112000001', 43, 504000, 'D', 'DPVL3N5K7VYF7ZSR'),
(119, 'JU05112000001', 44, 504000, 'K', 'DPVL3N5K7VYF7ZSR'),
(120, 'JU07112000001', 43, 40000, 'D', 'DPVL3N5K7VYF7ZSR'),
(121, 'JU07112000001', 44, 40000, 'K', 'DPVL3N5K7VYF7ZSR'),
(122, 'JU07112000002', 43, 200000, 'D', 'DPVL3N5K7VYF7ZSR'),
(123, 'JU07112000002', 44, 200000, 'K', 'DPVL3N5K7VYF7ZSR'),
(124, 'JU09112000001', 43, 200000, 'D', 'DPVL3N5K7VYF7ZSR'),
(125, 'JU09112000001', 44, 200000, 'K', 'DPVL3N5K7VYF7ZSR'),
(126, 'JU10112000001', 43, 2418431, 'D', 'DPVL3N5K7VYF7ZSR'),
(127, 'JU10112000001', 44, 2418431, 'K', 'DPVL3N5K7VYF7ZSR'),
(128, 'JU10112000002', 43, 2430746, 'D', 'DPVL3N5K7VYF7ZSR'),
(129, 'JU10112000002', 44, 2430746, 'K', 'DPVL3N5K7VYF7ZSR'),
(142, 'JU11112011284100001', 43, 15000, 'D', 'DPVL3N5K7VYF7ZSR'),
(143, 'JU11112011284100001', 44, 15000, 'K', 'DPVL3N5K7VYF7ZSR'),
(144, 'JU11112011290100001', 44, 150000, 'D', 'DPVL3N5K7VYF7ZSR'),
(145, 'JU11112011290100001', 43, 150000, 'K', 'DPVL3N5K7VYF7ZSR'),
(168, 'JU2020-10-0100001', 44, 121, 'D', 'DPVL3N5K7VYF7ZSR'),
(169, 'JU2020-10-0100001', 43, 121, 'K', 'DPVL3N5K7VYF7ZSR'),
(170, 'JU2020-10-0100002', 44, 212, 'K', 'DPVL3N5K7VYF7ZSR'),
(171, 'JU2020-10-0100002', 43, 212, 'D', 'DPVL3N5K7VYF7ZSR'),
(172, 'JU20100100003', 43, 22, 'K', 'DPVL3N5K7VYF7ZSR'),
(173, 'JU20100100003', 43, 22, 'D', 'DPVL3N5K7VYF7ZSR'),
(176, 'JU11112000001', 43, 4624642, 'D', 'DPVL3N5K7VYF7ZSR'),
(177, 'JU11112000001', 44, 4624642, 'K', 'DPVL3N5K7VYF7ZSR'),
(178, 'JU11112000002', 43, 213213, 'D', 'DPVL3N5K7VYF7ZSR'),
(179, 'JU11112000002', 44, 213213, 'K', 'DPVL3N5K7VYF7ZSR'),
(180, 'JU20090900001', 43, 150000, 'D', 'DPVL3N5K7VYF7ZSR'),
(181, 'JU20090900001', 44, 150000, 'K', 'DPVL3N5K7VYF7ZSR'),
(182, 'JU19112000001', 43, 4000, 'D', 'DPVL3N5K7VYF7ZSR'),
(183, 'JU19112000001', 44, 4000, 'K', 'DPVL3N5K7VYF7ZSR'),
(184, 'JU23112000001', 43, 120708, 'D', 'DPVL3N5K7VYF7ZSR'),
(185, 'JU23112000001', 44, 120708, 'K', 'DPVL3N5K7VYF7ZSR'),
(188, 'JU20120100001', 43, 12, 'D', 'DPVL3N5K7VYF7ZSR'),
(189, 'JU20120100001', 44, 12, 'K', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal_tmp`
--

CREATE TABLE `tb_jurnal_tmp` (
  `id_jurnal_tmp` int(11) NOT NULL,
  `no_jurnal` varchar(128) NOT NULL,
  `tgl_jurnal` date NOT NULL,
  `keterangan` text NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jurnal_tmp`
--

INSERT INTO `tb_jurnal_tmp` (`id_jurnal_tmp`, `no_jurnal`, `tgl_jurnal`, `keterangan`, `token`) VALUES
(53, 'JU05102000001', '2020-10-05', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(54, 'JU06102000001', '2020-10-06', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(55, 'JU06102000002', '2020-10-06', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(56, 'JU06102000003', '2020-10-06', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(57, 'JU06102000004', '2020-10-06', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(58, 'JU06102000005', '2020-10-06', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(59, 'JU03112000001', '2020-11-03', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(60, 'JU03112000002', '2020-11-03', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(61, 'JU03112000003', '2020-11-03', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(62, 'JU03112000004', '2020-11-03', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(63, 'JU03112000005', '2020-11-03', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(64, 'JU03112000006', '2020-11-03', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(65, 'JU05112000001', '2020-11-05', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(66, 'JU07112000001', '2020-11-07', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(67, 'JU07112000002', '2020-11-07', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(68, 'JU09112000001', '2020-11-09', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(69, 'JU10112000001', '2020-11-10', 'Pendapatan Penjualan Lewat Link Checkout', 'DPVL3N5K7VYF7ZSR'),
(70, 'JU10112000002', '2020-11-10', 'Pendapatan Penjualan Lewat Link Checkout', 'DPVL3N5K7VYF7ZSR'),
(77, 'JU11112011284100001', '2020-10-03', 'asdsad', 'DPVL3N5K7VYF7ZSR'),
(78, 'JU11112011290100001', '2020-10-04', 'asdasd', 'DPVL3N5K7VYF7ZSR'),
(90, 'JU2020-10-0100001', '2020-10-01', '21', 'DPVL3N5K7VYF7ZSR'),
(91, 'JU2020-10-0100002', '2020-10-01', '21', 'DPVL3N5K7VYF7ZSR'),
(92, 'JU20100100003', '2020-10-01', 'sa', 'DPVL3N5K7VYF7ZSR'),
(94, 'JU11112000001', '2020-11-11', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(95, 'JU11112000002', '2020-11-11', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(96, 'JU20090900001', '2020-09-09', 'qwerty', 'DPVL3N5K7VYF7ZSR'),
(97, 'JU19112000001', '2020-11-19', 'Pendapatan Penjualan', 'DPVL3N5K7VYF7ZSR'),
(98, 'JU23112000001', '2020-11-23', 'Pendapatan Penjualan Lewat Link Checkout', 'DPVL3N5K7VYF7ZSR'),
(100, 'JU20120100001', '2020-12-01', '21', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kabupaten`
--

CREATE TABLE `tb_kabupaten` (
  `id_kab` char(4) NOT NULL,
  `id_prov` char(2) NOT NULL,
  `nama` tinytext NOT NULL,
  `kode_pos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kabupaten`
--

INSERT INTO `tb_kabupaten` (`id_kab`, `id_prov`, `nama`, `kode_pos`) VALUES
('1', '21', 'Kabupaten Aceh Barat', 23681),
('10', '21', 'Kabupaten Aceh Timur', 24454),
('100', '19', 'Kabupaten Buru Selatan', 97351),
('101', '30', 'Kabupaten Buton', 93754),
('102', '30', 'Kabupaten Buton Utara', 93745),
('103', '9', 'Kabupaten Ciamis', 46211),
('104', '9', 'Kabupaten Cianjur', 43217),
('105', '10', 'Kabupaten Cilacap', 53211),
('106', '3', 'Kota Cilegon', 42417),
('107', '9', 'Kota Cimahi', 40512),
('108', '9', 'Kabupaten Cirebon', 45611),
('109', '9', 'Kota Cirebon', 45116),
('11', '21', 'Kabupaten Aceh Utara', 24382),
('110', '34', 'Kabupaten Dairi', 22211),
('111', '24', 'Kabupaten Deiyai (Deliyai)', 98784),
('112', '34', 'Kabupaten Deli Serdang', 20511),
('113', '10', 'Kabupaten Demak', 59519),
('114', '1', 'Kota Denpasar', 80227),
('115', '9', 'Kota Depok', 16416),
('116', '32', 'Kabupaten Dharmasraya', 27612),
('117', '24', 'Kabupaten Dogiyai', 98866),
('118', '22', 'Kabupaten Dompu', 84217),
('119', '29', 'Kabupaten Donggala', 94341),
('12', '32', 'Kabupaten Agam', 26411),
('120', '26', 'Kota Dumai', 28811),
('121', '33', 'Kabupaten Empat Lawang', 31811),
('122', '23', 'Kabupaten Ende', 86351),
('123', '28', 'Kabupaten Enrekang', 91719),
('124', '25', 'Kabupaten Fakfak', 98651),
('125', '23', 'Kabupaten Flores Timur', 86213),
('126', '9', 'Kabupaten Garut', 44126),
('127', '21', 'Kabupaten Gayo Lues', 24653),
('128', '1', 'Kabupaten Gianyar', 80519),
('129', '7', 'Kabupaten Gorontalo', 96218),
('13', '23', 'Kabupaten Alor', 85811),
('130', '7', 'Kota Gorontalo', 96115),
('131', '7', 'Kabupaten Gorontalo Utara', 96611),
('132', '28', 'Kabupaten Gowa', 92111),
('133', '11', 'Kabupaten Gresik', 61115),
('134', '10', 'Kabupaten Grobogan', 58111),
('135', '5', 'Kabupaten Gunung Kidul', 55812),
('136', '14', 'Kabupaten Gunung Mas', 74511),
('137', '34', 'Kota Gunungsitoli', 22813),
('138', '20', 'Kabupaten Halmahera Barat', 97757),
('139', '20', 'Kabupaten Halmahera Selatan', 97911),
('14', '19', 'Kota Ambon', 97222),
('140', '20', 'Kabupaten Halmahera Tengah', 97853),
('141', '20', 'Kabupaten Halmahera Timur', 97862),
('142', '20', 'Kabupaten Halmahera Utara', 97762),
('143', '13', 'Kabupaten Hulu Sungai Selatan', 71212),
('144', '13', 'Kabupaten Hulu Sungai Tengah', 71313),
('145', '13', 'Kabupaten Hulu Sungai Utara', 71419),
('146', '34', 'Kabupaten Humbang Hasundutan', 22457),
('147', '26', 'Kabupaten Indragiri Hilir', 29212),
('148', '26', 'Kabupaten Indragiri Hulu', 29319),
('149', '9', 'Kabupaten Indramayu', 45214),
('15', '34', 'Kabupaten Asahan', 21214),
('150', '24', 'Kabupaten Intan Jaya', 98771),
('151', '6', 'Kota Jakarta Barat', 11220),
('152', '6', 'Kota Jakarta Pusat', 10540),
('153', '6', 'Kota Jakarta Selatan', 12230),
('154', '6', 'Kota Jakarta Timur', 13330),
('155', '6', 'Kota Jakarta Utara', 14140),
('156', '8', 'Kota Jambi', 36111),
('157', '24', 'Kabupaten Jayapura', 99352),
('158', '24', 'Kota Jayapura', 99114),
('159', '24', 'Kabupaten Jayawijaya', 99511),
('16', '24', 'Kabupaten Asmat', 99777),
('160', '11', 'Kabupaten Jember', 68113),
('161', '1', 'Kabupaten Jembrana', 82251),
('162', '28', 'Kabupaten Jeneponto', 92319),
('163', '10', 'Kabupaten Jepara', 59419),
('164', '11', 'Kabupaten Jombang', 61415),
('165', '25', 'Kabupaten Kaimana', 98671),
('166', '26', 'Kabupaten Kampar', 28411),
('167', '14', 'Kabupaten Kapuas', 73583),
('168', '12', 'Kabupaten Kapuas Hulu', 78719),
('169', '10', 'Kabupaten Karanganyar', 57718),
('17', '1', 'Kabupaten Badung', 80351),
('170', '1', 'Kabupaten Karangasem', 80819),
('171', '9', 'Kabupaten Karawang', 41311),
('172', '17', 'Kabupaten Karimun', 29611),
('173', '34', 'Kabupaten Karo', 22119),
('174', '14', 'Kabupaten Katingan', 74411),
('175', '4', 'Kabupaten Kaur', 38911),
('176', '12', 'Kabupaten Kayong Utara', 78852),
('177', '10', 'Kabupaten Kebumen', 54319),
('178', '11', 'Kabupaten Kediri', 64184),
('179', '11', 'Kota Kediri', 64125),
('18', '13', 'Kabupaten Balangan', 71611),
('180', '24', 'Kabupaten Keerom', 99461),
('181', '10', 'Kabupaten Kendal', 51314),
('182', '30', 'Kota Kendari', 93126),
('183', '4', 'Kabupaten Kepahiang', 39319),
('184', '17', 'Kabupaten Kepulauan Anambas', 29991),
('185', '19', 'Kabupaten Kepulauan Aru', 97681),
('186', '32', 'Kabupaten Kepulauan Mentawai', 25771),
('187', '26', 'Kabupaten Kepulauan Meranti', 28791),
('188', '31', 'Kabupaten Kepulauan Sangihe', 95819),
('189', '6', 'Kabupaten Kepulauan Seribu', 14550),
('19', '15', 'Kota Balikpapan', 76111),
('190', '31', 'Kabupaten Kepulauan Siau Tagulandang Biaro (Sitaro)', 95862),
('191', '20', 'Kabupaten Kepulauan Sula', 97995),
('192', '31', 'Kabupaten Kepulauan Talaud', 95885),
('193', '24', 'Kabupaten Kepulauan Yapen (Yapen Waropen)', 98211),
('194', '8', 'Kabupaten Kerinci', 37167),
('195', '12', 'Kabupaten Ketapang', 78874),
('196', '10', 'Kabupaten Klaten', 57411),
('197', '1', 'Kabupaten Klungkung', 80719),
('198', '30', 'Kabupaten Kolaka', 93511),
('199', '30', 'Kabupaten Kolaka Utara', 93911),
('2', '21', 'Kabupaten Aceh Barat Daya', 23764),
('20', '21', 'Kota Banda Aceh', 23238),
('200', '30', 'Kabupaten Konawe', 93411),
('201', '30', 'Kabupaten Konawe Selatan', 93811),
('202', '30', 'Kabupaten Konawe Utara', 93311),
('203', '13', 'Kabupaten Kotabaru', 72119),
('204', '31', 'Kota Kotamobagu', 95711),
('205', '14', 'Kabupaten Kotawaringin Barat', 74119),
('206', '14', 'Kabupaten Kotawaringin Timur', 74364),
('207', '26', 'Kabupaten Kuantan Singingi', 29519),
('208', '12', 'Kabupaten Kubu Raya', 78311),
('209', '10', 'Kabupaten Kudus', 59311),
('21', '18', 'Kota Bandar Lampung', 35139),
('210', '5', 'Kabupaten Kulon Progo', 55611),
('211', '9', 'Kabupaten Kuningan', 45511),
('212', '23', 'Kabupaten Kupang', 85362),
('213', '23', 'Kota Kupang', 85119),
('214', '15', 'Kabupaten Kutai Barat', 75711),
('215', '15', 'Kabupaten Kutai Kartanegara', 75511),
('216', '15', 'Kabupaten Kutai Timur', 75611),
('217', '34', 'Kabupaten Labuhan Batu', 21412),
('218', '34', 'Kabupaten Labuhan Batu Selatan', 21511),
('219', '34', 'Kabupaten Labuhan Batu Utara', 21711),
('22', '9', 'Kabupaten Bandung', 40311),
('220', '33', 'Kabupaten Lahat', 31419),
('221', '14', 'Kabupaten Lamandau', 74611),
('222', '11', 'Kabupaten Lamongan', 64125),
('223', '18', 'Kabupaten Lampung Barat', 34814),
('224', '18', 'Kabupaten Lampung Selatan', 35511),
('225', '18', 'Kabupaten Lampung Tengah', 34212),
('226', '18', 'Kabupaten Lampung Timur', 34319),
('227', '18', 'Kabupaten Lampung Utara', 34516),
('228', '12', 'Kabupaten Landak', 78319),
('229', '34', 'Kabupaten Langkat', 20811),
('23', '9', 'Kota Bandung', 40111),
('230', '21', 'Kota Langsa', 24412),
('231', '24', 'Kabupaten Lanny Jaya', 99531),
('232', '3', 'Kabupaten Lebak', 42319),
('233', '4', 'Kabupaten Lebong', 39264),
('234', '23', 'Kabupaten Lembata', 86611),
('235', '21', 'Kota Lhokseumawe', 24352),
('236', '32', 'Kabupaten Lima Puluh Koto/Kota', 26671),
('237', '17', 'Kabupaten Lingga', 29811),
('238', '22', 'Kabupaten Lombok Barat', 83311),
('239', '22', 'Kabupaten Lombok Tengah', 83511),
('24', '9', 'Kabupaten Bandung Barat', 40721),
('240', '22', 'Kabupaten Lombok Timur', 83612),
('241', '22', 'Kabupaten Lombok Utara', 83711),
('242', '33', 'Kota Lubuk Linggau', 31614),
('243', '11', 'Kabupaten Lumajang', 67319),
('244', '28', 'Kabupaten Luwu', 91994),
('245', '28', 'Kabupaten Luwu Timur', 92981),
('246', '28', 'Kabupaten Luwu Utara', 92911),
('247', '11', 'Kabupaten Madiun', 63153),
('248', '11', 'Kota Madiun', 63122),
('249', '10', 'Kabupaten Magelang', 56519),
('25', '29', 'Kabupaten Banggai', 94711),
('250', '10', 'Kota Magelang', 56133),
('251', '11', 'Kabupaten Magetan', 63314),
('252', '9', 'Kabupaten Majalengka', 45412),
('253', '27', 'Kabupaten Majene', 91411),
('254', '28', 'Kota Makassar', 90111),
('255', '11', 'Kabupaten Malang', 65163),
('256', '11', 'Kota Malang', 65112),
('257', '16', 'Kabupaten Malinau', 77511),
('258', '19', 'Kabupaten Maluku Barat Daya', 97451),
('259', '19', 'Kabupaten Maluku Tengah', 97513),
('26', '29', 'Kabupaten Banggai Kepulauan', 94881),
('260', '19', 'Kabupaten Maluku Tenggara', 97651),
('261', '19', 'Kabupaten Maluku Tenggara Barat', 97465),
('262', '27', 'Kabupaten Mamasa', 91362),
('263', '24', 'Kabupaten Mamberamo Raya', 99381),
('264', '24', 'Kabupaten Mamberamo Tengah', 99553),
('265', '27', 'Kabupaten Mamuju', 91519),
('266', '27', 'Kabupaten Mamuju Utara', 91571),
('267', '31', 'Kota Manado', 95247),
('268', '34', 'Kabupaten Mandailing Natal', 22916),
('269', '23', 'Kabupaten Manggarai', 86551),
('27', '2', 'Kabupaten Bangka', 33212),
('270', '23', 'Kabupaten Manggarai Barat', 86711),
('271', '23', 'Kabupaten Manggarai Timur', 86811),
('272', '25', 'Kabupaten Manokwari', 98311),
('273', '25', 'Kabupaten Manokwari Selatan', 98355),
('274', '24', 'Kabupaten Mappi', 99853),
('275', '28', 'Kabupaten Maros', 90511),
('276', '22', 'Kota Mataram', 83131),
('277', '25', 'Kabupaten Maybrat', 98051),
('278', '34', 'Kota Medan', 20228),
('279', '12', 'Kabupaten Melawi', 78619),
('28', '2', 'Kabupaten Bangka Barat', 33315),
('280', '8', 'Kabupaten Merangin', 37319),
('281', '24', 'Kabupaten Merauke', 99613),
('282', '18', 'Kabupaten Mesuji', 34911),
('283', '18', 'Kota Metro', 34111),
('284', '24', 'Kabupaten Mimika', 99962),
('285', '31', 'Kabupaten Minahasa', 95614),
('286', '31', 'Kabupaten Minahasa Selatan', 95914),
('287', '31', 'Kabupaten Minahasa Tenggara', 95995),
('288', '31', 'Kabupaten Minahasa Utara', 95316),
('289', '11', 'Kabupaten Mojokerto', 61382),
('29', '2', 'Kabupaten Bangka Selatan', 33719),
('290', '11', 'Kota Mojokerto', 61316),
('291', '29', 'Kabupaten Morowali', 94911),
('292', '33', 'Kabupaten Muara Enim', 31315),
('293', '8', 'Kabupaten Muaro Jambi', 36311),
('294', '4', 'Kabupaten Muko Muko', 38715),
('295', '30', 'Kabupaten Muna', 93611),
('296', '14', 'Kabupaten Murung Raya', 73911),
('297', '33', 'Kabupaten Musi Banyuasin', 30719),
('298', '33', 'Kabupaten Musi Rawas', 31661),
('299', '24', 'Kabupaten Nabire', 98816),
('3', '21', 'Kabupaten Aceh Besar', 23951),
('30', '2', 'Kabupaten Bangka Tengah', 33613),
('300', '21', 'Kabupaten Nagan Raya', 23674),
('301', '23', 'Kabupaten Nagekeo', 86911),
('302', '17', 'Kabupaten Natuna', 29711),
('303', '24', 'Kabupaten Nduga', 99541),
('304', '23', 'Kabupaten Ngada', 86413),
('305', '11', 'Kabupaten Nganjuk', 64414),
('306', '11', 'Kabupaten Ngawi', 63219),
('307', '34', 'Kabupaten Nias', 22876),
('308', '34', 'Kabupaten Nias Barat', 22895),
('309', '34', 'Kabupaten Nias Selatan', 22865),
('31', '11', 'Kabupaten Bangkalan', 69118),
('310', '34', 'Kabupaten Nias Utara', 22856),
('311', '16', 'Kabupaten Nunukan', 77421),
('312', '33', 'Kabupaten Ogan Ilir', 30811),
('313', '33', 'Kabupaten Ogan Komering Ilir', 30618),
('314', '33', 'Kabupaten Ogan Komering Ulu', 32112),
('315', '33', 'Kabupaten Ogan Komering Ulu Selatan', 32211),
('316', '33', 'Kabupaten Ogan Komering Ulu Timur', 32312),
('317', '11', 'Kabupaten Pacitan', 63512),
('318', '32', 'Kota Padang', 25112),
('319', '34', 'Kabupaten Padang Lawas', 22763),
('32', '1', 'Kabupaten Bangli', 80619),
('320', '34', 'Kabupaten Padang Lawas Utara', 22753),
('321', '32', 'Kota Padang Panjang', 27122),
('322', '32', 'Kabupaten Padang Pariaman', 25583),
('323', '34', 'Kota Padang Sidempuan', 22727),
('324', '33', 'Kota Pagar Alam', 31512),
('325', '34', 'Kabupaten Pakpak Bharat', 22272),
('326', '14', 'Kota Palangka Raya', 73112),
('327', '33', 'Kota Palembang', 31512),
('328', '28', 'Kota Palopo', 91911),
('329', '29', 'Kota Palu', 94111),
('33', '13', 'Kabupaten Banjar', 70619),
('330', '11', 'Kabupaten Pamekasan', 69319),
('331', '3', 'Kabupaten Pandeglang', 42212),
('332', '9', 'Kabupaten Pangandaran', 46511),
('333', '28', 'Kabupaten Pangkajene Kepulauan', 90611),
('334', '2', 'Kota Pangkal Pinang', 33115),
('335', '24', 'Kabupaten Paniai', 98765),
('336', '28', 'Kota Parepare', 91123),
('337', '32', 'Kota Pariaman', 25511),
('338', '29', 'Kabupaten Parigi Moutong', 94411),
('339', '32', 'Kabupaten Pasaman', 26318),
('34', '9', 'Kota Banjar', 46311),
('340', '32', 'Kabupaten Pasaman Barat', 26511),
('341', '15', 'Kabupaten Paser', 76211),
('342', '11', 'Kabupaten Pasuruan', 67153),
('343', '11', 'Kota Pasuruan', 67118),
('344', '10', 'Kabupaten Pati', 59114),
('345', '32', 'Kota Payakumbuh', 26213),
('346', '25', 'Kabupaten Pegunungan Arfak', 98354),
('347', '24', 'Kabupaten Pegunungan Bintang', 99573),
('348', '10', 'Kabupaten Pekalongan', 51161),
('349', '10', 'Kota Pekalongan', 51122),
('35', '13', 'Kota Banjarbaru', 70712),
('350', '26', 'Kota Pekanbaru', 28112),
('351', '26', 'Kabupaten Pelalawan', 28311),
('352', '10', 'Kabupaten Pemalang', 52319),
('353', '34', 'Kota Pematang Siantar', 21126),
('354', '15', 'Kabupaten Penajam Paser Utara', 76311),
('355', '18', 'Kabupaten Pesawaran', 35312),
('356', '18', 'Kabupaten Pesisir Barat', 35974),
('357', '32', 'Kabupaten Pesisir Selatan', 25611),
('358', '21', 'Kabupaten Pidie', 24116),
('359', '21', 'Kabupaten Pidie Jaya', 24186),
('36', '13', 'Kota Banjarmasin', 70117),
('360', '28', 'Kabupaten Pinrang', 91251),
('361', '7', 'Kabupaten Pohuwato', 96419),
('362', '27', 'Kabupaten Polewali Mandar', 91311),
('363', '11', 'Kabupaten Ponorogo', 63411),
('364', '12', 'Kabupaten Pontianak', 78971),
('365', '12', 'Kota Pontianak', 78112),
('366', '29', 'Kabupaten Poso', 94615),
('367', '33', 'Kota Prabumulih', 31121),
('368', '18', 'Kabupaten Pringsewu', 35719),
('369', '11', 'Kabupaten Probolinggo', 67282),
('37', '10', 'Kabupaten Banjarnegara', 53419),
('370', '11', 'Kota Probolinggo', 67215),
('371', '14', 'Kabupaten Pulang Pisau', 74811),
('372', '20', 'Kabupaten Pulau Morotai', 97771),
('373', '24', 'Kabupaten Puncak', 98981),
('374', '24', 'Kabupaten Puncak Jaya', 98979),
('375', '10', 'Kabupaten Purbalingga', 53312),
('376', '9', 'Kabupaten Purwakarta', 41119),
('377', '10', 'Kabupaten Purworejo', 54111),
('378', '25', 'Kabupaten Raja Ampat', 98489),
('379', '4', 'Kabupaten Rejang Lebong', 39112),
('38', '28', 'Kabupaten Bantaeng', 92411),
('380', '10', 'Kabupaten Rembang', 59219),
('381', '26', 'Kabupaten Rokan Hilir', 28992),
('382', '26', 'Kabupaten Rokan Hulu', 28511),
('383', '23', 'Kabupaten Rote Ndao', 85982),
('384', '21', 'Kota Sabang', 23512),
('385', '23', 'Kabupaten Sabu Raijua', 85391),
('386', '10', 'Kota Salatiga', 50711),
('387', '15', 'Kota Samarinda', 75133),
('388', '12', 'Kabupaten Sambas', 79453),
('389', '34', 'Kabupaten Samosir', 22392),
('39', '5', 'Kabupaten Bantul', 55715),
('390', '11', 'Kabupaten Sampang', 69219),
('391', '12', 'Kabupaten Sanggau', 78557),
('392', '24', 'Kabupaten Sarmi', 99373),
('393', '8', 'Kabupaten Sarolangun', 37419),
('394', '32', 'Kota Sawah Lunto', 27416),
('395', '12', 'Kabupaten Sekadau', 79583),
('396', '28', 'Kabupaten Selayar (Kepulauan Selayar)', 92812),
('397', '4', 'Kabupaten Seluma', 38811),
('398', '10', 'Kabupaten Semarang', 50511),
('399', '10', 'Kota Semarang', 50135),
('4', '21', 'Kabupaten Aceh Jaya', 23654),
('40', '33', 'Kabupaten Banyuasin', 30911),
('400', '19', 'Kabupaten Seram Bagian Barat', 97561),
('401', '19', 'Kabupaten Seram Bagian Timur', 97581),
('402', '3', 'Kabupaten Serang', 42182),
('403', '3', 'Kota Serang', 42111),
('404', '34', 'Kabupaten Serdang Bedagai', 20915),
('405', '14', 'Kabupaten Seruyan', 74211),
('406', '26', 'Kabupaten Siak', 28623),
('407', '34', 'Kota Sibolga', 22522),
('408', '28', 'Kabupaten Sidenreng Rappang/Rapang', 91613),
('409', '11', 'Kabupaten Sidoarjo', 61219),
('41', '10', 'Kabupaten Banyumas', 53114),
('410', '29', 'Kabupaten Sigi', 94364),
('411', '32', 'Kabupaten Sijunjung (Sawah Lunto Sijunjung)', 27511),
('412', '23', 'Kabupaten Sikka', 86121),
('413', '34', 'Kabupaten Simalungun', 21162),
('414', '21', 'Kabupaten Simeulue', 23891),
('415', '12', 'Kota Singkawang', 79117),
('416', '28', 'Kabupaten Sinjai', 92615),
('417', '12', 'Kabupaten Sintang', 78619),
('418', '11', 'Kabupaten Situbondo', 68316),
('419', '5', 'Kabupaten Sleman', 55513),
('42', '11', 'Kabupaten Banyuwangi', 68416),
('420', '32', 'Kabupaten Solok', 27365),
('421', '32', 'Kota Solok', 27315),
('422', '32', 'Kabupaten Solok Selatan', 27779),
('423', '28', 'Kabupaten Soppeng', 90812),
('424', '25', 'Kabupaten Sorong', 98431),
('425', '25', 'Kota Sorong', 98411),
('426', '25', 'Kabupaten Sorong Selatan', 98454),
('427', '10', 'Kabupaten Sragen', 57211),
('428', '9', 'Kabupaten Subang', 41215),
('429', '21', 'Kota Subulussalam', 24882),
('43', '13', 'Kabupaten Barito Kuala', 70511),
('430', '9', 'Kabupaten Sukabumi', 43311),
('431', '9', 'Kota Sukabumi', 43114),
('432', '14', 'Kabupaten Sukamara', 74712),
('433', '10', 'Kabupaten Sukoharjo', 57514),
('434', '23', 'Kabupaten Sumba Barat', 87219),
('435', '23', 'Kabupaten Sumba Barat Daya', 87453),
('436', '23', 'Kabupaten Sumba Tengah', 87358),
('437', '23', 'Kabupaten Sumba Timur', 87112),
('438', '22', 'Kabupaten Sumbawa', 84315),
('439', '22', 'Kabupaten Sumbawa Barat', 84419),
('44', '14', 'Kabupaten Barito Selatan', 73711),
('440', '9', 'Kabupaten Sumedang', 45326),
('441', '11', 'Kabupaten Sumenep', 69413),
('442', '8', 'Kota Sungaipenuh', 37113),
('443', '24', 'Kabupaten Supiori', 98164),
('444', '11', 'Kota Surabaya', 60119),
('445', '10', 'Kota Surakarta (Solo)', 57113),
('446', '13', 'Kabupaten Tabalong', 71513),
('447', '1', 'Kabupaten Tabanan', 82119),
('448', '28', 'Kabupaten Takalar', 92212),
('449', '25', 'Kabupaten Tambrauw', 98475),
('45', '14', 'Kabupaten Barito Timur', 73671),
('450', '16', 'Kabupaten Tana Tidung', 77611),
('451', '28', 'Kabupaten Tana Toraja', 91819),
('452', '13', 'Kabupaten Tanah Bumbu', 72211),
('453', '32', 'Kabupaten Tanah Datar', 27211),
('454', '13', 'Kabupaten Tanah Laut', 70811),
('455', '3', 'Kabupaten Tangerang', 15914),
('456', '3', 'Kota Tangerang', 15111),
('457', '3', 'Kota Tangerang Selatan', 15332),
('458', '18', 'Kabupaten Tanggamus', 35619),
('459', '34', 'Kota Tanjung Balai', 21321),
('46', '14', 'Kabupaten Barito Utara', 73881),
('460', '8', 'Kabupaten Tanjung Jabung Barat', 36513),
('461', '8', 'Kabupaten Tanjung Jabung Timur', 36719),
('462', '17', 'Kota Tanjung Pinang', 29111),
('463', '34', 'Kabupaten Tapanuli Selatan', 22742),
('464', '34', 'Kabupaten Tapanuli Tengah', 22611),
('465', '34', 'Kabupaten Tapanuli Utara', 22414),
('466', '13', 'Kabupaten Tapin', 71119),
('467', '16', 'Kota Tarakan', 77114),
('468', '9', 'Kabupaten Tasikmalaya', 46411),
('469', '9', 'Kota Tasikmalaya', 46116),
('47', '28', 'Kabupaten Barru', 90719),
('470', '34', 'Kota Tebing Tinggi', 20632),
('471', '8', 'Kabupaten Tebo', 37519),
('472', '10', 'Kabupaten Tegal', 52419),
('473', '10', 'Kota Tegal', 52114),
('474', '25', 'Kabupaten Teluk Bintuni', 98551),
('475', '25', 'Kabupaten Teluk Wondama', 98591),
('476', '10', 'Kabupaten Temanggung', 56212),
('477', '20', 'Kota Ternate', 97714),
('478', '20', 'Kota Tidore Kepulauan', 97815),
('479', '23', 'Kabupaten Timor Tengah Selatan', 85562),
('48', '17', 'Kota Batam', 29413),
('480', '23', 'Kabupaten Timor Tengah Utara', 85612),
('481', '34', 'Kabupaten Toba Samosir', 22316),
('482', '29', 'Kabupaten Tojo Una-Una', 94683),
('483', '29', 'Kabupaten Toli-Toli', 94542),
('484', '24', 'Kabupaten Tolikara', 99411),
('485', '31', 'Kota Tomohon', 95416),
('486', '28', 'Kabupaten Toraja Utara', 91831),
('487', '11', 'Kabupaten Trenggalek', 66312),
('488', '19', 'Kota Tual', 97612),
('489', '11', 'Kabupaten Tuban', 62319),
('49', '10', 'Kabupaten Batang', 51211),
('490', '18', 'Kabupaten Tulang Bawang', 34613),
('491', '18', 'Kabupaten Tulang Bawang Barat', 34419),
('492', '11', 'Kabupaten Tulungagung', 66212),
('493', '28', 'Kabupaten Wajo', 90911),
('494', '30', 'Kabupaten Wakatobi', 93791),
('495', '24', 'Kabupaten Waropen', 98269),
('496', '18', 'Kabupaten Way Kanan', 34711),
('497', '10', 'Kabupaten Wonogiri', 57619),
('498', '10', 'Kabupaten Wonosobo', 56311),
('499', '24', 'Kabupaten Yahukimo', 99041),
('5', '21', 'Kabupaten Aceh Selatan', 23719),
('50', '8', 'Kabupaten Batang Hari', 36613),
('500', '24', 'Kabupaten Yalimo', 99481),
('501', '5', 'Kota Yogyakarta', 55222),
('51', '11', 'Kota Batu', 65311),
('52', '34', 'Kabupaten Batu Bara', 21655),
('53', '30', 'Kota Bau-Bau', 93719),
('54', '9', 'Kabupaten Bekasi', 17837),
('55', '9', 'Kota Bekasi', 17121),
('56', '2', 'Kabupaten Belitung', 33419),
('57', '2', 'Kabupaten Belitung Timur', 33519),
('58', '23', 'Kabupaten Belu', 85711),
('59', '21', 'Kabupaten Bener Meriah', 24581),
('6', '21', 'Kabupaten Aceh Singkil', 24785),
('60', '26', 'Kabupaten Bengkalis', 28719),
('61', '12', 'Kabupaten Bengkayang', 79213),
('62', '4', 'Kota Bengkulu', 38229),
('63', '4', 'Kabupaten Bengkulu Selatan', 38519),
('64', '4', 'Kabupaten Bengkulu Tengah', 38319),
('65', '4', 'Kabupaten Bengkulu Utara', 38619),
('66', '15', 'Kabupaten Berau', 77311),
('67', '24', 'Kabupaten Biak Numfor', 98119),
('68', '22', 'Kabupaten Bima', 84171),
('69', '22', 'Kota Bima', 84139),
('7', '21', 'Kabupaten Aceh Tamiang', 24476),
('70', '34', 'Kota Binjai', 20712),
('71', '17', 'Kabupaten Bintan', 29135),
('72', '21', 'Kabupaten Bireuen', 24219),
('73', '31', 'Kota Bitung', 95512),
('74', '11', 'Kabupaten Blitar', 66171),
('75', '11', 'Kota Blitar', 66124),
('76', '10', 'Kabupaten Blora', 58219),
('77', '7', 'Kabupaten Boalemo', 96319),
('78', '9', 'Kabupaten Bogor', 16911),
('79', '9', 'Kota Bogor', 16119),
('8', '21', 'Kabupaten Aceh Tengah', 24511),
('80', '11', 'Kabupaten Bojonegoro', 62119),
('81', '31', 'Kabupaten Bolaang Mongondow (Bolmong)', 95755),
('82', '31', 'Kabupaten Bolaang Mongondow Selatan', 95774),
('83', '31', 'Kabupaten Bolaang Mongondow Timur', 95783),
('84', '31', 'Kabupaten Bolaang Mongondow Utara', 95765),
('85', '30', 'Kabupaten Bombana', 93771),
('86', '11', 'Kabupaten Bondowoso', 68219),
('87', '28', 'Kabupaten Bone', 92713),
('88', '7', 'Kabupaten Bone Bolango', 96511),
('89', '15', 'Kota Bontang', 75313),
('9', '21', 'Kabupaten Aceh Tenggara', 24611),
('90', '24', 'Kabupaten Boven Digoel', 99662),
('91', '10', 'Kabupaten Boyolali', 57312),
('92', '10', 'Kabupaten Brebes', 52212),
('93', '32', 'Kota Bukittinggi', 26115),
('94', '1', 'Kabupaten Buleleng', 81111),
('95', '28', 'Kabupaten Bulukumba', 92511),
('96', '16', 'Kabupaten Bulungan (Bulongan)', 77211),
('97', '8', 'Kabupaten Bungo', 37216),
('98', '29', 'Kabupaten Buol', 94564),
('99', '19', 'Kabupaten Buru', 97371);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori_barang`
--

CREATE TABLE `tb_kategori_barang` (
  `id_kategori` int(100) NOT NULL,
  `kode_kategori` varchar(128) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kategori_barang`
--

INSERT INTO `tb_kategori_barang` (`id_kategori`, `kode_kategori`, `nama_kategori`, `token`) VALUES
(14, '1545644', 'fgdgdr', 'DPVL3N5K7VYF7ZSR'),
(15, '324', 'sda21', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `id_log` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `timestmp` datetime NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_moota`
--

CREATE TABLE `tb_moota` (
  `id_moota` int(11) NOT NULL,
  `apikey` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_moota`
--

INSERT INTO `tb_moota` (`id_moota`, `apikey`, `is_active`, `token`) VALUES
(1, 'Wioudplby2rFH1GBz12PRX2Os1DGhHVryWGCPNw760GKjq53fR', 1, 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `kd_pelanggan` int(11) NOT NULL,
  `kode_pel` varchar(128) NOT NULL,
  `nama_pel` varchar(256) NOT NULL,
  `no_hp` char(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `diskon` varchar(15) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`kd_pelanggan`, `kode_pel`, `nama_pel`, `no_hp`, `email`, `alamat`, `diskon`, `token`) VALUES
(24, '14833525', 'qwerty', '987456321', 'qwerty@gmail.com', 'qwerty\r\n', '5', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembelian`
--

CREATE TABLE `tb_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `no_faktur` varchar(100) NOT NULL,
  `kd_supplier` varchar(50) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `petugas` varchar(50) NOT NULL,
  `timestmp` datetime NOT NULL,
  `total` varchar(50) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pembelian`
--

INSERT INTO `tb_pembelian` (`id_pembelian`, `no_faktur`, `kd_supplier`, `tgl_transaksi`, `petugas`, `timestmp`, `total`, `token`) VALUES
(68, 'INV00001', '45586322536', '2020-12-02', 'detapos', '2020-12-02 12:37:30', '3000', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `no_transaksi` varchar(100) NOT NULL,
  `kode_pelanggan` varchar(20) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `petugas` varchar(25) NOT NULL,
  `status` varchar(10) NOT NULL,
  `timestmp` datetime NOT NULL,
  `bayar` varchar(11) NOT NULL,
  `total` varchar(30) NOT NULL,
  `diskon` double(5,2) NOT NULL,
  `pajak` double(5,2) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`no_transaksi`, `kode_pelanggan`, `tgl_transaksi`, `petugas`, `status`, `timestmp`, `bayar`, `total`, `diskon`, `pajak`, `token`) VALUES
('DP19112000001', '', '2020-11-19', 'detapos', 'Lunas', '2020-11-19 09:16:05', '5000', '4000', 0.00, 0.00, 'DPVL3N5K7VYF7ZSR');

--
-- Triggers `tb_penjualan`
--
DELIMITER $$
CREATE TRIGGER `after_delete_penjualan` AFTER DELETE ON `tb_penjualan` FOR EACH ROW BEGIN
	INSERT INTO tb_log(deskripsi, timestmp, token) 
	VALUES(CONCAT("<span class='text-danger'>Berhasil menghapus transaksi penjualan dengan nomor transaksi : </span>", OLD.no_transaksi), OLD.timestmp, OLD.token);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_penjualan` AFTER INSERT ON `tb_penjualan` FOR EACH ROW BEGIN
	INSERT INTO tb_log(deskripsi, timestmp, token) 
	VALUES(CONCAT("<span class='text-success'>Berhasil melakukan transaksi penjualan dengan nomor transaksi : </span>", NEW.no_transaksi), NEW.timestmp, NEW.token);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_provinsi`
--

CREATE TABLE `tb_provinsi` (
  `id_prov` char(2) NOT NULL,
  `nama` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_provinsi`
--

INSERT INTO `tb_provinsi` (`id_prov`, `nama`) VALUES
('1', 'Bali'),
('10', 'Jawa Tengah'),
('11', 'Jawa Timur'),
('12', 'Kalimantan Barat'),
('13', 'Kalimantan Selatan'),
('14', 'Kalimantan Tengah'),
('15', 'Kalimantan Timur'),
('16', 'Kalimantan Utara'),
('17', 'Kepulauan Riau'),
('18', 'Lampung'),
('19', 'Maluku'),
('2', 'Bangka Belitung'),
('20', 'Maluku Utara'),
('21', 'Nanggroe Aceh Darussalam (NAD)'),
('22', 'Nusa Tenggara Barat (NTB)'),
('23', 'Nusa Tenggara Timur (NTT)'),
('24', 'Papua'),
('25', 'Papua Barat'),
('26', 'Riau'),
('27', 'Sulawesi Barat'),
('28', 'Sulawesi Selatan'),
('29', 'Sulawesi Tengah'),
('3', 'Banten'),
('30', 'Sulawesi Tenggara'),
('31', 'Sulawesi Utara'),
('32', 'Sumatera Barat'),
('33', 'Sumatera Selatan'),
('34', 'Sumatera Utara'),
('4', 'Bengkulu'),
('5', 'DI Yogyakarta'),
('6', 'DKI Jakarta'),
('7', 'Gorontalo'),
('8', 'Jambi'),
('9', 'Jawa Barat');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekening`
--

CREATE TABLE `tb_rekening` (
  `kd_rekening` int(11) NOT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `no_rekening` varchar(255) NOT NULL,
  `jenis` varchar(15) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_rekening`
--

INSERT INTO `tb_rekening` (`kd_rekening`, `atas_nama`, `no_rekening`, `jenis`, `token`) VALUES
(12, 'Mohammad Fadhlan Zainuddin', '7975490432', 'bank-bca', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `tb_retur_pembelian`
--

CREATE TABLE `tb_retur_pembelian` (
  `id_retur_pembelian` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `kode_supplier` varchar(50) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `tgl_pem` date NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_retur_penjualan`
--

CREATE TABLE `tb_retur_penjualan` (
  `id_retur_penjualan` int(11) NOT NULL,
  `no_transaksi` varchar(128) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `harga` double(10,2) NOT NULL,
  `kode_pelanggan` varchar(50) NOT NULL,
  `jml_retur` varchar(10) NOT NULL,
  `tgl_beli` date NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `kd_supplier` int(11) NOT NULL,
  `kode_sup` varchar(128) NOT NULL,
  `nama_toko` varchar(256) NOT NULL,
  `alamat` text NOT NULL,
  `telpon` char(25) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`kd_supplier`, `kode_sup`, `nama_toko`, `alamat`, `telpon`, `email`, `token`) VALUES
(16, '45586322536', 'qwerty', 'fhhdh ggjgyu ghjfjhb gfuggjhh ', '9958632017421', 'qwerty@gmail.com', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `no_hp` varchar(25) NOT NULL,
  `produk` varchar(25) NOT NULL,
  `image` text NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(25) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `last_login` datetime NOT NULL,
  `coupon` varchar(256) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `email`, `no_hp`, `produk`, `image`, `password`, `role_id`, `is_active`, `date_created`, `last_login`, `coupon`, `token`) VALUES
(1, 'Super User', 'gamma2020', 'admin@detapos.com', '', '', 'default.png', '$2y$10$zAXGsHya3dfEMK0DLxRbeOnORiGqG1WdAeKcTgr58kJkR6WlmPFc6', 1, 1, 1581291784, '2020-12-03 02:47:15', '', '15812917'),
(71, 'Detapos Lite', 'detapos', 'admin@detapos.co.id', '082188811161', '1y', 'default.png', '$2y$10$akMvuGdxlsihD/DnVLkTweediFDOA5fvRqexvWmb5biR9V9nZ7.Fu', 2, 1, 1601705727, '2020-12-05 03:06:33', 'new', 'DPVL3N5K7VYF7ZSR'),
(73, 'fadlan', 'fadlan', 'fadlan642@gmail.com', '', '', 'default.png', '$2y$10$svv1Qp2MgmZvdoUZuAw2ZONq5tNcQJduEWoA/pnHCa4/7BaftPOGq', 3, 1, 1604377158, '2020-11-14 02:02:43', 'new', 'DPVL3N5K7VYF7ZSR');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` text NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tambah` int(11) NOT NULL,
  `ubah` int(11) NOT NULL,
  `hapus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`, `role`, `user_id`, `tambah`, `ubah`, `hapus`) VALUES
(150, '15812917', 1, 1, 1, 0, 0, 0),
(151, '15812917', 4, 1, 1, 0, 0, 0),
(152, '15812917', 5, 1, 1, 0, 0, 0),
(798, 'DPVL3N5K7VYF7ZSR', 2, 2, 71, 0, 0, 0),
(799, 'DPVL3N5K7VYF7ZSR', 19, 2, 71, 0, 0, 0),
(800, 'DPVL3N5K7VYF7ZSR', 21, 2, 71, 0, 0, 0),
(802, 'DPVL3N5K7VYF7ZSR', 24, 2, 71, 1, 1, 1),
(803, 'DPVL3N5K7VYF7ZSR', 26, 2, 71, 1, 0, 1),
(805, 'DPVL3N5K7VYF7ZSR', 28, 2, 71, 0, 0, 0),
(806, 'DPVL3N5K7VYF7ZSR', 34, 2, 71, 0, 1, 0),
(807, 'DPVL3N5K7VYF7ZSR', 35, 2, 71, 1, 1, 1),
(808, 'DPVL3N5K7VYF7ZSR', 36, 2, 71, 1, 1, 0),
(809, 'DPVL3N5K7VYF7ZSR', 37, 2, 71, 0, 0, 0),
(810, 'DPVL3N5K7VYF7ZSR', 41, 2, 71, 1, 0, 0),
(812, 'DPVL3N5K7VYF7ZSR', 100, 2, 71, 0, 0, 0),
(822, 'DPVL3N5K7VYF7ZSR', 45, 2, 71, 0, 0, 0),
(825, 'DPVL3N5K7VYF7ZSR', 18, 3, 73, 0, 0, 0),
(826, 'DPVL3N5K7VYF7ZSR', 19, 3, 73, 0, 0, 0),
(827, 'DPVL3N5K7VYF7ZSR', 20, 3, 73, 0, 0, 0),
(828, 'DPVL3N5K7VYF7ZSR', 100, 3, 73, 0, 0, 0),
(829, 'DPVL3N5K7VYF7ZSR', 27, 3, 73, 0, 0, 0),
(830, 'DPVL3N5K7VYF7ZSR', 28, 3, 73, 0, 0, 0),
(831, 'DPVL3N5K7VYF7ZSR', 36, 3, 73, 0, 0, 0),
(835, 'DPVL3N5K7VYF7ZSR', 46, 2, 71, 0, 0, 0),
(838, 'DPVL3N5K7VYF7ZSR', 47, 2, 71, 1, 1, 1),
(840, 'DPVL3N5K7VYF7ZSR', 49, 2, 71, 1, 1, 1),
(842, 'DPVL3N5K7VYF7ZSR', 51, 2, 71, 1, 0, 0),
(845, 'DPVL3N5K7VYF7ZSR', 23, 2, 71, 1, 1, 1),
(849, 'DPVL3N5K7VYF7ZSR', 48, 2, 71, 1, 1, 1),
(850, 'DPVL3N5K7VYF7ZSR', 52, 2, 71, 1, 1, 1),
(853, 'DPVL3N5K7VYF7ZSR', 38, 2, 71, 0, 0, 0),
(854, 'DPVL3N5K7VYF7ZSR', 50, 2, 71, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Dashboard'),
(2, 'Home'),
(4, 'Menu'),
(5, 'Akses'),
(18, 'Beranda'),
(19, 'Data Master'),
(20, 'Transaksi'),
(21, 'Akuntansi'),
(23, 'Pelanggan'),
(24, 'Supplier'),
(26, 'Barang'),
(27, 'Kasir'),
(28, 'Penjualan'),
(34, 'Profil'),
(35, 'User'),
(36, 'Account'),
(37, 'Laporan'),
(38, 'Kasir_Diskon'),
(39, 'Kasir_Checkout'),
(40, 'Kasir_Retail'),
(41, 'Pembelian'),
(42, 'Report'),
(43, 'Notif'),
(44, 'Tempo'),
(45, 'Orders'),
(46, 'No_Rekening'),
(47, 'Akun'),
(48, 'Jurnal_Umum'),
(49, 'Buku_Besar'),
(50, 'Neraca_Saldo'),
(51, 'Laba_Rugi'),
(52, 'Ket_Barang'),
(100, 'Setting');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'SU'),
(2, 'Admin'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `sub_menu` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `id_menu`, `title`, `url`, `icon`, `sub_menu`, `is_active`) VALUES
(2, 1, 'DASHBOARD', 'Dashboard', 'fas fa-home', 0, 1),
(3, 4, 'DATA MENU', 'Menu', '', 0, 1),
(4, 5, 'USER AKSES', 'Akses', '', 0, 1),
(6, 2, 'HOME', 'Home', 'fas fa-home', 0, 1),
(7, 19, 'DATA MASTER', '', '', 0, 1),
(8, 23, 'Data Pelanggan', 'Pelanggan', '', 7, 1),
(9, 24, 'Data Supplier', 'Supplier', '', 7, 1),
(10, 52, 'Data Kategori Barang', 'Ket_Barang', '', 7, 1),
(11, 26, 'Data Barang', 'Barang', '', 7, 1),
(12, 20, 'TRANSAKSI', '', '', 0, 0),
(13, 27, 'KASIR', 'Kasir', 'fas fa-vote-yea', 0, 1),
(14, 28, 'Data Penjualan', 'Penjualan', '', 7, 1),
(15, 21, 'AKUNTANSI', '', '', 0, 1),
(16, 47, 'Akun', 'Akun', '', 15, 1),
(17, 48, 'Jurnal Umum', 'Jurnal_Umum', '', 15, 1),
(18, 49, 'Buku Besar', 'Buku_Besar', '', 15, 1),
(19, 50, 'Neraca Saldo', 'Neraca_Saldo', '', 15, 1),
(21, 34, 'Profil', 'Profil', '', 24, 1),
(22, 35, 'User', 'User', '', 24, 1),
(23, 51, 'Laba Rugi', 'Laba_Rugi', '', 15, 1),
(24, 100, 'SETTING', '', '', 0, 1),
(25, 36, 'Account', 'Account', '', 24, 1),
(27, 18, 'Beranda', 'Beranda', 'fas fa-home', 0, 1),
(29, 37, 'LAPORAN', '', '', 0, 1),
(30, 37, 'Penjualan Harian', 'Laporan/Harian', '', 29, 1),
(31, 37, 'Penjualan Minggu/Bulan', 'Laporan/Minggu_Bulan', '', 29, 1),
(32, 37, 'Laporan Keuntungan', 'Laporan/Keuntungan', '', 29, 1),
(33, 38, 'KASIR', 'Kasir_Diskon', 'fas fa-vote-yea', 0, 1),
(34, 39, 'KASIR', 'Kasir_Checkout', 'fas fa-vote-yea', 0, 1),
(35, 37, 'Laporan Retur Supplier', 'Laporan/Retur_Supplier', '', 29, 1),
(36, 37, 'Laporan Retur Customer', 'Laporan/Retur_Customer', '', 29, 1),
(37, 40, 'KASIR', 'Kasir_Retail', 'fas fa-vote-yea', 0, 1),
(38, 37, 'Laporan Barang', 'Laporan/Barang', '', 29, 0),
(39, 41, 'Data Pembelian', 'Pembelian', '', 7, 1),
(40, 37, 'Pembelian Barang', 'Laporan/Pembelian', '', 29, 1),
(41, 42, 'REPORT BARANG', 'Report', 'fas fa-file', 0, 1),
(42, 43, 'NOTIF STOK', 'Notif', '', 0, 1),
(43, 44, 'JATUH TEMPO', 'Tempo', '', 0, 1),
(44, 45, 'ORDERS', 'Orders', 'fas fa-shopping-cart', 0, 1),
(45, 46, 'No. Rekening', 'No_rekening', '', 24, 1),
(46, 37, 'Laporan Penjualan Online', 'Laporan/Penjualan_Online', '', 29, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `setting_app`
--
ALTER TABLE `setting_app`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tb_akun`
--
ALTER TABLE `tb_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `tb_alert`
--
ALTER TABLE `tb_alert`
  ADD PRIMARY KEY (`kd_alert`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_tb_produk_tb_kategori_produk` (`id_kategori`);

--
-- Indexes for table `tb_barang_tmp`
--
ALTER TABLE `tb_barang_tmp`
  ADD PRIMARY KEY (`kd_barang_tmp`);

--
-- Indexes for table `tb_checkout`
--
ALTER TABLE `tb_checkout`
  ADD PRIMARY KEY (`kd_checkout`);

--
-- Indexes for table `tb_checkout_terima`
--
ALTER TABLE `tb_checkout_terima`
  ADD PRIMARY KEY (`kd_checkout_terima`);

--
-- Indexes for table `tb_checkout_tmp`
--
ALTER TABLE `tb_checkout_tmp`
  ADD PRIMARY KEY (`kd_checkout_tmp`);

--
-- Indexes for table `tb_detail_pembelian`
--
ALTER TABLE `tb_detail_pembelian`
  ADD PRIMARY KEY (`kd_pembelian`);

--
-- Indexes for table `tb_detail_pembelian_tmp`
--
ALTER TABLE `tb_detail_pembelian_tmp`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  ADD PRIMARY KEY (`kd_penjualan`);

--
-- Indexes for table `tb_detail_penjualan_tmp`
--
ALTER TABLE `tb_detail_penjualan_tmp`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  ADD PRIMARY KEY (`id_jurnal`);

--
-- Indexes for table `tb_jurnal_tmp`
--
ALTER TABLE `tb_jurnal_tmp`
  ADD PRIMARY KEY (`id_jurnal_tmp`);

--
-- Indexes for table `tb_kabupaten`
--
ALTER TABLE `tb_kabupaten`
  ADD PRIMARY KEY (`id_kab`);

--
-- Indexes for table `tb_kategori_barang`
--
ALTER TABLE `tb_kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `tb_moota`
--
ALTER TABLE `tb_moota`
  ADD PRIMARY KEY (`id_moota`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`kd_pelanggan`);

--
-- Indexes for table `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`no_transaksi`);

--
-- Indexes for table `tb_provinsi`
--
ALTER TABLE `tb_provinsi`
  ADD PRIMARY KEY (`id_prov`);

--
-- Indexes for table `tb_rekening`
--
ALTER TABLE `tb_rekening`
  ADD PRIMARY KEY (`kd_rekening`);

--
-- Indexes for table `tb_retur_pembelian`
--
ALTER TABLE `tb_retur_pembelian`
  ADD PRIMARY KEY (`id_retur_pembelian`);

--
-- Indexes for table `tb_retur_penjualan`
--
ALTER TABLE `tb_retur_penjualan`
  ADD PRIMARY KEY (`id_retur_penjualan`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`kd_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `setting_app`
--
ALTER TABLE `setting_app`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_akun`
--
ALTER TABLE `tb_akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7616;

--
-- AUTO_INCREMENT for table `tb_barang_tmp`
--
ALTER TABLE `tb_barang_tmp`
  MODIFY `kd_barang_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tb_checkout`
--
ALTER TABLE `tb_checkout`
  MODIFY `kd_checkout` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `tb_checkout_terima`
--
ALTER TABLE `tb_checkout_terima`
  MODIFY `kd_checkout_terima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `tb_checkout_tmp`
--
ALTER TABLE `tb_checkout_tmp`
  MODIFY `kd_checkout_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_detail_pembelian`
--
ALTER TABLE `tb_detail_pembelian`
  MODIFY `kd_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `tb_detail_pembelian_tmp`
--
ALTER TABLE `tb_detail_pembelian_tmp`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  MODIFY `kd_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `tb_detail_penjualan_tmp`
--
ALTER TABLE `tb_detail_penjualan_tmp`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `tb_jurnal_tmp`
--
ALTER TABLE `tb_jurnal_tmp`
  MODIFY `id_jurnal_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tb_kategori_barang`
--
ALTER TABLE `tb_kategori_barang`
  MODIFY `id_kategori` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT for table `tb_moota`
--
ALTER TABLE `tb_moota`
  MODIFY `id_moota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `kd_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tb_rekening`
--
ALTER TABLE `tb_rekening`
  MODIFY `kd_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_retur_pembelian`
--
ALTER TABLE `tb_retur_pembelian`
  MODIFY `id_retur_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_retur_penjualan`
--
ALTER TABLE `tb_retur_penjualan`
  MODIFY `id_retur_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `kd_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=855;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
