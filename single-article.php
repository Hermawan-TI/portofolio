<?php 
require_once 'includes/header.php';

$article = null;
$error_message = '';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $article_id = intval($_GET['id']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM articles WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $article_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $article = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Article not found.";
    }
    mysqli_stmt_close($stmt);
} else {
    $error_message = "No article specified.";
}
?>

<div class="container">
    <div class="section">
        <?php if ($article): ?>
            
            <div class="single-content-container">
                <h2 class="single-content-title"><?php echo htmlspecialchars($article['title']); ?></h2>
                
                <p class="single-content-meta">
                    Published on: <?php echo date('F d, Y', strtotime($article['publish_date'])); ?>
                </p>
                
                <div class="single-content-body">
                    <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </div>

                <a href="articles.php" class="back-to-list-link">&larr; Back to Articles</a>
            </div>

        <?php else: ?>
            
            <h2 class="section-title">Error</h2>
            <p style="text-align:center;"><?php echo $error_message; ?></p>
            <p style="text-align:center; margin-top:20px;">
                <a href="articles.php" class="btn btn-primary">Back to Articles</a>
            </p>

        <?php endif; ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>