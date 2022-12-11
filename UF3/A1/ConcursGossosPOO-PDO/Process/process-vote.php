<?php
  session_start();
  // Mira si és un post provinent de index.php o tanca la sessio
  if (!isset($_POST['poll'])) {
    header('Location: ../index.php');
  } else {
    require_once('../Classes/Vote.php');
    if (isset($_SESSION['vote'])) {
      $vote = new Vote(session_id(), $_SESSION['fase'], $_POST['poll']);
      // Update vote to database
      $vote->updateVote();
    } else {
      $vote = new Vote(session_id(), $_SESSION['fase'], $_POST['poll']);
      // Add vote to database
      $vote->addVote();
    }
    var_dump($vote);
    $_SESSION['vote'] = $_POST['poll'];
    // header('Location: ../index.php');
  }
?>