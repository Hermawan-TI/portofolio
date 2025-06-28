<?php 
require_once 'includes/header_admin.php'; 

$message = ''; 
$error = '';

$fa_icons = [
    'fab fa-php' => 'PHP',
    'fab fa-laravel' => 'Laravel',
    'fab fa-html5' => 'HTML5',
    'fab fa-css3-alt' => 'CSS3',
    'fab fa-js' => 'JavaScript',
    'fab fa-react' => 'React',
    'fab fa-vuejs' => 'Vue.js',
    'fab fa-bootstrap' => 'Bootstrap',
    'fab fa-sass' => 'Sass',
    'fab fa-git-alt' => 'Git',
    'fab fa-figma' => 'Figma',
    'fas fa-database' => 'Database',
    'fas fa-server' => 'Server'
];

if(isset($_POST['save_skill'])){
    $id = $_POST['id'];
    $skill_name = mysqli_real_escape_string($conn, $_POST['skill_name']);
    $skill_icon = mysqli_real_escape_string($conn, $_POST['skill_icon']);

    if(empty($skill_name)){
        $error = "Skill name cannot be empty.";
    } else {
        if(empty($id)){
            $stmt = mysqli_prepare($conn, "INSERT INTO skills (skill_name, skill_icon) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $skill_name, $skill_icon);
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE skills SET skill_name=?, skill_icon=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "ssi", $skill_name, $skill_icon, $id);
        }
        if(mysqli_stmt_execute($stmt)) {
            header("Location: manage_skills.php?message=Skill saved successfully!");
            exit;
        } else { 
            $error = "Failed to save skill."; 
        }
    }
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM skills WHERE id=$id");
    header("Location: manage_skills.php?message=Skill deleted successfully!");
    exit;
}

if(isset($_GET['message'])) $message = htmlspecialchars($_GET['message']);

$edit_skill = null;
if(isset($_GET['edit'])){
    $id_to_edit = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM skills WHERE id=$id_to_edit");
    $edit_skill = mysqli_fetch_assoc($result);
}
?>

<main>
    <div class="content-area-header">
        <h2>Manage Skills</h2>
    </div>

    <?php if ($message): ?><div class="success-message" style="margin-bottom:20px;"><?php echo $message; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error-message"><?php echo $error; ?></div><?php endif; ?>

    <div id="form-container">
        <div class="content-area">
            <h3 id="form-title"><?php echo $edit_skill ? 'Edit Skill' : 'Add New Skill'; ?></h3>
            <form action="manage_skills.php" method="post">
                <input type="hidden" name="id" id="skill_id" value="<?php echo $edit_skill['id'] ?? ''; ?>">
                <div class="form-group">
                    <label>Skill Name (e.g., Laravel, React, etc)</label>
                    <input type="text" name="skill_name" id="skill_name" class="form-control" value="<?php echo htmlspecialchars($edit_skill['skill_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Skill Icon</label>
                    <select name="skill_icon" class="form-control">
                        <option value="">-- Select Icon --</option>
                        <?php foreach($fa_icons as $class => $name): ?>
                            <option value="<?php echo $class; ?>" <?php if(isset($edit_skill) && $edit_skill['skill_icon'] == $class) echo 'selected'; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="save_skill" class="btn btn-primary">Save</button>
                <button type="button" id="cancel-btn" class="btn" style="background-color:#6c757d; color:white; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>


    <div class="content-area" style="margin-top:20px;">
        <div class="content-area-header">
            <h3>Skills List</h3>
            <button id="add-new-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Skill</button>
        </div>
        <div class="table-wrapper">
            <table class="content-table">
                <thead><tr><th>Icon</th><th>Skill Name</th><th>Actions</th></tr></thead>
                <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM skills ORDER BY skill_name ASC");
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php if(!empty($row['skill_icon'])) echo '<i class="' . $row['skill_icon'] . ' fa-lg"></i>'; ?></td>
                    <td><?php echo htmlspecialchars($row['skill_name']); ?></td>
                    <td class="action-buttons">
                        <a href="manage_skills.php?edit=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="manage_skills.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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
            formTitle.innerText = 'Add New Skill';
            document.getElementById('skill_id').value = '';
            document.getElementById('skill_name').value = '';
            document.querySelector('select[name="skill_icon"]').value = '';
            formContainer.style.display = 'block';
            this.style.display = 'none';
        });
    }

    if(cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            formContainer.style.display = 'none';
            addNewBtn.style.display = 'inline-block';
            window.location.href = 'manage_skills.php';
        });
    }

    <?php if (isset($_GET['edit'])) { ?>
        formTitle.innerText = 'Edit Skill';
        formContainer.style.display = 'block';
        if(addNewBtn) addNewBtn.style.display = 'none';
    <?php } ?>
</script>

<?php 
require_once 'includes/footer_admin.php'; 
?>