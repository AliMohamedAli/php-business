<?php

class KeywordData{

	private $keywords = array();
	private $keywordHeaders = array();
	private $keyPercents = array();
	private $sumkeys=0;
	private $sumimps=0;
	private $sumclicks=0;
	private $sumcosts=0;

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

	public function sumKeywords(){
		$sumkeys = $this->sumkeys;
		foreach($this->keywords as $key){
				foreach($key as $index=>$data){
					if($index=="keywordPlacement"){
						$sumkeys++;
					}
				}
			}
		return $sumkeys;
	}

	public function sumImpressions(){
		$sumimps = $this->sumimps;
		foreach($this->keywords as $key){
				foreach($key as $index=>$data){
					if($index=="impressions"){
						$sumimps=$sumimps+$data;
					}
				}
			}
		return $sumimps;
	}

	public function sumClicks(){
		$sumclicks = $this->sumclicks;
		foreach($this->keywords as $key){
				foreach($key as $index=>$data){
					if($index=="clicks"){
						$sumclicks=$sumclicks+$data;
					}
				}
			}
		return $sumclicks;
	}

	public function sumCosts(){
		$sumcosts = $this->sumcosts;
		foreach($this->keywords as $key){
				foreach($key as $index=>$data){
					if($index=="costs"){
							$sumcosts=$sumcosts+$data;
					}
				}
			}
		return $sumcosts;
	}

	public function costPercent($total){
		$keyPercents = $this->keyPercents;
		$count = 0;
		foreach($this->keywords as $key){
				foreach($key as $index=>$data){
					if($index=="keywordPlacement"){						
						$percents[0]=$data;
					}
					if($index=="costs"){
						$percents[1] = ($data*100)/$total;
					}
				}				
				$keyPercents[$count]=$percents;
				$count++;
			}			
		return $keyPercents;
	}
}

?>