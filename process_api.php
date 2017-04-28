<?php
/**
 * Created by PhpStorm.
 * User: Ernie Simuro
 * Date: 5/6/16
 * Time: 12:51 PM
 */

    include "./config.php";
    include './newsitem_Class_' . $dataType . '.php';

    $method = $_SERVER['REQUEST_METHOD'];
   // echo 'the method is ' . $method . "\n";
   // echo '<pre>';

    switch ($method) {
        case 'GET':
            // GET - Used for basic read requests to the server

            if (! empty ($_GET['action']) ){
                if ($_GET['action'] == 'getItem') {
                    $results = getUniqueItem($_GET['id']);
                } else if ($_GET['action'] == 'getList') {
                    $results = getListItems($_GET['id']);
                }
            }
            break;
        case 'PUT':
            // PUT- Used to modify an existing object on the server
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $results = updateAnItem($request);
            break;
        case 'POST':
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $results = addNewItem($request);
            break;
        case 'DELETE';
            // DELETE - Used to remove an object on the server
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $results = removeAnItem($request['id']);
            break;
    }

    function getUniqueItem($id) {
        $db = new newsItem();
        $result = $db-> getSpecificItem($id);
        $outp["records"] = $result;
        echo json_encode($outp);
    }

    function getListItems($id) {
        $db = new newsItem();
        $outp = $db->getListofItems($id);
        echo json_encode($outp);
    }

    function addNewItem($request) {
        $db = new newsItem();
        $outp = $db->addNewItem($request);
        echo json_encode($outp);
    }

    function updateAnItem($request) {
        $db = new newsItem();
        $outp = $db->updateAnItem($request);
        echo json_encode($outp);
    }

    function removeAnItem($request) {
        $db = new newsItem();
        $outp = $db->removeAnItem($request);
        echo json_encode($outp);
    }

