<!DOCTYPE>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>
        mission5-1
    </title>
</head>
<body>
    <form action="" method=post>
        <?php
        error_reporting(E_ALL & ~E_NOTICE);
        $name=$_POST["name"];
        $str=$_POST["str"];
        $st=$_POST["st"];
        $st=(int)$st;
        $pass1=$_POST["pass1"];
        $submit=$_POST["submit"];
        $date= date("Y年m月d日 H時i分s秒");
        
        $delete=$_POST["delete"];
        $delete=(int)$delete;
        $pass2=$_POST["pass2"];
        $dele=$_POST["dele"];
        
        $edit=$_POST["edit"];
        $edit=(int)$edit;
        $pass3=$_POST["pass3"];
        $edi=$_POST["edi"];
        
        /*データベース*/
        $dsn = 'mysql:dbname=tb******db;host=localhost';
        $user = 'tb-******';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        $sql = "CREATE TABLE IF NOT EXISTS mission5" /*mission5というテーブル名*/
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY," /*自動で生成されるナンバリング*/
        ."namae char(32)," /*名前、半角で32文字*/
        ."comment TEXT," /*コメント、長めの文章も入る*/
        ."time TEXT," /*入力された日時*/
        ."passwo TEXT" /*パスワード*/
        .");";
        $stmt = $pdo -> query($sql);
        
        if(!empty($name) && !empty($str) && empty($st) && !empty($submit)){
            if(empty($pass1)){
                echo "パスワードを入力してください！<br>";
            }
            else{
                $sql = $pdo -> prepare("INSERT INTO mission5(namae,comment,time,passwo) VALUE(:namae,:comment,:time,:passwo)");
                $sql -> bindParam(":namae",$namae,PDO::PARAM_STR);
                $sql -> bindParam(":comment",$comment,PDO::PARAM_STR);
                $sql -> bindParam(":passwo",$passwo,PDO::PARAM_STR);
                $sql -> bindParam(":time",$time,PDO::PARAM_STR);
                $namae = $name;
                $comment = $str;
                $passwo = $pass1;
                $time = $date;
                $sql -> execute(); /*データの入力*/
            }
        }
        
        if(!empty($delete) && !empty($dele)){ 
            if(empty($pass2)){
                echo "パスワードを入力してください！<br>";
            }
            else{
                $id = $delete;
                $passwo = $pass2;
                $sql = "DELETE FROM mission5 WHERE id=:id AND passwo=:passwo";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(":id",$id,PDO::PARAM_INT);
                $stmt -> bindParam(":passwo",$passwo,PDO::PARAM_STR);
                $stmt -> execute();
            }
        }
        
        if(!empty($edit) && !empty($edi)){ 
            if(empty($pass3)){
                echo "パスワードを入力してください！<br>";
            }
            else{
                $id = $edit;
                $passwo = $pass3;
                $sql = "SELECT * FROM mission5 WHERE id=:id AND passwo=:passwo";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(":id",$id,PDO::PARAM_INT);
                $stmt -> bindParam(":passwo",$passwo,PDO::PARAM_STR);
                $stmt -> execute();
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    $rowname = $row["namae"];
                    $rowcom = $row["comment"];
                    $rowid = $row["id"];
                }
            }
        }
        
        ?>
        <input type="text" name="name" placeholder="名前" value="<?php echo $rowname?>"><br>
        <input type="text" name="str"placeholder="コメント" value="<?php echo $rowcom?>"><br>
        <input type="hidden" name="st"value="<?php echo $rowid?>">
        <input type="password" name="pass1"placeholder="パスワード">
        <input type="submit" name="submit"><br>
        <br>
        <input type="text" name="delete"placeholder="削除番号"><br>
        <input type="password" name="pass2" placeholder="パスワード">
        <input type="submit" name="dele"value="削除"><br>
        <br>
        <input type="text" name="edit"placeholder="編集番号"><br>
        <input type="password"name="pass3"placeholder="パスワード">
        <input type="submit" name="edi"value="編集"><br>
    </form>
<?php
/*編集*/
if(!empty($name) && !empty($str) && !empty($st) && !empty($submit)){
    $id = $st;
    $namae = $name;
    $comment = $str;
    $time = $date;
    $sql = "UPDATE mission5 SET namae=:namae,comment=:comment,time=:time WHERE id=:id";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":id",$id,PDO::PARAM_INT);
    $stmt -> bindParam(":namae",$namae,PDO::PARAM_STR);
    $stmt -> bindPARAM(":comment",$comment,PDO::PARAM_STR);
    $stmt -> bindPARAM(":time",$time,PDO::PARAM_STR);
    $stmt -> execute();
}

$sql = "SELECT * FROM mission5";
$stmt = $pdo -> query($sql);
$result = $stmt -> fetchAll();
foreach($result as $row){
    echo $row["id"]."<>".$row["namae"]."<>".$row["comment"]."<>".$row["time"]."<br>";
    echo "<hr>";
}/*データの抽出*/

?>
</body>
</html>

