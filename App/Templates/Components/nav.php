<nav>
    <div>
        <form id="search-form" action="/" method="get">
            <input id="search-input" name="title" type="text" placeholder="Enter movie's title in English!" required>
            <button class="button" type="submit">Search</button>
        </form>
        <?php if (isset($feedback)) : ?>
            <p id="feedback"><?= $feedback; ?></p>
        <?php endif; ?>
    </div>
</nav>
