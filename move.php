<?php

require './phpQuery-single-master/phpQuery.php';
require './QueryList-3.2.1/QueryList.php';


//热门电影列表
$moveList = array();

$maoyanLink = 'http://maoyan.com';


$rules = array(
    //采集id为one这个元素里面的纯文本内容
    'title' => array('.movie-item-title a','html'),
    //采集class为two下面的超链接的链接
    'link' => array('.movie-item-title a','href'),
);


use QL\QueryList;
$hj = QueryList::Query($maoyanLink.'/films',$rules);

$data = $hj->getData(function($x){
    return $x;
});

foreach($data as $key=>$val){
	$data[$key]['link'] =  $maoyanLink. $val['link'];

	$link = $data[$key]['link'];

	//整理图片；

	$hj = QueryList::Query($link,
			array('image'    => array('.avatar-shadow img','src'),
				  'describe' => array('.dra','html'),
				  'category' => array('.movie-brief-container li:eq(0)','html'),
				  'releaseTime' => array('.movie-brief-container li:eq(1)','html'),
				  'country'  => array('.movie-brief-container li:eq(2)','html'),
			)
		);

	$detail = $hj->getData(function($x){return $x;});

    $data[$key]['image'] = $detail[0]['image'];
    $data[$key]['category'] = $detail[0]['category'];
    $data[$key]['releaseTime'] = $detail[0]['releaseTime'];
    $data[$key]['country']  = $detail[0]['country'];
    $data[$key]['describe'] = $detail[0]['describe'];

}


$moveList = $data;
var_dump($moveList);
