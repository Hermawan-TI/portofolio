<?php 
require_once 'includes/header_admin.php'; 
$message = ''; $error = '';
if(isset($_POST['save_contact_settings'])){
    $settings_to_update = ['contact_whatsapp', 'contact_github', 'contact_email', 'contact_linkedin'];
    foreach($settings_to_update as $setting_name){
        if(isset($_POST[$setting_name])){
            $value = $_POST[$setting_name]; // Hapus mysqli_real_escape_string
            $stmt = mysqli_prepare($conn, "UPDATE settings SET setting_value = ? WHERE setting_name = ?");
            mysqli_stmt_bind_param($stmt, "ss", $value, $setting_name);
            mysqli_stmt_execute($stmt);
        }
    }
    header("Location: manage_contact.php?message=Contact info updated successfully!");
    exit;
}
if(isset($_POST['save_service'])){
    $id = $_POST['id'];
    $service_name = $_POST['service_name'];
    $service_price = $_POST['service_price'];
    $service_description = $_POST['service_description']; // Hapus mysqli_real_escape_string
    if(empty($id)){
        $stmt = mysqli_prepare($conn, "INSERT INTO services (service_name, service_price, service_description) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $service_name, $service_price, $service_description);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE services SET service_name=?, service_price=?, service_description=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssi", $service_name, $service_price, $service_description, $id);
    }
    if(mysqli_stmt_execute($stmt)) {
        header("Location: manage_contact.php?message=Service saved successfully!");
        exit;
    } else { $error = "Failed to save service."; }
}
if(isset($_GET['delete_service'])){
    $id = $_GET['delete_service'];
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");
    header("Location: manage_contact.php?message=Service deleted successfully!");
    exit;
}
if(isset($_GET['message'])) { $message = htmlspecialchars($_GET['message']); }
$edit_service = null;
if(isset($_GET['edit_service'])){
    $id = $_GET['edit_service'];
    $result = mysqli_query($conn, "SELECT * FROM services WHERE id=$id");
    $edit_service = mysqli_fetch_assoc($result);
}
?>
<main>
    <div class="content-area-header"><h2>Manage Contact & Services</h2></div>
    <?php if ($message): ?><div class="success-message" style="margin-bottom:20px;"><?php echo $message; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error-message"><?php echo $error; ?></div><?php endif; ?>
    <div class="content-area">
        <h3>Contact Information</h3>
        <form action="manage_contact.php" method="post">
            <div class="form-group"><label>Email</label><input type="email" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>"></div>
            <div class="form-group"><label>WhatsApp Number</label><input type="text" name="contact_whatsapp" class="form-control" value="<?php echo htmlspecialchars($settings['contact_whatsapp'] ?? ''); ?>"></div>
            <div class="form-group"><label>GitHub Profile Link</label><input type="text" name="contact_github" class="form-control" value="<?php echo htmlspecialchars($settings['contact_github'] ?? ''); ?>"></div>
            <div class="form-group"><label>LinkedIn Profile Link</label><input type="text" name="contact_linkedin" class="form-control" value="<?php echo htmlspecialchars($settings['contact_linkedin'] ?? ''); ?>"></div>
            <button type="submit" name="save_contact_settings" class="btn btn-primary">Save Contact Info</button>
        </form>
    </div>
    <div id="service-form-container" style="margin-top:20px;">
        <div class="content-area">
            <h3 id="service-form-title">Add New Service</h3>
            <form action="manage_contact.php" method="post">
                <input type="hidden" name="id" id="service_id" value="<?php echo $edit_service['id'] ?? ''; ?>">
                <div class="form-group"><label>Service Name</label><input type="text" name="service_name" id="service_name" class="form-control" value="<?php echo htmlspecialchars($edit_service['service_name'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Price</label><input type="text" name="service_price" id="service_price" class="form-control" value="<?php echo htmlspecialchars($edit_service['service_price'] ?? ''); ?>"></div>
                <div class="form-group"><label>Short Description</label><textarea name="service_description" id="service_description" rows="3" class="form-control"><?php echo htmlspecialchars($edit_service['service_description'] ?? ''); ?></textarea></div>
                <button type="submit" name="save_service" class="btn btn-primary">Save Service</button>
                <button type="button" id="cancel-service-btn" class="btn" style="background-color:#6c757d; color:white; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>
    <div class="content-area" style="margin-top:20px;">
        <div class="content-area-header"><h3>Services List</h3><button id="add-new-service-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Service</button></div>
        <div class="table-wrapper">
            <table class="content-table">
                <thead><tr><th>Service Name</th><th>Price</th><th>Description</th><th>Actions</th></tr></thead>
                <tbody>
                <?php $result = mysqli_query($conn, "SELECT * FROM services ORDER BY id DESC"); while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['service_price']); ?></td>
                    <td><?php echo htmlspecialchars($row['service_description']); ?></td>
                    <td class="action-buttons">
                        <a href="manage_contact.php?edit_service=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="manage_contact.php?delete_service=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    const serviceFormContainer = document.getElementById('service-form-container');
    const addNewServiceBtn = document.getElementById('add-new-service-btn');
    const cancelServiceBtn = document.getElementById('cancel-service-btn');
    const serviceFormTitle = document.getElementById('service-form-title');
    if(addNewServiceBtn){
        addNewServiceBtn.addEventListener('click', function() {
            serviceFormTitle.innerText = 'Add New Service';
            document.getElementById('service_id').value = '';
            document.getElementById('service_name').value = '';
            document.getElementById('service_price').value = '';
            document.getElementById('service_description').value = '';
            serviceFormContainer.style.display = 'block';
            this.style.display = 'none';
        });
    }
    if(cancelServiceBtn){
        cancelServiceBtn.addEventListener('click', function() {
            serviceFormContainer.style.display = 'none';
            addNewServiceBtn.style.display = 'inline-block';
            window.location.href = 'manage_contact.php';
        });
    }
    <?php if (isset($_GET['edit_service'])) { ?>
        serviceFormTitle.innerText = 'Edit Service';
        serviceFormContainer.style.display = 'block';
        if(addNewServiceBtn) addNewServiceBtn.style.display = 'none';
    <?php } ?>
</script>
<?php 
require_once 'includes/footer_admin.php'; 
?>