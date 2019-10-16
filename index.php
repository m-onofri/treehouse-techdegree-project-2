<?php 
    session_start();
    include('inc/questions.php');

    //Collect and shuffle the questions
    $total = count($questions);
    if (empty($_SESSION['questions'])) {
        shuffle($questions);
        $_SESSION['questions'] = $questions;
    }

    //Keep track of the current question
    if (empty($_SESSION['index']) && empty($_POST["id"])) {
        $_SESSION['index'] = 0;
    } else {
        $_SESSION['index'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    //Random answer option
    $answers_array = [
        $_SESSION['questions'][$_SESSION['index']]['correctAnswer'],
        $_SESSION['questions'][$_SESSION['index']]['firstIncorrectAnswer'],
        $_SESSION['questions'][$_SESSION['index']]['secondIncorrectAnswer']
    ];
    shuffle($answers_array);

    //Keep track of the user's answers
    if (isset($_POST['answer'])) {
        if (!isset($_SESSION['result'])) {
            $_SESSION['result'] = ['correct' => 0, 'wrong' => 0];
        }
        $answer = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING);

        //Set toast
        if ($answer == $_SESSION['questions'][$_SESSION['index']]['correctAnswer']) {
            $toast = "Great, your answer is right!";
            $bg_answer = "correct";
            $_SESSION['result']["correct"]++;
        } else {
            $toast = "Oh no, you are wrong!";
            $bg_answer = "wrong";
            $_SESSION['result']['wrong']++;
        }
    }

    //Manage quiz result
    if ($_SESSION["index"] == $total) {
        $right_answers = $_SESSION['result']['correct'];
        $correct_answers = $_SESSION['result']['wrong'];
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
<body class="<?php if(isset($bg_answer)) {echo $bg_answer;} ?>">
    <div class="container">

        <?php if (!isset($_POST["answer"]) && ($_SESSION["index"] < $total)) { ?>

            <!-- Display the question and the answer options -->
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

            <!-- Display answer evaluation -->
            <div id="quiz-box">
                <p class="breadcrumbs">Question <?php echo $_SESSION["index"] + 1; ?> of <?php echo $total; ?></p>
                <p class="toast"><?php echo $toast; ?></p>

                <?php if (($_SESSION["index"] + 1) == $total) { ?>

                    <!-- Display button for the final score -->
                    <div class="quiz-end">
                        <p>The quiz is over!</p>
                        <form action="index.php"  method="post">
                            <input type="hidden" name="id" value="<?php echo $_SESSION["index"] + 1; ?>" />
                            <input type="submit" class="btn btn-result" value="Final Score"/>
                        </form>
                    </div>

                <?php } else { ?>

                    <!-- Display button for the next answer -->
                    <form action="index.php"  method="post">
                        <input type="hidden" name="id" value="<?php echo $_SESSION["index"] + 1; ?>" />
                        <input type="submit" class="btn <?php echo $bg_answer == "correct" ? "btn-correct" : "btn-wrong" ?>" value="Next Question" />
                    </form>
                <?php } ?>
            </div>

        <?php } else { ?>

            <!-- Display the final score -->
            <div id="quiz-box">
                <div class="final-score">
                    <h2>FINAL SCORE</h2>
                    <table>
                        <tr>
                            <th>CORRECT ANSWERS</th>
                            <th>WRONG ANSWERS</th>
                        </tr>
                        <tr>
                            <td><?php echo $right_answers; ?></td>
                            <td><?php echo $correct_answers; ?></td>
                        </tr>
                    </table>
                    <form action="index.php"  method="post">
                        <input type="submit" class="btn btn-result" value="Play Again" />
                    </form>
                </div>
            </div>

        <?php } ?>

    </div>
</body>
</html>