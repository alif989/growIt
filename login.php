<html>
<head>
    <meta charset="utf-8">
    <title>PHP Login Using Database</title>
    <link href="./css/style.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<br>
<form id="form" action="" method="post" name="Login_Form">
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
    <?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2" align="left" valign="top"><h3>Login</h3></td>
    </tr>
    <tr>
      <td align="right" valign="top">Username</td>
      <td><input name="Username" id="user_id" type="text" class="Input"></td>
    </tr>
    <tr>
      <td align="right">Password</td>
      <td><input id="pass_id" name="Password" type="password" class="Input"></td>
    </tr>
    <tr>
      <td> </td>
      <td><input name="Submit" type="submit" value="Login" class="Button3"></td>
    </tr>
    
<tr>
      <td colspan="2"><small>Username: abc Password:123456</small></td>
    </tr>
  </table>
</form>

<script type = "text/javascript">
    $(document).ready(function() {
      

      $("form").submit(function(e){

        e.preventDefault();
        var email  = $("#user_id").val() ; 
        var password  = $("#pass_id").val() ; 
      // alert(email); alert(password);
        $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: "http://localhost/php_gw/backend/api/login.php",
        data: {email,password},
        success: function(data){
          //localStorage.setItem("auth",data);
          //console.log(data);
          localStorage.removeItem('user');
          localStorage.setItem('user', JSON.stringify(data));
          window.location.href = 'http://localhost/php_gw/list.php';
        }
      });
    });
    });
</script>

</body>
</html>
