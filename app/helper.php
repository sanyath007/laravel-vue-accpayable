<?php
function convDateFromDb($date) 
{
	if(empty($date) || !isset($date)) { return ''; }

	$arr = explode('-', $date);
	$year = (int)$arr[0] + 543;
	
	return $arr[2]. '/' .$arr[1]. '/' .$year;
}