<?php
require_once '../includes/db.php';
$error = '';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = trim($_POST['password']);

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // Jika password benar, buat ulang session ID untuk keamanan
                        session_regenerate_id(true);
                        
                        // Simpan data ke session
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        
                        // --- TAMBAHAN KEAMANAN ---
                        $_SESSION['last_activity'] = time(); 
                        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                        
                        header("location: index.php");
                        exit;
                    } else {
                        // BARIS INI YANG DIPERBAIKI
                        $error = "Password yang Anda masukkan salah.";
                    }
                }
            } else {
                $error = "Username tidak ditemukan.";
            }
        } else {
            $error = "Oops! Terjadi kesalahan.";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #111111;
            --bg-surface: #1e1e1e;
            --primary-purple: #8A2BE2;
            --text-heading: #FFFFFF;
            --text-body: #A9A9A9;
            --border-color: #333333;
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; font-family: 'Inter', sans-serif; background-color: var(--bg-dark); color: var(--text-body); }
        body { display: flex; align-items: center; justify-content: center; }
        .login-card { background-color: var(--bg-surface); padding: 40px; border-radius: 12px; border: 1px solid var(--border-color); width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .login-card h2 { color: var(--text-heading); font-weight: 800; text-align: center; margin-top: 0; margin-bottom: 30px; font-size: 2rem; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 700; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 12px 15px; background-color: #2a2a2a; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-heading); font-size: 1rem; transition: border-color 0.3s, box-shadow 0.3s; }
        .form-control:focus { outline: none; border-color: var(--primary-purple); box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.3); }
        .btn-login { width: 100%; padding: 15px; background-color: var(--primary-purple); border: none; border-radius: 8px; color: white; font-size: 1rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s; margin-top: 10px; }
        .btn-login:hover { background-color: #7b24cc; }
        .error-message { color: #ff6b6b; background-color: rgba(255, 107, 107, 0.1); border: 1px solid #ff6b6b; padding: 10px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login Admin</h2>
        
        <?php if(!empty($error)){ echo '<p class="error-message">' . htmlspecialchars($error) . '</p>'; } ?>
        
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>