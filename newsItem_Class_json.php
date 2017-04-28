<?php
/**
 * Created by PhpStorm.
 * User: Ernie Simuro
 * Date: 5/9/16
 * Time: 7:52 AM
 */

require_once 'baseDataMethods.php';

class newsItem implements baseDataMethods {

    private $jsonData;
    private $maxIndex;
    private $jsonFile;

    public function __construct()
    {
        $this->jsonFile = "data/newsitem.json";

        $postdata = file_get_contents($this->jsonFile);
        $tempArray = json_decode($postdata, true);
        $this->jsonData = array();
        foreach ($tempArray['RECORDS'] as $i=>$record ) {
            $this->jsonData[$record['id']] = $record;
            $tempMax = $record['id'];
        }
        $this->maxIndex = $tempMax;

    }

    public function getSpecificItem($key)
    {
        return $this->jsonData[$key];
    }

    public function getListofItems($from=0)
    {
        $cnt = count($this->jsonData);                  // get count of db records
        $max = 3;                                       // max items returned
        if ($from <= $cnt)
        {
            usort($this->jsonData, function($a, $b) {
                $a = strtotime($a['publishDate']);
                $b = strtotime($b['publishDate']);
                return (($a == $b) ? (0) : (($a < $b) ? (1) : (-1)));
            });

            $outp = array();
            $res = array();
            $num= 1;
            for($i = $from; $i < $cnt; $i++, $num++) {
                $res[] = $this->jsonData[$i];
                if ($num == $max) {
                    break;
                }
            }

            if ( ($from + $num) < $cnt ) {
                $outp['next'] = $num;
            } else {
                $outp['next'] = -1;
            }
            $outp["records"] = $res;
            return $outp;        }
    }

    public function addNewItem($request) {
        $newId = $this->maxIndex + 1;
        $request['id'] = $newId;
        $date = new DateTime($request['publishDate']);
        $request['publishDate'] = $date->format('Y-m-d');
        $this->jsonData[$newId] = $request;

        $this->writeJsondata();
        return true;
    }

    public function updateAnItem($request) {
        $date = new DateTime($request['publishDate']);
        $request['publishDate'] = $date->format('Y-m-d');
        $this->jsonData[$request['id']] = $request;
        $this->writeJsondata();
        return true;
    }

    public function removeAnItem($id) {
        unset($this->jsonData[$id]);
        $this->writeJsondata();
        return true;
    }

    private function writeJsondata()
    {
        $endArray = array();
        $endArray['RECORDS'] = $this->jsonData;

        $postdata = json_encode($endArray);
        file_put_contents($this->jsonFile, $postdata);

    }
} 