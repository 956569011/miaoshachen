### 秒杀案例探究

1. 使用数据库的事务加行锁
2. 使用redis的队列(单线程,原子)  lpush rpop 先进先出   lpop rpush 先进先出 

