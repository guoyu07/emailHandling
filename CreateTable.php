<?php
session_start();



$conn = pg_pconnect("host=localhost dbname=Message user=postgres password=****") or die('Could not connect: ' . pg_last_error());
;
if (!$conn) {
    echo "An error connection occurred.\n";
    exit;
}

$sql = <<<EOF
      CREATE TABLE Template3
      (ID INT PRIMARY KEY     NOT NULL,
      Keys           text[]   ,
	  Values		 text[],
      Body            Text     NOT NULL
	  );

EOF;
$ret = pg_query($conn, $sql);
if (!$ret) {
    echo pg_last_error($conn);
} else {
    echo "Table created successfully\n";
}


$sql = <<<EOF
    CREATE TABLE sentemail3(
    ID INT NOT NULL,
    emailaddress  TEXT NOT NULL,
	PRIMARY KEY(ID, emailaddress)
);
EOF;
$ret = pg_query($conn, $sql);
if (!$ret) {
    echo pg_last_error($conn);
} else {
    echo "Table created successfully\n";
}



pg_close($conn);
?>
