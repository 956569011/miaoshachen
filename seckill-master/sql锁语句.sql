//mysql 数据库锁
myisam 表锁

1)加锁    读锁
lock table chen_goods read;//锁住当前会话只能读不能改(改提示表已经锁了只能读),其他会话只能读(在改的时候会进入阻塞状态) 
                           //要能改需要解锁;操作其他表不能操作,如果要操作需要把其他表也锁起来
         写锁
lock table chen_goods write;//锁住当前会话,进行过修改过的表,(当前会话可以访问及修改),此时其他会话访问时候会阻塞状态不能读取到,也不能改,数据
                            //若其他会话要能读取到数据,需要当前会话解锁

2)解锁
UNLOCK TABLES


Innodb操作 行(页)锁:
Innodb也称为事务表
锁的操作与事务要建立联系 否则锁不起作用
start transaction;//开启事务

锁定操作
                                              //共享锁
select * from chen_goods  where  ....  lock in share mode;    //当前会话可以读,可以改,
                                                       //其他会话可以读取(此时如果之前的当前会话改了,此时还是读取到旧的数据),改的时候会阻塞
                                                       //如果其他会话要能改需要,(之前当前会话提交事务)
                                             //排他锁
select * from chen_goods  where  ....  for update;    //当前会话可读可改 //其他会话查询 或者修改都是阻塞状态
                                                     //如果其他会话要能改需要,(之前当前会话提交事务)
                                            //页锁 (理论边界值id=5没有锁定,实际有锁定)
select * from chen_goods  where  id<5 for update;
                                                     //当前会话可以读可以改,//其他会话锁定范围内的数据禁止操作(如读,改)
                                                                        //锁定范围外的数据可以(读,改)


commit  //提交事务 或者  rollback

或者



set autocommit=0;  //开启事务 禁止自动提交

锁定操作

set autocommit=1;  //使得事务进行提交


mysql 中事务提交方式有几种?
    1.自动提交(默认)
        MySQL 在自动提交模式下,每个 SQL 语句都是一个独立的事务,这意味着,
        当您执行一个用于更新(修改)表的语句之后,MySQL立刻把更新存储到磁盘中
    2.手动提交(commit)
        手动设置set @@autocommit = 0
        即设定为非自动提交模式
        只对当前的mysql命令行窗口有效
        打开一个新的窗口后
        默认还是自动提交
        使用 MySQL 客户端执行 SQL 命令后必须使用commit命令执行事务
        否则所执行的 SQL 命令无效
        如果想撤销事务则使用 rollback 命令(在commit之前)

查看 MySQL 客户端的事务提交方式命令
                           select @@autocommit; 默认值=1,自动提交

修改 MySQL 客户端的事务提交方式为手动提交命令
                            set @@autocommit = 0;

包括 MySQL 在内的一些数据库 当发出一条类似 DROP TABLE 或 CREATE TABLE 这样的 DDL 语句时 会自动进行一个隐式地事务提交
隐式地提交将 阻止你在此事务范围内回滚任何其他更改(因为事务已经给提交了无法回滚)


MySql事务开始begin和start transcation的区别

目录
事务的开始
事务的提交
事务回滚
事务的开始
begin或 start transaction 都是显式开启一个事务

事务的提交
commit 或 commit work 都是等价的

事务回滚
rollback 或 rollback work 也是等价的

结论 (行锁注意点)
在开启事务的情况下 查询使用for update 如果使用了索引(主键)并且索引生效的情况下 锁的是查到的行 否则是表锁


//参考如下:
https://jingyan.baidu.com/article/454316ab2f9adaf7a7c03ad5.html

参考:https://blog.csdn.net/qq_31975227/article/details/103710018