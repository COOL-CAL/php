<?php
    namespace application\controllers;
    use application\models\BoardModel;

    class BoardController extends Controller {
        public function list() {
            $model = new BoardModel();
            // $this->list = $model->selBoardList();
            $this->addAttribute("title", "List");
            $this->addAttribute("list", $model->selBoardList());
            $this->addAttribute("js", ["board/list"]);
            return 'board/list.php'; //view 파일명
        }

        public function detail() {
            $i_board = $_GET["i_board"];

            $model = new BoardModel();
            // print "i_board : {$i_board} <br>";
            $param = ["i_board" => $i_board];
            $this->addAttribute("data", $model->selBoard($param));
            $this->addAttribute("js", ["board/detail"]); //스크립트 파일 import
            return "board/detail.php";
        }

        public function del() {
            $i_board = $_GET["i_board"];
            $param = ["i_board" => $i_board];
            $model = new BoardModel();
            $model->delBoard($param);
            return "redirect:/board/list";
        }

        public function mod() {
            $i_board = $_GET["i_board"];
            $model = new BoardModel();
            $param = ["i_board" => $i_board];
            $this->addAttribute("data", $model->selBoard($param));
            $this->addAttribute(_TITLE, "Edit");
            $this->addAttribute(_HEADER, $this->getView("template/header.php"));
            $this->addAttribute(_MAIN, $this->getView("board/mod.php"));
            $this->addAttribute(_FOOTER, $this->getView("template/footer.php"));
            return "template/t1.php";
        }

        public function modProc() {
            $i_board = $_POST["i_board"];
            $title = $_POST["title"];
            $ctnt = $_POST["ctnt"];
            $param = [
                "i_board" => $i_board,
                "title" => $title,
                "ctnt" => $ctnt
            ];
            $model = new BoardModel;
            $model->updBoard($param);
            return "redirect:/board/detail?i_board={$i_board}";
        }
    }