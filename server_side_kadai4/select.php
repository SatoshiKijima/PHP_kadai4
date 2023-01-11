<?php

session_start();
require_once('funcs.php');
loginCheck();

//クロスサイトスクリプティングを防ぐ 
//hが下が効いた状態で動く
//select.php 描写するときにhtmlspecialcharsで<script>タグで悪さされたものが文字列として入力される

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table2;"); //あるデータベースから抜き出すからそのままでOK
$status = $stmt->execute(); //実行するPHPのClassを理解しないと-＞は理解できない

//３．データ表示
//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
         $view .= '<a href="detail.php?id=' . $result['id'] . '">';
        $view .= h($result['id']). '：' . h($result['time']) . '：' . h($result['bookname']). '：' . h($result['type']). '：';
        $view .= '</a>';

        $view .= '<a href="delete.php?id=' . $result['id'] . '">';
        $view .= '[削除]';
        $view .= '</a>';
        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>書籍ログ表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->
<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div> 
   
</div>
<!-- Main[End] -->

</body>
</html>
