<?php include 'db.php'; ?>
<style>
    <?php include 'styles.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>PHP</title>
    </head>
    <body>
        <?php include './components/header/header.php'; ?>
        <main class="main">
            <div class="quizzes">
                <?php
                $query = 'SELECT title, slug FROM quizzes';
                $result = mysqli_query($connection, $query);
                $quizzes = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($quizzes as $quiz) {
                  echo "<div class='quiz'>";
                  echo "<div class='quiz__title'>{$quiz['title']}</div>";
                  echo "<a class='quiz__link' href='/website/quiz.php?slug={$quiz['slug']}'>Go</a>";
                  echo '</div>';
                }

                mysqli_free_result($result);
                ?>
            </div>
        </main>
        <?php include './components/footer/footer.php'; ?>
    </body>
</html>

<?php mysqli_close($connection); ?>
