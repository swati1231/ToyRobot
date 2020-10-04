<?php

spl_autoload_register(
    function ($class) {
        include 'classes/' . $class . '.php';
    }
);

// Instantiating toyTable, toyRobot
$table = new toyTable(5, 5);
$toyRobot = new toyRobot($table);

//invoking file with commands
$file = 'test/test.txt';

$fHandle = fopen($file, 'r');

while (($command = fgets($fHandle))) {
    $toyRobot->action($command);
}

fclose($fHandle);
