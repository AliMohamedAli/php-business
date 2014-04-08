<?php

function drawTable($keyData){
	$keywords = $keyData->GetKeywordData();
	$keywordHeaders = $keyData->GetHeaders();

	print("<table border=\"1\" class=\"tSortable\">");

	tH($keywordHeaders);
	tD($keywords);
}
function tH($keywordHeaders){
	print("<tr>");
	foreach($keywordHeaders as $headers){
		print("<th>".$headers[0]."</th>");
	}
	print("</tr>");
}

function tD($keywords){
	foreach($keywords as $key){
		print("<tr>");			
		foreach($key as $data){			
			print("<td>".$data."</td>");
		}
		print("</tr>");
	}
}

?>