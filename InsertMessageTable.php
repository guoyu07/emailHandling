<?php

session_start();

/**
 * This class inserts emails to two tables. One table keeps track of the general
 * data of emails such as their subjects and bodies. Another table is the sentEmail
 * table that keeps track of emailaddresses and ids of the emails. I designed the
 * second table because when I am sending one Email to 1000 student there is no
 * reason to save all data of the emails 1000 times so we can save all data one
 * time and in sentmail table have one column as emailaddresses and ID for those
 * 1000 students.
 */

$conn = pg_pconnect("host=localhost dbname=Message user=postgres password=*******") or die('Could not connect: ' . pg_last_error());

if (!$conn) {
    echo "An error connection occurred.\n";
    exit;
}


$sql = "INSERT INTO sentemail3 (ID,emailaddress) VALUES ({$_POST["ID"]},'{$_POST["tolist"]}')";
$ret = pg_query($conn, $sql);
if (!$ret) {
    echo pg_last_error($conn);
} else {
    echo " sentemail3 Records created successfully\n";
}

$sql = <<<EOF
      INSERT INTO emailtemplatelog (id,subject,body,status)
      VALUES ({$_POST["ID"]},'{$_POST["subject"]}','{$_POST["body"]}','sent' );
EOF;
$ret = pg_query($conn, $sql);
if (!$ret) {
    echo pg_last_error($conn);
} else {
    echo "Table created successfully\n";
}
$_SESSION['ID'] = $_POST["ID"];
$_SESSION['subject'] = $_POST["subject"];
$_SESSION['body'] = $_POST["body"];
$_SESSION['tolist'] = $_POST["tolist"];
include 'SedMessagefinal.php';
?>
