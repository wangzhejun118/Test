<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = "パスワード";
$pdo = new PDO($dsn,$user,$password);

      $sql = "CREATE TABLE IF NOT EXISTS tbtest"
      ." ("
      . "id INT AUTO_INCREMENT PRIMARY KEY,"
      . "name char(32),"
      . "pw char(32),"
      . "date TEXT,"
      . "comment TEXT"
      .");";
      $stmt = $pdo->query($sql);
    ?>
    
    
        【　投稿フォーム　】<br>
    <form action="" method="post">
         名前：　　　　<input type="text" name="name" placeholder="名前" value="<?php 
         
            if(!empty($_POST["edit"])){
            $edit=$_POST["edit"];
            $password3 = $_POST["password3"];
            $sql = 'SELECT * FROM tbtest WHERE id=:id AND pw=:pw';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $edit, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->bindParam(":pw", $password3, PDO::PARAM_STR);
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
    foreach ($results as $row){
        echo $row['name'];
    }}
          ?>">
         <br>
        コメント：　　<input type="text" name="comment" placeholder="コメント" value="<?php 
           if(!empty($_POST["edit"])){
            $edit=$_POST["edit"];
            $password3 = $_POST["password3"];
            $sql = 'SELECT * FROM tbtest WHERE id=:id AND pw=:pw';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $edit, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->bindParam(":pw", $password3, PDO::PARAM_STR);
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
    foreach ($results as $row){
        echo $row['comment'];
    }}
        ?>">  
        <br>
        パスワード：　<input type="password" name="password1" placeholder="パスワード">
        <br>
        <input type="submit" value="送信">
        <br>
        <br>
        【　削除フォーム　】<br>
        投稿番号：　　<input type="number" name="delete" placeholder="削除対象番号">
        <br>
        パスワード：　<input type="password" name="password2" placeholder="パスワード">
        <br>
        <input type="submit" value="削除">
        <br>
        <br>
        【　編集フォーム　】<br>
        投稿番号：　　<input type="number" name="edit" placeholder="編集対象番号">
        <br>
        パスワード：　<input type="password" name="password3" placeholder="パスワード">
        <br>
        <input type="submit" value="編集">
        <input type="hidden" name="editNO" value="<?php 

     if(!empty($_POST["edit"])){
            $edit=$_POST["edit"];
            $password3 = $_POST["password3"];
            $sql = 'SELECT * FROM tbtest WHERE id=:id AND pw=:pw';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $edit, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->bindParam(":pw", $password3, PDO::PARAM_STR);
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
    foreach ($results as $row){
        echo $row['id'];
    }}

        ?>">
    　　<br>
    　　<hr>
    【　投稿一覧　】<br><br>
    </form>
        
 <?php
        
 //　削除
   if(!empty($_POST["delete"])){
       $delete=$_POST["delete"];
       $password2 = $_POST["password2"];
    $sql = 'delete from tbtest where id=:id AND pw=:pw';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    $stmt->bindParam(':pw', $password2, PDO::PARAM_STR);
    $stmt->execute();
        }

           
 
 //新規登録・投稿
        if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password1"])) {
             if (empty($_POST['editNO'])) {
   $sql = $pdo -> prepare("INSERT INTO tbtest (name, pw, date, comment) VALUES (:name, :pw, :date, :comment)");
    $sql -> bindParam(':name', $name1, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment1, PDO::PARAM_STR);
    $sql -> bindParam(':pw', $password1, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date1, PDO::PARAM_STR);
        $name1 = $_POST['name'];
        $comment1 = $_POST['comment'];
        $date1 = date("Y/m/d H:i:s");     
        $password1 = $_POST["password1"];
        $sql -> execute();
        }else{
             $editNO=$_POST["editNO"];
            $name2 =$_POST["name"];
            $comment2 =$_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
            $password4 = $_POST["password1"];
            $date2 = date("Y/m/d H:i:s");
            $sql = 'UPDATE tbtest SET name=:name,comment=:comment,date=:date WHERE id=:id AND pw=:pw';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name2, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment2, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date2, PDO::PARAM_STR);
            $stmt->bindParam(':id', $editNO, PDO::PARAM_INT);
            $stmt->bindParam(":pw", $password4, PDO::PARAM_STR);
            $stmt->execute();
            
  
    
        }}
          

          
  
   //表示
    
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment']." ";
        echo $row["date"]."<br>";
    echo "<hr>";
    }
       
    ?>
</body>
</html>