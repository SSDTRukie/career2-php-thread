<html>
<head><title>掲示板</title></head>
<body>

<h1>掲示板App</h1>

<h2>投稿フォーム</h2>

<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
    <input type="text" name="personal_name" placeholder="名前" required><br><br>
    <textarea name="contents" rows="8" cols="40" placeholder="内容" required>
</textarea><br><br>
    <input type="submit" name="btn" value="投稿する">
</form>

<!--削除できない-->
<form method="POST" action="delete.php">
    <button type="submit">投稿を全削除する</button>
</form>

<!--
<from method="POST" action="index.php">
    <input type="hidden" name="method" value="DELETE">
    <buttom type="submit">投稿を削除する</buttom>
</from>
-->

<h2>スレッド</h2>

<?php


const THREAD_FILE = 'thread.txt';

function readData() 
{
    // ファイルが存在しなければデフォルト空文字のファイルを作成する
    if (! file_exists(THREAD_FILE)) 
    {
        $fp = fopen(THREAD_FILE, 'w');
        fwrite($fp, '');
        fclose($fp);
    }

    $thread_text = file_get_contents(THREAD_FILE);
    echo $thread_text;
}

function writeData() 
{
    $personal_name = $_POST['personal_name'];
    $contents = $_POST['contents'];
    $contents = nl2br($contents);

    //ｔ
    $data = "<hr>\n";
    $data = $data."<p>投稿日時:".date("Y年n月d日 H時i分s秒")."</p>\n";
    $data = $data."<p>投稿者:".$personal_name."</p>\n";
    $data = $data."<p>内容:</p>\n";
    $data = $data."<p>".$contents."</p>\n";

    $fp = fopen(THREAD_FILE, 'a');

    if ($fp)
    {
        if (flock($fp, LOCK_EX))
        {
            if (fwrite($fp,  $data) === FALSE)
            {
                print('ファイル書き込みに失敗しました');
            }

            flock($fp, LOCK_UN);
        }else
        {
            print('ファイルロックに失敗しました');
        }
    }

    fclose($fp);

    // ブラウザのリロード対策
    $redirect_url = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect_url");
    exit;
    //it'smemario
}

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    writeData();
}

readData();

?>

</body>
</html>