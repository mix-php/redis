<?php

namespace Mix\Redis;

use Mix\Redis\Base\AbstractRedisConnection;

/**
 * Class RedisConnection
 * @package Mix\Redis
 * @author liu,jian <coder.keda@gmail.com>
 */
class RedisConnection extends AbstractRedisConnection
{

    /**
     * 后置处理事件
     */
    public function onAfterInitialize()
    {
        parent::onAfterInitialize();
        // 关闭连接
        $this->disconnect();
    }

    /**
     * 析构事件
     */
    public function onDestruct()
    {
        parent::onDestruct();
        // 关闭连接
        $this->disconnect();
    }

}
