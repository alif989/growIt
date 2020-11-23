<?php
require './backend/api/config/conc.php';

$sql = "SELECT * FROM curr_market";
$result = $conn->query($sql);
$fArray = array();
$fArray2nd = array();
if ($result->num_rows > 0) {

  // output data of each row
  while($row = $result->fetch_assoc()) {
    array_push($fArray, $row);
    array_push($fArray2nd, $row);
  }
}
// echo "<pre>";
// print_r($fArray);
?>

<html>
<head>
    <meta charset="utf-8">
    <title>PHP Login Without Using Database</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>

<body>
<br/>
<div id="hide">
  <button type="button" style="color:red" id="logout_id" >log out</button>
  <br/> <br/>
  <div id="" class="col-md-7">
      <table id="myTable" class="table center table-striped table-bordered">
          <thead>
            <tr>
              <th>#SL</th>
              <th>Name</th>
              <th>Currency Code</th>
              <th>Currency Number</th>
              <th>Forex Rate</th>
            </tr>
          </thead>
      </table>
  </div>
  <div id="" class="col-md-5">
      <div id="" class="col-md-12">
        <div id="" class="col-md-6">
          <label for="1st_curr_id">Choose 1st Currency:</label>
          <select name="1st_curr_id" id="1st_curr_id" class="form-control">
          <option > Choose Currency</option>
            <?php foreach($fArray as $fArray) {?>
                  <option value="<?php  echo $fArray['value'] ?>"><?php  echo $fArray['char_code'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div id="" class="col-md-6">
          <label for="2nd_curr_id">Choose 2nd Currency:</label>
          <select name="2nd_curr_id" id="2nd_curr_id" class="form-control">
              <option> Choose Currency</option>
            <?php foreach($fArray2nd as $fArray2nds) {?>
                  <option value="<?php  echo $fArray2nds['value'] ?>"><?php  echo $fArray2nds['char_code'] ?></option>
            <?php } ?>
          </select>
        </div>
        <br/><br/><br/><br/>
        <div id="" class="col-md-12">
            <label for="cross">Cross Rate:</label>
            <label id="cal_result_id"></label>
            <label id="cur_text_id"></label>
        </div>
      </div>
      
  </div> 
</div>

<script type = "text/javascript">
    $(document).ready(function() {
        var data = JSON.parse(localStorage.getItem("user"));
       //console.log(data);
       $("#hide").hide();
            // console.log(token);
        if(data){
          $("#hide").show();
          var token = data.jwt;
            $.ajax({
              type: "POST",
              dataType: 'JSON',
              url: "http://localhost/php_gw/backend/api/api_list.php",
              data: {token},
              success: function(data){
                var sl =0;
                $.each(data.data, function(a ,b ) {
                  $("#myTable").append('<tr><td>'+ ++sl +'</td><td>'+b.name+'</td><td>'+b.char_code+'</td><td>'+b.num_code+'</td><td>'+b.value+'</td></tr>');     
            
                });
              }  
           });
        } else{
          window.location.href = 'http://localhost/php_gw/login.php';

        } 
        

    });
    $(document).on("click","#logout_id",function() {
      localStorage.removeItem('user');
          window.location.href = 'http://localhost/php_gw/login.php';
    });

    $(document).on('change', '#1st_curr_id', function(){
       var first_curr = parseFloat($("#1st_curr_id").val());
       var second_curr = parseFloat($("#2nd_curr_id").val());
       var first_curr_name =$( "#1st_curr_id option:selected" ).text();;
        console.log(first_curr_name);
       console.log(first_curr);
       console.log(second_curr);
       if(first_curr>0 && second_curr>0 ){
        var rate = parseFloat(first_curr/second_curr);
        $("#cal_result_id").text(rate.toFixed(4));
        $("#cur_text_id").text(cur_text_id);
       }
     });

     $(document).on('change', '#2nd_curr_id', function(){
       var first_curr = parseFloat($("#1st_curr_id").val());
       var second_curr = parseFloat($("#2nd_curr_id").val());
       var first_curr_name =$( "#1st_curr_id option:selected" ).text();;
       if(first_curr>0 && second_curr>0 ){
        var rate = parseFloat(second_curr/first_curr);
        $("#cal_result_id").text(rate.toFixed(4));
        $("#cur_text_id").text(first_curr_name);
       }
     });

</script>

</body>
</html>
