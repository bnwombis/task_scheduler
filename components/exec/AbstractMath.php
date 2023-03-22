<?php

namespace app\components\exec;

abstract class AbstractMath
{
    /**
     * Validate input data for Math types of tasks
     * @param $data
     * @return bool
     */
    public function validate($data): bool
    {
        if(!isset($data['a']) || !isset($data['b'])){
            return false;
        }
        if(!is_numeric($data['a']) || !is_numeric($data['b'])){
            return false;
        }
        return true;
    }

}