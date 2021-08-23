<?php
	

	$url = 'http://192.168.16.73/Seckill/index.php?app=app&c=seckill&a=addQsec&gid=2&type=transaction';
	$result = file_get_contents($url);
	
	var_dump($result);

	//get 请求 ab -c 50 -n 200 "http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=transaction"
    //post 请求时写法 ab  -c 50 -n 200 -T "application/x-www-form-urlencoded" -p  para.txt "http://www.miaosha.com/index.php"
