-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 09:01 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinehealthguide`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(128) NOT NULL,
  `time` varchar(128) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `user_id` int(128) DEFAULT NULL,
  `doc_user_id` int(128) DEFAULT NULL,
  `visitor_id` int(128) DEFAULT NULL,
  `status` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `time`, `date`, `user_id`, `doc_user_id`, `visitor_id`, `status`) VALUES
(1, '009:13 AM-09:28 AM', '29 Aug 2020', NULL, 21, 1, 'unapproved'),
(2, '10:16 PM-10:31 PM', '22 Nov 2020', 85, 21, NULL, 'unapproved');

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `id` int(128) NOT NULL,
  `to_user_id` int(128) DEFAULT NULL,
  `from_user_id` int(128) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `clinic_id` int(128) NOT NULL,
  `clinic_name` varchar(128) DEFAULT NULL,
  `clinic_type` varchar(128) DEFAULT NULL,
  `clinic_location` varchar(128) DEFAULT NULL,
  `contact` varchar(10) DEFAULT NULL,
  `clinic_status` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `clinic_name`, `clinic_type`, `clinic_location`, `contact`, `clinic_status`) VALUES
(1, 'Global Medical', 'Eye', '05 Block,Guldara,Kabul', '0763425234', 'Approved'),
(2, 'New Nangarhar', 'Eye', '05 Block,Behsood,Nangarhar', '0793434523', 'Approved'),
(3, 'National Eye', 'Eye', '02 Block,Chapa Dara,Konar', '0790343245', 'Approved'),
(4, 'Al Noor', 'Eye', '04 Block,Nurgram,Nuristan', '0763434234', 'Approved'),
(5, 'AL Shafa', 'Eye', '04 Block,Khost Matun,Khost', '0790023452', 'Approved'),
(6, 'Al Zeba', 'Dentist', '03 Block,Chahar Asyab,Kabul', '0762342542', 'Approved'),
(7, 'Halimi', 'Dentist', '03 Block,Chamkani,Paktia', '0763432522', 'Approved'),
(8, 'New Wajid', 'Skin', '04 Block,Azra,Logar', '0773424553', 'Approved'),
(9, 'Al Saba', 'Skin', '05 Block,Dahbala,Nangarhar', '0790023435', 'Approved'),
(10, 'Mer Majedi', 'Skin', '11 Block,Wama,Nuristan', '0773423453', 'Approved'),
(11, 'National Kabul', 'Primary Care', '04 Block,Istalif,Kabul', '0774342345', 'Approved'),
(12, 'Noor ', 'Skin', '04 Block,Nurgram,Nuristan', '0781234343', 'Approved'),
(13, 'Rana', 'Primary Care', '02 Block,Tarwe,Paktika', '0790034323', 'Approved'),
(14, 'Zeeshan', 'ENT', '11 Block,Istalif,Kabul', '0773424323', 'Approved'),
(15, 'Banara', 'ENT', '05 Block,Khas Konar,Konar', '0773424323', 'Approved'),
(16, 'Kalam ', 'Dermatologist', '03 Block,Dara Noor,Nangarhar', '0771233432', 'Approved'),
(17, 'National Safi', 'Dermatologist', '04 Block,Khas Konar,Konar', '0763432543', 'Approved'),
(18, 'Shiasta', 'Urology', '04 Block,Anaba,Panjshir', '0792342043', 'Approved'),
(19, 'Kandolak', 'Urology', '03 Block,Chaparhar,Nangarhar', '0763424343', 'Approved'),
(20, 'Peer Baba', 'Neurology', '11 Block,Nahra-i-shahi,Balkh', '0790034233', 'Approved'),
(21, 'Al Raiuf', 'Orthopedic', '04 Block,Tarwe,Paktika', '0773424323', 'Approved'),
(22, 'New Jan', 'Orthopedic', '03 Block,Deh Sabz,Kabul', '0776432343', 'Approved'),
(23, 'Al Dada', 'Cardiologist', '03 Block,Khas Konar,Konar', '0782343243', 'Approved'),
(24, 'AL Paroon', 'Cardiologist', '05 Block,Guldara,Kabul', '0773424343', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doc_id` int(128) NOT NULL,
  `doc_firstName` varchar(128) DEFAULT NULL,
  `doc_lastName` varchar(128) DEFAULT NULL,
  `doc_specialization` varchar(128) DEFAULT NULL,
  `doc_province` varchar(128) DEFAULT NULL,
  `doc_district` varchar(128) DEFAULT NULL,
  `doc_location` varchar(128) DEFAULT NULL,
  `doc_email` varchar(128) DEFAULT NULL,
  `doc_qualification` varchar(128) DEFAULT NULL,
  `doc_university` varchar(128) DEFAULT NULL,
  `doc_contact` varchar(128) DEFAULT NULL,
  `doc_gender` varchar(128) DEFAULT NULL,
  `doc_birth` varchar(128) DEFAULT NULL,
  `doc_status` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doc_id`, `doc_firstName`, `doc_lastName`, `doc_specialization`, `doc_province`, `doc_district`, `doc_location`, `doc_email`, `doc_qualification`, `doc_university`, `doc_contact`, `doc_gender`, `doc_birth`, `doc_status`) VALUES
(1, 'Waheed', 'Hashimi', 'Dentist', 'Paktia', 'Chamkani', '01 Block,Deh Sabz,Kabul', 'waheedhashimi@gmail.com', 'MD', 'Rokhan University', '0766229510', 'Male', '1997-07-23', 'approve'),
(2, 'Said Aminullah', 'Halimi', 'Dentist', 'Kabul', 'Deh Sabz', '02 Block,Batikot,Nangarhar', 'saidaminullahhalimi@gmail.com', 'MBBS', 'Spin Ghar University', '0777229510', 'Male', '1997-05-23', 'approve'),
(3, 'Manan ', 'Hashimi', 'Dentist', 'Konar', 'Chapa Dara', '03 Block,Arghistan,Kandahar', 'mananhashimi@gmail.com', 'MBBS', 'Ariana University', '0777234343', 'Male', '1995-06-23', 'approve'),
(4, 'Shoiab', 'Haidary', 'Eye', 'Laghman', 'Qarghayi', '02 Block,Ghardaz,Paktia', 'shoiabhaidary@gmail.com', 'MD', 'Kardan University', '0786229510', 'Male', '1998-10-24', 'approve'),
(5, 'Zubair ', 'Wafa', 'Eye', 'Logar', 'Azra', '03 Block,Charkh,Logar', 'zubairwafa@gmail.com', 'MBBS', 'Rokhan University', '0799229213', 'Male', '1993-10-24', 'approve'),
(6, 'Samim ', 'Saifi', 'Eye', 'Kabul', 'Istalif', '02 Block,Guldara,Kabul', 'samimsaifi@gmail.com', 'MD', 'Kabul Medical University', '0761229510', 'Male', '1999-10-24', 'approve'),
(7, 'Akramullah', 'Hashimi', 'Primary Care', 'Nangarhar', 'Achin', '01 Block,Batikot,Nangarhar', 'akramullahhashimi@gmail.com', 'MBBS', 'Rokhan University', '0766888123', 'Male', '1992-05-24', 'approve'),
(8, 'Arfanullah', 'Halimi', 'Primary Care', 'Herat', 'Gulran', '01 Block,Gulran,Herat', 'arfanullahhalimi@gmail.com', 'MD', 'Spin Ghar University', '0777229510', 'Male', '1986-10-24', 'approve'),
(9, 'Rahim', 'Raifi', 'Primary Care', 'Ghazni', 'Giro', '02 Block,Arghistan,Kandahar', 'rahimraifi@gmail.com', 'MBBS', 'Balkh University Faculty of Medicine', '0771212234', 'Male', '1994-06-24', 'approve'),
(10, 'Mirwas', 'Sharefi', 'ENT', 'Kabul', 'Bagrami', '05 Block,Istalif,Kabul', 'mirwassharefi@gmail.com', 'MBBS', 'Nangarhar Medical Faculty', '0799009487', 'Male', '1991-06-24', 'approve'),
(11, 'Zeeshan', 'Sarwari', 'ENT', 'Laghman', 'Dawlat Shah', '04 Block,Mazar-i-sharif,Balkh', 'zeeshansarwari@gmail.com', 'MD', 'Herat Medical Faculty', '0799009487', 'Male', '1998-09-24', 'approve'),
(12, 'Ferdos', 'Asghara', 'ENT', 'Konar', 'Asadabad', '03 Block,Behsood,Nangarhar', 'ferdosasghara@gmail.com', 'MD', 'Kardan University', '0706229510', 'Male', '1999-03-12', 'approve'),
(13, 'Qasam', 'Bari', 'Skin', 'Kabul', 'Bagrami', '05 Block,Istalif,Kabul', 'qasambari@gmail.com', 'MD', 'Herat Medical Faculty', '0777229510', 'Male', '1998-02-12', 'approve'),
(14, 'Azizullah', 'Hashimi', 'Skin', 'Paktia', 'Chamkani', '05 Block,Parun,Kabul', 'azizullahhashimi@gmail.com', 'MD', 'Paktia University', '0772233124', 'Male', '1992-05-10', 'approve'),
(15, 'Javid', 'Qaramal', 'Skin', 'Kandahar', 'Spinboldak', '01 Block,Gurbaz,Kabul', 'javidqaramal@gmail.com', 'MD', 'Spin Ghar University', '0773432123', 'Male', '1992-11-11', 'approve'),
(16, 'Wajid', 'Hussain', 'Dermatologist', 'Logar', 'Mohammad Agha', '01 Block,Chamkani,Paktia', 'wajidhussain@gmail.com', 'MBBS', 'Ariana University', '0799009487', 'Male', '1990-11-09', 'approve'),
(17, 'Muhammad', 'Halim', 'Dermatologist', 'Nangarhar', 'Behsood', '05 Block,Kalakan,Kabul', 'muhammadhalim@gmail.com', 'MBBS', 'Spin Ghar University', '0786229510', 'Male', '1990-02-12', 'approve'),
(18, 'Muhammad', 'Ishaq', 'Dermatologist', 'Balkh', 'Hairatan', '02 Block,Kahmard,Kabul', 'muhammadishaq@gmail.com', 'MD', 'Kardan University', '0799229510', 'Male', '1992-02-12', 'approve'),
(19, 'Farooq', 'Wardaq', 'Urology', 'Kabul', 'Deh Sabz', '01 Block,Deh Sabz,Kabul', 'farooqwardaq@gmail.com', 'MD', 'Balkh University Faculty of Medicine', '0706229510', 'Male', '1991-03-11', 'approve'),
(20, 'Ayaz', 'Khan', 'Urology', 'Konar', 'Khas Konar', '05 Block,Dara Noor,Nangarhar', 'ayazkhan@gmail.com', 'MD', 'Spin Ghar University', '0777229510', 'Male', '1999-12-12', 'approve'),
(21, 'Karim', 'Khan', 'Urology', 'Herat', 'Kohsan', '03 Block,Shah Walikot,Kandahar', 'karimkhan@gmail.com', 'MBBS', 'Spin Ghar University', '0706229534', 'Male', '1990-05-23', 'approve'),
(22, 'Khan ', 'Ameer', 'Neurology', 'Nangarhar', 'Batikot', '02 Block,Farah,Kabul', 'khanameer@gmail.com', 'MD', 'Kardan University', '0774421234', 'Male', '1990-08-18', 'approve'),
(23, 'Jafar', 'Safari', 'Neurology', 'Konar', 'Asadabad', '02 Block,Ghazni,Ghazni', 'jafarsafari@gmail.com', 'MBBS', 'Ariana University', '0776229510', 'Male', '1990-03-22', 'approve'),
(24, 'Farid', 'Hussain', 'Neurology', 'Nangarhar', 'Dahbala', '01 Block,Badpash,Laghman', 'faridhussain@gmail.com', 'MBBS', 'Ariana University', '0766229510', 'Male', '1999-11-12', 'approve'),
(25, 'Naseemullah', 'Rafi', 'Orthopedic', 'Logar', 'Mohammad Agha', '02 Block,Chahar Asyab,Kabul', 'naseemullahrafi@gmail.com', 'MBBS', 'Spin Ghar University', '0777229510', 'Male', '1999-01-12', 'approve'),
(26, 'Subhanullah', 'Khan', 'Orthopedic', 'Ghazni', 'Deh Yak', '02 Block,Batikot,Nangarhar', 'subhanullahkhan@gmail.com', 'MBBS', 'Herat Medical Faculty', '0761229510', 'Male', '1880-03-31', 'approve'),
(27, 'Asad', 'Khan', 'Orthopedic', 'Konar', 'Asadabad', '12 Block,Khaki Safed,Farah', 'asadkhan@gmail.com', 'MD', 'Ariana University', '0777229510', 'Male', '1997-03-12', 'approve'),
(28, 'Masood', 'Kar', 'Cardiologist', 'Ghazni', 'Giro', '05 Block,Dara,Panjshir', 'masoodkar@gmail.com', 'MBBS', 'Spin Ghar University', '0771214352', 'Male', '1997-03-31', 'approve'),
(29, 'Janullah', 'Baz', 'Cardiologist', 'Kabul', 'Bagrami', '10 Block,Shah Walikot,Kandahar', 'janullahbaz@gmail.com', 'MD', 'Kardan University', '0773432123', 'Male', '1998-03-04', 'approve'),
(30, 'Ghani', 'Khan', 'Cardiologist', 'Laghman', 'Dawlat Shah', '05 Block,Tarwe,Paktika', 'ghanikhan@gmail.com', 'MD', 'Kardan University', '0706229510', 'Male', '1996-03-31', 'approve'),
(31, 'Zakar', 'Ahmad', 'Dermatology', 'Laghman', 'Dawlat Shah', '04 Block,Chahar Asyab,Kabul', 'zakarahmad@gmail.com', 'MBBS', 'Kardan University', '0786229510', 'Male', '1989-02-12', 'approve'),
(32, 'Shah', 'Nawaz', 'Dermatology', 'Laghman', 'Badpash', '03 Block,Batikot,Nangarhar', 'shahnawaz@gmail.com', 'MBBS', 'Kardan University', '0799007678', 'Male', '1990-08-08', 'approve'),
(33, 'Basit', 'Khan', 'Dermatology', 'Nangarhar', 'Achin', '03 Block,Dara Noor,Konar', 'basitkhan@gmail.com', 'MBBS', 'Spin Ghar University', '0771212234', 'Male', '1990-02-23', 'approve'),
(34, 'Shiasta', 'Gula', 'Dentist', 'Laghman', 'Mihtarlam', '03 Block,Deh Sabz,Kabul', 'shiastagula@gmail.com', 'MD', 'Ariana University', '0773445233', 'Female', '1990-03-31', 'approve'),
(35, 'Marwa', 'Khan', 'Dentist', 'Laghman', 'Qarghayi', '02 Block,Behsood,Nangarhar', 'marwakhan@gmail.com', 'MD', 'Kardan University', '0799733422', 'Female', '1998-03-02', 'approve'),
(36, 'Gul', 'Dana', 'Dentist', 'Kandahar', 'Spinboldak', '03 Block,Shah Walikot,Kandahar', 'guldana@gmail.com', 'MD', 'Ariana University', '0778767564', 'Female', '1990-03-31', 'approve'),
(37, 'Mehwish', 'Fatima', 'Eye', 'Logar', 'Baraki Barak', '02 Block,Deh Sabz,Kabul', 'mehwishfatima@gmail.com', 'MD', 'Kardan University', '0773432123', 'Female', '1999-03-31', 'approve'),
(38, 'Mehnoor', 'Ali', 'Eye', 'Balkh', 'Mazar-i-sharif', '04 Block,Khas Konar,Konar', 'mahnoorali@gmail.com', 'MBBS', 'Ariana University', '0777229510', 'Female', '1998-09-08', 'approve'),
(39, 'Zaba', 'Gula', 'Eye', 'Konar', 'Asadabad', '01 Block,Nahra-i-shahi,Balkh', 'zabagula@gmail.com', 'MD', 'Ariana University', '0766229510', 'Female', '1998-04-03', 'approve'),
(40, 'Sania', 'Ahmad', 'Primary Care', 'Laghman', 'Badpash', '01 Block,Ghardaz,Paktia', 'saniaahmad@gmail.com', 'MBBS', 'Kardan University', '0799229510', 'Female', '1997-03-04', 'approve'),
(41, 'Afreen', 'Khan', 'Primary Care', 'Laghman', 'Dawlat Shah', '01 Block,Arghistan,Kandahar', 'afreenkhan@gmail.com', 'MD', 'Kandahar Faculty of Medicine', '0766229510', 'Female', '1995-03-04', 'approve'),
(42, 'Soba', 'Khan', 'Primary Care', 'Paktia', 'Chamkani', '05 Block,Anaba,Panjshir', 'sobakhan@gmail.com', 'MBBS', 'Ariana University', '0776229510', 'Female', '1994-03-31', 'approve'),
(43, 'Mena', 'Ahmadi', 'ENT', 'Laghman', 'Qarghayi', '02 Block,Guldara,Kabul', 'menaahmadi@gmail.com', 'MD', 'Kandahar Faculty of Medicine', '0773466723', 'Female', '1993-02-02', 'approve'),
(44, 'Meera', 'Ali', 'ENT', 'Herat', 'Guzara', '04 Block,Parun,Kabul', 'meeraali@gmail.com', 'MD', 'Herat Medical Faculty', '0766229510', 'Female', '1993-03-03', 'approve'),
(45, 'Zobiada', 'Khan', 'ENT', 'Konar', 'Asadabad', '04 Block,Azra,Logar', 'zobiadakhan@gmail.com', 'MD', 'Nangarhar Medical Faculty', '0766229510', 'Female', '1990-03-04', 'approve'),
(46, 'Fahima', 'Aksha', 'Skin', 'Laghman', 'Dawlat Shah', '02 Block,Deh Sabz,Kabul', 'fahimaaksha@gmail.com', 'MBBS', 'Kardan University', '0799009487', 'Female', '1994-03-03', 'approve'),
(47, 'Batool', 'Khan', 'Skin', 'Kandahar', 'Spinboldak', '11 Block,Ghazni,Ghazni', 'batoolkhan@gmail.com', 'MD', 'Balkh University Faculty of Medicine', '0766229510', 'Female', '1997-03-07', 'approve'),
(48, 'Zeenat', 'Ali', 'Skin', 'Herat', 'Ghoryan', '12 Block,Dara Noor,Nangarhar', 'zennatali@gmail.com', 'MD', 'Balkh University Faculty of Medicine', '0706229510', 'Female', '1994-03-04', 'approve'),
(49, 'Maryam', 'Khan', 'Dermatologist', 'Kabul', 'Bagrami', '11 Block,Guldara,Kabul', 'maryamkhan@gmail.com', 'MD', 'Balkh University Faculty of Medicine', '0786229510', 'Female', '1990-03-04', 'approve'),
(50, 'Sakeena', 'Ahmadi', 'Dermatologist', 'Logar', 'Mohammad Agha', '05 Block,Chaparhar,Nangarhar', 'skeenaahmadi@gmail.com', 'MD', 'Nangarhar Medical Faculty', '0766229510', 'Female', '1993-02-02', 'approve'),
(51, 'Basmeena', 'Jan', 'Dermatologist', 'Kandahar', 'Spinboldak', '04 Block,Kamdesh,Nuristan', 'basmeenajan@gmail.com', 'MBBS', 'Herat Medical Faculty', '0774421234', 'Female', '1993-02-02', 'approve'),
(52, 'Alia', 'Khan', 'Urology', 'Kandahar', 'Arghandab', '04 Block,Maroof,Kandahar', 'aliakhan@gmail.com', 'MBBS', 'Herat Medical Faculty', '0799007678', 'Female', '1998-03-03', 'approve'),
(53, 'Fareshta', 'Noori', 'Urology', 'Konar', 'Dara Noor', '12 Block,Deh Sabz,Kabul', 'fareshtanoori@gmail.com', 'MD', 'Kardan University', '0766888123', 'Female', '1994-03-04', 'approve'),
(54, 'Shakeela', 'Noori', 'Urology', 'Logar', 'Mohammad Agha', '03 Block,Chaparhar,Nangarhar', 'shakeelanoori@gmail.com', 'MD', 'Kandahar Faculty of Medicine', '0774323653', 'Female', '1994-05-04', 'approve'),
(55, 'Rafia', 'Khan', 'Neurology', 'Balkh', 'Mazar-i-sharif', '05 Block,Kalakan,Kabul', 'rafiakhan@gmail.com', 'MD', 'Kandahar Faculty of Medicine', '0766229510', 'Female', '1991-03-02', 'approve'),
(56, 'Sheena', 'Bibi', 'Neurology', 'Laghman', 'Dawlat Shah', '05 Block,Dara Noor,Nangarhar', 'sheenabibi@gmail.com', 'MD', 'Herat Medical Faculty', '0766229510', 'Female', '1991-01-01', 'approve'),
(57, 'Safdar', 'Arman', 'Neurology', 'Nangarhar', 'Chaparhar', '03 Block,Zazai,Paktia', 'safdararman@gmail.com', 'MD', 'Balkh University Faculty of Medicine', '0777229510', 'Female', '1994-03-03', 'approve'),
(58, 'Sardara', 'Weeh', 'Orthopedic', 'Laghman', 'Dawlat Shah', '03 Block,Zazi Miadan,Khost', 'sardaraweeh@gmail.com', 'MD', 'Spin Ghar University', '0766229510', 'Female', '1990-03-03', 'approve'),
(59, 'Kareema', 'Ahmadi', 'Orthopedic', 'Herat', 'Herat', '04 Block,Khas Konar,Konar', 'kareemaahmadi@gmail.com', 'MD', 'Ariana University', '0773432123', 'Female', '1992-03-03', 'approve'),
(60, 'Zeenat', 'Sarwari', 'Orthopedic', 'Laghman', 'Dawlat Shah', '02 Block,Sayghan,Bamyan', 'zeenatsarwari@gmail.com', 'MD', 'Ariana University', '0799733422', 'Female', '1992-03-03', 'approve'),
(61, 'Nela', 'Bibi', 'Cardiologist', 'Laghman', 'Qarghayi', '04 Block,Istalif,Kabul', 'nelabibi@gmail.com', 'MD', 'Kardan University', '0766229510', 'Female', '1991-03-03', 'approve'),
(62, 'Geela', 'Bibi', 'Cardiologist', 'Nangarhar', 'Behsood', '02 Block,Dangam,Konar', 'geelabibi@gmail.com', 'MD', 'Kandahar Faculty of Medicine', '0777229510', 'Female', '1992-03-03', 'approve'),
(63, 'Noora', 'Ahmadi', 'Cardiologist', 'Laghman', 'Dawlat Shah', '03 Block,Farah,Kabul', 'nooraahmadi@gmail.com', 'MD', 'Spin Ghar University', '0799229510', 'Female', '1990-03-03', 'approve'),
(64, 'Asmara', 'Khan', 'Dermatologist', 'Balkh', 'Mazar-i-sharif', '03 Block,Istalif,Kabul', 'asmarakhan@gmail.com', 'MD', 'Ariana University', '0761229510', 'Female', '1994-03-03', 'approve');

-- --------------------------------------------------------

--
-- Table structure for table `doctorclinics`
--

CREATE TABLE `doctorclinics` (
  `doc_clinic_id` int(128) NOT NULL,
  `clinic_name` varchar(128) DEFAULT NULL,
  `clinic_address` varchar(128) DEFAULT NULL,
  `profile_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctoreducation`
--

CREATE TABLE `doctoreducation` (
  `doc_edu_id` int(128) NOT NULL,
  `degree` varchar(128) DEFAULT NULL,
  `college` varchar(128) DEFAULT NULL,
  `yearofcompletion` varchar(128) DEFAULT NULL,
  `profile_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctorexpierence`
--

CREATE TABLE `doctorexpierence` (
  `doc_exp_id` int(128) NOT NULL,
  `hospitalName` varchar(128) DEFAULT NULL,
  `startFrom` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `profile_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctorprofile`
--

CREATE TABLE `doctorprofile` (
  `profile_id` int(128) NOT NULL,
  `profile_biography` varchar(600) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `profile_city` varchar(128) DEFAULT NULL,
  `profile_province` varchar(128) DEFAULT NULL,
  `profile_fees` int(128) DEFAULT NULL,
  `profile_services` varchar(128) DEFAULT NULL,
  `profile_specilizations` varchar(128) DEFAULT NULL,
  `user_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctorprofile`
--

INSERT INTO `doctorprofile` (`profile_id`, `profile_biography`, `contact`, `profile_city`, `profile_province`, `profile_fees`, `profile_services`, `profile_specilizations`, `user_id`) VALUES
(1, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 1000, 'Dentist,Dentist Cleaning', '', 21),
(2, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777229510', NULL, NULL, 1300, 'Dentist,Dentist Cleaning,Dentist Check', '', 22),
(3, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777234343', NULL, NULL, 2000, 'Dentist ,Tooth Cleaning,Checking', '', 23),
(4, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0786229510', NULL, NULL, 700, 'Eye,Eye Testing,Eye Check', '', 24),
(5, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799229213', NULL, NULL, 1200, 'Eye,Eye Check,Eye Testing', '', 25),
(6, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0761229510', NULL, NULL, 600, 'Eye Check,Eye Cleaning,Eye Testing', '', 26),
(7, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766888123', NULL, NULL, 2500, 'Primary Care', '', 27),
(8, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777229510', NULL, NULL, 1700, 'Primary Care', '', 28),
(9, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0771212234', NULL, NULL, 1000, 'Primary Care', '', 29),
(10, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799009487', NULL, NULL, 1200, 'ENT', '', 30),
(11, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799009487', NULL, NULL, 600, 'ENT', '', 31),
(12, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0706229510', NULL, NULL, 726, 'ENT', '', 32),
(13, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777229510', NULL, NULL, 1600, 'Skin,Skin Cleaning', '', 33),
(14, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0772233124', NULL, NULL, 1300, 'Skin,Skin Checing', '', 34),
(15, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0773432123', NULL, NULL, 3000, 'Skin,Skin Check', '', 35),
(16, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799009487', NULL, NULL, 1500, 'Dermatologist', '', 36),
(17, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0786229510', NULL, NULL, 2000, 'Dermatologist', '', 37),
(18, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799229510', NULL, NULL, 1300, 'Dermatologist', '', 38),
(19, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0706229510', NULL, NULL, 1300, 'Urology', '', 39),
(20, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777229510', NULL, NULL, 1100, 'Urology', '', 40),
(21, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0706229534', NULL, NULL, 1600, 'Urology', '', 41),
(22, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0774421234', NULL, NULL, 1600, 'Neurology', '', 42),
(23, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0773445233', NULL, NULL, 1600, 'Dentist,Dentist Check', '', 54),
(24, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799733422', NULL, NULL, 1000, 'Dentist,Dentist Check', '', 55),
(25, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0773432123', NULL, NULL, 1300, 'Eye,Eye check,Eye Testing', '', 57),
(26, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777229510', NULL, NULL, 1100, 'Eye,Eye check,Eye Testing', '', 58),
(27, ' Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 1000, 'Eye,Eye Check,Eye Testing', '', 59),
(28, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799229510', NULL, NULL, 4000, 'Primary Care', '', 60),
(29, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 1500, 'Primary Care', '', 61),
(30, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0773466723', NULL, NULL, 1300, 'ENT', '', 63),
(31, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 1400, 'ENT', '', 64),
(32, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 600, 'ENT', '', 65),
(33, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799009487', NULL, NULL, 689, 'Skin,Skin Check', '', 66),
(34, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 500, 'Skin', '', 67),
(35, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0706229510', NULL, NULL, 1600, 'Skin', '', 68),
(36, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0766229510', NULL, NULL, 600, 'Cardiologist', '', 81),
(37, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0777229510', NULL, NULL, 1300, 'Cardiologist', '', 82),
(38, '\r\nFirstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '0799229510', NULL, NULL, 888, 'Cardiologist', '', 83),
(39, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '00923168797035', NULL, NULL, 3000, 'Eye,Eye check,Eye Testing', '', 86),
(40, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '00923168797035', NULL, NULL, 1350, 'Dentist,Tooth Cleaning', '', 87),
(41, 'Firstly Welcome to my profile, I am a doctor in Afghanistan which I am serving in many provinces so now i want to serve as online to bring some facilities to our people without any physical difficulties. So you are in a right place, health guide system is a good platform for Afghanistan people to easily search for approved doctors, clinics and so and as well make appointments with your own doctor. Thanks', '00923168797035', NULL, NULL, 2500, 'Skin,Skin Cleaning', '', 88);

-- --------------------------------------------------------

--
-- Table structure for table `doctorslots`
--

CREATE TABLE `doctorslots` (
  `user_id` int(128) DEFAULT NULL,
  `start_time` varchar(128) DEFAULT NULL,
  `end_time` varchar(128) DEFAULT NULL,
  `saturday` varchar(128) DEFAULT NULL,
  `sunday` varchar(128) DEFAULT NULL,
  `monday` varchar(128) DEFAULT NULL,
  `tuesday` varchar(128) DEFAULT NULL,
  `wednesday` varchar(128) DEFAULT NULL,
  `thursday` varchar(128) DEFAULT NULL,
  `friday` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctorslots`
--

INSERT INTO `doctorslots` (`user_id`, `start_time`, `end_time`, `saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`) VALUES
(21, '009:13 AM', '09:28 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(21, '12:16 PM', '12:31 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(21, '10:16 PM', '10:31 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(21, '10:14 PM', '10:29 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(21, '12:16 AM', '12:31 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(21, '02:19 PM', '02:34 PM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(21, '11:16 AM', '11:31 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(21, '12:17 AM', '12:32 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(21, '11:16 AM', '11:31 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(21, '12:17 AM', '12:32 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(21, '12:17 AM', '12:32 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(21, '12:25 AM', '12:40 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(22, '12:34 AM', '12:49 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(22, '12:42 AM', '12:57 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(22, '10:33 AM', '10:48 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(22, '11:34 AM', '11:49 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(22, '10:34 AM', '10:49 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(22, '11:34 AM', '11:49 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(22, '11:35 AM', '11:50 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(22, '12:36 AM', '12:51 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(22, '11:35 AM', '11:50 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(22, '12:38 AM', '12:53 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(22, '10:34 AM', '10:49 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(22, '11:35 AM', '11:50 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(23, '10:36 AM', '10:51 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(23, '11:37 AM', '11:52 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(23, '10:36 AM', '10:51 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(23, '11:37 AM', '11:52 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(23, '11:37 AM', '11:52 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(23, '12:36 AM', '12:51 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(23, '10:37 AM', '10:52 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(23, '11:38 AM', '11:53 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(23, '11:38 AM', '11:53 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(23, '12:39 AM', '12:54 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(24, '10:39 AM', '10:54 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(24, '11:39 AM', '11:54 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(24, '10:39 AM', '10:54 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(24, '11:40 AM', '11:55 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(24, '10:39 AM', '10:54 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(24, '12:40 AM', '12:55 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(24, '11:40 AM', '11:55 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(24, '12:40 AM', '12:55 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(24, '11:42 AM', '11:57 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(24, '12:41 AM', '12:56 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(24, '10:40 AM', '10:55 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(24, '11:41 AM', '11:56 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(25, '11:41 AM', '11:56 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(25, '12:42 AM', '12:57 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(25, '11:42 AM', '11:57 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(25, '12:43 AM', '12:58 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(25, '11:44 AM', '11:59 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(25, '12:41 AM', '12:56 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(25, '11:43 AM', '11:58 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(25, '12:43 AM', '12:58 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(25, '10:41 AM', '10:56 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(25, '11:43 AM', '11:58 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(26, '11:44 AM', '11:59 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(26, '11:44 AM', '11:59 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(26, '11:44 AM', '11:59 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(26, '10:43 AM', '10:58 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(26, '10:43 AM', '10:58 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(26, '12:43 AM', '12:58 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(27, '11:46 AM', '12:01 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(27, '11:47 AM', '12:02 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(27, '11:46 PM', '12:01 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(27, '10:46 PM', '11:01 PM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(27, '10:46 AM', '11:01 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(28, '10:47 AM', '11:02 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(28, '11:47 AM', '12:02 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(28, '11:48 AM', '12:03 PM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(28, '10:47 AM', '11:02 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(28, '10:48 AM', '11:03 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(28, '12:27 AM', '12:42 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(29, '11:49 AM', '12:04 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(29, '10:48 AM', '11:03 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(29, '10:49 AM', '11:04 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(29, '10:48 AM', '11:03 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(29, '10:48 AM', '11:03 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(30, '10:48 AM', '11:03 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(30, '10:50 AM', '11:05 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(30, '11:50 AM', '12:05 PM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(30, '10:50 AM', '11:05 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(30, '10:51 AM', '11:06 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(30, '10:51 AM', '11:06 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(31, '11:52 AM', '12:07 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(31, '11:52 AM', '12:07 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(31, '009:50 AM', '10:05 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(31, '10:51 AM', '11:06 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(31, '11:52 AM', '12:07 PM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(31, '009:51 AM', '10:06 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(32, '11:54 AM', '12:09 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(32, '11:54 AM', '12:09 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(32, '11:54 AM', '12:09 PM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(32, '10:53 AM', '11:08 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(32, '10:53 AM', '11:08 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(32, '11:54 AM', '12:09 PM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(33, '009:53 AM', '10:08 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(33, '10:54 AM', '11:09 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(33, '10:54 AM', '11:09 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(33, '009:54 AM', '10:09 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(33, '10:56 AM', '11:11 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(33, '10:55 AM', '11:10 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(34, '11:57 AM', '12:12 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(34, '10:57 AM', '11:12 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(34, '11:57 AM', '12:12 PM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(34, '10:56 AM', '11:11 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(34, '10:57 AM', '11:12 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(34, '10:58 AM', '11:13 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(35, '10:58 AM', '11:13 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(35, '11:59 AM', '12:14 PM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(35, '10:59 AM', '11:14 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(35, '11:59 AM', '12:14 PM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(35, '11:59 AM', '12:14 PM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(35, '10:58 AM', '11:13 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(36, '10:58 AM', '11:13 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(36, '11:00 AM', '11:15 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(36, '10:59 AM', '11:14 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(36, '11:00 AM', '11:15 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(36, '10:59 AM', '11:14 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(36, '10:001 AM', '10:16 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(37, '10:00 AM', '10:15 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(37, '11:001 AM', '11:16 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(37, '10:00 AM', '10:15 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(37, '11:00 AM', '11:15 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(37, '10:00 AM', '10:15 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(37, '11:00 AM', '11:15 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(38, '10:001 AM', '10:16 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(38, '12:001 AM', '12:16 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(38, '11:002 AM', '11:17 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(38, '10:002 AM', '10:17 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(38, '11:003 AM', '11:18 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(39, '10:002 AM', '10:17 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(39, '11:004 AM', '11:19 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(39, '11:005 AM', '11:20 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(39, '11:005 AM', '11:20 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(39, '11:005 AM', '11:20 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(40, '11:005 AM', '11:20 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(40, '11:006 AM', '11:21 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(40, '11:004 AM', '11:19 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(40, '11:005 AM', '11:20 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(40, '11:005 AM', '11:20 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(40, '12:006 AM', '12:21 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(41, '11:006 AM', '11:21 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(41, '12:007 AM', '12:22 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(41, '12:007 AM', '12:22 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(41, '11:006 AM', '11:21 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(41, '12:009 AM', '12:24 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(41, '12:16 AM', '12:31 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(42, '11:17 AM', '11:32 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(42, '11:15 AM', '11:30 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(42, '12:13 AM', '12:28 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(42, '12:12 AM', '12:27 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(42, '12:13 AM', '12:28 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(42, '11:13 AM', '11:28 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(54, '12:11 AM', '12:26 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(54, '12:11 AM', '12:26 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(54, '12:14 AM', '12:29 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(54, '12:16 AM', '12:31 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(54, '12:13 AM', '12:28 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(54, '11:13 AM', '11:28 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(55, '11:13 AM', '11:28 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(55, '12:13 AM', '12:28 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(55, '11:15 AM', '11:30 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(55, '11:13 AM', '11:28 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(55, '12:14 AM', '12:29 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(57, '12:14 AM', '12:29 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(57, '12:16 AM', '12:31 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(57, '12:18 AM', '12:33 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(57, '10:13 AM', '10:28 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(57, '10:13 PM', '10:28 PM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(58, '11:16 AM', '11:31 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(58, '12:16 AM', '12:31 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(58, '12:17 AM', '12:32 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(58, '11:15 AM', '11:30 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(58, '12:16 AM', '12:31 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(58, '12:18 AM', '12:33 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(59, '12:17 AM', '12:32 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(59, '12:19 AM', '12:34 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(59, '11:17 AM', '11:32 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(59, '10:16 AM', '10:31 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(59, '11:17 AM', '11:32 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(59, '10:17 AM', '10:32 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(60, '12:19 AM', '12:34 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(60, '12:20 AM', '12:35 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(60, '11:19 AM', '11:34 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(60, '12:17 AM', '12:32 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(60, '11:19 AM', '11:34 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(61, '12:20 AM', '12:35 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(61, '12:19 AM', '12:34 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(61, '11:20 AM', '11:35 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(61, '10:19 AM', '10:34 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(61, '11:21 AM', '11:36 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(61, '12:21 AM', '12:36 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(63, '12:23 AM', '12:38 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(63, '11:22 AM', '11:37 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(63, '12:23 AM', '12:38 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(63, '11:23 AM', '11:38 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(63, '10:21 AM', '10:36 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(64, '11:23 AM', '11:38 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(64, '11:23 AM', '11:38 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(64, '11:23 AM', '11:38 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(64, '10:22 AM', '10:37 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(64, '11:24 AM', '11:39 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(65, '12:25 AM', '12:40 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(65, '12:27 AM', '12:42 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(65, '10:23 AM', '10:38 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(65, '11:24 AM', '11:39 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(65, '11:24 AM', '11:39 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(65, '12:25 AM', '12:40 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(66, '11:25 AM', '11:40 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(66, '12:26 AM', '12:41 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(66, '12:25 AM', '12:40 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(66, '10:25 AM', '10:40 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(66, '11:26 AM', '11:41 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(66, '12:27 AM', '12:42 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(67, '12:26 AM', '12:41 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(67, '10:26 AM', '10:41 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(67, '11:27 AM', '11:42 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(67, '12:28 AM', '12:43 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(67, '11:28 AM', '11:43 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(67, '12:28 AM', '12:43 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(68, '11:29 AM', '11:44 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(68, '11:28 AM', '11:43 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(68, '12:30 AM', '12:45 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(68, '12:31 AM', '12:46 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(68, '12:32 AM', '12:47 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(68, '10:28 AM', '10:43 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(81, '12:31 AM', '12:46 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(81, '11:30 AM', '11:45 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(81, '12:31 AM', '12:46 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(81, '12:32 AM', '12:47 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(82, '12:32 AM', '12:47 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(82, '11:32 AM', '11:47 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(82, '12:34 AM', '12:49 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(82, '11:32 AM', '11:47 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(82, '11:34 AM', '11:49 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(82, '11:34 AM', '11:49 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(83, '11:34 AM', '11:49 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(83, '12:34 AM', '12:49 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(83, '11:34 AM', '11:49 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(83, '12:34 AM', '12:49 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(83, '12:35 AM', '12:50 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(83, '12:35 AM', '12:50 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(86, '12:42 AM', '12:57 AM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(86, '12:43 AM', '12:58 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(86, '10:42 AM', '10:57 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(86, '11:43 AM', '11:58 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(86, '11:43 AM', '11:58 AM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(86, '006:46 AM', '07:01 AM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(87, '11:45 AM', '12:00 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(87, '12:44 AM', '12:59 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(87, '12:42 AM', '12:57 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(87, '11:47 AM', '12:02 PM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL),
(87, '11:46 AM', '12:01 PM', NULL, NULL, NULL, NULL, 'yes', NULL, NULL),
(87, '11:47 AM', '12:02 PM', NULL, NULL, NULL, NULL, NULL, 'yes', NULL),
(88, '11:47 AM', '12:02 PM', 'yes', NULL, NULL, NULL, NULL, NULL, NULL),
(88, '10:46 AM', '11:01 AM', NULL, 'yes', NULL, NULL, NULL, NULL, NULL),
(88, '12:43 AM', '12:58 AM', NULL, NULL, 'yes', NULL, NULL, NULL, NULL),
(88, '10:46 AM', '11:01 AM', NULL, NULL, NULL, 'yes', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `hos_id` int(128) NOT NULL,
  `hos_name` varchar(128) DEFAULT NULL,
  `hos_numOfDept` int(128) DEFAULT NULL,
  `hos_numOfDoctors` int(128) DEFAULT NULL,
  `hos_deptDesc` varchar(128) DEFAULT NULL,
  `hos_location` varchar(128) DEFAULT NULL,
  `contact` varchar(10) DEFAULT NULL,
  `hos_status` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hos_id`, `hos_name`, `hos_numOfDept`, `hos_numOfDoctors`, `hos_deptDesc`, `hos_location`, `contact`, `hos_status`) VALUES
(1, 'New Kabul', 2, 23, 'Eye,Dentist', '04 Block,Guldara,Kabul', '0766229510', 'Approved'),
(2, 'Al Shafa', 3, 10, 'Eye,Skin,Dermatologist', '04 Block,Chaparhar,Nangarhar', '0799009487', 'Approved'),
(3, 'New Sahat', 4, 44, 'Skin,Orthopedic,Dermatologist,Dentist', '03 Block,Guldara,Kabul', '0772323421', 'Approved'),
(4, 'Ali Abad', 3, 32, 'Urology,Neurology,Skin', '05 Block,Kalakan,Kabul', '0773423345', 'Approved'),
(5, 'Ahmad Shah Baba', 2, 43, 'Primary Care,Eye', '03 Block,Behsood,Nangarhar', '0763323433', 'Approved'),
(6, 'Peer Baba', 4, 34, 'Eye,Skin,Orthopedic,Dentist', '02 Block,Chapa Dara,Konar', '0774324452', 'Approved'),
(7, 'Andkhoy', 5, 50, 'Eye,Skin,Primary Care,ENT,Dentist', '02 Block,Dara Noor,Konar', '0773453223', 'Approved'),
(8, 'New Afghan', 3, 23, 'Cardiologist,Neurology,Skin', '03 Block,Mandol,Nuristan', '0773432342', 'Approved'),
(9, 'Pamir', 4, 23, 'Cardiologist,Eye,Dentist,Orthopedic', '09 Block,Parun,Nuristan', '0783432343', 'Approved'),
(10, 'Ali Shang', 2, 23, 'Skin,Dentist', '02 Block,Qarghayi,Laghman', '0783432343', 'Approved'),
(11, 'New Ghani', 4, 23, 'Cardiologist,Dermatologist,Skin,Eye', '04 Block,Qarghayi,Laghman', '0793432345', 'Approved'),
(12, 'Mer Zaman', 2, 23, 'Urology,Neurology', '04 Block,Balkh,Balkh', '0793432345', 'Approved'),
(13, 'New Balkh', 3, 23, 'Dermatologist,ENT,Eye', '01 Block,Mazar-i-sharif,Balkh', '0783453432', 'Approved'),
(14, 'Kabul International', 4, 32, 'ENT,Orthopedic,Dentist,Skin', '03 Block,Panjab,Bamyan', '0763424323', 'Approved'),
(15, 'Merwari National', 3, 34, 'ENT,Skin,Eye', '05 Block,Shibar,Bamyan', '0763422894', 'Approved'),
(16, 'American Medical ', 5, 23, 'Eye,ENT,Dermatologist,Skin,Dentist', '04 Block,Gulistan,Farah', '0782323433', 'Approved'),
(17, 'New Halimi', 2, 12, 'Dentist,Skin', '05 Block,Nawa,Ghazni', '0793430453', 'Approved'),
(18, 'Karzia National', 3, 23, 'Dermatologist,Neurology,ENT', '04 Block,Giro,Ghazni', '0763424321', 'Approved'),
(19, 'AL Wajid', 3, 23, 'Primary Care,Orthopedic,Cardiologist', '03 Block,Shah Walikot,Kandahar', '0763432345', 'Approved'),
(20, 'Speen National', 4, 23, 'Eye,ENT,Skin,Primary Care,Neurology', '02 Block,Zazi Miadan,Khost', '0783243434', 'Approved'),
(21, 'Bacha Khan', 2, 32, 'Primary Care,ENT', '04 Block,Said Karam,Paktia', '0766229510', 'Approved'),
(22, 'Sakhat Ama', 4, 32, 'Eye,Dermatologist,Cardiologist,Dentist', '03 Block,Anaba,Panjshir', '0763432412', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `medicals`
--

CREATE TABLE `medicals` (
  `medical_id` int(128) NOT NULL,
  `medical_name` varchar(128) DEFAULT NULL,
  `medical_location` varchar(128) DEFAULT NULL,
  `contact` varchar(10) DEFAULT NULL,
  `medical_status` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicals`
--

INSERT INTO `medicals` (`medical_id`, `medical_name`, `medical_location`, `contact`, `medical_status`) VALUES
(1, 'AL Ahmad', '02 Block,Chahar Asyab,Kabul', '0773432123', 'Approved'),
(2, 'New Parwas', '03 Block,Chahar Asyab,Kabul', '0774421234', 'Approved'),
(3, 'Parwan', '01 Block,Behsood,Nangarhar', '0766229510', 'Approved'),
(4, 'Badshah', '02 Block,Dahbala,Nangarhar', '0762432432', 'Approved'),
(5, 'Al Zaman', '02 Block,Dangam,Konar', '0790023434', 'Approved'),
(6, 'Nawa Zwand', '03 Block,Mandol,Nuristan', '0790023432', 'Approved'),
(7, 'Kera Mera', '02 Block,Mandol,Nuristan', '0773243432', 'Approved'),
(8, 'New Yabo', '03 Block,Qarghayi,Laghman', '0790023434', 'Approved'),
(9, 'Al Zainat', '02 Block,Nahra-i-shahi,Balkh', '0790023433', 'Approved'),
(10, 'Jan Agha', '02 Block,Sayghan,Bamyan', '0773242343', 'Approved'),
(11, 'Zarin', '02 Block,Balkh,Balkh', '0790203432', 'Approved'),
(12, 'Nera Mera', '03 Block,Gulistan,Farah', '0772343423', 'Approved'),
(13, 'Al Sawafi', '03 Block,Guzara,Herat', '0762434323', 'Approved'),
(14, 'Moqadasa', '02 Block,Shah Walikot,Kandahar', '0792343475', 'Approved'),
(15, 'Paroon', '01 Block,Zazi Miadan,Khost', '0792342342', 'Approved'),
(16, 'Seenda', '02 Block,Charkh,Logar', '0796723467', 'Approved'),
(17, 'Al Jan', '03 Block,Naka,Paktika', '0762543245', 'Approved'),
(18, 'AL Tafa', '02 Block,Rokha,Panjshir', '0792546236', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `medicineindustry`
--

CREATE TABLE `medicineindustry` (
  `medicine_id` int(128) NOT NULL,
  `medicine_name` varchar(128) DEFAULT NULL,
  `company_name` varchar(128) DEFAULT NULL,
  `medicine_status` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `outsidedoctor`
--

CREATE TABLE `outsidedoctor` (
  `id` int(128) NOT NULL,
  `firstname` varchar(128) DEFAULT NULL,
  `lastname` varchar(128) DEFAULT NULL,
  `specialization` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `gender` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outsidedoctor`
--

INSERT INTO `outsidedoctor` (`id`, `firstname`, `lastname`, `specialization`, `country`, `location`, `contact`, `email`, `gender`) VALUES
(1, 'Zeeshan', 'Ghalani', 'Eye', 'Pakistan', 'Phase 1,Hayatabad,Peshawar', '00923168797035', 'zeeshanghalani@gmail.com', 'Male'),
(2, 'Saifi', 'Ahmad', 'Dentist', 'Pakistan', 'Phase 3,Hayatabad,Peshawar', '00923168797035', 'saifiahmad@gmail.com', 'Male'),
(3, 'Numan', 'Ali', 'Skin', 'Pakistan', 'Phase 6,Hayatabad,Peshawar', '00923168797035', 'numanali@gmail.com', 'Male'),
(4, 'Ahmad Saigi', 'Hashin', 'Urology', 'Pakistan', 'Phase 4,Abdara Road,Peshawar', '00923168797035', 'ahmadsaifi@gmail.com', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(128) NOT NULL,
  `file_name` varchar(128) DEFAULT NULL,
  `user_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `file_name`, `user_id`) VALUES
(1, '1598242664.jpg', 21),
(2, '1598243633.jpg', 22),
(3, '1598243799.jpg', 23),
(4, '1598243936.jpg', 24),
(5, '1598244076.jpg', 25),
(6, '1598244195.jpg', 26),
(7, '1598244295.jpg', 27),
(8, '1598244403.jpg', 28),
(9, '1598244480.jpg', 29),
(10, '1598244565.jpg', 30),
(11, '1598244675.jpg', 31),
(12, '1598244765.jpg', 32),
(13, '1598244870.jpg', 33),
(14, '1598244979.jpg', 34),
(15, '1598245076.jpg', 35),
(16, '1598245165.jpg', 36),
(17, '1598245259.jpg', 37),
(18, '1598245336.jpg', 38),
(19, '1598245413.jpg', 39),
(20, '1598245494.jpg', 40),
(21, '1598245576.jpg', 41),
(22, '1598245704.jpg', 42),
(23, '1598245836.jpg', 54),
(24, '1598245918.jpg', 55),
(25, '1598246017.jpg', 57),
(26, '1598246106.jpg', 58),
(27, '1598246202.jpg', 59),
(28, '1598246287.jpg', 60),
(29, '1598246380.jpg', 61),
(30, '1598246487.jpg', 63),
(31, '1598246561.jpg', 64),
(32, '1598246645.jpg', 65),
(33, '1598246730.jpg', 66),
(34, '1598246831.jpg', 67),
(35, '1598246918.jpg', 68),
(36, '1598246998.jpg', 81),
(37, '1598247079.jpg', 82),
(38, '1598247161.jpg', 83),
(39, '1598247343.jpg', 84),
(40, '1598247373.jpg', 85),
(41, '1598247789.jpg', 86),
(42, '1598247914.jpg', 87),
(43, '1598247997.jpg', 88),
(44, '1598251305.jpg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_d` int(128) NOT NULL,
  `profile_id` int(128) DEFAULT NULL,
  `reviewer_id` int(128) DEFAULT NULL,
  `reviewer_msg` mediumtext NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rating` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(128) NOT NULL,
  `user_name` varchar(128) DEFAULT NULL,
  `user_username` varchar(128) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_address` varchar(128) DEFAULT NULL,
  `user_contact` varchar(128) DEFAULT NULL,
  `user_type` varchar(128) DEFAULT NULL,
  `user_status` varchar(128) DEFAULT NULL,
  `doc_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_username`, `user_password`, `user_address`, `user_contact`, `user_type`, `user_status`, `doc_id`) VALUES
(11, 'Said Muqeem Halimi', 'muqeem12@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'super admin', 'approved', NULL),
(13, 'jan abc', 'janahmad@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', '', '0766229510', 'moha', 'approved', NULL),
(21, 'Waheed Hashimi', 'wahidhashimi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 1),
(22, 'Said Aminullah', 'saidaminullah@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 2),
(23, 'Manan Hashimi', 'mananhashimi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 3),
(24, 'Shiiab Haidary', 'shoiabhaidary@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 4),
(25, 'Zubair Wafa', 'zubairwafa@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 5),
(26, 'Samim Saifi', 'samimsaifi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 6),
(27, 'Akramullah Hashimi', 'akramullahhashimi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 7),
(28, 'Arfanullah Halimi', 'arfanullahhalimi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 8),
(29, 'Rahim Raifi', 'rahimraifi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 9),
(30, 'Mirwas Sharefi', 'mirwassharefi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 10),
(31, 'Zesshan Sarwari', 'zeeshansarwari@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 11),
(32, 'ferdos asghara', 'ferdosasghara@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 12),
(33, 'qasam bari', 'qasambari@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 13),
(34, 'Azizullah Hashimi', 'azizullahhashimi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 14),
(35, 'Javid Qaramal', 'javidqaramal@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 15),
(36, 'Wajid Hussain', 'wajidhussain@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 16),
(37, 'Muhammad Halim', 'muhammadhalim@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 17),
(38, 'Muhammad Ishaq', 'muhammadishaq@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 18),
(39, 'Farooq Wardaq', 'farooqwardaq@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 19),
(40, 'Ayaz Khan', 'ayazkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 20),
(41, 'Karim Khan', 'karimkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 21),
(42, 'Khan Ameer', 'khanameer@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 22),
(43, 'Jafar Safari', 'jafarsafari@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 23),
(44, 'Farid Hussain', 'faridhussain@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 24),
(45, 'Naseemullah Rafi', 'naseemullahrafi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 25),
(46, 'Subhanullah Khan', 'subhanullahkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 26),
(47, 'Asad Khan', 'asadkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 27),
(48, 'Masood Kar', 'masoodkar@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 28),
(49, 'Janullah Baz', 'janullahbaz@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 29),
(50, 'Ghani Khan', 'ghanikhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 30),
(51, 'Zakar Ahmad', 'zakarahmad@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 31),
(52, 'Shah Nawaz', 'shahnawaz@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 32),
(53, 'Basit Khan', 'basitkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 33),
(54, 'Shiasta Gula', 'shiastagula@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 34),
(55, 'Marwa Khan', 'marwakhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 35),
(56, 'Marwa Khan', 'marwakhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 36),
(57, 'Gul Dana', 'guldana@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 37),
(58, 'Mehwish Fatima', 'mehwishfatima@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 38),
(59, 'Mahnoor Ali', 'mahnoorali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 39),
(60, 'Zaba Gula', 'zabagula@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 40),
(61, 'Sania Ahmad', 'saniaahmad@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 41),
(62, 'Afreen Khan', 'mahnoorali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 42),
(63, 'Soba Khan', 'sobakhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 43),
(64, 'Mena Ahmadi', 'menaahmadi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 44),
(65, 'Meera Ali', 'meeraali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 45),
(66, 'Zobiada Khan', 'zobiadakhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 46),
(67, 'Fahima Aksha', 'fahimaaksha@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 47),
(68, 'Batool Khan', 'batoolkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 48),
(69, 'Zennat Ali', 'zennatali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 49),
(70, 'Maryam Khan', 'maryamkhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 50),
(71, 'Skeena Ahmadi', 'skeenaahmadi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 51),
(72, 'Basmeena Jan', 'basmeenajan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 52),
(73, 'Alia Khan', 'aliakhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 53),
(74, 'Fareshta Noori', 'fareshtanoori@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 54),
(75, 'Shakeela Noori', 'shakeelanoori@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 55),
(76, 'Rafia Khan', 'rafiakhan@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 56),
(77, 'Sheena Bibi', 'sheenabibi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 57),
(78, 'Safdar Arman', 'safdararman@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 58),
(79, 'Kareema Ahmadi', 'kareemaahmadi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 59),
(80, 'Zeenat Sarwari', 'zeenatsarwari@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 60),
(81, 'Nela Bibi', 'nelabibi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 61),
(82, 'Geela Bibi', 'geelabibi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 62),
(83, 'Noora Ahmadi', 'nooraahmadi@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'doctor', 'approved', 63),
(84, 'Ahmad Ali', 'ahmadali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'patient', 'approved', NULL),
(85, 'Zafar Ali', 'zafarali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Kabul', '0766229510', 'patient', 'approved', NULL),
(86, 'Zeeshan Ghalani', 'zeeshanghalani@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Peshawar', '00923168797035', 'outside doctor', 'approved', NULL),
(87, 'Saifi Ahmad', 'saifiahmad@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Peshawar', '00923168797035', 'outside doctor', 'approved', NULL),
(88, 'Numan Ali', 'numanali@gmail.com', '$2y$10$C3/aktWNxlpRE79Z0XYwueiE9qFJJNDmF6DTcKENB4HXxSXpfjPl6', 'Peshawar', '00923168797035', 'outside doctor', 'approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(128) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `age` int(128) DEFAULT NULL,
  `gender` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `name`, `age`, `gender`, `contact`) VALUES
(1, 'Ahmad Aku', 23, 'Male', '0766229510');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doc_user_id` (`doc_user_id`),
  ADD KEY `visitor_id` (`visitor_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_user_id` (`to_user_id`),
  ADD KEY `from_user_id` (`from_user_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `doctorclinics`
--
ALTER TABLE `doctorclinics`
  ADD PRIMARY KEY (`doc_clinic_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `doctoreducation`
--
ALTER TABLE `doctoreducation`
  ADD PRIMARY KEY (`doc_edu_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `doctorexpierence`
--
ALTER TABLE `doctorexpierence`
  ADD PRIMARY KEY (`doc_exp_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `doctorprofile`
--
ALTER TABLE `doctorprofile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `doctorslots`
--
ALTER TABLE `doctorslots`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hos_id`);

--
-- Indexes for table `medicals`
--
ALTER TABLE `medicals`
  ADD PRIMARY KEY (`medical_id`);

--
-- Indexes for table `medicineindustry`
--
ALTER TABLE `medicineindustry`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `outsidedoctor`
--
ALTER TABLE `outsidedoctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_d`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doc_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `doctorclinics`
--
ALTER TABLE `doctorclinics`
  MODIFY `doc_clinic_id` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctoreducation`
--
ALTER TABLE `doctoreducation`
  MODIFY `doc_edu_id` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctorexpierence`
--
ALTER TABLE `doctorexpierence`
  MODIFY `doc_exp_id` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctorprofile`
--
ALTER TABLE `doctorprofile`
  MODIFY `profile_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `hos_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `medicals`
--
ALTER TABLE `medicals`
  MODIFY `medical_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `medicineindustry`
--
ALTER TABLE `medicineindustry`
  MODIFY `medicine_id` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outsidedoctor`
--
ALTER TABLE `outsidedoctor`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_d` int(128) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doc_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `chat_message_ibfk_1` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_message_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctorclinics`
--
ALTER TABLE `doctorclinics`
  ADD CONSTRAINT `doctorclinics_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `doctorprofile` (`profile_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctoreducation`
--
ALTER TABLE `doctoreducation`
  ADD CONSTRAINT `doctoreducation_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `doctorprofile` (`profile_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctorexpierence`
--
ALTER TABLE `doctorexpierence`
  ADD CONSTRAINT `doctorexpierence_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `doctorprofile` (`profile_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctorprofile`
--
ALTER TABLE `doctorprofile`
  ADD CONSTRAINT `doctorprofile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctorslots`
--
ALTER TABLE `doctorslots`
  ADD CONSTRAINT `doctorslots_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `doctor` (`doc_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
