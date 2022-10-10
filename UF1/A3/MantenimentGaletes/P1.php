<?php
    if (!isset($_COOKIE["laMevaCookie"])) {
        setcookie("laMevaCookie", "100");
    } else {
        setcookie("laMevaCookie", "101");
    }
    
    header('Location: P2.php');
?>