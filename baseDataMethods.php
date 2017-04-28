<?php
/**
 * Created by PhpStorm.
 * User: Ernie Simuro
 * Date: 5/21/16
 * Time: 4:09 PM
 */

interface baseDataMethods {

    public function getSpecificItem($key);

    public function getListofItems($from=0);

    public function addNewItem($request);

    public function updateAnItem($request);

    public function removeAnItem($request);

} 