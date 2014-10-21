<?php
class Auth{
	public function __construct( $cardnum, $auth_token ) {
		$this -> cardnum = $cardnum;
		$this -> auth_token = $auth_token;
		$this -> auth();
	}

	public function auth() {
		$sql = "INSERT INTO `auth` (`card_num`, `auth_token`) VALUES ('".$this->cardnum."','".$this->auth_token."')";
		mysql_query($sql) or die(mysql_error());
	}
}