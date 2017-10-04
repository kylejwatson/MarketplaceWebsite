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
    <section>
        <form name="form1" method="post" action="index.php">
            <label>Enter a positive integer:</label>
            <input type="text" name="n">
            <input type="submit" name="Submit" value="Submit">
            <input type="reset" name="reset" value="Reset">
        </form>
    </section>
    <section>
        <?php
        function arrayVals($arr){
            $total = 0;
            foreach($arr as $val){
                $total += $val;
            }

            $cnt = count($arr);
            $total /= $cnt;
            echo "<p> Average Tempurature is : $total </p>";
            echo "<p> List of 7 lowest tempuratures : ";
            sort($arr);
            for($i = 0; $i < 7; $i++){
                echo " $arr[$i],";
            }

            echo "</p><p> List of 7 highest tempuratures : ";
            for($i = $cnt - 7; $i < $cnt; $i++){
                echo " $arr[$i],";
            }
            echo " </p>";
        }

        function floydsTriangle($n){
            $counter = 1;
            for($i = 0; $i <= $n; $i++){
                for($ii = 0; $ii < $i; $ii++){
                    //echo " $counter &#x1F";
                    //echo $counter+100;
                    echo $counter;
                    $counter++;
                }
                echo "<br>";
            }
        }

        function factorial($n){
            if($n == 0){
                return 1;
            }
            return factorial($n-1)*$n;
        }
        if( isset($_POST['n'])) {
            $n = $_POST['n'];
            $fac = factorial($n);
            echo "<p>Factorial of $n : $fac</p><p>Floyds Triangle:</p>";
            floydsTriangle($n);
            $myArray = Array(78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62,
                73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73);
            arrayVals($myArray);
        }

        $response = file_get_contents("http://www.classifiedsteam.co.uk/for-sale/5-gauge-locomotives-and-parts");
        //echo "<textarea> $response </textarea>";

        $titlePos = strpos($response, 'title="');
        $title = substr($response, $titlePos, -1);
        ?>
    </section>
    <section>
        <?php

        ?>
    </section>
</main>
</body>
</html>