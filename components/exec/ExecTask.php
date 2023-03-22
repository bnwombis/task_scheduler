<?php

namespace app\components\exec;

use app\components\interfaces\ExecService;
use app\models\Task;
use DateTime;

class ExecTask
{
    protected ExecService $exec;

    /**
     * @param ExecService $exec
     */
    public function __construct(ExecService $exec)
    {
        $this->exec = $exec;
    }

    /**
     * This class execute tasks
     * @param Task $task
     * @return array|bool
     */
    public function process(Task $task): array|bool
    {
        $data = json_decode($task->data, true);
//      processing task here
        if(!$this->exec->validate($data)){
            return false;
        }
        $result = $this->exec->execute($data);

        return ['result' => $result];
    }
}