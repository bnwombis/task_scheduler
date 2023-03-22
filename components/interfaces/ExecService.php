<?php

namespace app\components\interfaces;

interface ExecService
{
    public function validate($data);
    public function execute($data);
}