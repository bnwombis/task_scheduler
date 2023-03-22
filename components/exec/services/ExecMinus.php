<?php

namespace app\components\exec\services;

use app\components\exec\AbstractMath;
use app\components\interfaces\ExecService;

class ExecMinus extends AbstractMath implements ExecService
{
    /**
     * This function minus variables b from a
     * @param $data
     * @return float|int
     */
    public function execute($data): float|int
    {
        return $data['a'] - $data['b'];
    }
}