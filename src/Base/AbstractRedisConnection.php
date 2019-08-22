<?php

namespace Mix\Redis\Base;

use Mix\Bean\BeanInjector;
use Mix\Redis\Event\ExecuteEvent;
use Mix\Redis\RedisConnectionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractRedisConnection
 * @package Mix\Redis\Base
 * @author liu,jian <coder.keda@gmail.com>
 */
abstract class AbstractRedisConnection implements RedisConnectionInterface
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
     * 超时时间
     * @var float
     */
    public $timeout = 0.0;

    /**
     * 重连间隔
     * @var int
     */
    public $retryInterval = 0;

    /**
     * 读超时时间
     * phpredis >= 3.1.3
     * @var int
     */
    public $readTimeout = -1;

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
     * 事件调度器
     * @var EventDispatcherInterface
     */
    public $eventDispatcher;

    /**
     * redis对象
     * @var \Redis
     */
    protected $_redis;

    /**
     * AbstractRedisConnection constructor.
     * @param array $config
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     */
    public function __construct(array $config = [])
    {
        BeanInjector::inject($this, $config);
    }

    /**
     * 析构
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        // 关闭连接
        $this->disconnect();
    }

    /**
     * 创建连接
     * @return \Redis
     * @throws \RedisException
     */
    protected function createConnection()
    {
        $redis = new \Redis();
        if (!$redis->connect($this->host, $this->port, $this->timeout, null, $this->retryInterval)) {
            throw new \RedisException(sprintf('Redis connect failed (host: %s, port: %s)', $this->host, $this->port));
        }
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, $this->readTimeout);
        // 假设密码是字符串 0 也能通过这个校验
        if ('' != (string)$this->password) {
            $redis->auth($this->password);
        }
        $redis->select($this->database);
        return $redis;
    }

    /**
     * 关闭连接
     * @return bool
     */
    public function disconnect()
    {
        if (isset($this->_redis)) {
            $this->_redis->close();
            $this->_redis = null;
        }
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
     * 获取微秒时间
     * @return float
     */
    protected static function microtime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * 调度执行事件
     * @param $command
     * @param $arguments
     * @param $time
     */
    protected function dispatchExecuteEvent($command, $arguments, $time)
    {
        if (!$this->eventDispatcher) {
            return;
        }
        $event            = new ExecuteEvent();
        $event->command   = $command;
        $event->arguments = $arguments;
        $event->time      = $time;
        $this->eventDispatcher->dispatch($event);
    }

    /**
     * 执行命令
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($command, $arguments)
    {
        // 自动连接
        $this->autoConnect();
        // 执行命令
        $microtime = static::microtime();
        $result    = call_user_func_array([$this->_redis, $command], $arguments);
        $time      = round((static::microtime() - $microtime) * 1000, 2);
        // 调度执行事件
        $this->dispatchExecuteEvent($command, $arguments, $time);
        // 返回
        return $result;
    }

    /**
     * 遍历key
     * @param $iterator
     * @param string $pattern
     * @param int $count
     * @return array|bool
     */
    public function scan(&$iterator, $pattern = '', $count = 0)
    {
        return $this->_redis->scan($iterator, $pattern, $count);
    }

    /**
     * 遍历set key
     * @param $key
     * @param $iterator
     * @param string $pattern
     * @param int $count
     * @return array|bool
     */
    public function sScan($key, &$iterator, $pattern = '', $count = 0)
    {
        return $this->_redis->sScan($key, $iterator, $pattern, $count);
    }

    /**
     * 遍历zset key
     * @param $key
     * @param $iterator
     * @param string $pattern
     * @param int $count
     * @return array|bool
     */
    public function zScan($key, &$iterator, $pattern = '', $count = 0)
    {
        return $this->_redis->zScan($key, $iterator, $pattern, $count);
    }

    /**
     * 遍历hash key
     * @param $key
     * @param $iterator
     * @param string $pattern
     * @param int $count
     * @return array
     */
    public function hScan($key, &$iterator, $pattern = '', $count = 0)
    {
        return $this->_redis->hScan($key, $iterator, $pattern, $count);
    }
}
