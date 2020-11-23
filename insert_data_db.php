<?php 

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

$sql = "CREATE DATABASE mydb";
$conn->query($sql);

$conn1 = mysqli_connect("localhost", "root", "", "mydb");

$sql_tbl = "CREATE TABLE curr_market(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    num_code VARCHAR(30) ,
    char_code VARCHAR(30),
    name VARCHAR(50),
    value VARCHAR(50),
    date date
    )";

mysqli_query($conn1, $sql_tbl);

$sql_tbl_user = "CREATE TABLE users(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) ,
    last_name VARCHAR(30),
    email VARCHAR(50),
    password VARCHAR(50)
    )";
    mysqli_query($conn1, $sql_tbl_user);
    $sql_tr_usr = "TRUNCATE TABLE users";
    mysqli_query($conn1,$sql_tr_usr); 

    $password_usr ='123456';

    $sql_user_inst = "INSERT INTO users(first_name,last_name,email,password) VALUES ('alif','motaleb','abc','".$password_usr."')";
    $result = mysqli_query($conn1, $sql_user_inst);
   




$affectedRow = 0;
// $str ='http://www.cbr.ru/scripts/XML_daily.asp';
$xml = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp') ;
$new = simplexml_load_string($xml); 
echo "<pre>";
$date= $new->attributes()->{'Date'};

$phpdate = strtotime($date);
$mysqldate = date( 'Y-m-d', $phpdate );
// echo $mysqldate ; exit();
$var = array();
$sql_tr = "TRUNCATE TABLE curr_market";

 mysqli_query($conn1,$sql_tr);
foreach($new->children() as $val ){
    $NumCode = $val->NumCode;
    $CharCode = $val->CharCode;
    $Name = $val->Name;
    $Value = $val->Value;

    // echo "<pre>";
    // print_r($val);
    $sql = "INSERT INTO curr_market(num_code,char_code,Name,Value,date) VALUES ('" .$NumCode . "','" .$CharCode . "','" .$Name. "','" . $Value . "','" . $mysqldate. "')";
    $result = mysqli_query($conn1, $sql);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    if (! empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = mysqli_error($conn1) . "\n";
    }
}
    ?>
  
    <!-- <h2>Insert XML Data to MySql Table Output</h2> -->
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}



?>
<style>
body {
	max-width: 550px;
	font-family: Arial;
}

.affected-row {
	background: #cae4ca;
	padding: 10px;
	margin-bottom: 20px;
	border: #bdd6bd 1px solid;
	border-radius: 2px;
	color: #6e716e;
}

.error-message {
	background: #eac0c0;
	padding: 10px;
	margin-bottom: 20px;
	border: #dab2b2 1px solid;
	border-radius: 2px;
	color: #5d5b5b;
}
</style>
<div class="affected-row">
    <?php  echo $message; ?>
</div>
<?php if (! empty($error_message)) { ?>
    <div class="error-message">
        <?php echo nl2br($error_message); ?>
    </div>
<?php } ?>