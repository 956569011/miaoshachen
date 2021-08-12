<?php

	/*-------------------------------------------------
	 * redis驱动类，需要安装phpredis扩展
	 *
	 * @athor	liubin
	 * @link	http://pecl.php.net/package/redis
	 * @date	2016-02-09
	 *-------------------------------------------------
	*/

	class QRedisdanli{

		private static $_instance = null;


        private function __construct(){ //私有的构造方法
//            self::$_instance = new \Redis();

            try{
                self::$_instance = new Redis();
                $hanedel = self::$_instance ->connect('127.0.0.1',6379);

                //            if(isset($config['password'])){
                //                self::$_instance->auth($config['password']);
                //            }
                if( !$hanedel){
                    echo 'redis服务器无法链接';
                    exit;
                }
            }catch(RedisException $e){
                echo 'phpRedis扩展没有安装：' . $e->getMessage();
                exit;
            }


        }

        //获取静态实例
        public static  function getRedis(){
            if(!self::$_instance){
                new self();
            }
            return self::$_instance;
        }
        /*
         * 禁止clone
         */
        private function __clone(){}



	}



?>