<?php 
require_once 'includes/header.php';
$services_result = mysqli_query($conn, "SELECT * FROM services ORDER BY id ASC");
$pesan_sukses = ''; $pesan_error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
    $nama = trim($_POST['name']); $email = trim($_POST['email']); $subjek = trim($_POST['subject']); $pesan = trim($_POST['message']);
    if (!empty($nama) && !empty($email) && !empty($subjek) && !empty($pesan)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $subjek, $pesan);
        if (mysqli_stmt_execute($stmt)) { $pesan_sukses = "Thank you, " . htmlspecialchars($nama) . ". Your message has been sent successfully!"; } else { $pesan_error = "Sorry, an error occurred while sending your message."; }
        mysqli_stmt_close($stmt);
    } else { $pesan_error = "Please fill in all required fields."; }
}
?>
<div class="container">
    <div class="section">
        <h2 class="section-title">Get In Touch</h2>
        <p style="text-align:center; max-width: 600px; margin: -30px auto 50px;">Have a question or a project in mind? Feel free to contact me.</p>
        <?php if ($pesan_sukses): ?><div style="background-color: rgba(45, 204, 113, 0.1); color: #2ecc71; border: 1px solid #27ae60; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 30px;"><?php echo $pesan_sukses; ?></div><?php endif; ?>
        <?php if ($pesan_error): ?><div style="background-color: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid #c0392b; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 30px;"><?php echo $pesan_error; ?></div><?php endif; ?>
        <div class="contact-grid">
            <div class="contact-form-wrapper">
                <form action="contact.php#contact-form" method="POST" id="contact-form">
                    <div class="form-group"><label>Your Name</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group"><label>Your Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="form-group"><label>Subject</label><input type="text" name="subject" class="form-control" required></div>
                    <div class="form-group"><label>Your Message</label><textarea name="message" rows="5" class="form-control" required></textarea></div>
                    <button type="submit" name="send_message" class="btn btn-primary">Send Message</button>
                </form>
            </div>
            <div class="contact-info-wrapper">
                <h4>Contact Information</h4>
                <ul class="contact-list">
                    <?php if (!empty($settings['contact_email'])): ?><li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo htmlspecialchars($settings['contact_email']); ?>"><?php echo htmlspecialchars($settings['contact_email']); ?></a></li><?php endif; ?>
                    <?php if (!empty($settings['contact_whatsapp'])): ?><li><i class="fab fa-whatsapp"></i> <a href="https://wa.me/<?php echo htmlspecialchars($settings['contact_whatsapp']); ?>" target="_blank">+<?php echo htmlspecialchars($settings['contact_whatsapp']); ?></a></li><?php endif; ?>
                    <?php if (!empty($settings['contact_github'])): ?><li><i class="fab fa-github"></i> <a href="<?php echo htmlspecialchars($settings['contact_github']); ?>" target="_blank"><?php echo htmlspecialchars(basename($settings['contact_github'])); ?></a></li><?php endif; ?>
                    <?php if (!empty($settings['contact_linkedin'])): ?><li><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($settings['contact_linkedin']); ?>" target="_blank"><?php echo htmlspecialchars(basename($settings['contact_linkedin'])); ?></a></li><?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="section" id="layanan">
        <h2 class="section-title">Services Offered</h2>
        <div class="project-grid">
            <?php while ($service = mysqli_fetch_assoc($services_result)): ?>
                <div class="project-card">
                    <div class="project-info">
                        <h3><?php echo htmlspecialchars($service['service_name']); ?></h3>
                        <?php if (!empty($service['service_price'])): ?><p class="service-price" style="font-weight:700; color:var(--text-body); margin-top:5px; margin-bottom:15px;"><?php echo htmlspecialchars($service['service_price']); ?></p><?php endif; ?>
                        <p><?php echo nl2br(htmlspecialchars($service['service_description'])); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php 
include 'includes/footer.php'; 
?>