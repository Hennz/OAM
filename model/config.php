<?php

$mysqli = new mysqli("localhost", "u656145912_root", "154815", "u656145912_larav");



/* check connection */

if ($mysqli->connect_errno) {

    printf("Connect failed: %s\n", $mysqli->connect_error);

    exit();

}



