<?php

namespace Mix\Redis;

/**
 * Interface ExecuteListenerInterface
 * @package Mix\Redis
 * @author liu,jian <coder.keda@gmail.com>
 */
interface ExecuteListenerInterface
{

    /**
     * 监听
     * @param array $data
     */
    public function listen($data);

}
