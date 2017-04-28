<?php
/**
 * Created by PhpStorm.
 * User: Ernie Simuro
 * Date: 5/9/16
 * Time: 7:52 AM
 */

require_once 'baseDataMethods.php';

class newsItem implements baseDataMethods {
    private $conn;

    public function __construct()
    {
        include "./config.php";
        $this->conn = new mysqli($dbHost, $dbUser, $dbPass, $dbData);
    }

    public function getSpecificItem($key)
    {
        $mQuery = 'select * from NewsItem where id = ' . $key;

        $result = $this->conn->query($mQuery);
        $outp = array();
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $out  = array();
            $out["id"] =  $rs["id"];
            $out["title"] =  $rs["title"];
            $out["subTitle"] =  $rs["subTitle"];
            $out["author"] = $rs["author"] ;
            $out["publishDate"] = $rs["publishDate"] ;
            $out["article"] = $rs["article"] ;
        }
        return $out;
    }

    public function getListofItems($from=0)
    {
        $cnt = $this->getRecordCount();                 // get count of db records
        if ($from <= $cnt)
        {
            $mQuery = 'select * from newsitem order by publishDate DESC limit ' . $from . ',3';
            $result = $this->conn->query($mQuery);
            $num = $result->num_rows;
            $res = array();
            while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
                $out  = array();
                $out["id"] =  $rs["id"];
                $out["title"] =  $rs["title"];
                $out["subTitle"] =  $rs["subTitle"];
                $out["author"] = $rs["author"] ;
                $out["publishDate"] = $rs["publishDate"] ;
                $out["article"] = $rs["article"] ;
                $res[] = $out;
            }
            if ( ($from + $num) < $cnt ) {
                $outp['next'] = $num;
            } else {
                $outp['next'] = -1;
            }
            $outp["records"] = $res;
            return $outp;
        }

    }

    public function addNewItem($request) {
        $date = new DateTime($request['publishDate']);
        $mQuery = 'insert into newsitem (`title`, `subTitle`, `author`, `publishDate`, `article`) values (  '
            . '"' . $request['title'] . '", '
            . '"' . $request['subTitle'] . '", '
            . '"' . $request['author'] . '", '
            . '"' . $date->format('Y-m-d') . '", '
            . '"' . $request['article'] . '")';
        echo 'the insert query is ' . $mQuery . "\n";
        $result = $this->conn->query($mQuery);
        return $result;
    }

    public function updateAnItem($request) {
        $date = new DateTime($request['publishDate']);
        $mQuery = 'update newsitem  set `title` = "' . $request['title'] . '"'
            . ', `subTitle` = "' . $request['subTitle'] . '"'
            . ', `author` = "' . $request['author'] . '"'
            . ', `publishDate` = "' . $date->format('Y-m-d') . '"'
            . ', `article` = "' . $request['article'] . '"   where id = ' . $request['id'];
        echo 'this is the update query '  . $mQuery . "\n";
        $result = $this->conn->query($mQuery);
        return $result;
    }

    public function removeAnItem($id) {
        $mQuery = 'delete from newsitem where id = ' . $id;
        $result = $this->conn->query($mQuery);
        return $result;
    }

    private function getRecordCount()
    {
        $mQuery = 'select count(id) as cnt from newsitem';
        $result = $this->conn->query($mQuery);
        $outp = array();
        $rs = $result->fetch_array(MYSQLI_ASSOC);
        return $rs['cnt'];
    }
} 