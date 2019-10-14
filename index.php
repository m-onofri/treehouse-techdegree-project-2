<?php 
    session_start();
    include('inc/questions.php');

    $total = count($questions);
    if (empty($_SESSION['questions'])) {
        shuffle($questions);
        $_SESSION['questions'] = $questions;
    }

    if (empty($_SESSION['index']) && empty($_POST["id"])) {
        $_SESSION['index'] = 0;
    } else {
        $_SESSION['index'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    $answers_array = [
        $_SESSION['questions'][$_SESSION['index']]['correctAnswer'],
        $_SESSION['questions'][$_SESSION['index']]['firstIncorrectAnswer'],
        $_SESSION['questions'][$_SESSION['index']]['secondIncorrectAnswer']
    ];
    shuffle($answers_array);

    if (isset($_POST['answer'])) {
        if (!isset($_SESSION['result'])) {
            $_SESSION['result'] = ['right' => 0, 'wrong' => 0];
        }
        $answer = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING);

        if ($answer == $_SESSION['questions'][$_SESSION['index']]['correctAnswer']) {
            $toast = "Great, your answer is right!";
            $_SESSION['result']['right']++;
        } else {
            $toast = "Oh no, you are wrong!";
            $_SESSION['result']['wrong']++;
        }
    }

    if ($_SESSION["index"] == $total) {
        $right_answers = $_SESSION['result']['right'];
        $wrong_answers = $_SESSION['result']['wrong'];
        session_destroy();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Math Quiz: Addition</title>
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <?php if (!isset($_POST["answer"]) && ($_SESSION["index"] < $total)) { ?>
            <div id="quiz-box">
                <p class="breadcrumbs">Question <?php echo $_SESSION["index"] + 1; ?> of <?php echo $total; ?></p>
                <p class="quiz">What is <?php echo $_SESSION['questions'][$_SESSION["index"]]["leftAdder"]; ?> + <?php echo $_SESSION['questions'][$_SESSION["index"]]["rightAdder"]; ?>?</p>
                <form action="index.php"  method="post">
                    <input type="hidden" name="id" value="<?php echo $_SESSION["index"]; ?>" />
                    <?php foreach ($answers_array as $item_answers) { ?>
                        <input type="submit" class="btn" name="answer" value="<?php echo $item_answers ?>" />
                    <?php } ?>
                </form>
            </div>
        <?php } elseif (isset($_POST["answer"]) && ($_SESSION["index"] < $total)) { ?>
            <div id="quiz-box">
                <p class="toast"><?php echo $toast; ?></p>
                <form action="index.php"  method="post">
                    <input type="hidden" name="id" value="<?php echo $_SESSION["index"] + 1; ?>" />
                    <input type="submit" class="btn" value="Next Question" />
                </form>
            </div>
        <?php } else { ?>
            <div id="quiz-box">
                <p class="result">You gave <?php echo $right_answers; ?> right answers and <?php echo $wrong_answers; ?> wrong answers</p>
                <form action="index.php"  method="post">
                    <input type="submit" class="btn" value="New Quiz" />
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>