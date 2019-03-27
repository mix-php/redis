<?php

namespace Mix\Redis\Pool;

use Mix\Pool\DialInterface;

/**
 * Class Dial
 * @package Mix\Redis\Pool
 * @author liu,jian <coder.keda@gmail.com>
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
