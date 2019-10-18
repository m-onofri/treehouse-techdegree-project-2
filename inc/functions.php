<?php

//Generate the single question starting from the correct answer
function generate_question($value) {
    $leftAdder = rand(1, $value - 1);
    $rightAdder = $value - $leftAdder;
    $max_value = max([$leftAdder, $rightAdder]);

    /*$firstIncorrectAnswer must be 
    ** - greater than the highest adder;
    ** - not equal to $value;
    */
    do {
        $firstIncorrectAnswer = rand($value - 10, $value + 10);
    } while (($firstIncorrectAnswer == $value) || ($firstIncorrectAnswer <= $max_value));

    /*$secondIncorrectAnswer must be:
    ** - greater than the highest adder;
    ** - not equal to $value;
    ** - not equal to $firstIncorrectAnswer;
    */
    do {
        $secondIncorrectAnswer = rand($value - 10, $value + 10);
    } while (($secondIncorrectAnswer == $firstIncorrectAnswer) || ($secondIncorrectAnswer == $value) || ($secondIncorrectAnswer <= $max_value));

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
        $value = rand(5, 100);
        if (!array_search($value, $results)) {
            $results[] = $value;
        }
    }

    //Generate an array of 10 questions with relative answers
    $questions = array_map('generate_question', $results);

    return $questions;
}

//Check if the user choice is correct or incorrect
function check_selected_btn($correct_answer, $user_choice, $answer_option) {
    if ($user_choice == $answer_option) {
        if ($correct_answer == $answer_option) {
            return "btn-correct";
        } else {
            return "btn-wrong";
        }
    }
}
