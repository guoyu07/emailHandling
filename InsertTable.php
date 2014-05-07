
<?php

/**
 * InsertTable class gets the content of the text files that user typed in and inserts
 * them as the value of the keys into the database.
 */

session_start();

$conn = pg_pconnect("host=localhost dbname=Message user=postgres password=****") or die('Could not connect: ' . pg_last_error());

if (!$conn) {
    echo "An error connection occurred.\n";
    exit;
}

$sql = <<<EOF
      INSERT INTO Template3 (ID,Keys,Values,Body)
      VALUES ({$_POST["ID"]},  '{"Fname", "Lname"}', '{ {$_POST["Fname"]} , {$_POST["Lname"]}  }', 'templatetext.html' );
EOF;


$ret = pg_query($conn, $sql);
if (!$ret) {
    echo pg_last_error($conn);
} else {
    echo "Table created successfully\n";
}
include 'SelectTable.php';
?>
