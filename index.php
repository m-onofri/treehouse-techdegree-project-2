<?php 
    include('inc/questions.php');
    $total = count($questions);
    $index = filter_input(INPUT_GET, 'index', FILTER_SANITIZE_NUMBER_INT);
    if (empty($index)) {
        $index = 1;
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
        <div id="quiz-box">
            <p class="breadcrumbs">Question <?php echo $index; ?> of <?php echo $total; ?></p>
            <p class="quiz">What is 54 + 71?</p>
            <form action="index.php?index=<?php echo $index + 1 ?>"  method="post">
                <input type="hidden" name="id" value="0" />
                <input type="submit" class="btn" name="answer" value="135" />
                <input type="submit" class="btn" name="answer" value="125" />
                <input type="submit" class="btn" name="answer" value="115" />
            </form>
        </div>
    </div>
</body>
</html>