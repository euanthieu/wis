<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>05_constants</title>
</head>
<body>
    <?php
        print "constants <br><br>";
        print "constant example <br>";
        define("MINSIZE", 50);
        echo MINSIZE;
        echo constant("MINSIZE"); // same thing as the previous line
        print "<br><br>";

        print "valid and invalid constant names <br> <br>";
        // Valid constant names
        print "valid names: ONE, TWO2, THREE_3";
        define("ONE", "first thing");
        define("TWO2", "second thing");
        define("THREE_3", "third thing");
        print "<br><br>";
        // Invalid constant names
        print "will error with: 2TWO, __THREE__";
        //define("2TWO", "second thing");
        //define("__THREE__", "third value");

    ?>
</body>
</html>