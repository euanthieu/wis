<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>04_variable_types</title>
</head>
<body>
    <?php
        print "integers <br>";
        $int_var = 12345;
        print $int_var . "<br>";
        $another_int = -12345 + 12345;
        print $another_int . "<br><br>";

        print "doubles <br>";
        $many = 2.2888800;
        $many_2 = 2.2111200;
        $few = $many + $many_2;
        print($many + $many_2 ." = $few<br>");
        print "<br>";

        print "bolean <br>";
        if (TRUE)
            print("This will always print<br>");
        else
            print("This will never print<br>");
        print "<br>";    


        print "other types of booleans";
        $true_num = 3 + 0.14159;
        $true_str = "Tried and true";
        $true_array[49] = "An array element";
        $false_array = array();
        $false_null = NULL;
        $false_num = 999 - 999;
        print "true_num: " . $true_num . "<br>";
        print "true_str: " . $true_str . "<br>";
        print "true_array[49]: " . $true_array[49] . "<br>";
        print "false_array: " . var_export($false_array, true) . "<br>";
        print "false_null: " . var_export($false_null, true) . "<br>";
        print "false_num: " . $false_num . "<br>";
        print "<br>";

        print "null <br>";
        $my_var = null;
        print "my_var: " . $my_var . "<br>";
        print "<br>";

        print "strings <br>";
        $string_1 = "This is a string in double quotes";
        $string_2 = "This is a somewhat longer, singly quoted string";
        $string_39 = "This string has thirty-nine characters";
        $string_0 = ""; // a string with zero characters
        $variable = "name";
        $literally = 'My $variable will not print!<br>';
        echo $literally;
        $literally = "My $variable will print!<br>";
        echo $literally;
        print "<br>";

        print "Here Document <br>";
        $channel = <<< _XML_
        <channel>
        <title>What's For Dinner</title>
        <link>http://menu.example.com/</link>
        <description>Choose what to eat tonight.</description>
        </channel>
        _XML_;
        echo <<< END
        This uses the "here document" syntax to output
        multiple lines with variable interpolation. Note
        that the here document terminator must appear on a
        line with just a semicolon. no extra whitespace!
        <br />
        END;
        print $channel . "<br>";
        print "<br>";

        print "variable Naming <br> <br>";
        print "local Variables <br>";
        $x = 4;
        function assignx()
        {
            global $x; // Use the globalkeyword to access the global variable $x
            $x = 0;
            print "\$x inside function is $x. ";
        }
        assignx();
        print "\$x outside of function is $x. <br>";
        print "<br>";

        print "function parameters <br>";
        // multiply a value by 10 and return it to the caller
        function multiply($value)
            {
                $value = $value * 10;
                return $value;
            }
        $retval = multiply(10);
        Print "Return value is $retval <br>"; 
        print "<br>";
        
        print "global variables <br>";
        $somevar = 15;
        function addit()
        {
            GLOBAL $somevar;
            $somevar++;
            print "Somevar is $somevar";
        }
        addit();
        print "<br><br>";

        print "static variables <br>";
        function keep_track()
        {
            static $count = 0;
            $count++;
            print $count;
            print "<br>";
        }

        keep_track();
        keep_track();
        keep_track();
        print "<br><br>";

        print "bye!";
    ?>
</body>
</html>