<?php

namespace app\components\exec\services;

use app\components\exec\AbstractMath;
use app\components\interfaces\ExecService;

class ExecPlus extends AbstractMath implements ExecService
{
    /**
     * This function adds up variables a and b
     * @param $data
     * @return float|int
     */
    public function execute($data): float|int
    {
        return $data['a'] + $data['b'];
    }
}