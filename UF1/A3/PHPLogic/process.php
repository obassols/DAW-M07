<?php
    session_start();

    // Comprova si la lletra usa la lletra del mig, si es una funcio o si ja està al array de respostes de l'usuari
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