<! ※GitHubアップロード用>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>mission_5-1</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="name" placeholder="名前"><br>
    <input type="text" name="comment" placeholder="コメント"><br>
    <input type="password" name="pass"><br>
    <input type="submit" name="submit" value="送信"><br><br>
    </form>

<form action="" method="post">
      <input type="number" name="delete" placeholder="削除番号指定用"><br>
      <input type="password" name="pass"><br>
      <input type="submit" name="submit" value="削除"><br><br>
    </form>

<form action="" method="post">
      <input type="number" name="edit" placeholder="編集番号指定用"><br>
      <input type="password" name="pass"><br>
      <input type="submit" name="submit" value="編集">
    </form>
    
    <!--作成の流れ
    1.データベース接続
    2.投稿機能：フォーム作成、空じゃない時、DBのテーブル作成機能とDBの表示機能
    3.削除機能：フォーム作成、空じゃない時、DBのテーブル削除機能とDBの表示機能
    4.編集機能：フォーム作成、空じゃない時、DBのテーブル編集機能とDBの表示機能
    5.パスワード：DBのパスワードとPOSTで受け取った値が一致したら各々機能させる
    -->
    
<?php

    $dsn = "データベース名";
    $user = "ユーザー名";
    $password = "パスワード";
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//投稿機能
if (!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["pass"])) {
    $name = $_POST["name"];//m3-1,3-2
    $comment = $_POST["comment"];
    $pass = $_POST["pass"];
    
    //テーブル作成
    if($pass==$password){//m3-5
    $sql = "CREATE TABLE IF NOT EXISTS tb1"//m4-2
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = $pdo -> prepare("INSERT INTO tb1 (name, comment) VALUES (:name, :comment)");
    $sql -> bindParam(":name", $name, PDO::PARAM_STR);//m4-5
    $sql -> bindParam(":comment", $comment, PDO::PARAM_STR);
    $sql -> execute();
   
$sql = "SELECT * FROM tb1";//m4-6
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row["id"].",";
        echo $row["name"].",";
        echo $row["comment"]."<br>";
    echo "<hr>";
    }
}
}

//削除機能
if(!empty($_POST["delete"])&&!empty($_POST["pass"])){
$delete = $_POST["delete"];
$pass = $_POST["pass"];

    if($pass==$password){
    $id = 21;
    $sql = "delete from tb1 where id=:id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    
     $sql = "SELECT * FROM tb1";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row["id"].",";
        echo $row["name"].",";
        echo $row["comment"]."<br>";
    echo "<hr>";
    }
}
}

//編集機能
 if (!empty($_POST["edit"])&&!empty($_POST["pass"])) {
     $edit = $_POST["edit"];
     $pass = $_POST["pass"];
    
    if($pass==$password){
    $id = 1; //変更する投稿番号
    $name = "yuina";
    $comment = "yeah!!"; //変更したい名前、変更したいコメントは自分で決める
    $sql = "UPDATE tb1 SET name=:name,comment=:comment WHERE id=:id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $sql = "SELECT * FROM tb1";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row["id"].",";
        echo $row["name"].",";
        echo $row["comment"]."<br>";
    echo "<hr>";
    }
}
}

?>

</body>
</html>