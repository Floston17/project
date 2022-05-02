<?php use core\Request;

require __DIR__ . '/Components/header.php'; ?>

<main class="login-page">

    <form class="login-form" action="login" method="post">

        <input class="login-input" name="email" type="text" placeholder="Enter your email" required
               value="<?= Request::oldData('email'); ?>"
        >
        <input class="login-input" name="password" type="password" placeholder="Enter your password" required>

        <p class="error" <?php if (!$error) : ?> hidden <?php endif; ?> >
            <?= $error; ?>
        </p>

        <button class="submit-button" type="submit">Submit</button>

    </form>

</main>

<?php require __DIR__ . '/Components/footer.php'; ?>