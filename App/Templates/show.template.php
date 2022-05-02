<?php require __DIR__ . '/Components/header.php'; ?>

<?php require __DIR__ . '/Components/nav.php'; ?>


<main class="movie-page">

    <!-- Display movie by API search-->
    <?php if (isset($movie)): ?>

        <div class="movie-card-single">
            <img class="movie-poster-single" src="<?= $movie['Poster']; ?>" alt="movie's poster" loading="lazy">

            <div>
                <h2 id="movie-title"><?= $movie['Title']; ?></h2>
                <ul id="movie-list">
                    <?php foreach ($movie as $key => $value):

                        if ($key == 'Title' || $key == 'Poster' || $key == 'Plot') :
                            continue;
                        endif;
                        ?>
                        <li><?= $key . ': ' . $value ?></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <p id="movie-plot"><?= $movie['Plot'] ?></p>

        <!--Display favorite movie by database data-->
    <?php else: ?>

        <div class="movie-card-single">
            <img class="movie-poster-single" src="<?= $favouriteMovie['poster']; ?>" alt="movie's poster"
                 loading="lazy">

            <div>
                <h2 id="movie-title"><?= $favouriteMovie['title']; ?></h2>
                <ul id="movie-list">
                    <?php foreach ($favouriteMovie as $key => $value):

                        if ($key == 'title' || $key == 'poster' || $key == 'plot') :
                            continue;
                        endif;
                        ?>
                        <li><?= ucfirst($key) . ': ' . $value ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <p id="movie-plot"><?= $favouriteMovie['plot'] ?></p>

    <?php endif; ?>

</main>

    <!--Comment section-->
<?php if (isset($favouriteMovie)) : ?>
    <section class="movie-page">
        <h2>Comment Section</h2>
        <hr>

        <ul>
            <?php foreach ($comments as $comment) : ?>
                <div class="container">
                    <li id="comment-list">
                        <div id="image-container">
                            <img id="user-logo" src="App/public/pictures/user-logo.png" alt="user-logo" width="100px"
                                 height="100px">
                        </div>
                        <div id="comment-paragraphs">
                            <p><?= $comment->user->name; ?>, <?= $comment->timeDifferance; ?></p>
                            <p><?= nl2br($comment->commentary); ?></p>
                        </div>

                        <!--Delete comment-->
                        <?php if ($_SESSION['admin'] == 1) : ?>
                            <form id="comment-delete-form" action="deleteComment" method="post">
                                <input name="id" type="text" value="<?= $comment->id; ?>" hidden>
                                <input name="url" type="text" value="<?= trim($_SERVER['REQUEST_URI'], '/'); ?>" hidden>
                                <button id="comment-delete-button" type="submit">Delete</button>
                            </form>
                        <?php endif; ?>
                    </li>
                </div>

            <?php endforeach; ?>
        </ul>

        <!--Add comment-->
        <?php if (isset($_SESSION['userName'])) : ?>
            <form id="comment-add-form" action="addComment" method="post">
                <textarea id="comment-text" name="commentary" placeholder="Enter your commentary"></textarea>
                <input name="imdbId" value="<?= $favouriteMovie['imdbID']; ?>" hidden>
                <button id="comment-add-button" type="submit">Add a comment!</button>
            </form>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/Components/footer.php'; ?>
<?php
