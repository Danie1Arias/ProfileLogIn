<?php
require_once "pdo.php";

session_start();

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {

    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 
    || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {

        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;

    } else if (!strpos($_POST['email'], '@')) {

        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: add.php");
        return;

        } else {

            $stmt = $pdo->prepare('INSERT INTO profile (user_id, first_name, last_name, email, headline, summary) VALUES (:uid, :fn, :ln, :em, :he, :su)');

            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
            );

            $_SESSION["success"] = "Profile added";
            header("Location: index.php");
            return;
                    
    }

}

?>

<!DOCTYPE html>
<html>
    <head>
    <title>Daniel Arias Severance's Resume Registry 54a4b351</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
<div class="container">
    <?php

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
    $guess = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : false;
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

    if ( isset($_SESSION['name'])) {
        echo "<h1>Adding Profile for  ";
        echo htmlentities($_SESSION['name']);
        echo "</h1>\n";
    }

    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
            
    ?>

    <form method="post">
        <p>First Name:
        <input type="text" name="first_name" size="60"></p>
        <p>Last Name:
        <input type="text" name="last_name" size="60"></p>
        <p>Email:
        <input type="text" name="email" size="30"></p>
        <p>Headline:<br>
        <input type="text" name="headline" size="80"></p>
        <p>Summary:<br>
        <textarea name="summary" rows="8" cols="80"></textarea></p>
        <input type="submit" value="Add"/>
        <input type="submit" name = "cancel" value="Cancel"/> 
    </form>

</div>
</body>
