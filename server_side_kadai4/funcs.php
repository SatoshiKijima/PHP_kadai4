<?php
//XSS対応（ echoする場所で使用！）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。

function db_conn() //関数
{
  try {
      $db_name = 'kadai_php3'; //データベース名
      $db_id   = 'root'; //アカウント名
      $db_pw   = ''; //パスワード：MAMPは'root'
      $db_host = 'localhost'; //DBホスト
      $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
      return $pdo; 
  } catch (PDOException $e) {
       exit('DB Connection Error:' . $e->getMessage());
   }
  }
//SQLエラー関数：sql_error($stmt)
//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}


//リダイレクト関数: redirect($file_name)
function redirect($file_name)
{
    header('Location: ' . $file_name);
    exit();
}

// ログインチェク処理 loginCheck()
function loginCheck()
{
    if( !isset($_SESSION['chk_ssid'])|| $_SESSION['chk_ssid'] != session_id()){
        // 'chk_ssid'があるか、chk_ssidがserver側と同じidかを照合する。異なる場合はログインがおかしい
    exit('LOGIN ERROR');
    } else {
    session_regenerate_id(true);  //OKなら$_SESSIN['chk_ssid']に入れなおす
    //ログインOK
    $_SESSION['chk_ssid'] = session_id();
    }
}