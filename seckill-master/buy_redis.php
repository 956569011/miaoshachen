<?php
	
//	$url = 'http://192.168.16.73/Seckill/index.php?app=app&c=seckill&a=addQsec&gid=2&type=redis';
	$url = 'http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=redis';
	$result = file_get_contents($url);
	
	var_dump($result);

	//模拟1号商品并发购卖减库存
	//ab -c 50 -n 200 "http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=redis"
	//ab -c 100 -n 1000 "http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=redis"
	//ab -c 100 -n 1000 -k "http://www.miaosha.com/index.php?app=app&c=seckill&a=addQsec&gid=1&type=redis"
