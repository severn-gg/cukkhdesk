-- Definisi Skema
CREATE SCHEMA IF NOT EXISTS `hdesk` DEFAULT CHARACTER SET utf8 ;
USE `hdesk`;

-- Tabel Grup Pengguna
CREATE TABLE IF NOT EXISTS `usergroup` (
  `usergroup_id` INT NOT NULL AUTO_INCREMENT,
  `nama_group` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`usergroup_id`)
) ENGINE = InnoDB;

-- Tabel Pengguna
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `nama_pengguna` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `usergroup_id` INT NOT NULL,
  `nomor_telepon` VARCHAR(20),
  `jabatan` VARCHAR(100),
  `kantor` VARCHAR(100), -- New field for storing user's workplace
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`usergroup_id`) REFERENCES `usergroup` (`usergroup_id`)
) ENGINE = InnoDB;

-- Tabel Kategori Tiket
CREATE TABLE IF NOT EXISTS `tiketkategori` (
  `tiketkategori_id` INT NOT NULL AUTO_INCREMENT,
  `nama_kategori` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT,
  PRIMARY KEY (`tiketkategori_id`)
) ENGINE = InnoDB;

-- Tabel Tiket
CREATE TABLE IF NOT EXISTS `tiket` (
  `tiket_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `tiketkategori_id` INT NOT NULL,
  `status` VARCHAR(45) NOT NULL DEFAULT 'Buka',
  `prioritas` VARCHAR(45) NOT NULL DEFAULT 'Sedang',
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deskripsi` TEXT NOT NULL,
  `ditugaskan_user_id` INT,
  `nama_file` VARCHAR(255),
  `url_gambar` VARCHAR(255),
  PRIMARY KEY (`tiket_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`tiketkategori_id`) REFERENCES `tiketkategori` (`tiketkategori_id`),
  FOREIGN KEY (`ditugaskan_user_id`) REFERENCES `user` (`user_id`)
) ENGINE = InnoDB;

-- Tabel Komentar
CREATE TABLE IF NOT EXISTS `komentar` (
  `komentar_id` INT NOT NULL AUTO_INCREMENT,
  `tiket_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `dibuat_pada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teks_komentar` TEXT NOT NULL,
  PRIMARY KEY (`komentar_id`),
  FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`tiket_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE = InnoDB;
