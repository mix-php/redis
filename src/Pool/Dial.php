<?php

namespace Mix\Redis\Pool;

use Mix\Pool\DialInterface;

/**
 * Class RedisConnectionDial
 * @author LIUJIAN <coder.keda@gmail.com>
 * @package Mix\Redis\Coroutine
 */
class Dial implements DialInterface
{

    /**
     * 拨号
     * @return RedisConnection
     */
    public function handle()
    {
        return \Mix\Redis\Coroutine\RedisConnection::newInstance();
    }

}
