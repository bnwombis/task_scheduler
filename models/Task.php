<?php

namespace app\models;

use DateTime;
use Yii;
use yii\console\ExitCode;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $task_id
 * @property string|null $type
 * @property string|null $date_to_start
 * @property string|null $date_started
 * @property string|null $date_finished
 * @property int|null $is_started
 * @property int|null $is_finished
 * @property string|null $data
 * @property string $result
 */
class Task extends \yii\db\ActiveRecord
{
    public const TYPE_PLUS = "ExecPlus";
    public const TYPE_MINUS = "ExecMinus";

    public const TYPES = [
        self::TYPE_PLUS,
        self::TYPE_MINUS,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['date_to_start', 'date_started', 'date_finished'], 'safe'],
            [['is_started', 'is_finished'], 'integer'],
            [['data'], 'string'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'task_id' => 'Task ID',
            'type' => 'Type',
            'date_to_start' => 'Date To Start',
            'date_started' => 'Date Started',
            'date_finished' => 'Date Finished',
            'is_started' => 'Is Started',
            'is_finished' => 'Is Finished',
            'data' => 'Data',
        ];
    }

    /** Set task as started
     * @return Task
     */
    public function start(): Task
    {
        $this->is_started = 1;
        $this->date_started = (new DateTime())->format(\Yii::$app->params['mysqlDateFormat']);
        $this->save();
        return $this;
    }

    /**
     * Set task as finished
     * @param $result
     * @return Task
     */

    public function finish($result): Task
    {
        $this->date_finished = (new DateTime())->format(\Yii::$app->params['mysqlDateFormat']);
        $this->is_finished = 1;
        $this->result = json_encode($result, true);
        $this->save();
        return $this;
    }

    /**
     * Get task needed to be executed
     * @return Task|ActiveRecord|null
     */
    public static function getNew(): Task|\yii\db\ActiveRecord|null
    {
        return self::find()
            ->where(['is_started' => 0])
            ->andWhere(['<=', 'date_to_start', (new DateTime())->format(\Yii::$app->params['mysqlDateFormat'])])
            ->one();
    }

    /** Validate type of the task
     * @param $taskType
     * @return bool
     */
    private static function validateType($taskType): bool
    {
        if(!in_array($taskType,self::TYPES)) {
            return false;
        }
        return true;
    }

    /** Validate input date
     * @param $taskDateToStart
     * @return bool
     */
    private static function validateDate($taskDateToStart): bool
    {
        if(DateTime::createFromFormat('Y-m-d H:i:s', $taskDateToStart) === false){
            return false;
        }
        return true;
    }

    /**
     * Validate optional data
     * @param $taskData
     * @return bool
     */
    private static function validateData($taskData): bool
    {
        if($taskData && !json_decode($taskData)){
            return false;
        }
        return true;
    }

    /**
     * Validate all input for the new task
     * @param $taskType
     * @param $taskDateToStart
     * @param $taskData
     * @return bool
     */
    public static function validateInput($taskType, $taskDateToStart, $taskData): bool
    {
        if(!self::validateType($taskType)) return false;
        if(!self::validateDate($taskDateToStart)) return false;
        if(!self::validateData($taskData)) return false;
        return true;
    }
}
