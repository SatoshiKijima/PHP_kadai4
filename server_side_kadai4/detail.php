<?php
/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */
session_start();
require_once('funcs.php');
loginCheck();

 $id = $_GET['id'];


//select.php 描写するときにhtmlspecialcharsで<script>タグで悪さされたものが文字列として入力される

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_bm_table2 WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //INT = 数字
$status = $stmt->execute();


if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    $result = $stmt->fetch();
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
<form method="POST" action="update.php">
<div>
    <div class="container jumbotron"></div> 
    <fieldset>
                <legend>書籍記録</legend>
                <label>書籍名：<input type="text" name="bookname" value="<?= $result['bookname']?>"></label><br>
                <label>書籍URL:<input type="text" name="url" value="<?= $result['url']?>"></label><br>
                <label>書籍コメント:<textarea name="bookcomment" rows="4" cols="40"><?= $result['bookcomment']?></textarea></label><br>
                <input type="hidden" name="id" value="<?= $result['id']?>">
                <select name="type" class="type" value="<?= $result['type']?>">
                  <option>--種類選択--</option>
                  <option>マンガ</option>
                  <option>ビジネス書</option>
                  <option>趣味・文芸書</option>
                  <option>雑誌</option>
                  <option>小説</option>
                  <option>その他</option>
                </slect>
                <input type="submit" value="修正">
            </fieldset>
</div>
<!-- Main[End] -->
</body>
</html>
