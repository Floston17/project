<?php require __DIR__ . '/Components/header.php'; ?>

<?php require __DIR__ . '/Components/nav.php'; ?>

<?php if (!isset($movies)) : ?>
    <h1>Favourites</h1>
<?php endif; ?>

<main id="movie-cards">

    <!-- Display all movies by search.-->
    <?php if (isset($movies)) :
        foreach ($movies as $movie) :
            ?>
            <div class="container">
                <a href="
                <?php
                if (!$movie->favorite) : ?>movie?imdbId=<?php
                else : ?>movie?favImdbId=<?php
                endif;
                echo $movie->imdbID; ?>
                "
                   class="movie-link"
                >
                    <div class="movie-card">
                        <img class="movie-poster" src="<?= $movie->Poster; ?>" alt="movie's poster" loading="lazy">
                        <div class="list">
                            <h4><?= $movie->Title; ?></h4>
                            <ul>
                                <li>Year: <?= $movie->Year; ?></li>
                                <li>Type: <?= $movie->Type; ?></li>
                                <li>IMDB ID: <?= $movie->imdbID; ?></li>
                            </ul>
                        </div>
                    </div>
                </a>

                <!-- Add to the favorites list.-->
                <?php if ($_SESSION['admin'] == 1) : ?>

                    <?php if (!$movie->inFavorites) : ?>

                        <form id="add-form" action="addFavouriteMovie" method="post">
                            <input name="imdbId" type="text" value="<?= $movie->imdbID; ?>" hidden>
                            <input name="url" type="text" value="<?= trim($_SERVER['REQUEST_URI'], '/'); ?>" hidden>
                            <button id="add-button" type="submit">Add to favourites!</button>
                        </form>

                    <?php else : ?>
                        <p id="added-paragraph">Already added to favorite list!</p>
                    <?php endif; ?>

                <?php endif; ?>

            </div>

            <!-- Display all favorite movies.-->
        <?php endforeach;
    else:
        foreach ($favourites as $movie) :
            ?>
            <div class="container">

                <a href="movie?favImdbId=<?= $movie->imdbID; ?>" class="movie-link">
                    <div class="movie-card">
                        <img class="movie-poster" src="<?= $movie->poster; ?>" alt="movie's poster" loading="lazy">

                        <div class="list">
                            <h4><?= $movie->title; ?></h4>
                            <ul>
                                <li>Year: <?= $movie->released; ?></li>
                                <li>Type: <?= $movie->type; ?></li>
                                <li>IMDB ID: <?= $movie->imdbID; ?></li>
                            </ul>
                        </div>
                    </div>
                </a>

                <!-- Delete from the favorites list.-->
                <?php if ($_SESSION['admin'] == 1) : ?>

                    <form id="delete-form" action="delete" method="post">
                        <input name="imdbId" type="text" value="<?= $movie->imdbID; ?>" hidden>
                        <button id="delete-button" type="submit">
                            Delete From Favorites!
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        <?php endforeach;
    endif;
    ?>


</main>

<!-- Pagination. -->
<?php if (isset($movies)) : ?>

    <section>
        <form id="paginate-form" action="/" method="get">
            <p id="paginate-paragraph"><?= $pages; ?> pages is found!</p>
            <div>
                <input name="title" value="<?= $_GET['title']; ?>" type="text" hidden>
                <input id="page-input" name="page" type="text" placeholder="Enter the page number">
                <button id="paginate-button" type="submit">Go to!</button>
            </div>
        </form>
    </section>

<?php endif; ?>

<?php require __DIR__ . '/Components/footer.php'; ?>
