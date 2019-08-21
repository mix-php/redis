<?php

namespace Mix\Redis\Event;

/**
 * Class ExecuteEvent
 * @package Mix\Redis\Event
 * @author liu,jian <coder.keda@gmail.com>
 */
class ExecuteEvent
{

    /**
     * @var string
     */
    public $command = '';

    /**
     * @var array
     */
    public $arguments = [];

    /**
     * @var float
     */
    public $time = 0;

}
