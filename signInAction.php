<?php 

//Connecting to the database

session_start();
try {
    $con = new PDO('mysql: host=localhost; dbname=database', 'username', 'password');
}
catch (PDOException $e){
die("Error : ".$e->getMessage()."<br/>");
} 


//Checking if the posted username or email input value is empty or not

if ($_POST['username_or_email'] != "") {


$username_or_email = filter_var($_POST['username_or_email'], FILTER_SANITIZE_STRING);
$stmt = $con->prepare("select * from accounts where username= ?");
$stmt->execute([$username_or_email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Checking if an account with the posted username or email exists

 if ($username_or_email == $result['username'] | $result['email']) {

//Checking if the posted password input value is empty or not 

  if (isset($_POST['login_password'])) {

$password=$_POST['login_password'];

//Checking if the posted password matches with the password of the account or not

    if (password_verify($password, $result['password'])) {

       /* Returning the response 13, after successfully signing into the account */ echo json_encode(array('success' => '13'));
       
    } else { /* Returning the response 12, if the posted password matches with the password of the account */ echo json_encode(array('success' => '12')); }
  } else { /* Returning the response 11, if the posted password input value is empty */ echo json_encode(array('success' => '11')); }
 } else { /* Returning the response 10, if an account with the same username or email does not exist */ echo json_encode(array('success' => '10')); }
} else { /* Returning the response 9, if the posted username or email input value is empty */ echo json_encode(array('success' => '9')); }
?>
