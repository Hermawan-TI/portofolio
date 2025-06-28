<?php 
require_once 'includes/header_admin.php'; 

$message = ''; 
$error = '';

if(isset($_POST['save'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    // DIUBAH: Fungsi yang salah (mysqli_real_escape_string) dihapus dari sini
    $content = $_POST['content']; 

    if(empty($title) || empty($content)){
        $error = "Title and Content cannot be empty.";
    } else {
        if(empty($id)){
            $stmt = mysqli_prepare($conn, "INSERT INTO articles (title, content) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $title, $content);
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE articles SET title=?, content=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $id);
        }
        if(mysqli_stmt_execute($stmt)) {
            header("Location: manage_articles.php?message=Article saved successfully!");
            exit;
        } else { 
            $error = "Failed to save article."; 
        }
    }
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM articles WHERE id=$id");
    header("Location: manage_articles.php?message=Article deleted successfully!");
    exit;
}

if(isset($_GET['message'])) $message = htmlspecialchars($_GET['message']);

$edit_article = null;
if(isset($_GET['edit'])){
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM articles WHERE id=$id");
    $edit_article = mysqli_fetch_assoc($result);
}
?>

<main>
    <div class="content-area-header">
        <h2>Manage Articles</h2>
    </div>

    <?php if ($message): ?><div class="success-message" style="margin-bottom:20px;"><?php echo $message; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error-message"><?php echo $error; ?></div><?php endif; ?>

    <div id="form-container">
        <div class="content-area">
            <div class="content-area-header">
                <h3 id="form-title"><?php echo $edit_article ? 'Edit Article' : 'Add New Article'; ?></h3>
            </div>
            <form action="manage_articles.php" method="post">
                <input type="hidden" name="id" id="article_id" value="<?php echo $edit_article['id'] ?? ''; ?>">
                <div class="form-group">
                    <label>Article Title</label>
                    <input type="text" name="title" id="article_title" class="form-control" value="<?php echo htmlspecialchars($edit_article['title'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea name="content" id="article_content" rows="10" class="form-control" required><?php echo htmlspecialchars($edit_article['content'] ?? ''); ?></textarea>
                </div>
                <button type="submit" name="save" class="btn btn-primary">Save Article</button>
                <button type="button" id="cancel-btn" class="btn" style="background-color:#6c757d; color:white; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>

    <div class="content-area" style="margin-top:20px;">
        <div class="content-area-header">
            <h3>Articles List</h3>
            <button id="add-new-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</button>
        </div>
        <div class="table-wrapper">
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Publication Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM articles ORDER BY publish_date DESC");
                    while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo date('F d, Y', strtotime($row['publish_date'])); ?></td>
                        <td class="action-buttons">
                            <a href="manage_articles.php?edit=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="manage_articles.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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
            formTitle.innerText = 'Add New Article';
            document.getElementById('article_id').value = '';
            document.getElementById('article_title').value = '';
            document.getElementById('article_content').value = '';
            formContainer.style.display = 'block';
            this.style.display = 'none';
        });
    }

    if(cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            formContainer.style.display = 'none';
            addNewBtn.style.display = 'inline-block';
            window.location.href = 'manage_articles.php';
        });
    }

    <?php if (isset($_GET['edit'])) { ?>
        formTitle.innerText = 'Edit Article';
        formContainer.style.display = 'block';
        if(addNewBtn) addNewBtn.style.display = 'none';
    <?php } ?>
</script>

<?php 
require_once 'includes/footer_admin.php'; 
?>