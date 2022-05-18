<?php
session_start();
require_once("system/controller/main.php");
require_once("system/config/function.php");
$day = $_GET["day"];
$todo = new Todo();
$_SESSION["Limit"] = true;

//ページリロード時$dayを元に情報を取得
if(!$day){//今日
   $day = date('d');
   $today = $todo->getRegister($pdo,$day);
}else if($day == date("d")){//今日
   $day = date('d');
   $today = $todo->getRegister($pdo,$day);
}else{ //今日以外
   $today = $todo->getRegister($pdo,$day);
   unset($_SESSION["validation_text"]);
}

//送信時
if(isset($_POST["content_submit"])){
   if(!$day){//今日
      $content = h($_POST["content"]);
      $day = date('d');
      $info = $todo->Register($pdo,$content,$day);
   }else if($day == date("d")){//今日
      $content = h($_POST["content"]);
      $day = date('d');
      $info = $todo->Register($pdo,$content,$day);
   }else{//今日以外
      $content = h($_POST["content"]);
      $info = $todo->Register($pdo,$content,$day);
   }
}

//削除機能
if($_GET["delete"]){
   $param = $_GET["delete"];
   $todo->delete($pdo,$param);
}

//編集機能
if(isset($_POST["edit"])){
   $id = $_POST["get_edit_id"];
   $text = $_POST["edit_text"];
   $todo->edit($pdo,$id,$text);  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
   <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
   <link rel="stylesheet" href="/common/css/styles.css">
   <title></title>
</head>
<body>
   <div class="parent">
      <div class="title">
            <div>TODO List</div>
            <!-- 今日だったとき -->
            <?php if(!$day): ?>
               <div><i class="far fa-calendar-alt"></i>&nbsp;<?php echo date('Y/m/d'); ?></div>
            <?php else: ?><!-- 今日以外 -->
               <div><i class="far fa-calendar-alt"></i>&nbsp;<?php echo date('Y/m') . "/" . $day; ?></div>
            <?php endif; ?>
            <div>
               <form method="post" action="search.php">
                  <i class="fas fa-search"></i>&nbsp;<input type="text" placeholder="search" name="search_text">
                  &nbsp;<button class="search" name="search">検索</button>
               </form>
            </div>
      </div>
      <div class="day">
         <!-- 今日だったとき -->
         <?php if(!$day || $day == date('j')): ?>
               <!-- 今月最初だったとき -->
               <?php if(date("j") == 1): ?>
                  <a href="#"></a>
                  <a href="index.php?day=<?php echo date('d')+1; ?>">NEXT <i class="fas fa-chevron-right"></i></a>
               <!-- ↓月の最終日だったら -->
               <?php elseif(date("j") == date("t")): ?>
                  <a href="index.php?day=<?php echo date('d')-1; ?>"><i class="fas fa-chevron-left"></i> PREV</a>
                  <a href="#"></a>
               <!--  //↓月の初日、最終日日以外だったら -->
               <?php else: ?>
                  <a href="index.php?day=<?php echo date('d')-1; ?>"><i class="fas fa-chevron-left"></i> PREV</a>
                  <a href="index.php?day=<?php echo date('d')+1; ?>">NEXT <i class="fas fa-chevron-right"></i></a>
               <?php endif; ?>
         <!-- 今日以外 -->
         <?php else: ?>
               <!-- 今月最初だったとき -->
               <?php if($day == 1): ?>
                  <a href="#"></a>
                  <a href="/"><i class="fas fa-user-clock"></i></a>
                  <a href="index.php?day=<?php echo date('d')+1; ?>">NEXT <i class="fas fa-chevron-right"></i></a>
               <!-- ↓月の最終日だったら -->
               <?php elseif($day == date("t")): ?>
                  <a href="index.php?day=<?php echo date('t')-1; ?>"><i class="fas fa-chevron-left"></i> PREV</a>
                  <a href="/"><i class="fas fa-user-clock"></i></a>
                  <a href="#"></a>
               <!--  //↓月の初日、最終日日以外だったら -->
               <?php else: ?>
                  <a href="index.php?day=<?php echo $day-1; ?>"><i class="fas fa-chevron-left"></i> PREV</a>
                  <a href="/"><i class="fas fa-user-clock"></i></a>
                  <a href="index.php?day=<?php echo $day+1; ?>">NEXT <i class="fas fa-chevron-right"></i></a>
               <?php endif; ?>
         <?php endif; ?>
      </div>
      <?php if($_SESSION["validation_text"]): ?>
         <div class="error"><?php echo $_SESSION["validation_text"]; ?></div>
      <?php endif; ?>
      <?php if($today): ?>
         <table class="post">
            <?php foreach($today as $todays): ?>
            <tr>
               <td class="cursol"><span class="edit_btn"><i class="fas fa-bars"></i></span></td>
               <td><?php echo $todays["content"]; ?></td>
               <td><i class="far fa-clock"></i>&nbsp;<?php echo $todays["full_day"]; ?></td>
               <td><a href="index.php?delete=<?php echo $todays["id"]; ?>"><i class="fas fa-times"></i></a></td>
            </tr>
            <?php endforeach; ?>
         </table>
         <?php foreach($today as $todays): ?>
         <div class="edit">
            <div class="back">
               <form class="edit_submit" method="post">
                  <div>
                     <p>変更内容を入力してください</p>
                     <p class="error">入力が空です</p>
                     <i class="fas fa-times fadeout"></i>
                     <div class="edit_submit_flex">
                        <div class="cp_iptxt">
                           <input class="edit_text" type="text" name="edit_text">
                           <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                        </div>
                        <input type="hidden" name="get_edit_id" value="<?php echo $todays["id"]; ?>">
                        <input type="hidden" name="edit_day" value="<?php echo $_GET["day"]; ?>">
                        <button class="edit_button" name="edit">変更</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <!-- /edit -->
         <?php endforeach; ?>
      <?php else: ?>
         <p class="no_comment">まだ投稿がありません</p>
      <?php endif; ?>

      <!-- 今日だったら投稿可 -->
      <?php if(!$day || $day == date('j')): ?>
      <div class="content">
         <form method="post">
            <div class="cp_iptxt">
               <input type="text" name="content">
               <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
            </div>
            <button name="content_submit">投稿</button>
         </form>
      </div>
      <?php endif; ?>
   </div>
   <!-- /parent -->
</body>
<script src="common/js/jquery.js"></script>
<script src="common/js/common.js"></script>
</html>

