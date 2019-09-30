<?php

namespace Mix\Redis;

use Mix\Pool\ConnectionTrait;

/**
 * Class Connection
 * @package Mix\Redis
 * @author liu,jian <coder.keda@gmail.com>
 */
class Connection extends \Mix\Redis\Persistent\Connection implements ConnectionInterface
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
