<?php
//キャッシュを読まないおまじない
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$param = $_POST['param'];

$host = 'mysql2.star.ne.jp';
$dbname = 'xxxxxxxxxxxxxxx';
$dbuser = 'xxxxxxxxxxxxxxx';
$dbpass = 'xxxxxxxxxxxxxxx';

try {
$dbh = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $dbuser,$dbpass, array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 var_dump($e->getMessage());
 exit;
}
// データ取得
$sql = "SELECT * FROM suikei WHERE longcode = ? ORDER BY year ASC";
$stmt = ($dbh->prepare($sql));
$stmt->execute(array($param));

//あらかじめ配列を生成しておき、while文で回します。
$memberList = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 $memberList[]=array(
  'longcode' =>$row['longcode'],
  'prefname' =>$row['prefname'],
  'cityname' =>$row['cityname'],
  'year'=>$row['year'],
  'total'=>$row['total'],
  'child'=>$row['child'],
  'middle'=>$row['middle'],
  'senior'=>$row['senior'],
 );
}

//jsonとして出力
header('Content-type: application/json');
echo json_encode($memberList,JSON_UNESCAPED_UNICODE);
