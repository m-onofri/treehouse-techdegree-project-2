<?php

//Generate the single question starting from the correct answer
function generate_question($value) {
    $leftAdder = rand(1, $value - 1);
    $rightAdder = $value - $leftAdder;
    $max_value = max([$leftAdder, $rightAdder]);

    //$firstIncorrectAnswer must be greater than zero, greater than the highest adder and not equal to $value;
    do {
        $firstIncorrectAnswer = rand($value - 10, $value + 10);
    } while ($firstIncorrectAnswer < 0 || ($firstIncorrectAnswer == $value) || ($firstIncorrectAnswer < $max_value));

    //$secondIncorrectAnswer must be greater than zero, greater than the highest adder, not equal to $value and not equal to $firstIncorrectAnswer;
    do {
        $secondIncorrectAnswer = rand($value - 10, $value + 10);
    } while ($secondIncorrectAnswer < 0 || ($secondIncorrectAnswer == $firstIncorrectAnswer) || ($secondIncorrectAnswer == $value) || ($secondIncorrectAnswer < $max_value));

    $question = [
        "leftAdder" => $leftAdder,
        "rightAdder" => $rightAdder,
        "results" => [
            "correctAnswer" => $value,
            "firstIncorrectAnswer" => $firstIncorrectAnswer,
            "secondIncorrectAnswer" => $secondIncorrectAnswer
        ]
    ];

    return $question;
}

//Generate an array of 10 questions
function generate_questions() {
    $results = [];

    //Generate an array of 10 correct answers
    while (count($results) < 10) {
        $value = rand(5, 99);
        if (!array_search($value, $results)) {
            $results[] = $value;
        }
    }

    $questions = array_map('generate_question', $results);

    return $questions;
}
