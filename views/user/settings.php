<?php
session_start();
require "../../config/db.php";

// Proteksi: jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Ambil data user
$q = mysqli_query($conn, "SELECT * FROM users WHERE id=$userId");
$user = mysqli_fetch_assoc($q);

$title = "Settings";
$active = "settings";

$success = $_SESSION['success'] ?? "";
$error   = $_SESSION['error'] ?? "";

unset($_SESSION['success']);
unset($_SESSION['error']);

// PROCESS UPDATE NAME + EMAIL
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update_info'])) {

    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);

    $update = mysqli_query($conn, "
        UPDATE users SET name='$name', email='$email'
        WHERE id=$userId
    ");

    if ($update) {
        $_SESSION['success'] = "Profile updated successfully.";
        $_SESSION['name'] = $name;
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }

    header("Location: settings.php");
    exit;
}

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">Settings</h2>
<p style="color:#6c5a8d;">Manage your personal information & preferences</p>

<!-- NOTIFICATIONS -->
<?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<!-- PROFILE PHOTO -->
<div class="card p-4 shadow-sm border-0 mb-4" style="max-width:650px;">
    <h4 class="mb-3">Profile Photo</h4>

    <div class="d-flex align-items-center gap-4">

        <!-- FOTO PROFIL -->
        <img src="/Nimbus/assets/uploads/<?= $user['photo'] ?? 'default.png' ?>"
             style="width:100px; height:100px; border-radius:12px; object-fit:cover; border:3px solid #8A6EB8;">

        <div>
        <?php if (!empty($user['photo'])): ?>

            <!-- MODE FOTO SUDAH ADA -->
            <button class="btn btn-primary" id="editPhotoBtn">Edit Photo</button>

            <!-- HIDDEN UNTUK EDIT -->
            <form id="editPhotoForm" action="upload_photo.php" method="POST"
                  enctype="multipart/form-data" style="display:none; margin-top:10px;">
                <input type="file" name="photo" class="form-control mb-2" accept="image/*">
                <button class="btn btn-primary">Save Photo</button>
            </form>

        <?php else: ?>

            <!-- MODE BELUM ADA FOTO -->
            <form action="upload_photo.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="photo" class="form-control mb-2" accept="image/*" required>
                <button class="btn btn-primary">Upload Photo</button>
            </form>

        <?php endif; ?>
        </div>
    </div>
</div>

<!-- UPDATE PROFILE INFO -->
<div class="card p-4 shadow-sm border-0" style="max-width:650px;">
    <h4 class="mb-3">Update Profile</h4>

    <form method="POST">

        <input type="hidden" name="update_info">

        <label class="form-label fw-semibold">Name</label>
        <input type="text" name="name" class="form-control mb-3"
               value="<?= htmlspecialchars($user['name']) ?>" required>

        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control mb-3"
               value="<?= htmlspecialchars($user['email']) ?>" required>

        <button class="btn btn-primary">Save Changes</button>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("editPhotoBtn");
    const form = document.getElementById("editPhotoForm");

    if (btn) {
        btn.addEventListener("click", () => {
            form.style.display = "block";
            btn.style.display = "none";
        });
    }
});
</script>
<script src="/Nimbus/assets/js/alerts.js"></script>

<?php
$content = ob_get_clean();
include "../layouts/user_layout.php";
