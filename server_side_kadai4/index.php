<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
    
     <link rel="stylesheet" href="css/style.css">
     <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/phi-jp/meltline@v0.1.13/meltline.css"> -->
    <script src='https://cdn.jsdelivr.net/gh/phi-jp/firerest@v0.1.4/firerest.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">登録書籍データ一覧</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
  
    <!-- Main[Start] -->
    <form method="post" action="insert.php">
        <div class="inputform">
            <fieldset class='field'>
                <legend>書籍記録</legend>
                <label>書籍名：<input type="text" name="bookname" class="title"></label><br>
                <label>書籍URL:<input type="text" name="url" class="url"></label><br>
                <label>書籍コメント:<br><textArea name="bookcomment" class="comment" rows="4" cols="40"></textArea></label><br>
                <select name="type" class="type" value="書籍種類">
                  <option>--種類選択--</option>
                  <option>マンガ</option>
                  <option>ビジネス書</option>
                  <option>趣味・文芸書</option>
                  <option>雑誌</option>
                  <option>小説</option>
                  <option>その他</option>
                </slect>
        </div>
            </fieldset>
              <p><input type="submit" class="submit" value="送信"></p>
            
        
    </form>  
    <body class='p16'>
    <h1 class='mb16'>Google Book API</h1>

    <input class='input bg-white mb16' type='search' id='$q' />
    
    <div>
      <h2 class='mb8'>検索結果</h2>
      <p id="push"><input type=button value="表示" >:</p>
      <div id='$results'></div>
    </div>
    <!-- Main[End] -->
<script>
    window.onload = async function() {
  // 検索する
  var search = async () => {
    // 入力された値でを本を検索
    var items = await searchBooks($q.value);
    
    // html に変換して表示用 DOM に代入
    var texts = items.map(item => {
      return `
      <a class='f border bg-white mb8' href='${item.link}', target='_blank'>
        <img class='w100 object-fit-contain bg-gray' src='${item.image}' />
        <div class='p16'>
          <h3 class='mb8'><input type=checkbox name="checktitle" class="checktitle" value=${item.title}>${item.title}</h3>
          <p class='line-clamp-3'><input type=checkbox name="checkurl" class="checkurl" value=${item.link}>${item.link}'</p>
          <p class='line-clamp-2'><input type=checkbox name="checkdis" class="checkdis" value=${item.description}>${item.description}</p>
        </div>
      </div>`;
    });
    $results.innerHTML = texts.join('');
  };

  
  // 入力するたびに検索( debounce で API 連打対策 )
  $q.oninput = _.debounce(search, 256);
  
  // フォーカスしたら全文字選択
  $q.onfocus = () => { $q.select(); };
  
  // 初期値設定
  $q.value = '鬼滅';
  search();
};

// 本を検索して結果を返す
var searchBooks = async (query) => {
  // Google Books APIs のエンドポイント
  var endpoint = 'https://www.googleapis.com/books/v1';
  
  // 検索 API を叩く
  var res = await fetch(`${endpoint}/volumes?q=${$q.value}`);
  // JSON に変換
  var data = await res.json();
  
  // 必要なものだけ抜き出してわかりやすいフォーマットに変更する
  var items = data.items.map(item => {
    var vi = item.volumeInfo;
    return {
      title: vi.title,
      description: vi.description,
      link: vi.infoLink,
      image: vi.imageLinks ? vi.imageLinks.smallThumbnail : '',
    }; 
  });
  
  return items;
};

$("#push").on("click",(event) => {
            let checkboxesT = document.querySelectorAll('input[name="checktitle"]:checked');
            let outputT = [];
            checkboxesT.forEach((checkbox) => {
                outputT.push(checkbox.value);
            });
            console.log(outputT)
            $(".title").val(outputT);
    });
$("#push").on("click",(event) => {
            let checkboxesU = document.querySelectorAll('input[name="checkurl"]:checked');
            let outputU = [];
            checkboxesU.forEach((checkbox) => {
                outputU.push(checkbox.value);
            });
            console.log(outputU)
            $(".url").val(outputU);
    });
$("#push").on("click",(event) => {
            let checkboxesD = document.querySelectorAll('input[name="checkdis"]:checked');
            let outputD = [];
            checkboxesD.forEach((checkbox) => {
                outputD.push(checkbox.value);
            });
            console.log(outputD)
            $(".comment").val(outputD);
    });

  
</script>

</body>

</html>
