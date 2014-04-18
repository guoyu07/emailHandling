<?php  
session_start(); 
// The main goal of this class is showing the template preview based on the user input.
//Firs step is getting the content of the template file then substitute its keys with its real values.

print_r( $json );

  $conn = pg_pconnect("host=localhost dbname=Message user=postgres password=****")
		or die('Could not connect: ' . pg_last_error());;
		if (!$conn)
		{
		echo "An error connection occurred.\n";
		exit;
		}
   

    
 $sql3 =<<<EOF
          SELECT array_to_json(Keys),array_to_json(Values),Body FROM template3
		
	 ;
EOF;

$ret3 = pg_query($conn, $sql3);
   if(!$ret3){
      echo pg_last_error($conn);
      exit;
   };
   
   
   
//$var = array();
 while($row3 = pg_fetch_row($ret3)){
    //  echo "---ID = ". $row3[0] . "\n";  
	//  echo "---Key = ". $row3[1] . "\n";  
	//  echo "---Values = ". $row3[2] . "\n";  
	//  echo "---Body = ". $row3[3] . "\n"; 
	  
//$templatefile=$row3[3];	
//$template = file_get_contents($templatefile);
//echo $template;

$vals = json_decode($row3[1]);
$keys = json_decode($row3[0]);
$variables = array();


//echo count($vals);
	for($i = 0; $i < count($keys); ++$i) 
	{
		//echo $vals[$i];
		$variables[$keys[$i]] = $vals[$i];
	}
	
	
/*	
//******* JSON
	$result = array();
    array_push($result, array('keys'  => $keys,
						 ));
	echo json_encode(array("result" => $result));

 //******** 

*/

}
$template = file_get_contents("templatetext.html");

foreach($variables as $key => $value)
{
//echo $key;
//echo $value;
    $template = str_replace('{{ '.$key.' }}', $value, $template);
}

//echo $template;

$_SESSION['template'] = $template;


include 'TemplatePreview.php';
  

   pg_close($conn);

?>
