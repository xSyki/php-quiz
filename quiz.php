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
                <?php
                $slug = $_GET['slug'];

                $query =
                  'SELECT title, questions FROM quizzes WHERE slug = "' .
                  $slug .
                  '"';
                $result = mysqli_query($connection, $query);
                $quiz = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
                $quiz['questions'] = json_decode($quiz['questions'], true);

                echo "<form class='quiz__form' action='quiz.php?slug={$slug}' method='post'>";
                echo "<h1 class='quiz__title'>{$quiz['title']}</h1>";
                foreach ($quiz['questions'] as $question) {
                  echo "<div class='quiz__question'>{$question['question']}</div>";
                  foreach ($question['answers'] as $key => $answer) {
                    echo "<label class='quiz__answer'>";
                    echo "<input class='quiz__input' type='radio' name='{$question['id']}' value='{$key}'>";
                    echo "<span class='quiz__text'>{$answer}</span>";
                    echo '</label>';
                  }
                }
                echo "<button class='quiz__submit' type='submit'>Submit</button>";
                echo '</form>';

                mysqli_free_result($result);
                ?>

                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $slug = $_GET['slug'];

                  $query =
                    'SELECT title, questions FROM quizzes WHERE slug = "' .
                    $slug .
                    '"';
                  $result = mysqli_query($connection, $query);
                  $quiz = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
                  $quiz['questions'] = json_decode($quiz['questions'], true);

                  $result = 0;

                  foreach ($quiz['questions'] as $key => $question) {
                    if ($_POST[$key] == $question['correctAnswer']) {
                      $result++;
                    }
                  }

                  $questionsLength = count($quiz['questions']);
                  echo "{$result} / {$questionsLength}";
                } ?>
        </main>
        <?php include './components/footer/footer.php'; ?>
    </body>
</html>

<?php mysqli_close($connection); ?>
