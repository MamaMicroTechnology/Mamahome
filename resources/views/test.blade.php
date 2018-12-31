<?php
/*
 * Converts CSV to JSON
 * Example uses Google Spreadsheet CSV feed
 * csvToArray function I think I found on php.net
 */
header('Content-type: application/json');
// Set your CSV feed

$feed =$x;
// Arrays we'll use later
$keys = array();
$newArray = array();
// Function to convert CSV into associative array
function csvToArray($file, $delimiter) { 
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0; 
    while (($lineArray = fgetcsv($handle, 7000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray); $j++) { 
        $arr[$i][$j] = $lineArray[$j]; 
      } 
      $i++; 
    } 
    fclose($handle); 
  } 
  return $arr; 
} 
// Do it
$data = csvToArray($feed, ',');
// Set number of elements (minus 1 because we shift off the first row)
$count = count($data) - 1;
  
//Use first row for names  
$labels = array_shift($data);  
foreach ($labels as $label) {
  $keys[] = $label;
}
// Add Ids, just in case we want them later
$keys[] = 'id';
for ($i = 0; $i < $count; $i++) {
  $data[$i][] = $i;
}
  
// Bring it all together
for ($j = 0; $j < $count; $j++) {
  $d = array_combine($keys, $data[$j]);
  $newArray[$j] = $d;
}
// print_r($newArray);
// print_r(sizeof($newArray));
// Print it out as JSon
// $servername = "localhost";
// $username = "root";
// $password = "yadav";
// $dbname = "mamahome_mamahome";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // print_r($newArray[0]);
// $murali = [];
// for($i=0;$i<sizeof($newArray);$i++){
//   $m = array_values($newArray[$i]); 

// array_push($murali,$m);

// }
// $i=0;
// if($i<sizeof($murali)){
//     print_r($murali[$i][0]);
//     $yup = [$murali[$i][0],$murali[$i][1]];
//     $sql = "INSERT INTO ledgers (val_date,Transaction) values ";
//       $sql .= (implode(",",$yup));
      
// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error:". "<br>" . $conn->error;
// }

// $conn->close();
//  $i = $i+1;

// }else{
//   echo "string";
// }
    

?>
<!DOCTYPE html>
<html>
<head>
  <title>Mamahome</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <table>
    <?php $s = serialize($newArray); ?>
     <br><br>
    <a href="{{ URL::to('/') }}/testdata?id={{$s}}" class="btn btn-warning"> Your File is upload Sucuss Please press to go back home</a>
  </table>
</body>
</html>