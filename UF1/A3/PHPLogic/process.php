<?php
    session_start();
    $letters = strtolower(implode($_SESSION['letters']));
    $regex = "/^[". $letters ."]*[" . $letters[3] . "]+[". $letters ."]*$/";
    if (preg_match($regex, $_SESSION['test-word'])) {
        if(in_array($_SESSION['test-word'], $_SESSION['all_answers'])) {
            if(!in_array($_SESSION['test-word'], $_SESSION['correct_answers'])) {
                $_SESSION['correct_answers'][] = $_SESSION['test-word'];
                unset($_SESSION['error_msg']);
            } else {
                $_SESSION['error_msg'] = "Ja hi és";
            }
        } else {
            $_SESSION['error_msg'] = $_SESSION['test-word'];
        }
    } else {
        $_SESSION['error_msg'] = "Falta la lletra del mig";
    }
    header('Location: ' . $_SESSION['url']);
?>