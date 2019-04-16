<?php
/**
 * Created by PhpStorm.
 * User: kerva
 * Date: 6.03.2019
 * Time: 13:50
 */
include ("autoload.php");
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

$version = new Version1X("http://localhost:3000");

$clint = new Client($version);

$clint ->initialize();

$clint->emit("connection",["test"=>"test","test1"=>"test1"]);