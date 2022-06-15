<?php
    include_once 'db/db_board.php';
    session_start();
    $nm = "";

    if(isset($_SESSION["login_user"])) {
        $login_user = $_SESSION["login_user"];
        $nm = $login_user["nm"];
    }

    $page = 1;
    if(isset($_GET["page"])) {       
        $page = intval($_GET["page"]);
    }

    $search_txt = "";
    if(isset($_GET["search_txt"])) {
        $search_txt = $_GET["search_txt"];
    }

    $row_count = 10;
    $param = [
        "row_count" => $row_count,
        "start_idx" => ($page - 1) * $row_count,
        "search_txt" => $search_txt
    ];
    $paging_count = sel_paging_count($param);
    $list = sel_board_list($param);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <title>LIST</title>
</head>
<body>
    <div id="container">
        <header>
            <?=isset($_SESSION["login_user"]) ? "<div>" . "Welcome,". $nm . "</div>" : ""?>
            <div>
                <a href="list.php">LIST</a>
                <?php if(isset($_SESSION["login_user"])) { ?>
                    <a href="write.php">WRITE</a>
                    <a href="logout.php">LOGOUT</a>
                <?php } else { ?>
                    <a href='login.php'>LOGIN</a>
                <?php } ?>
            </div>
        </header>
        <main>
            <h1>LIST</h1>
            <div>
                <form action="list.php" method="get">
                    <div>
                        <input type="search" name="search_txt" value="<?=$search_txt?>">
                        <input type="submit" value="SEARCH">
                    </div>
                </form>
            </div>
            <table>
                <tbody>
                    <thead>
                        <tr>
                            <th width=100>Nr.</th>
                            <th width=300>Title</th>
                            <th width=120>Name</th>
                            <th width=200>Date</th>
                        </tr>
                    </thead>
                <tbody>                    
                <?php foreach($list as $item) { ?>
                    <tr>
                        <td><?=$item["i_board"]?></td>
                        <td><a href="detail.php?i_board=<?=$item["i_board"]?>&page=<?=$page?>&search_txt=<?=$search_txt?>">
                                <?=str_replace($search_txt, "<mark>{$search_txt}</mark>", $item["title"])?>
                                </a></td>
                        <td><?=$item["nm"]?></td>
                        <td><?=$item["created_at"]?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div>
            <?php for($i=1; $i<=$paging_count; $i++) { ?>
                <span class="<?=$i===$page ? "pageSelected" : ""?>"> 
                <?php if($search_txt !== "") { ?>
                    <a href="list.php?page=<?=$i?>&search_txt=<?=$search_txt?>"><?=$i?></a>
                <?php }else{ ?>
                    <a href="list.php?page=<?=$i?>"><?=$i?></a>
                <?php } ?>
                </span>
            <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>