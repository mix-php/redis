<?php

namespace Mix\Redis;

/**
 * Interface RedisConnectionInterface
 * @package Mix\Redis
 * @author LIUJIAN <coder.keda@gmail.com>
 */
interface RedisConnectionInterface
{

    // 关闭连接
    public function disconnect();

    // 执行命令
    public function __call($name, $arguments);

}
