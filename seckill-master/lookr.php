<?php


//$arr_methods = get_class_methods(new Redis);
//foreach ($arr_methods as $m){
//    echo $m.'<br />';
//}

//dump( method_exists('Redis','lsize') );


$redis		= new Redis();
$hanedel	= $redis->connect('127.0.0.1',6379);
//print_r($redis->lPush('duili','one'));
//print_r($redis->lPush('duili','two','three','four'));
//print_r ( $redis->delete('duili') );
$redis->set('zs',520);
$redis->setTimeout('zs',60);
print_r ( $redis->del('duili') );