<?php

require 'vendor/autoload.php';
require_once 'lib/mysql.php';
require_once 'lib/action_log.php';
require_once 'lib/auth.php';

use GuzzleHttp\Client;

$app = new \Slim\Slim();

$app->get( '/', function() {
	echo "<h1>Hello World!</h1>";
});

$app->post( '/auth', function() use ($app){
	$cardnum = $app->request()->params('cardnum');
	$password= $app->request()->params('password');
	$client = new Client();
	$res = $client->post('http://herald.seu.edu.cn/useraccount/login.php', ['body' => [
		'username' => $cardnum,
		'password' => $password
		]]);
	$result = $res->json();

	if($result['code'] == '200'){
		$userinfo = json_decode($result['data']);

		$sql = "SELECT * FROM `member` WHERE `card_num` =" . $userinfo->cardnum;
		$query = mysql_query($sql) or die(mysql_error());
		$re = mysql_fetch_array($query);
		if($re){
			$auth_token = md5(time() + rand());
			$data = array(
				'auth_token' => $auth_token, 
				'message' => 'Auth_Success'
				);
			$app->response->setStatus(200);

			new ActionLog($userinfo->cardnum, 'Auth');
			new Auth($userinfo->cardnum, $auth_token);
		} else {
			$data = array('message' => 'Not_Herald_Member');
			$app->response->setStatus(404);
		}
	} else {
		$app->response->setStatus(403);
		$data = array('message' => 'Wrong_Password');
	}

	$app->response['Content-Type'] = 'application/json';
	$app->response['X-Powered-By'] = 'HeraldStudio';
	$app->response->write(json_encode($data));
});

$app->get('/in/:cardnum/:auth_token', function($cardnum, $auth_num) use ($app){
	
});
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->run();