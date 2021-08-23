### ab工具使用  
ab命令会创建多个并发访问线程，模拟多个访问者同时对某一URL地址进行访问。
它的测试目标是基于URL的，因此，它既可以用来测试apache的负载压力，
也可以测试nginx、lighthttp、tomcat、IIS等其它Web服务器的压力
ab命令对发出负载的计算机要求很低，它既不会占用很高CPU，也不会占用很多内存。
但却会给目标服务器造成巨大的负载，自己测试使用也需要注意，否则一次上太多的负载。
可能造成目标服务器资源耗完，严重时甚至导致死机
参考链接 
https://www.pianshen.com/article/37521610468/
https://www.jianshu.com/p/166a4ea8aade
#### 带参数的的请求
ab -t 60 -c 100 -T "application/x-www-form-urlencoded" -p p.txt http://192.168.0.10/hello.html

p.txt 是和ab.exe在一个目录 p.txt 中可以写参数，如 p=wdp&fq=78 要注意编码问题

##### 参数中的三种形式

* application/x-www-form-urlencoded (默认值)
    * 就是设置表单传输的编码,典型的post请求
* multipart/form-data.
    * 用来指定传输数据的特殊类型的，主要就是我们上传的非文本的内容，比如图片,mp3，文件等等
* text/plain 
    * 是纯文本传输的意思

qps意思是每秒查询率

https://www.cnblogs.com/taiyonghai/p/5810150.html
    

