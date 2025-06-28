</main>
    
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                
                <div class="footer-column about">
                    <h4><?php echo htmlspecialchars($settings['full_name']); ?></h4>
                    <p><?php echo htmlspecialchars($settings['tagline']); ?></p>
                </div>

                <div class="footer-column links">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="index.php#home">Home</a></li>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-column social">
                    <h4>Follow Me</h4>
                    <div class="social-icons">
                        <?php if (!empty($settings['contact_github'])): ?><a href="<?php echo htmlspecialchars($settings['contact_github']); ?>" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a><?php endif; ?>
                        <?php if (!empty($settings['contact_linkedin'])): ?><a href="<?php echo htmlspecialchars($settings['contact_linkedin']); ?>" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a><?php endif; ?>
                        <?php if (!empty($settings['contact_whatsapp'])): ?><a href="https://wa.me/<?php echo htmlspecialchars($settings['contact_whatsapp']); ?>" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
                        <?php if (!empty($settings['contact_email'])): ?><a href="mailto:<?php echo htmlspecialchars($settings['contact_email']); ?>" target="_blank" aria-label="Email"><i class="fas fa-envelope"></i></a><?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($settings['full_name']); ?>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <?php
    if (isset($conn)) {
        mysqli_close($conn);
    }
    ?>
    
    <script>
        const menuToggleBtn = document.getElementById('mobile-menu-toggle');
        const mainNav = document.querySelector('.main-nav');

        if (menuToggleBtn && mainNav) {
            menuToggleBtn.addEventListener('click', function() {
                mainNav.classList.toggle('show');
            });
        }

        const dropdownToggle = document.querySelector(".dropdown > a");
        const dropdownMenu = document.querySelector(".dropdown-menu");

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', function(event) {
                const isHomePage = window.location.pathname.endsWith('index.php') || window.location.pathname.endsWith('/portfolio/') || window.location.pathname === '/portfolio' || window.location.pathname === '/';
                
                if (isHomePage || window.innerWidth <= 768) {
                    event.preventDefault();
                    dropdownMenu.classList.toggle('show');
                }
            });
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropdown > a') && !event.target.matches('.dropdown > a *')) {
                var allDropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < allDropdowns.length; i++) {
                    var openDropdown = allDropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

</body>
</html>