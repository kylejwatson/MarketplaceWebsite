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
        <?php
        $myArray = Array(78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62,
            73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73);
        $total;
        foreach($myArray as $val){
            $total += $val;
        }

        $cnt = count($myArray);
        $total /= $cnt;
        echo "<p> Average Tempurature is : $total </p>";
        echo "<p> List of 7 lowest tempuratures : ";
        sort($myArray);
        for($i = 0; $i < 7; $i++){
            echo " $myArray[$i],";
        }

        echo "</p><p> List of 7 highest tempuratures : ";
        for($i = $cnt - 7; $i < $cnt; $i++){
            echo " $myArray[$i],";
        }
        echo " </p>";
        var_dump(($myArray));
        $n = 500;
        $counter = 1;
        for($i = 0; $i <= $n; $i++){
            for($ii = 0; $ii < $i; $ii++){
                echo " $counter &#x1F";
                echo $counter+100;
                $counter++;
            }
            echo "<br>";
        }

        ?>
    </section>
</main>
</body>
</html>