<?php

class AdWordsAdapter{

	private $client_id;
	private $client_secret;
	private $refresh_token;
	private $developer_token;
	private $client_customer_id;

	public function __construct($client_id,$client_secret,$refresh_token,
		$developer_token,$client_customer_id){

		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->refresh_token = $refresh_token;
		$this->developer_token = $developer_token;
		$this->client_customer_id = $client_customer_id;

	}

	public function getCID(){
		return $this->client_id;
	}

	public function getCIS(){
		return $this->client_secret;
	}

	public function getREF(){
		return $this->refresh_token;
	}

	public function getDEV(){
		return $this->developer_token;
	}

	public function getCCI(){
		return $this->client_customer_id;
	}
}

?>