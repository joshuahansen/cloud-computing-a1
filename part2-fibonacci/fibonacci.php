<?php session_start(); ?>
<html>
    <body>
        <?php
            if(array_key_exists('n', $_POST)) {
                $fib_file = 'gs://s3589185-a1-storage/fibonacci_'.$_POST['n'].'.txt';
                $handle = fopen($fib_file, 'w');
                $_SESSION['fib_file'] = $fib_file;
                $f0 = 1;
                $f1 = 1;
                fwrite($handle, $f0.',');
                fwrite($handle, $f1.',');
                for($i = 2; $i < $_POST['n']; $i++) {
                    $fib = $f0 + $f1;
                    $f0 = $f1;
                    $f1 = $fib;
                    fwrite($handle, $fib);
                    if($i == ($_POST['n'] - 1))
                        break;
                    else
                        fwrite($handle, ",");
                }
                fclose($handle);
            ?>
                <form action='/sign' method='post'>
                    <div>A: <input type='number' name='A'></div>
                    <div>B: <input type='number' name='B'></div>
                    <div>C: <input type='number' name='C'></div>
                    <div><input type='submit' value='Submit'></div>
                </form>
            <?php 
            }
            else if(array_key_exists('A', $_POST) && array_key_exists('A', $_POST) && array_key_exists('A', $_POST)) {
                $fib_file = $_SESSION['fib_file'];
                $fibs = explode(",", file_get_contents($fib_file));
                
                $S = ($_POST['A'] + $_POST['B']);
                $M = $S * $_POST['C'];
                
                for($x = 0; $x < count($fibs); $x++) {
                    $M = $M + $fibs[$x];
                }
                $average = $M/(count($fibs)+3);
                $average = number_format((float)$average, 2, '.', '');
                $result_file = 'gs://s3589185-a1-storage/result.txt';
                $handle = fopen($result_file, 'w');
                fwrite($handle, $average);

                echo "Total Sum: " . $M;
                echo "</br>Average: " .$average;
            }
            else {
            ?>
                <form action='/sign' method='post'>
                    <div>N: <input type='number' name='n' min='5' max='25'></div>
                    <div><input type='submit' value='Submit'></div>
                </form>
            <?php } ?> 
    </body>
</html>
