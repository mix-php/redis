<?php

namespace Mix\Redis\Coroutine;

use Mix\Pool\ConnectionTrait;

/**
 * Class RedisConnection
 * @package Mix\Redis\Coroutine
 * @author liu,jian <coder.keda@gmail.com>
 */
class RedisConnection extends \Mix\Redis\Persistent\RedisConnection
{

    use ConnectionTrait;

    /**
     * 析构
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        // 丢弃连接
        $this->discard();
    }

}
