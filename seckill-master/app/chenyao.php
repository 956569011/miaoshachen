<?php

/**
 * Class chenyao
 */
    class chenyao extends common{
        private $_orderModel = null;
        private $_goodsModel = null;


        public function __construct()
        {
            if($this->_orderModel === null){
                $this->_orderModel = new OrderModel();
            }

            if($this->_goodsModel === null){
                $this->_goodsModel = new GoodsModel();
            }


        }

        // ab -c 50 -n 200   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=show"

        //这种写法有问题 会下单超卖
        public function show(){
            $model	= $this->_goodsModel;
            $pdo	= $model->getHandler();

            $res = $pdo->query('select * from chen_goods where id=1',PDO::FETCH_ASSOC)->fetch();

            //每次购卖数量
            $buycount = 1;
            //查询是否有库存
            if($res['counts'] > 0){
                dump('有库存');
                $order_id = 'ON' . time() . uniqid();

                $goods_id = $res['id'];
                $uid = rand(1,2);
                $add_time = time();
//                $sql = "insert into chen_orders ('id','order_id','goods_id','uid','addtime')
//                        values (null,$order_id,$goods_id,$uid,$add_time)";


                $sql = "insert into chen_orders (id,order_id,goods_id,uid,addtime) 
                        values (null,'{$order_id}',$goods_id,$uid,$add_time)";

                $res = $pdo->exec($sql);

                //下单成功减库存
                if($res){
                    $sql_upd_goods = "update chen_goods set counts = counts - {$buycount} where counts > 0 and id=1 ";

                    $res_upd = $pdo->exec($sql_upd_goods);
                    if($res_upd){
                        dump('库存减少成功');
                    }
                }


//                dump($res);
            }


        }

        //1.数据库秒杀不会导致超卖sql写法的另一种方式
        //ab -c 50 -n 200   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=show2"
        public function show2(){
            $model	= $this->_goodsModel;
            $pdo	= $model->getHandler();
            //每次购卖数量
            $buycount = 1;
            try{
                $pdo->beginTransaction();//开启事务处理
                //先减库存,在下单
                $sql_upd_goods = "update chen_goods set counts = counts - {$buycount} where counts > 0 and id=1 ";
                //$sql_upd_goods = "update chen_goods set counts = counts - {$buycount} where counts >= $buycount and id=1";
                $res_upd = $pdo->exec($sql_upd_goods);
                //库存减少成功我们才下单
                if( $res_upd > 0 ){
                    //这里就该从前台传来的商品判断商品是不是在搞秒杀,是我们才能下单 不要相信用户传来的商品id
                    $res = $pdo->query('select * from chen_goods where id=1',PDO::FETCH_ASSOC)->fetch();

                    $order_id = 'ON' . time() . uniqid();
                    $goods_id = $res['id'];
//                    $uid = rand(1,2);
                    $uid = rand(1,10);
                    $add_time = time();

                    //查询存在的用户不能下单      //如果不想用户已经下单过的重复下单,请加上这个逻辑 ,否则是可以重复下单的
//                    $res = $pdo->query('select id from chen_orders where uid = ' . $uid,PDO::FETCH_ASSOC)->fetch();
//                    //如果用户下单过,不能重复下单,同时恢复库存
//                    if($res){
//                        dump('秒杀成功,不能重复下单');
//                        $pdo->rollBack();
//                        return false;
//                    }
                    $sql = "insert into chen_orders (id,order_id,goods_id,uid,addtime) 
                        values (null,'{$order_id}',$goods_id,$uid,$add_time)";

                    $res = $pdo->exec($sql);
                    if($res){
                        $pdo->commit();//提交事务
                    }else{
                        $pdo->rollBack();//回滚事务
                    }
                }
                //说明没有库存了
                if($res_upd === 0){
                    dump('没有库存了');
                }
            }catch(PDOException $e){
                echo $e->getMessage();
                $pdo->rollBack();//数据库异常回滚事务
            }
        }

        //2.使用文件锁非阻塞实现秒杀
        //ab -c 50 -n 200   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=show3"
        public function show3(){

            $file_name = 'lock.txt';
            $fp = fopen("lock.txt", "w+");//读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。

            //LOCK_EX - 独占锁定（写入的程序）。防止其他进程访问该文件。
            //LOCK_NB - 锁定的情况下避免阻塞其他进程。
            if(!flock($fp,LOCK_EX | LOCK_NB)){
                echo "系统繁忙，请稍后再试";
                file_put_contents('./a.txt',"系统繁忙，请稍后再试".PHP_EOL,FILE_APPEND | LOCK_EX);
                return false;
            }

            //并发跑完执行200次 分别是获取到锁和没获取到锁情况
            file_put_contents('./a.txt',"获取到锁非阻塞情况".PHP_EOL,FILE_APPEND | LOCK_EX);
            //每次购卖数量
            $buycount = 1;

            //(1).先检查库存是不是在于0
            $model	= $this->_goodsModel;
            $pdo	= $model->getHandler();
            $res = $pdo->query('select * from chen_goods where id=1',PDO::FETCH_ASSOC)->fetch();
            if($res['counts'] > 0){
                dump('有库存');
                $order_id = 'ON' . time() . uniqid();$goods_id = $res['id'];$uid = rand(1,2);$add_time = time();

                $sql = "insert into chen_orders (id,order_id,goods_id,uid,addtime) 
                        values (null,'{$order_id}',$goods_id,$uid,$add_time)";

                $res = $pdo->exec($sql);

                //下单成功减库存
                if($res){
                    $sql_upd_goods = "update chen_goods set counts = counts - {$buycount} where counts > 0 and id=1 ";

                    $res_upd = $pdo->exec($sql_upd_goods);
                    if($res_upd){
//                      file_put_contents('./a.txt',"下单成功".PHP_EOL,FILE_APPEND | LOCK_EX);
                        dump('库存减少成功');
                        flock($fp,LOCK_UN);//释放锁
                    }else{
                        dump('库存减少失败');
//                        flock($fp,LOCK_UN);//释放锁 可以不写
                    }
                }


            }else{
                dump('库存不足');
//                flock($fp,LOCK_UN);//释放锁 可以不写
            }

            //关闭文件资源 fclose() 来释放锁定操作，脚本执行完成时会自动调用
            fclose($fp);
        }


        //file_put_contents 高并发时用法 (file_put_contents记录的日志内容丢失问题)
        //ab -c 50 -n 200   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=fgcshow"
        public function fgcshow(){
            //当写入完成时，其他写入操作才会执行。防止多人同时写入造成内容丢失。
            //如果不希望 flock() 在锁定时堵塞，则给 lock 加上 LOCK_NB
            //FILE_APPEND（追加写），在文件末尾以追加的方式写入数据
            //LOCK_EX（写入时获得一个独占锁)LOCK_EX，写文件的时候先锁定，此时其他写入操作会队列等待。
            //参考地址 https://blog.csdn.net/weixin_33726943/article/details/93743172

            $file_name = './fgctest.txt';
//            !file_exists($file_name) &&  file_put_contents($file_name, time().PHP_EOL, FILE_APPEND|LOCK_EX);
            $res = file_put_contents($file_name, time().PHP_EOL, FILE_APPEND|LOCK_EX);
            if($res){
                file_put_contents('xie.log', '写成功' . $res .PHP_EOL, FILE_APPEND|LOCK_EX);
            }else{
                file_put_contents('xie.log', '写失败'.PHP_EOL, FILE_APPEND|LOCK_EX);
            }
        }

        //ab -c 50 -n 200   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=fortest"

        public function fortest(){
            $i = 0;
            for($i=0;$i<5;$i++){

            }
            file_put_contents('fortest',$i.PHP_EOL,FILE_APPEND | LOCK_EX);
        }

        //ab -c 50 -n 200 "http://www.miaosha.com/index.php?app=app&c=chenyao&a=ftest01"
        //ab -c 50 -n 500   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=ftest01"
        //文件锁 阻塞模式
        public function ftest01(){
            $fp = fopen('./lock.txt','r');

            //加锁 排它锁（LOCK_EX）
            if(flock($fp,LOCK_EX) ){
                dump('加锁后执行的一些操作,如查询库存,减库存,生成订单');
                file_put_contents('./ftest01.txt',"获取到锁情况".PHP_EOL,FILE_APPEND | LOCK_EX);
//                sleep(10); //睡10秒钟,此时没有释放锁;在次注释掉此行在10秒钟内访问是阻塞状态,只有等前一个进程释放锁后才能执行
                //执行完解锁
                flock($fp,LOCK_UN);

            }else{
                file_put_contents('./ftest01.txt',"阻塞情况是一直等待不可能进入到这个分支判断".PHP_EOL,FILE_APPEND | LOCK_EX);
            }
            file_put_contents('./ftest01.txt',"释放锁后可以执行".PHP_EOL,FILE_APPEND | LOCK_EX);
            //ftest01.txt里面写入400条数据说明正确
            //关闭文件
            fclose($fp);
        }
        //文件锁 非阻塞  ab -c 50 -n 200   "http://www.miaosha.com/index.php?app=app&c=chenyao&a=ftest02"
        public function ftest02(){
            $fp = fopen('./lock.txt','r');
            if(!flock($fp,LOCK_EX | LOCK_NB))
            {
//                dump('没获取到锁,非阻塞情况');
                file_put_contents('./ftest02.txt',"没获取到锁,非阻塞情况可以进入到这个分支".PHP_EOL,FILE_APPEND | LOCK_EX);

            }else{
//                dump('加锁后执行的一些操作,如查询库存,减库存,生成订单');
                file_put_contents('./ftest02.txt',"获取到锁".PHP_EOL,FILE_APPEND | LOCK_EX);
                flock($fp,LOCK_UN);
            }
            //以下这条语句会执行添加200次    加上上面的200次 共400次
            file_put_contents('./ftest02.txt',"不管释放没释放都会执行".PHP_EOL,FILE_APPEND | LOCK_EX);
            //关闭文件
            fclose($fp);
        }

    }