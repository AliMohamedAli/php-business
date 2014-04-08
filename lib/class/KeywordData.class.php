<?php

class KeywordData{

	private $keywords = array();
	private $keywordHeaders = array();

	public function __construct($keywords,$keywordHeaders){
		$this->keywords = $keywords;
		$this->keywordHeaders = $keywordHeaders;
	}

	public function GetHeaders(){
		return $this->keywordHeaders;
	}

	public function GetKeywordData(){
		return $this->keywords;
	}

}

?>