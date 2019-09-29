<?php

namespace Mix\Redis\Coroutine;

use Mix\Pool\ConnectionTrait;

/**
 * Class Connection
 * @package Mix\Redis\Coroutine
 * @author liu,jian <coder.keda@gmail.com>
 */
class Connection extends \Mix\Redis\Persistent\Connection
{

    use ConnectionTrait;

    /**
     * 析构
     */
    public function __destruct()
    {
        // 丢弃连接
        $this->discard();
    }

}
