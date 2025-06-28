<?php 
require_once 'includes/header_admin.php'; 

$message = ''; 
$error = '';

if(isset($_POST['save_item'])){
    $id = $_POST['id'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $period = $_POST['period'];
    $description = $_POST['description'];

    if(empty($id)){
        $stmt = mysqli_prepare($conn, "INSERT INTO resume_items (type, title, period, description) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $type, $title, $period, $description);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE resume_items SET type=?, title=?, period=?, description=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssi", $type, $title, $period, $description, $id);
    }
    if(mysqli_stmt_execute($stmt)) {
        header("Location: manage_resume.php?message=Item saved successfully!");
        exit;
    } else {
        $error = "Failed to save item.";
    }
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM resume_items WHERE id=$id");
    header("Location: manage_resume.php?message=Item deleted successfully!");
    exit;
}

$educations = mysqli_query($conn, "SELECT * FROM resume_items WHERE type='education' ORDER BY id DESC");
$experiences = mysqli_query($conn, "SELECT * FROM resume_items WHERE type='experience' ORDER BY id DESC");
$organizations = mysqli_query($conn, "SELECT * FROM resume_items WHERE type='organization' ORDER BY id DESC");

if(isset($_GET['message'])) $message = htmlspecialchars($_GET['message']);

$edit_item = null;
if(isset($_GET['edit'])){
    $id_to_edit = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM resume_items WHERE id=$id_to_edit");
    $edit_item = mysqli_fetch_assoc($result);
}
?>

<main>
    <div class="content-area-header">
        <h2>Manage Resume (Education, Experience, Organization)</h2>
    </div>

    <?php if ($message): ?><div class="success-message" style="margin-bottom:20px;"><?php echo $message; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error-message"><?php echo $error; ?></div><?php endif; ?>

    <div id="form-container">
        <div class="content-area">
            <h3 id="form-title"><?php echo $edit_item ? 'Edit Item' : 'Add New Item'; ?></h3>
            <form action="manage_resume.php" method="post">
                <input type="hidden" name="id" id="item_id" value="<?php echo $edit_item['id'] ?? ''; ?>">
                <div class="form-group">
                    <label>Item Type</label>
                    <select name="type" id="item_type" class="form-control" required>
                        <option value="education" <?php if(isset($edit_item) && $edit_item['type'] == 'education') echo 'selected'; ?>>Education</option>
                        <option value="experience" <?php if(isset($edit_item) && $edit_item['type'] == 'experience') echo 'selected'; ?>>Experience</option>
                        <option value="organization" <?php if(isset($edit_item) && $edit_item['type'] == 'organization') echo 'selected'; ?>>Organization</option>
                    </select>
                </div>
                <div class="form-group"><label>Title / Institution Name</label><input type="text" name="title" id="item_title" class="form-control" value="<?php echo htmlspecialchars($edit_item['title'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Period (e.g., 2021 - Present)</label><input type="text" name="period" id="item_period" class="form-control" value="<?php echo htmlspecialchars($edit_item['period'] ?? ''); ?>"></div>
                <div class="form-group"><label>Short Description</label><textarea name="description" id="item_description" rows="3" class="form-control"><?php echo htmlspecialchars($edit_item['description'] ?? ''); ?></textarea></div>
                <button type="submit" name="save_item" class="btn btn-primary">Save Item</button>
                <button type="button" id="cancel-btn" class="btn" style="background-color:#6c757d; color:white; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>

    <div class="content-area" style="margin-top:20px;">
        <div class="content-area-header">
            <h3>Education List</h3>
            <button id="add-new-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Item</button>
        </div>
        <div class="table-wrapper">
            <table class="content-table">
                <thead><tr><th>Institution</th><th>Period</th><th>Actions</th></tr></thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($educations)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['period']); ?></td>
                    <td class="action-buttons">
                        <a href="manage_resume.php?edit=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="manage_resume.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="content-area" style="margin-top:20px;">
        <h3>Experience List</h3>
        <div class="table-wrapper">
            <table class="content-table">
                <thead><tr><th>Position / Company</th><th>Period</th><th>Actions</th></tr></thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($experiences)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['period']); ?></td>
                    <td class="action-buttons">
                        <a href="manage_resume.php?edit=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="manage_resume.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="content-area" style="margin-top:20px;">
        <h3>Organization List</h3>
        <div class="table-wrapper">
            <table class="content-table">
                <thead><tr><th>Organization</th><th>Period</th><th>Actions</th></tr></thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($organizations)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['period']); ?></td>
                    <td class="action-buttons">
                        <a href="manage_resume.php?edit=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="manage_resume.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    const formContainer = document.getElementById('form-container');
    const addNewBtn = document.getElementById('add-new-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const formTitle = document.getElementById('form-title');

    if(addNewBtn) {
        addNewBtn.addEventListener('click', function() {
            formTitle.innerText = 'Add New Item';
            document.getElementById('item_id').value = '';
            document.getElementById('item_title').value = '';
            document.getElementById('item_period').value = '';
            document.getElementById('item_description').value = '';
            document.getElementById('item_type').value = 'education';
            
            formContainer.style.display = 'block';
            this.style.display = 'none';
        });
    }

    if(cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            formContainer.style.display = 'none';
            addNewBtn.style.display = 'inline-block';
            window.location.href = 'manage_resume.php';
        });
    }

    <?php if (isset($_GET['edit'])) { ?>
        formTitle.innerText = 'Edit Item';
        formContainer.style.display = 'block';
        if(addNewBtn) addNewBtn.style.display = 'none';
    <?php } ?>
</script>

<?php 
require_once 'includes/footer_admin.php'; 
?>