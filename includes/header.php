<?php
// Selalu mulai dengan koneksi database
require_once 'db.php';

// Ambil semua data settings agar tersedia di semua halaman
$settings_result = mysqli_query($conn, "SELECT * FROM settings");
$settings = [];
while ($row = mysqli_fetch_assoc($settings_result)) {
    $settings[$row['setting_name']] = $row['setting_value'];
}

// LOGIKA BARU: Dapatkan nama file saat ini untuk menandai menu aktif
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($settings['full_name'] ?? 'Portofolio'); ?> - Web Portofolio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="index.php">My Portfolio</a>
                </div>
                <button class="menu-toggle" id="mobile-menu-toggle" aria-label="Buka Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="main-nav">
                    <li class="dropdown <?php if($current_page == 'index.php') echo 'active'; ?>">
                        <a href="index.php">Home <i class="fas fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php#home">About</a></li>
                            <li><a href="index.php#keahlian">Skills</a></li>
                            <li><a href="index.php#proyek">Project</a></li>
                            <li><a href="index.php#pendidikan">Education</a></li>
                            <li><a href="index.php#pengalaman">Experience</a></li>
                            <li><a href="index.php#organisasi">Organization</a></li>
                        </ul>
                    </li>
                    <li><a href="articles.php" class="<?php if($current_page == 'articles.php' || $current_page == 'single-article.php') echo 'active'; ?>">Article</a></li>
                    <li><a href="contact.php" class="<?php if($current_page == 'contact.php') echo 'active'; ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>