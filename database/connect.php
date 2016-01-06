<?php

require '../lib/rb.php';

if (is_writable("./") === false) {
    echo 'Please set "database" directory writable!';
    exit();
}

$db_filename = "db.sqlite";
$is_db_exists = is_file($db_filename);

R::setup("sqlite:./" . $db_filename);

if ($is_db_exists === false) {
    echo 1;
}
else {
    echo 2;
}

$post = R::dispense( 'post' );
    $post->text = 'Hello World';

    $id = R::store( $post );          //Create or Update
