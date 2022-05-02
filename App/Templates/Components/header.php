<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Updock&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="App/public/css/style.css">
    <title>Movies</title>
</head>
<body>

<header id="header">

    <a href="/" class="link">
        Home page
    </a>


    <?php if (!$_SESSION['userName']): ?>
        <div class="register-link">
            <a class="link" href="register">Register!</a>
            <a class="link" href="login" alt="login">Log In!</a>
        </div>
    <?php else: ?>
        <div class="register-link">
            <h3>Hello, <?= $_SESSION['userName']; ?></h3>
            <a class="link" href="logout">Log Out!</a>
        </div>
    <?php endif; ?>

</header>