<?php
/**
 * Created by PhpStorm.
 * User: Wisdom Emenike
 * Date: 24/03/2020
 * Time: 2:55 PM
 */

require 'class/Network.php';
require 'class/Request.php';
require 'class/Response.php';

$users = []; //list of users to bill from db

$list = new SplDoublyLinkedList();

foreach ($users as $user) { //iterate through users

    $request = new network\Request();

    //set billing data
    $request->setAmount($user['amount_to_bill']);
    $request->setUsername($user['username']);

    //add request instance to list
    $list->add($user['id'], $request);
}

//iterate through request list
for ($list->rewind(); $list->valid(); $list->next()) {

    $request = $list->current();

    if (!$request instanceof \network\Request) continue;

    $response = $request->initiate(); //initiate api call

    if ($response->getStatus() === true) { //check request status

        // API call succeeded, handle response
        $api_response = $response->getResponseArray();
    }
}