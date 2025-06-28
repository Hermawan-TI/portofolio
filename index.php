<?php 
require_once 'includes/header.php'; 
?>
<div class="container">
    <div class="section" id="home">
        <div class="hero">
            <div class="hero-image">
                <div class="image-blob-container">
                    <img src="images/<?php echo htmlspecialchars($settings['photo_profile']); ?>" alt="Foto Profil">
                </div>
            </div>
            <div class="hero-text">
                <h3 class="hero-section-subtitle">About Me</h3>
                <p class="hero-greeting">Hello, I am</p>
                <h1><?php echo htmlspecialchars($settings['full_name']); ?></h1>
                <p class="hero-role"><?php echo htmlspecialchars($settings['tagline']); ?></p>
                <p class="hero-bio"><?php echo nl2br(htmlspecialchars($settings['summary'])); ?></p>
                <div class="social-links-hero">
                    <?php if (!empty($settings['contact_github'])): ?><a href="<?php echo htmlspecialchars($settings['contact_github']); ?>" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a><?php endif; ?>
                    <?php if (!empty($settings['contact_linkedin'])): ?><a href="<?php echo htmlspecialchars($settings['contact_linkedin']); ?>" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a><?php endif; ?>
                    <?php if (!empty($settings['contact_whatsapp'])): ?><a href="https://wa.me/<?php echo htmlspecialchars($settings['contact_whatsapp']); ?>" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
                    <?php if (!empty($settings['contact_email'])): ?><a href="mailto:<?php echo htmlspecialchars($settings['contact_email']); ?>" target="_blank" aria-label="Email"><i class="fas fa-envelope"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="section" id="keahlian">
         <h2 class="section-title">My Skills</h2>
         <div class="skills-grid">
            <?php 
            $skills_result = mysqli_query($conn, "SELECT * FROM skills ORDER BY skill_name ASC");
            while($skill = mysqli_fetch_assoc($skills_result)):
            ?>
                <div class="skill-card">
                    <?php if(!empty($skill['skill_icon'])) echo '<i class="' . htmlspecialchars($skill['skill_icon']) . '"></i>'; ?>
                    <h3><?php echo htmlspecialchars($skill['skill_name']); ?></h3>
                </div>
            <?php endwhile; ?>
         </div>
    </div>

    <div class="section" id="proyek">
        <h2 class="section-title">My Projects</h2>
        <div class="project-grid">
            <?php
            $projects_result = mysqli_query($conn, "SELECT * FROM projects ORDER BY year DESC");
            while ($project = mysqli_fetch_assoc($projects_result)) {
                // DIUBAH: Menghapus substr() dan "..." agar deskripsi tampil lengkap
                echo "<div class='project-card'><img src='images/projects/" . htmlspecialchars($project['project_image'] ?? 'default.jpg') . "' alt='" . htmlspecialchars($project['project_name']) . "'><div class='project-info'><h3>" . htmlspecialchars($project['project_name']) . "</h3><p>" . nl2br(htmlspecialchars($project['description'])) . "</p></div></div>";
            }
            ?>
        </div>
    </div>

    <div class="section" id="pendidikan"><h2 class="section-title">Education</h2><div class="resume-grid"><?php $education_result = mysqli_query($conn, "SELECT * FROM resume_items WHERE type='education' ORDER BY id DESC"); while($item = mysqli_fetch_assoc($education_result)): ?><div class="resume-card"><h3><?php echo htmlspecialchars($item['title']); ?></h3><p class="resume-period"><?php echo htmlspecialchars($item['period']); ?></p><p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p></div><?php endwhile; ?></div></div>
    <div class="section" id="pengalaman"><h2 class="section-title">Experience</h2><div class="resume-grid"><?php $experience_result = mysqli_query($conn, "SELECT * FROM resume_items WHERE type='experience' ORDER BY id DESC"); while($item = mysqli_fetch_assoc($experience_result)): ?><div class="resume-card"><h3><?php echo htmlspecialchars($item['title']); ?></h3><p class="resume-period"><?php echo htmlspecialchars($item['period']); ?></p><p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p></div><?php endwhile; ?></div></div>
    <div class="section" id="organisasi"><h2 class="section-title">Organization</h2><div class="resume-grid"><?php $organization_result = mysqli_query($conn, "SELECT * FROM resume_items WHERE type='organization' ORDER BY id DESC"); while($item = mysqli_fetch_assoc($organization_result)): ?><div class="resume-card"><h3><?php echo htmlspecialchars($item['title']); ?></h3><p class="resume-period"><?php echo htmlspecialchars($item['period']); ?></p><p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p></div><?php endwhile; ?></div></div>
</div>
<?php 
include 'includes/footer.php'; 
?>