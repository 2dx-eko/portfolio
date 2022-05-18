<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>TouchNumbers</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Teko" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="player">
        <div class="position">
            <span class="error"></span>
            <form method="post">
                <p><i class="fas fa-address-card">&nbsp;</i>Plaer Name</p>
                <input class="name" type="text" name="name">
                <button class="namebutton" type="button">OK</button>  
            </form>
        </div>
    </div>
    <div class="mode_window">
        <div class="maintitle">TouchNumbers</div>
        <div class="geme_mode">
            <ul>
                <li class="dif"><a class="easy" href="#">EASY</a></li>
                <li class="dif"><a class="normal" href="#">NORMAL</a></li>
                <li class="dif"><a class="hard" href="#">HARD</a></li>
            </ul>
        </div>
    </div>
    <div class="count"></div>
</body>
<script src="js/game.js"></script>
<script src="js/main.js"></script>

<script>
$(function() {
	$('body').fadeIn(3000);
});
</script>
</html>