<footer class="main-footer">
            <p>Copyright &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($settings['full_name'] ?? 'Nama Anda'); ?>. All Rights Reserved.</p>
        </footer>

    </div> <script>
        const sidebarToggleBtn = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');

        if (sidebarToggleBtn && sidebar) {
            sidebarToggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }
    </script>
</body>
</html>