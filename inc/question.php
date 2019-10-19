
<div id="quiz-box">
    <p class="breadcrumbs">
        Question <?php echo $_SESSION["index"] + 1; ?> of <?php echo $total; ?>
    </p>
    <p class="quiz">What is <?php echo $leftAdder; ?> + <?php echo $rightAdder; ?>?</p>

    <?php if (!isset($_POST["answer"])) { ?>

        <!-- Display active buttons before user choice -->
        <form action="index.php"  method="post">
            <?php foreach ($_SESSION['answers'] as $item_answers) { ?>
                <input type="submit" class="btn" name="answer" value="<?php echo $item_answers; ?>" />
            <?php } ?>
        </form>

    <?php } else { ?>

        <!-- Display inactive buttons and user choice -->
        <?php foreach ($_SESSION['answers'] as $item_answers) { ?>
            <button class="btn <?php echo check_selected_btn($correct_answer, $_POST["answer"], $item_answers); ?>">
                <?php echo $item_answers; ?>
            </button>
        <?php } ?>

    <?php } ?>
</div>