<?php

require './phpQuery-single-master/phpQuery.php';
require './QueryList-3.2.1/QueryList.php';


//热门影院列表
$cinemaList = array();

$maoyanLink = 'http://maoyan.com';

$rules = array(
    'name' => array('.cinema-info a','html'),
    'address' => array('.cinema-info p','html'),
    'link' => array('.cinema-info a','href'),
);


//第一页；
use QL\QueryList;
$hj = QueryList::Query($maoyanLink.'/cinemas',$rules);

$data = $hj->getData(function($x){
    return $x;
});

foreach($data as $key=>$val){

	$data[$key]['link'] =  $maoyanLink. $val['link'];
	$link = $data[$key]['link'];
}


$cinemaList[0] = $data;


//第二页 - 第四页；
for ($x=1; $x<=3; $x++) {

	$cinemasLink = 'http://maoyan.com/cinemas?offset='. (12 * $x);

	$hj = QueryList::Query($cinemasLink,$rules);

	$data = $hj->getData(function($x){
	    return $x;
	});

	foreach($data as $key=>$val){

	   $data[$key]['link'] =  $maoyanLink. $val['link'];
	   $link = $data[$key]['link'];
    
    }

    $cinemaList[$x] = $data;

	sleep(1);

} 


var_dump($cinemaList);
