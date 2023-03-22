<?php

namespace app\commands;

use app\components\exec\ExecTask;
use app\components\exec\services\ExecMinus;
use app\components\exec\services\ExecPlus;
use app\models\Task;
use DateTime;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Controller for adding and exec tasks
 */
class TaskController extends Controller
{
    /**
     * This command add task
     * @param string $taskType type of the task.
     * @param string|null $taskData optional data for the task.
     * @return int Exit code
     */
    public function actionAdd(string $taskType, string $taskDateToStart, string $taskData = null): int
    {
        if(!Task::validateInput($taskType, $taskDateToStart, $taskData)) return ExitCode::UNSPECIFIED_ERROR;

//        create task
        $task = new Task([
            'type'=>$taskType,
            'date_to_start'=>$taskDateToStart,
            'data'=>$taskData
        ]);

        if(!$task->save()){
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }

    /**
     * This command find execute one task
     * @return int
     */
    public function actionExec(): int
    {
        $task = Task::getNew();
        if($task){
            echo "start task with id: " . $task->task_id . "\n";

            $task->start();

            $service = match ($task->type) {
                "ExecPlus" => new ExecPlus(),
                "ExecMinus" => new ExecMinus(),
                default => false,
            };

            if(!$service){
                echo "bad task type\n";
                return ExitCode::UNSPECIFIED_ERROR;
            }
            $execTask = new ExecTask($service);
            $result = $execTask->process($task);
            $task->finish($result);

        } else {
            echo "no tasks\n";
        }
        return ExitCode::OK;
    }
}
