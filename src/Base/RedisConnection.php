<?php

namespace Mix\Redis\Base;

use Mix\Core\Component\AbstractComponent;

/**
 * Class RedisConnection
 * @package Mix\Redis\Base
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class RedisConnection extends AbstractComponent implements RedisConnectionInterface
{

    /**
     * 主机
     * @var string
     */
    public $host = '';

    /**
     * 端口
     * @var string
     */
    public $port = '';

    /**
     * 数据库
     * @var string
     */
    public $database = '';

    /**
     * 密码
     * @var string
     */
    public $password = '';

    /**
     * redis对象
     * @var
     */
    protected $_redis;

    /**
     * 创建连接
     * @return \Redis
     * @throws \RedisException
     */
    protected function createConnection()
    {
        $redis = new \Redis();
        // connect 这里如果设置timeout，是全局有效的，执行brPop时会受影响
        if (!$redis->connect($this->host, $this->port)) {
            throw new \RedisException("Redis connection failed, host: {$this->host}, port: {$this->port}");
        }
        $redis->auth($this->password);
        $redis->select($this->database);
        return $redis;
    }

    /**
     * 关闭连接
     * @return bool
     */
    public function disconnect()
    {
        $this->_redis = null;
        return true;
    }

    /**
     * 连接
     * @throws \RedisException
     */
    protected function connect()
    {
        $this->_redis = $this->createConnection();
    }

    /**
     * 自动连接
     * @throws \RedisException
     */
    protected function autoConnect()
    {
        if (isset($this->_redis)) {
            return;
        }
        $this->connect();
    }

    /**
     * 执行命令
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // 自动连接
        $this->autoConnect();
        // 执行命令
        return call_user_func_array([$this->_redis, $name], $arguments);
    }

}
