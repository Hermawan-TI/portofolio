-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jun 2025 pada 08.01
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_portofolio`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publish_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `publish_date`) VALUES
(1, 'Building a Technological Foundation from an Early Age', 'As the world continues to evolve, technology has become an inseparable part of everyday life. Hermawan, a student of Informatics Engineering at Universitas Maritim Raja Ali Haji, has been on a journey in the field of technology since his secondary school years. His interest in the digital world and science grew through his participation in various academic competitions such as the Social Studies Olympiad in junior high school and the Biology and Mathematics Olympiads (OSN) in senior high school. This passion did not arise overnight—it was shaped by a strong curiosity and a consistent enthusiasm for learning.\r\n\r\nIn addition to his academic pursuits, Hermawan has actively developed his character through various student organizations. He served as the Head of the Character Development Division in his junior high OSIS (student council) and later joined the Religious Affairs Division and Scout Council in senior high. These roles honed his leadership, sense of responsibility, and teamwork—essential values that laid a strong foundation for tackling challenges in the tech world.\r\n\r\nAs he entered university, Hermawan delved deeper into software development. He learned various programming languages and design tools such as HTML, CSS, JavaScript, PHP, MySQL, and Figma. With a strong ambition to become a Full Stack Developer, he explored both front-end and back-end development. His growing passion for technology is reflected in his dedication to real-world, application-based coursework projects.\r\n\r\nAlthough still in the learning phase, Hermawan believes that technical skills must be accompanied by creativity and a collaborative spirit. He strives not only for good grades but also to create meaningful, usable work. This dedication drives him to continually seek opportunities to learn, experiment, and contribute to the broader world of technology.\r\n\r\nWith a solid foundation built from an early age and a strong desire to grow, Hermawan remains optimistic about his journey in the IT field. To him, technology is not just a tool—it’s a bridge to build real solutions for society. His commitment to learning and growing since his youth stands as a testament that the path to a brighter future begins with small, consistent steps.', '2025-06-22'),
(2, 'Collaboration and Innovation in Every Technological Project', 'Pursuing a degree in Informatics Engineering is not only about mastering theoretical concepts but also about working together to create real-world solutions. Hermawan, alongside his team members, has completed various technology-based projects that demanded not only technical skills but also strong collaborative abilities. Each project became an arena for exploration, discussion, and joint execution, all aimed at producing valuable and impactful outcomes.\r\n\r\nOne notable project involved developing a maritime tourism destination website. In this project, Hermawan and his team combined interface design, front-end programming, and content management based on user needs. The result was a user-friendly and informative website that effectively showcased the tourism potential of the Riau Archipelago. The project highlighted how a well-organized team effort can produce functional and aesthetically pleasing digital products.\r\n\r\nThe Smart Courier and Smart Parking System projects further demonstrated the importance of team coordination in uniting algorithms, graphic programming, and user interface logic. Within the team, each member contributed based on their strengths—some focused on algorithmic logic, others handled visual presentation, while some took charge of documentation and system flow. Hermawan himself played a key role in developing the core logic and ensuring the usability of the system design.\r\n\r\nOne of the most challenging projects was face recognition using deep learning, developed for the Artificial Intelligence course. This project required a clear division of tasks—from data preprocessing and model training to system deployment. Thanks to strong team synergy, the project was completed on time with satisfactory results. It proved that collaboration is the key to success, even in complex topics involving advanced technologies.\r\n\r\nAll of these projects were more than just academic assignments—they became valuable learning experiences in building teamwork, communication, and shared responsibility. Hermawan believes that great technology is not born from individual efforts alone, but from teams that trust, complement each other, and share a common vision. With these collaborative experiences, he feels confident in taking the next step into the professional world, where innovation is built upon the foundation of strong collaboration.', '2025-06-22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `description` text NOT NULL,
  `project_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `year`, `description`, `project_image`) VALUES
(1, 'Pulau Mubut Darat Tourism Website', 2025, 'Developed a web-based tourism information website as part of the Web Design course project.', '1750912869_Projects_PW.jpeg'),
(2, 'Turing Machine Visualization Website', 2024, 'Developed a web-based project for the Theory of Formal Languages and Automata (TBFO) course to simulate and visualize Turing Machines.', '1750913266_Project_TBFO.png'),
(3, 'Face Recognition with Deep Learning', 2024, 'This project was developed for the Artificial Intelligence course, implementing Deep Learning methods to perform face recognition.', '1750913866_Project_AI.png'),
(4, 'Maritime Tourism Destination Website', 2025, 'This website was developed for the Human-Computer Interaction course, focusing on maritime tourism destinations in the Riau Islands Province.', '1750915101_project_imk.png'),
(5, 'Smart Courier System', 2025, 'This project was developed as part of the Algorithm Design and Analysis course. ', '1750915857_Project_PAA.png'),
(6, 'Smart Parking System Based on IoT', 2025, 'This project was developed as part of the Digital Systems course, aiming to create a smart parking system based on the Internet of Things (IoT).', '1750918554_Project_sisdig.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resume_items`
--

CREATE TABLE `resume_items` (
  `id` int(11) NOT NULL,
  `type` enum('education','experience','organization') NOT NULL,
  `title` varchar(255) NOT NULL,
  `period` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `resume_items`
--

INSERT INTO `resume_items` (`id`, `type`, `title`, `period`, `description`) VALUES
(1, 'education', 'Universitas Maritim Raja Ali Haji', '2023 - Sekarang', 'Bachelor’s Degree in Informatics Engineering, Faculty of Engineering. Studying software development, information systems, and web technologies to build a professional career in IT.'),
(4, 'education', 'SMA Negeri 3 Senayang', '2020-2023', 'Majored in Science (MIPA), focusing on Mathematics and Natural Sciences as a foundation for pursuing further studies in technology and informatics.'),
(5, 'education', 'SMP Negeri 2 Senayang', '2017-2020', 'Undertook junior high school education with a strong focus on character development and foundational academic skills.'),
(6, 'education', 'SD Negeri 003 Senayang', '2011-2017', 'Completed elementary education with early exposure to reading, writing, arithmetic, and character-based learning activities.'),
(7, 'organization', 'Student Council – SMA Negeri 3 Senayang', '2021-2022', 'Served as a Member of the Religious Affairs Division. Organized Islamic religious events, spiritual gatherings, and activities aimed at strengthening students’ religious values and character.'),
(8, 'organization', 'Boy Scouts – SMA Negeri 3 Senayang', '2021-2023', 'Served as a member of the Ambalan Council. Engaged in planning and executing scouting activities, mentoring new members, and organizing regular training and induction events.'),
(16, 'organization', 'Student Council – SMP Negeri 2 Senayang', '2018-2019', 'Served as Head of the Noble Character Division. Coordinated character education programs including social initiatives, school clean-ups, and student ethics campaigns.'),
(17, 'organization', 'Boy Scouts – SMP Negeri 2 Senayang', '2018-2019', 'Actively participated in scouting activities and joined the Kwartir Cabang (District Level) Grand Camp. Developed leadership, teamwork, and resilience through outdoor programs.'),
(18, 'experience', 'Participant – IPS Olympiad (Sub-District Level)', 'SMP Negeri 2 Senayang – 2019', 'Represented the school in the Social Science Olympiad at the sub-district level. Trained analytical thinking and understanding of geography, history, and basic economics.'),
(19, 'experience', 'Participant – OSN Biology (District Level)', 'SMA Negeri 3 Senayang – 2021', 'Participated in the Biology branch of the National Science Olympiad at the district level. Enhanced scientific reasoning and foundational biology skills.'),
(20, 'experience', 'Participant – OSN Mathematics (District Level)', 'SMA Negeri 3 Senayang – 2022', 'Represented the school in the Mathematics branch of the National Science Olympiad (OSN) at the district level. Focused on solving high-difficulty problems in logic, algebra, and geometry.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_price` varchar(255) DEFAULT NULL,
  `service_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_price`, `service_description`) VALUES
(1, 'User Interface (UI) Design', 'Starting from: $16 – $48 USD', 'Designing modern and responsive website interfaces using Figma. Focused on intuitive navigation and user-friendly visual experience. Perfect for personal branding, startups, or academic projects.'),
(2, 'Full-Stack Web Development', 'Starting from: $32 – $95 USD', 'Building websites from both front-end and back-end using HTML, CSS, JavaScript, PHP, and MySQL. Ideal for business landing pages, portfolios, or basic information systems.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `setting_name` varchar(50) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`setting_name`, `setting_value`) VALUES
('contact_email', 'hermawan@student.umrah.ac.id'),
('contact_github', 'https://github.com/Hermawan-TI'),
('contact_linkedin', 'https://www.linkedin.com/in/hermawan-0a3a03357/'),
('contact_whatsapp', '6285765605251'),
('full_name', 'Hermawan'),
('photo_profile', 'profil.png'),
('summary', 'I’m an Informatics Engineering student at Universitas Maritim Raja Ali Haji with a strong interest in web development, software engineering, and information systems. Since high school, I’ve been active in science olympiads and student organizations, while continuously improving my front-end and back-end development skills. I believe that technology combined with creativity can create impactful solutions. Let’s build something great together!'),
('tagline', 'Student | Full Stack Web Developer ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `skill_icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skills`
--

INSERT INTO `skills` (`id`, `skill_name`, `skill_icon`) VALUES
(3, 'JavaScript', 'fab fa-js'),
(6, 'Figma', 'fab fa-figma'),
(8, 'HTML5', 'fab fa-html5'),
(9, 'CSS3', 'fab fa-css3-alt'),
(10, 'PHP', 'fab fa-php'),
(11, 'MYSQL', 'fas fa-database');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(5, 'hermawan', '$2y$10$0YmPernQZcGTvJ8vynXZoOu8xqNfz2XGJQPPhZAPwokjhR.oU2Z8m');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `resume_items`
--
ALTER TABLE `resume_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_name`);

--
-- Indeks untuk tabel `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `resume_items`
--
ALTER TABLE `resume_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
