<?php
session_start();
require_once("system/controller/main.php");
require_once("system/config/function.php");
$todo = new Todo();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
   <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
   <link rel="stylesheet" href="../common/css/styles.css">
   <title></title>
</head>
<body>
<div class="parent">
<form method="post">
   <input class="test" type="text" name="test">
   
</form>
</div>
</body>
<input type='date' name='date'>
<button>呼び出し</button>
<script>
jQuery(function($){
  $('button').click(function(){
    var day = $('input[name=date]').val();//インプット欄の日付を取得
    console.log("aa");
    $.ajax({
      type: 'POST',
      dataType:'json',
      url:'aaa.php',
      data:{
        item:day
      },
      success:function(data) {
        alert(data);
      }
    });
});
})
</script>
<script src="common/js/jquery.js"></script>
<script src="common/js/common.js"></script>
</html>

