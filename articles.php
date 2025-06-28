<?php 
require_once 'includes/header.php';
$articles_result = mysqli_query($conn, "SELECT * FROM articles ORDER BY publish_date DESC");
?>

<div class="container">
    <div class="section">
        <h2 class="section-title">My Articles</h2>
        <p style="text-align:center; max-width: 600px; margin: -30px auto 50px;">A collection of writings about technology, web development, and other interesting topics.</p>
        
        <div class="project-grid">
            <?php
            if (mysqli_num_rows($articles_result) > 0) {
                while ($article = mysqli_fetch_assoc($articles_result)) {
            ?>
                    <div class="project-card">
                        <div class="project-info">
                            <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                            <p class="article-meta" style="border:none; padding-bottom:0; margin-bottom: 10px; font-size: 0.8rem;">
                                Published on: <?php echo date('F d, Y', strtotime($article['publish_date'])); ?>
                            </p>
                            <p>
                                <?php echo nl2br(htmlspecialchars(substr($article['content'], 0, 120))); ?>...
                            </p>
                            <div class="read-more-container" style="margin-top: auto; padding-top: 20px;">
                                <a href="single-article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary" style="padding: 10px 20px; font-size: 0.9rem;">Read More</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p style='text-align:center;'>No articles have been published yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>