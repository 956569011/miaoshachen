<?php
	

//	$url = 'http://192.168.16.73/Seckill/index.php?app=app&c=seckill&a=addQsec&gid=2&type=mysql';
	$url = 'http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=mysql';

	$result = file_get_contents($url);

	var_dump($result);

	//使用php方式来请求
//	ab -c 50 -n 200 "http://www.miaosha.com/buy_mysql.php"

//  ab -c 50 -n 200 "http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=mysql"