<?php
error_reporting('E_ALL');
include __DIR__.'/autoloader.php';

use NBU_API\NBU_API_Exchange;

$nbuApi = new NBU_API_Exchange();
//$nbuApi->setResponseType('xml');
//$nbuApi->getRates('USD');
var_dump($nbuApi->getRates(['USD','EUR']));
//var_dump($nbuApi->getRate('EUR'));

