<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>๋ก๊ทธ์ธ</title>
</head>
<body>
    <div class="container">
        <header>
            <a href="../main/main.php">โ MAIN</a>        
        </header>
        <fieldset>
            <legend><h2>๐ผ ๋ก๊ทธ์ธ ๐ผ</h2></legend>
            <form action="login_proc.php" method="post" autocomplete="off">
                <div><input type="text" name="u_nick" id="u_nick" class="box" placeholder="๋๋ค์" autofocus></div>
                <div><input type="password" name="u_pw" id="u_pw" class="box" placeholder="๋น๋ฐ๋ฒํธ"></div>
                <div><input type="submit" class="button" onclick="pw_check()" value="๋ก๊ทธ์ธ"></div>
            </form>        
        </fieldset>        
    </div>
    <small><a href="join.php">์ฒ์ ์ค์จ๋์?</a></small>
</body>
</html>