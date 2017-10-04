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
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="script.js"></script>-->
</head>
<body>
<main id="bio" tabindex="-1">
    <section id="interests">
        <p> Please enter your details below:- </p>
        <form name="form1" method="post" action="passingdata.php">
            <label>Date of Birth (in DD/MM/YYYY format):</label>
            <input type="date" name="date">
            <label>Password:</label>
            <input type="password" name="password">
            <label>First name:</label>
            <input type="text" name="firstname">
            <label>Surname:</label>
            <input type="text" name="surname">
            <fieldset>
                <label>CS</label>
                <input type="radio" name="course" value="CS">
                <label>SE</label>
                <input type="radio" name="course" value="SE">
                <label>MIT</label>
                <input type="radio" name="course" value="MIT">
            </fieldset>
            <label>Living on the Salford Campus</label>
            <input type="checkbox" name="campus" value="campus">
            <input type="submit" name="Submit" value="Submit">
            <input type="reset" name="reset" value="Reset">
        </form>
    </section>
</main>
</body>
</html>