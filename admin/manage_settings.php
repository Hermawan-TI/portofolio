<?php 
require_once 'includes/header_admin.php'; 

$message = '';
$error = '';

if(isset($_POST['save_settings'])){
    $settings_to_update = ['full_name', 'tagline', 'summary'];
    foreach($settings_to_update as $setting_name){
        if(isset($_POST[$setting_name])){
            // DIUBAH: Fungsi mysqli_real_escape_string() dihapus dari sini
            // karena kita sudah menggunakan prepared statement yang lebih aman.
            $value = $_POST[$setting_name]; 
            
            $stmt = mysqli_prepare($conn, "UPDATE settings SET setting_value = ? WHERE setting_name = ?");
            mysqli_stmt_bind_param($stmt, "ss", $value, $setting_name);
            mysqli_stmt_execute($stmt);
        }
    }
    
    if(isset($_FILES['photo_profile']) && $_FILES['photo_profile']['error'] == 0){
        $target_dir = "../images/";
        $file_extension = strtolower(pathinfo($_FILES["photo_profile"]["name"], PATHINFO_EXTENSION));
        $unique_file_name = "profile_" . time() . "." . $file_extension;
        $target_file = $target_dir . $unique_file_name;
        
        if(move_uploaded_file($_FILES["photo_profile"]["tmp_name"], $target_file)){
            $stmt = mysqli_prepare($conn, "UPDATE settings SET setting_value = ? WHERE setting_name = 'photo_profile'");
            mysqli_stmt_bind_param($stmt, "s", $unique_file_name);
            mysqli_stmt_execute($stmt);
        }
    }
    
    $message = "Settings saved successfully!";
    header("Location: manage_settings.php?message=" . urlencode($message));
    exit;
}

if(isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}
?>

<main>
    <div class="content-area-header">
        <h2>General Settings</h2>
    </div>

    <?php if ($message): ?><div class="success-message" style="margin-bottom:20px;"><?php echo $message; ?></div><?php endif; ?>

    <div class="content-area">
        <form action="manage_settings.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($settings['full_name']); ?>">
            </div>
            <div class="form-group">
                <label>Tagline (e.g., Student | Web Developer)</label>
                <input type="text" name="tagline" class="form-control" value="<?php echo htmlspecialchars($settings['tagline']); ?>">
            </div>
            <div class="form-group">
                <label>Summary</label>
                <textarea name="summary" rows="4" class="form-control"><?php echo htmlspecialchars($settings['summary']); ?></textarea>
            </div>
            
            <hr style="margin: 30px 0; border-color: var(--border-color);">
            
            <div class="form-group">
                <label>Profile Picture</label>
                <p><img src="../images/<?php echo htmlspecialchars($settings['photo_profile']); ?>" alt="Profile Picture" width="100" style="border-radius: 50%;"></p>
                <input type="file" name="photo_profile" class="form-control" accept="image/*">
                <small>*Leave empty if you don't want to change the profile picture.</small>
            </div>
            
            <br>
            <button type="submit" name="save_settings" class="btn btn-primary">Save All Settings</button>
        </form>
    </div>
</main>

<?php 
require_once 'includes/footer_admin.php'; 
?>