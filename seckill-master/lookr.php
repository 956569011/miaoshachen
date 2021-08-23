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
//$redis->set('zs',520);
//$redis->expire('zs',60);
//print_r ( $redis->del('duili') );

//追加(append)
//append()表示往字符串后面追加元素，返回值是字符串的总长度
//示例：在'hello'后面追加' world'

//$res = $redis->set('respect', 'hello',60);
//var_dump($res);//返回boolean
//$length = $redis->append('respect', ' nihao');
//var_dump($length);