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
            echo 'قدرات';
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

    function getCount($from, $where = '') {
        global $con;
        $stmt = $con->prepare("SELECT COUNT(*) FROM $from $where");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function checkItem ($select, $from, $value) {
        global $con;
        $statement =  $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $statement->execute(array($value));
        $count = $statement->rowCount();

        return $count;
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