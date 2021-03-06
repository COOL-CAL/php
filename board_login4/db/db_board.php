<?php
    include_once 'db.php';

    function ins_board($param) {
        $i_user = $param["i_user"];
        $title = $param["title"];
        $ctnt = $param["ctnt"];

        $sql = "INSERT INTO t_board (title, ctnt, i_user)
                VALUES ('$title', '$ctnt', '$i_user')";
        
        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    function sel_paging_count(&$param) {
        $row_count = $param["row_count"];
        $sql = "SELECT CEIL(COUNT(i_board) / $row_count) as cnt
                FROM t_board";

        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        $row = mysqli_fetch_assoc($result);
        return $row["cnt"];
    }

    function sel_board_list($param) {
        $start_idx = $param["start_idx"];
        $row_count = $param["row_count"];

        $sql = "SELECT A.i_board, A.title, A.created_at
                     , B.nm, B.i_user, B.profile_img
                  FROM t_board A
                 INNER JOIN t_user B
                    ON A.i_user = B.i_user
                 ORDER BY A.i_board DESC
                 LIMIT $start_idx, $row_count";
        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    function sel_board(&$param) {
        $i_board = $param["i_board"];
        $sql = "SELECT A.title, A.ctnt, A.created_at
                     , B.i_user, B.nm
                  FROM t_board A
                 INNER JOIN t_user B
                    ON A.i_user = B.i_user
                 WHERE A.i_board = $i_board";
        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return mysqli_fetch_assoc($result);
    }

    function sel_next_board(&$param) {
        $i_board = $param["i_board"];
        $sql = "SELECT i_board
                  FROM t_board
                 WHERE i_board > $i_board
                 ORDER BY i_board
                 LIMIT 1";

        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        $row = mysqli_fetch_assoc($result);
        if($row) {
            return $row["i_board"];
        }
        return 0;
    }

    function sel_prev_board(&$param) {
        $i_board = $param["i_board"];
        $sql = "SELECT i_board
                  FROM t_board
                 WHERE i_board < $i_board
                 ORDER BY i_board DESC
                 LIMIT 1";

        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        $row = mysqli_fetch_assoc($result);
        if($row) {
            return $row["i_board"];
        }
        return 0;
    }

    function upd_board(&$param) {
        $i_board = $param["i_board"];
        $title = $param["title"];
        $ctnt = $param["ctnt"];
        $i_user = $param["i_user"];

        $sql = "UPDATE t_board
                   SET title = '$title'
                     , ctnt = '$ctnt'
                     , updated_at = now()
                 WHERE i_board = $i_board
                   AND i_user = $i_user";

        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    function del_board(&$param) {
        $i_board = $param["i_board"];
        $i_user = $param["i_user"];

        $sql = "DELETE FROM t_board
                 WHERE i_board = $i_board
                   AND i_user = $i_user";
        
        $conn = get_conn();
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    function search_board(&$param) {
        $conn = get_conn();
        
        $search_select = $param["search_select"]; //select?????????
        $search_input_txt = $param["search_input_txt"];//?????????
        $textArray = explode(" ", $search_input_txt); //???????????? "??????"?????? ?????????

        $where = []; //sql?????? ??? ???(??????) ??????
        $sql = "SELECT A.i_board, A.title, A.ctnt, A.created_at
                     , B.i_user, B.nm
                  FROM t_board A
                 INNER JOIN t_user B
                    ON A.i_user = B.i_user
                 WHERE ";
                   //???????????? ?????? a,b??? ?????? ?????????

        switch($search_select) {
            case "search_writer":
                $where += ["B.nm"];
                break;
            case "search_title":
                $where += ["A.title"];
                break;
            case "search_ctnt":
                $where += ["A.title", "A.ctnt"];
                break;
            default:
        }

       for($i = 0; $i < count($textArray); $i++) {
           for($j=0; $j < count($where); $j++) {
               $sql = $sql . " $where[$j] LIKE '%$textArray[$i]%' ";
                //????????? ???????????? ?????????

                if(($i !== count($textArray)-1) || ($j !== count($where) -1)) { //????????? ???????????? ?????????
                    $sql = $sql . "OR";
                }
            }
        }

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    // function view_count(&$params) {
    //     $conn = get_conn();

    //     //?????? ?????? ????????????
    //     $YY = date('Y');
    //     $MM = date('m');
    //     $DD = date('d');
    //     $dat = $YY . "-" . $MM . "-" . $DD;

    //     $sql = "SELECT * FROM count_db
    //             WHERE redate = '$dat'";
        
    //     $result = mysqli_query($conn, $sql);
    //     $list = mysqli_num_rows($result);

    //     if(!$list) { //????????? ????????? ?????? ????????? date ????????? ?????? ??????
    //         $count = 0; // count = 0
    //     } else { //???????????? ????????? ?????? ????????? date ????????? ????????? ??????
    //         $row = mysqli_fetch_assoc($result);
    //         $count = $row['count']; // ?????? ????????? count?????? ????????????
    //     }
    
    //     if($count === 0) {
    //         $count++; //?????? ????????? ????????? count?????? ??????
    //         $sql = "INSERT INTO count_db
    //                 VALUES ($count, '$dat')";
    //     } else {
    //         $count++; //?????? ????????? ?????? count?????? ??????
    //         $sql = "UPDATE count_db
    //                    SET count = $count
    //                  WHERE redate = '$dat'";
    //     }
    
    //     mysqli_query($conn, $sql);
    //     //total views - ?????? count?????? sum()??? ??????
    //     $totalQuery = "SELECT SUM(count) as cnt
    //                      FROM count_db";
    //     $totalCount = mysqli_fetch_assoc(mysqli_query($conn, $totalQuery))['cnt'];
    //     mysqli_close($conn);
    // }