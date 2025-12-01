<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/nimbus/assets/css/auth.css">
</head>

<body>
<div class="auth-wrapper">
    <div class="auth-left">
        <h2><?= $leftTitle ?></h2>
        <p><?= $leftDesc ?></p>
    </div>
    <div class="auth-right">
        <?= $content ?>
    </div>
</div>
</body>
</html>
