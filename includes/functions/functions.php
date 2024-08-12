<?php 

    function GetLinkCss () {
        global $linkCss;
        if (isset($linkCss)) {
            echo $linkCss;
        }
    }

    function GetLinkjs () {
        global $linkjs;
        if (isset($linkjs)) {
            echo $linkjs;
        }
    }

    function GetTitle () {
        global $pageTitle;
        if (isset($pageTitle)) {
            echo $pageTitle;
        }else {
            echo 'مشروع';
        }
    }

    function Getsrc1 () {
        global $src1;
        if (isset($src1)) {
            echo $src1;
        }else {
            echo 'index.php';
        }
    }

    function Getsrc2 () {
        global $src2;
        if (isset($src2)) {
            echo $src2;
        }else {
            echo 'index.php';
        }
    }

    function Getnamesrc1 () {
        global $namesrc1;
        if (isset($namesrc1)) {
            echo $namesrc1;
        }
    }

    function Getnamesrc2 () {
        global $namesrc2;
        if (isset($namesrc2)) {
            echo $namesrc2;
        }
    }


    function redirectHome ($therMsg, $url = null, $seconds = 3) {
        if ($url == null) {
            $url = 'index.php';
            $link = 'HomePage';
        }else {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'BackPage';
            }else {
                $url = 'index.php';
                $link = 'HomePage';
            }
            
        }
        echo $therMsg;
        echo 'wil be redirect to ' . $link . 'after '. $seconds . 's';
        header('refresh:'.$seconds.';url='.$url);
        exit();
    }


    function checkItem ($select, $from, $value) {
        global $con;
        $statement =  $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $statement->execute(array($value));
        $count = $statement->rowCount();

        return $count;
    }



    function countItems ($Item, $Table) {
        global $con;
        $stmt2 = $con->prepare("SELECT COUNT($Item) FROM $Table");
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }

    function getDates ($select, $from, $where = '', $value = '') {
        global $con;
        $stmt =  $con->prepare("SELECT $select FROM $from $where");
        if (empty($where)) {
            $stmt->execute();
        }else {
            $stmt->execute(array($value));
        }
        $selector = $stmt->fetch();

        return $selector[0];
    }

    function passCount ($Pass1) {
        global $con;
        $passcount = 0;
        $stmt = $con->prepare("SELECT
                                password
                            FROM
                                userss");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $arraypass = array();
        foreach ($rows as $row) {
            $arraypass[] = $row['password'];
        }
        foreach ($arraypass as $pass) {
            $stmt1 = $con->prepare("SELECT
                                        *
                                    FROM
                                        userss
                                    WHERE
                                        password = ?
                                    LIMIT 1");
            $stmt1->execute(array($pass));
            $count1 = $stmt1->rowCount();
            if (password_verify($Pass1, $pass)) {
            $passcount = 1;
            }
        }
        return $passcount;
    }

    function findpass ($Pass1) {
        global $con;
        $thePass = '';
        $stmt = $con->prepare("SELECT
                                password
                            FROM
                                userss");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $arraypass = array();
        foreach ($rows as $row) {
            $arraypass[] = $row['password'];
        }
        foreach ($arraypass as $pass) {
            $stmt1 = $con->prepare("SELECT
                                        *
                                    FROM
                                        userss
                                    WHERE
                                        password = ?
                                    LIMIT 1");
            $stmt1->execute(array($pass));
            if (password_verify($Pass1, $pass)) {
            $thePass = $pass;
            }
        }
        return $thePass;
    }