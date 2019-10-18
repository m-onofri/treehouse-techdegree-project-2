<?php 
    session_start();
    include('inc/generate_questions.php');

    //Generate questions
    if (empty($_SESSION['questions'])) {
        $questions = generate_questions();
        $_SESSION['questions'] = $questions;
    }
    $total = count($_SESSION['questions']);

    //Keep track of the current question
    if (empty($_SESSION['index']) && empty($_POST["id"])) {
        $_SESSION['index'] = 0;
    } elseif (isset($_POST["id"])) {
        $_SESSION['index'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    //Get answer options, left adder and right adder 
    if (($_SESSION["index"] < $total) && !isset($_POST["answer"])) {
        $_SESSION['answers'] = $_SESSION['questions'][$_SESSION['index']]['results'];
        shuffle($_SESSION['answers']);
    }
    $leftAdder = $_SESSION['questions'][$_SESSION["index"]]["leftAdder"];
    $rightAdder = $_SESSION['questions'][$_SESSION["index"]]["rightAdder"];

    //Keep track of the user's answers
    if (isset($_POST['answer'])) {
        if (!isset($_SESSION['result'])) {
            $_SESSION['result'] = ['correct' => 0, 'wrong' => 0];
        }
        $answer = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING);

        //Set toast and keep track of the user's answers
        if ($answer == $_SESSION['questions'][$_SESSION['index']]['results']['correctAnswer']) {
            $toast = "Great, your answer is correct!";
            $bg_answer = "correct";
            $_SESSION['result']["correct"]++;
        } else {
            $toast = "Oh no, you are wrong!";
            $bg_answer = "wrong";
            $_SESSION['result']['wrong']++;
        }
    }

    //Manage final score
    if ($_SESSION["index"] == $total) {
        $right_answers = $_SESSION['result']['correct'];
        $correct_answers = $_SESSION['result']['wrong'];
        session_destroy();
    }   
?>

<?php include('inc/header.php'); ?>    

<?php if (!isset($_POST["answer"]) && ($_SESSION["index"] < $total)) { ?>

    <!-- Display the question and the answer options -->
    <?php include('inc/questions.php'); ?>
    
<?php } elseif (isset($_POST["answer"]) && ($_SESSION["index"] < $total)) { ?>

    <!-- Display answer evaluation -->
    <?php include('inc/questions.php'); ?>
    <p class="toast"><?php echo $toast; ?></p>

    <?php if (($_SESSION["index"] + 1) == $total) { ?>

        <!-- Display button for the final score --> 
        <form action="index.php"  method="post">
            <input type="hidden" name="id" value="<?php echo $_SESSION["index"] + 1; ?>" />
            <input type="submit" class="btn btn-result" value="Final Score"/>
        </form>
        
    <?php } else { ?>

        <!-- Display button for the next answer -->
        <form action="index.php"  method="post">
            <input type="hidden" name="id" value="<?php echo $_SESSION["index"] + 1; ?>" />
            <input type="submit" class="btn <?php echo $bg_answer == "correct" ? "btn-correct" : "btn-wrong" ?>" value="Next Question" />
        </form>

    <?php } ?>

<?php } else { ?>

    <!-- Display the final score -->
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

<?php } ?>

<?php include('inc/footer.php'); ?>  