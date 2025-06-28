<?php
require_once dirname(__DIR__, 2) . '/includes/db.php';

$settings_result = mysqli_query($conn, "SELECT * FROM settings");
$settings = [];
while ($row = mysqli_fetch_assoc($settings_result)) {
    $settings[$row['setting_name']] = $row['setting_value'];
}

$timeout = 1800;
$is_session_valid = true;

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $is_session_valid = false;
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    $is_session_valid = false;
}

if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    $is_session_valid = false;
}

if (!$is_session_valid) {
    session_unset();
    session_destroy();
    header("location: login.php?message=session_expired");
    exit;
}

$_SESSION['last_activity'] = time();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo htmlspecialchars($settings['full_name'] ?? 'Portfolio'); ?></title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="../images/<?php echo htmlspecialchars($settings['photo_profile'] ?? 'default.jpg'); ?>" alt="Admin Photo" class="admin-photo">
            <h3><?php echo htmlspecialchars($settings['full_name']); ?></h3>
        </div>
        <ul class="nav-menu">
            <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="manage_settings.php"><i class="fas fa-cog"></i> General Settings</a></li>
            <li><a href="manage_resume.php"><i class="fas fa-file-alt"></i> Manage Resume</a></li>
            <li><a href="manage_skills.php"><i class="fas fa-cogs"></i> Manage Skills</a></li>
            <li><a href="manage_projects.php"><i class="fas fa-project-diagram"></i> Manage Projects</a></li>
            <li><a href="manage_articles.php"><i class="fas fa-newspaper"></i> Manage Articles</a></li>
            <li><a href="manage_contact.php"><i class="fas fa-address-book"></i>Manage Contact & Services</a></li> 
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <button class="sidebar-toggle" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <header class="top-bar"></header>