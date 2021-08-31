<?php
use App\Http\Controllers\CalcController;

$router->get('/', 'CalcController@show');
$router->post('/calc', 'CalcController@calc');
