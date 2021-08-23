php-fpm是什么

php-fpm即php-Fastcgi Process Manager.
php-fpm是 FastCGI 的实现，并提供了进程管理的功能。
进程包含 master 进程和 worker 进程两种进程。
master 进程只有一个，负责监听端口，接收来自 Web Server 的请求，
而 worker 进程则一般有多个(具体数量根据实际需要配置)，
每个进程内部都嵌入了一个 PHP 解释器，是 PHP 代码真正执行的地方。


nginx与php-fpm的结合，完整的流程是这样的。

 www.example.com
        |
        |
      Nginx
        |
        |
路由到www.example.com/index.php
        |
        |
加载nginx的fast-cgi模块
        |
        |
fast-cgi监听127.0.0.1:9000地址
        |
        |
www.example.com/index.php请求到达127.0.0.1:9000
        |
        |
php-fpm 监听127.0.0.1:9000
        |
        |
php-fpm 接收到请求，启用worker进程处理请求
        |
        |
php-fpm 处理完请求，返回给nginx
        |
        |
nginx将结果通过http返回给浏览器

https://blog.csdn.net/u013474436/article/details/52972699