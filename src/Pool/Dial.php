<?php

namespace Mix\Redis\Pool;

use Mix\Pool\DialInterface;

/**
 * Class Dial
 * @author LIUJIAN <coder.keda@gmail.com>
 * @package Mix\Redis\Pool
 */
class Dial implements DialInterface
{

    /**
     * 处理
     * @return \Mix\Redis\Coroutine\RedisConnection
     */
    public function handle()
    {
        return \Mix\Redis\Coroutine\RedisConnection::newInstance();
    }

}
