<?php
session_start();
require "../../config/db.php";

$err = "";

// === PROSES LOGIN ===
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = strtolower(trim($_POST['email']));
    $email = mysqli_real_escape_string($conn, $email);
    $password = trim($_POST['password']);


    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if ($q && mysqli_num_rows($q) === 1) {
        $user = mysqli_fetch_assoc($q);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            header("Location: ../user/dashboard.php");
            exit;
        }
    }

    $err = "Incorrect email or password!";
}

$title = "Login";
$leftTitle = "Welcome!";
$leftDesc = "Log in to stay organized and manage your tasks effortlessly";

ob_start();
?>
<h3>Login</h3>

<?php if ($err): ?>
<div class="error-box">
    <?= $err ?>
</div>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" class="form-control" placeholder="Email" required>
    <input type="password" name="password" class="form-control" placeholder="Password" required>

    <button class="btn-purple mt-2">Login</button>

    <div class="text-center mt-3">
        Don't have an account?
        <a href="register.php">Register</a>
    </div>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . "/../layouts/auth_layout.php";
