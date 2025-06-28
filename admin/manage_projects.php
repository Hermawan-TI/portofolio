<?php 
require_once 'includes/header_admin.php'; 
$message = ''; $error = '';
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['project_name'];
    $year = $_POST['year'];
    $desc = $_POST['description']; // Fungsi yang salah dihapus dari sini
    $existing_image = $_POST['existing_image'];
    $image_name = $existing_image;
    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == 0) {
        $target_dir = "../images/projects/";
        $file_name = basename($_FILES["project_image"]["name"]);
        $unique_file_name = time() . '_' . $file_name;
        $target_file = $target_dir . $unique_file_name;
        if (move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file)) {
            $image_name = $unique_file_name;
            if (!empty($existing_image) && file_exists($target_dir . $existing_image)) { unlink($target_dir . $existing_image); }
        } else { $error = "Sorry, there was an error uploading your file."; }
    }
    if (empty($error)) {
        if (empty($id)) {
            $stmt = mysqli_prepare($conn, "INSERT INTO projects (project_name, year, description, project_image) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "siss", $name, $year, $desc, $image_name);
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE projects SET project_name=?, year=?, description=?, project_image=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "sissi", $name, $year, $desc, $image_name, $id);
        }
        if (mysqli_stmt_execute($stmt)) { header("Location: manage_projects.php?message=Project saved successfully!"); exit;
        } else { $error = "Failed to save project to database."; }
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $res = mysqli_query($conn, "SELECT project_image FROM projects WHERE id=$id");
    if($row = mysqli_fetch_assoc($res)){ if(!empty($row['project_image']) && file_exists('../images/projects/'.$row['project_image'])){ unlink('../images/projects/'.$row['project_image']); } }
    mysqli_query($conn, "DELETE FROM projects WHERE id=$id");
    header("Location: manage_projects.php?message=Project deleted successfully!"); exit;
}
if(isset($_GET['message'])) $message = htmlspecialchars($_GET['message']);
$edit_project = null;
if(isset($_GET['edit'])){
    $edit_project = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM projects WHERE id=".intval($_GET['edit'])));
}
?>
<main>
    <div class="content-area-header"><h2>Manage Projects</h2></div>
    <?php if ($message): ?><div class="success-message" style="margin-bottom:20px;"><?php echo $message; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error-message"><?php echo $error; ?></div><?php endif; ?>
    <div id="form-container">
        <div class="content-area">
            <div class="content-area-header"><h3 id="form-title">Add New Project</h3></div>
            <form action="manage_projects.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="project_id" value="<?php echo $edit_project['id'] ?? ''; ?>">
                <input type="hidden" name="existing_image" value="<?php echo $edit_project['project_image'] ?? ''; ?>">
                <div class="form-group"><label>Project Name</label><input type="text" name="project_name" id="project_name" class="form-control" value="<?php echo htmlspecialchars($edit_project['project_name'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Year</label><input type="number" name="year" id="project_year" class="form-control" value="<?php echo $edit_project['year'] ?? ''; ?>" required></div>
                <div class="form-group"><label>Description</label><textarea name="description" id="project_description" rows="5" class="form-control" required><?php echo htmlspecialchars($edit_project['description'] ?? ''); ?></textarea></div>
                <div class="form-group"><label>Project Image</label><div id="current_image_container"></div><input type="file" name="project_image" class="form-control" accept="image/*"><small>*Leave empty if you don't want to change the image.</small></div>
                <button type="submit" name="save" class="btn btn-primary">Save Project</button>
                <button type="button" id="cancel-btn" class="btn" style="background-color:#6c757d; color:white; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>
    <div class="content-area" style="margin-top:20px;">
        <div class="content-area-header"><h3>Projects List</h3><button id="add-new-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</button></div>
        <div class="table-wrapper">
            <table class="content-table">
                <thead><tr><th>Image</th><th>Project Name</th><th>Year</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php $result = mysqli_query($conn, "SELECT * FROM projects ORDER BY year DESC"); while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><img src="../images/projects/<?php echo htmlspecialchars($row['project_image'] ?? 'default.jpg'); ?>" width="100" alt="Project Image"></td>
                        <td><?php echo htmlspecialchars($row['project_name']); ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td class="action-buttons">
                            <a href="manage_projects.php?edit=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="manage_projects.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    const formContainer = document.getElementById('form-container'); const addNewBtn = document.getElementById('add-new-btn'); const cancelBtn = document.getElementById('cancel-btn'); const formTitle = document.getElementById('form-title');
    if(addNewBtn) {
        addNewBtn.addEventListener('click', function() {
            formTitle.innerText = 'Add New Project';
            document.getElementById('project_id').value = ''; document.getElementById('project_name').value = ''; document.getElementById('project_year').value = ''; document.getElementById('project_description').value = ''; document.getElementById('current_image_container').innerHTML = '';
            formContainer.style.display = 'block'; this.style.display = 'none';
        });
    }
    if(cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            formContainer.style.display = 'none'; addNewBtn.style.display = 'inline-block'; window.location.href = 'manage_projects.php';
        });
    }
    <?php if (isset($_GET['edit'])) { ?>
        formTitle.innerText = 'Edit Project'; const currentImage = document.querySelector('input[name="existing_image"]').value; if(currentImage) { document.getElementById('current_image_container').innerHTML = `<p>Current Image: <br><img src="../images/projects/${currentImage}" width="150"></p>`; }
        formContainer.style.display = 'block'; if(addNewBtn) addNewBtn.style.display = 'none';
    <?php } ?>
</script>
<?php 
require_once 'includes/footer_admin.php'; 
?>