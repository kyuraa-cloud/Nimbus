<?php
require "../../config/db.php";

$err = "";
$success = "";

// === PROSES REGISTER ===
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name  = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $pass  = trim($_POST['password']);
    $conf  = trim($_POST['password_confirmation']);

    if ($pass != $conf) {
        $err = "Password tidak sama!";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        $insert = mysqli_query($conn, "
            INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$hashed', 'user')
        ");

        if ($insert) {
            $success = "Registration successful. Please log in.";
        } else {
            $err = "Registration failed, please try again.";
        }
    }
}

$title = "Register";
$leftTitle = "Register Now!";
$leftDesc = "Create an account and begin managing your tasks easily.";

ob_start();
?>

<h3>Register</h3>

<?php if ($err): ?>
<div class="error-box"><?= $err ?></div>
<?php endif; ?>

<?php if ($success): ?>
<div class="success-box"><?= $success ?></div>
<?php endif; ?>


<form method="POST">

    <input type="text" name="name" class="form-control"
           placeholder="Name" required>

    <input type="email" name="email" class="form-control"
           placeholder="Email" required>

    <input type="password" name="password" class="form-control"
           placeholder="Password" required>

    <input type="password" name="password_confirmation" class="form-control"
           placeholder="Confirm Password" required>

    <button class="btn-purple mt-2">Register</button>

    <div class="text-center mt-3">
        Already have an account?
        <a href="login.php">Login</a>
    </div>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . "/../layouts/auth_layout.php";
