<?php

namespace Mix\Redis\Coroutine;

use Mix\Pool\ConnectionTrait;

/**
 * RedisCoroutine组件
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class RedisConnection extends \Mix\Redis\Persistent\BaseRedisConnection
{

    use ConnectionTrait;

}
