<!DOCTYPE html>
<html lang="en">
<head>
    <title> Kyle Watson's Portfolio - Personal </title>
    <meta charset="UTF-8" />
    <meta name="keywords" content="Portfolio, Student, Developer, Counter-Strike">
    <meta name="description" content="A simple portfolio to show off projects and attributes.">
    <meta name="author" content="Kyle Watson">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <!--<script src="script.js"></script>-->
</head>
<body>
<main id="bio" tabindex="-1">
    <section id="interests">
        <form name="form1" method="post" action="passingdata.php">
            <?php
            /**
             * Created by PhpStorm.
             * User: Kyle
             * Date: 26/09/2017
             * Time: 12:30
             */

            if(file_exists("passwords.txt")){
                $myfile = fopen("passwords.txt", "r") or die("Unable to open file!");
                $txt = fread($myfile,filesize("passwords.txt"));
                if(password_verify($_POST['password'], $txt)){
                    echo "<p> Correct password </p>";
                }else{
                    echo "<p> Incorrect password </p>";
                }
                fclose($myfile);
            }else{
                $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $myfile = fopen("passwords.txt", "w") or die("Unable to open file!");
                fwrite($myfile, $pass);
                fclose($myfile);
                echo "<p>Saved new password</p>";
            }

            echo "<p>Hello " . $_POST['firstname']. " ". $_POST['surname'] . ". ";
            echo "You are studying " . $_POST['course'] . " and you are ";

            if(!isset($_POST['campus'])) {
                echo "not ";
            }
            echo "living on campus.</p>";

            list($dd,$mm,$yyyy) = explode("/",$_POST['date']);
            $year = intval($yyyy);
            $curYear = (int)date_create()->format("Y");
            if(intval($dd) != 0 && intval($dd) < 32 && intval($mm) != 0 && intval($mm) < 13 && $year != 0 ){
                $hundYear = $curYear - 100;
                if($year > date_create()->format("Y")){
                    echo "<p><strong> Please enter a date before this year</strong></p>";
                    echo "<label>Date of Birth (in DD/MM/YY format):</label>
                <input type=\"date\" name=\"date\">
                <input type=\"submit\" name=\"Submit\" value=\"Submit\">
                <input type=\"reset\" name=\"reset\" value=\"Reset\">";
                }elseif($year < $hundYear){
                    echo "<p><strong> Please enter a date after $hundYear</strong></p>";
                    echo "<label>Date of Birth (in DD/MM/YY format):</label>
                <input type=\"date\" name=\"date\">
                <input type=\"submit\" name=\"Submit\" value=\"Submit\">
                <input type=\"reset\" name=\"reset\" value=\"Reset\">";
                }else{
                    $thisYear = $curYear - $year;
                    echo "<p> You are $thisYear years old</p>";
                }
            }else{
                echo "<p><strong> Please enter a valid date </strong></p>";
                echo "<label>Date of Birth (in DD/MM/YY format):</label>
                <input type=\"date\" name=\"date\">
                <input type=\"submit\" name=\"Submit\" value=\"Submit\">
                <input type=\"reset\" name=\"reset\" value=\"Reset\">";
            }
            ?>


            <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
            <input type="hidden" name="firstname" value="<?php echo $_POST['firstname']; ?>">
            <input type="hidden" name="surname" value="<?php echo $_POST['surname']; ?>">
            <input type="hidden" name="course" value="<?php echo $_POST['course']; ?>">
            <input type="hidden" name="campus" value="<?php if(isset($_POST['campus'])) {
                echo "campus";
            } ?>">
        </form>
    </section>
</main>
</body>
</html>
