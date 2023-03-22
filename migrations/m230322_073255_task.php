<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m230322_073255_task
 */
class m230322_073255_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'task_id' => $this->primaryKey(),
            'type' => $this->string(),
            'date_to_start' => $this->dateTime(),
            'date_started' => $this->dateTime(),
            'date_finished' => $this->dateTime(),
            'is_started' => $this->tinyInteger()->defaultValue(0),
            'is_finished' => $this->tinyInteger()->defaultValue(0),
            'data' => $this->text(),
            'result' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
    }

}
