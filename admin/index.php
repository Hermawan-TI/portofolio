<?php 
require_once 'includes/header_admin.php'; 

$total_projects_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM projects");
$total_projects = mysqli_fetch_assoc($total_projects_res)['total'];

$total_articles_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM articles");
$total_articles = mysqli_fetch_assoc($total_articles_res)['total'];

$total_skills_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM skills");
$total_skills = mysqli_fetch_assoc($total_skills_res)['total'];

$total_education_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM resume_items WHERE type='education'");
$total_education = mysqli_fetch_assoc($total_education_res)['total'];

$total_experience_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM resume_items WHERE type='experience'");
$total_experience = mysqli_fetch_assoc($total_experience_res)['total'];

$total_organization_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM resume_items WHERE type='organization'");
$total_organization = mysqli_fetch_assoc($total_organization_res)['total'];

$recent_projects = mysqli_query($conn, "SELECT id, project_name FROM projects ORDER BY id DESC LIMIT 5");
$recent_articles = mysqli_query($conn, "SELECT id, title FROM articles ORDER BY id DESC LIMIT 5");
?>

<main>
    <div class="content-area-header">
        <h2>Dashboard</h2>
    </div>

    <div class="activity-card" style="margin-bottom: 20px; border:none;">
        <h3>Welcome, <?php echo htmlspecialchars($settings['full_name']); ?>!</h3>
        <p>This is a summary of your portfolio website's content.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card card-blue">
            <div class="stat-card-icon"><i class="fas fa-project-diagram"></i></div>
            <div class="stat-card-info"><h4>Total Projects</h4><p><?php echo $total_projects; ?></p></div>
        </div>
        <div class="stat-card card-green">
            <div class="stat-card-icon"><i class="fas fa-newspaper"></i></div>
            <div class="stat-card-info"><h4>Total Articles</h4><p><?php echo $total_articles; ?></p></div>
        </div>
        <div class="stat-card card-purple">
            <div class="stat-card-icon"><i class="fas fa-cogs"></i></div>
            <div class="stat-card-info"><h4>Total Skills</h4><p><?php echo $total_skills; ?></p></div>
        </div>
        <div class="stat-card card-red">
            <div class="stat-card-icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-card-info"><h4>Total Education</h4><p><?php echo $total_education; ?></p></div>
        </div>
        <div class="stat-card card-teal">
            <div class="stat-card-icon"><i class="fas fa-briefcase"></i></div>
            <div class="stat-card-info"><h4>Total Experience</h4><p><?php echo $total_experience; ?></p></div>
        </div>
        <div class="stat-card card-navy">
            <div class="stat-card-icon"><i class="fas fa-sitemap"></i></div>
            <div class="stat-card-info"><h4>Total Organizations</h4><p><?php echo $total_organization; ?></p></div>
        </div>
    </div>

    <div class="recent-activity-grid">
        <div class="activity-card">
            <h4><i class="fas fa-project-diagram"></i> Recent Projects</h4>
            <ul>
                <?php 
                if (mysqli_num_rows($recent_projects) > 0) {
                    while($project = mysqli_fetch_assoc($recent_projects)): ?>
                        <li><a href="manage_projects.php?edit=<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['project_name']); ?></a></li>
                    <?php endwhile;
                } else { echo "<li>No projects yet.</li>"; }
                ?>
            </ul>
        </div>
        <div class="activity-card">
            <h4><i class="fas fa-newspaper"></i> Recent Articles</h4>
            <ul>
                <?php 
                if (mysqli_num_rows($recent_articles) > 0) {
                    while($article = mysqli_fetch_assoc($recent_articles)): ?>
                        <li><a href="manage_articles.php?edit=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></li>
                    <?php endwhile;
                } else { echo "<li>No articles yet.</li>"; }
                ?>
            </ul>
        </div>
    </div>
</main>

<?php 
require_once 'includes/footer_admin.php'; 
?>