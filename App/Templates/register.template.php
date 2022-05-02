<?php use core\Request;

require __DIR__ . '/Components/header.php'; ?>

<main class="login-page">

    <form class="login-form" action="register" method="post">

        <h1 id="register">Register!</h1>

        <input class="login-input" name="name" type="text" placeholder="Enter your name" required
               value="<?= Request::oldData('name'); ?>"
        >

        <p class="error" <?php if (!$nameError) : ?> hidden <?php endif; ?> >
            <?= $nameError; ?>
        </p>

        <input class="login-input" name="email" type="text" placeholder="Enter your email" required
               value="<?= Request::oldData('email'); ?>"
        >

        <p class="error" <?php if (!$emailError) : ?> hidden <?php endif; ?> >
            <?= $emailError; ?>
        </p>

        <input class="login-input" name="city" type="text" placeholder="Enter your city" required
               value="<?= Request::oldData('city');; ?>"
        >

        <p class="error" <?php if (!$cityError) : ?> hidden <?php endif; ?> >
            <?= $cityError; ?>
        </p>

        <input class="login-input" name="password" type="password" placeholder="Enter your password" required>

        <p class="error" <?php if (!$passwordError) : ?> hidden <?php endif; ?> >
            <?= $passwordError; ?>
        </p>

        <p class="error" <?php if (!$error) : ?> hidden <?php endif; ?> >
            <?= $error; ?>
        </p>

        <button class="submit-button" type="submit">Submit</button>

    </form>

</main>

<?php require __DIR__ . '/Components/footer.php'; ?>