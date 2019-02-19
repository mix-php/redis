<?php

namespace Mix\Redis;

/**
 * Class RedisConnection
 * @package Mix\Redis
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class RedisConnection extends \Mix\Redis\Base\RedisConnection
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
