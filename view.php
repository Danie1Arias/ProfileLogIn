<!DOCTYPE html>
<html>
    <head>
    <title>Daniel Arias Cámara 54a4b351</title>
    <?php 
    require_once "bootstrap.php"; 
    ?>
</head>

<body>
<div class="container">
    <h2>Profile information</h2>
    <?php
    require_once "pdo.php";
    
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, headline, summary FROM profile where profile_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for profile_id';
        header( 'Location: view.php' ) ;
        return;
    }

    echo("<p>First Name: " . htmlentities($row['first_name']) . "</p>");
    echo("<p>Last Name: " . htmlentities($row['last_name']) . "</p>");
    echo("<p>Email: " . htmlentities($row['email']) . "</p>");
    echo("<p>Headline: " . htmlentities($row['headline']) . "</p>");
    echo("<p>Summary: " . htmlentities($row['summary']) . "</p>");

    ?>

<a href="index.php">Done</a>

</div>
</body>