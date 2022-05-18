<?php
class main_model{
    
    //到達時のログインチェック
    public static function loginCheck($pdo,$mail){
        $sql = "SELECT * FROM user WHERE mail = :mail";
        $statement = $pdo->prepare($sql);
        $statement->bindvalue(":mail",$mail);
        $statement->execute();
        $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $statement;
    }

    //ログアウト処理(フラグを０に)
    public static function logout($pdo,$mail){
        $sql = "UPDATE user SET login_check = 0 WHERE mail = :mail";
        $statement = $pdo->prepare($sql);
        $statement->bindvalue(":mail",$mail);
        $statement->execute();
    }

    //スレッドの情報を登録
    public static function threadRegister($pdo,$title,$desc,$cat,$img,$classname){
        $date = date('Y-m-d');
        $sql = "INSERT INTO bord_info(title,gaiyo,category,img,classname,created_at) VALUES(:title,:gaiyo,:category,:img,:classname,:date)";
        $statement = $pdo->prepare($sql);
        $statement->bindvalue(":title",$title);
        $statement->bindvalue(":gaiyo",$desc);
        $statement->bindvalue(":category",$cat);
        $statement->bindvalue(":img",$img);
        $statement->bindvalue(":classname",$classname);
        $statement->bindvalue(":date",$date);
        $statement->execute();
    }

    //スレッド呼び出し
    public static function callColumn($pdo){
        $sql ="SELECT * FROM bord_info";
        $post = $pdo->query($sql);
        $statement = $post->fetchAll(PDO::FETCH_ASSOC);
        return $statement;
    }

    //絞り込みスレッド呼び出し
    public static function callCatColumn($pdo,$sort){
        $sql ="SELECT * FROM bord_info WHERE category = :category";
        $statement = $pdo->prepare($sql);
        $statement->bindvalue(":category",$sort);
        $statement->execute();
        $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $statement;
    }

    //スレッド検索
    public static function searchThread($pdo,$search_text){
        $sql ="SELECT * FROM bord_info WHERE title like :title";
        $statement = $pdo->prepare($sql);
		$title = '%'.$search_text.'%';
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
		$statement->execute();
        $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $statement;
    }

    //スレ情報取得
    public static function thread_info($pdo,$threadId){
        $sql = "SELECT * FROM bord_info WHERE id = " . $threadId;
        $post = $pdo->query($sql);
        $statement = $post->fetchAll(PDO::FETCH_ASSOC);
        return $statement;
    }

    //スレテキスト登録
    public static function threadTextRegister($pdo,$text,$threadId,$user_name){
        $date = date("Y-m-d H:i:s");
        $threadId = (int)$threadId;
        $sql = "INSERT INTO thread_text(naiyou,thread_id,user_name,created_at) VALUES(:naiyou,:thread_id,:user_name,:created_at)";
        $statement = $pdo->prepare($sql);
        $statement->bindvalue(":naiyou",$text);
        $statement->bindvalue(":thread_id",$threadId);
        $statement->bindvalue(":user_name",$user_name);
        $statement->bindvalue(":created_at",$date);
        $statement->execute();
        $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
        header("Refresh:0");
        return $statement;
    }

    //スレテキスト情報取得
    public static function getThreadText($pdo,$threadId){
        $sql = "SELECT * FROM thread_text WHERE thread_id = " . $threadId;
        $post = $pdo->query($sql);
        $statement = $post->fetchAll(PDO::FETCH_ASSOC);
        return $statement;
    }



}

?>