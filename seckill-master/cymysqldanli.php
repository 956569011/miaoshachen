<?php

//数据库连接单例模式

/**
 * 以后开的时候 注意事项
 * 尽量在一个函数中 实现一种功能
 * 之后，可以在构造函数中去调用函数
 */
class MySqlDB
{
    //创建私有属性
    private static $instence;
    private $host;
    private $user;
    private $pwd;
    private $port;
    private $db;
    private $charset;
    private $link;

    //实例化
    private function __construct($data)
    {
        $this->initArg($data);
        $this->sqlLink();
    }

    private function __clone()
    {
    }

    //创建对象
    public static function createLink($data = array())
    {
        if (!self::$instence instanceof self) {
            return self::$instence = new self($data);
        }
        return self::$instence;
    }

    //初始化参数
    private function initArg($data)
    {
        $this->host = $data['host'] ?? "127.0.0.1";
        $this->user = $data['user'] ?? "root";
        $this->pwd = $data['pwd'] ?? "123456";
        $this->port = $data['port'] ?? "3306";
        $this->db = $data['db'] ?? "miaosha";
    }

    private function sqlLink()
    {
        $this->link = mysqli_connect($this->host, $this->user, $this->pwd, $this->db, $this->port);
        if (mysqli_connect_error()) {
            echo "数据库连接失败<br>";
            echo "错误代码" . mysqli_connect_errno();
            exit;
        }
        mysqli_set_charset($this->link, $this->charset);

    }

}

var_dump($a = MySqlDB::createLink());
var_dump($b = MySqlDB::createLink());
var_dump( $a === $b );