<?php

use yii\db\Migration;

/**
 * Handles the creation of table `taskuser`.
 */
class m170818_104804_create_taskuser_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('taskuser', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'task_id' => $this->integer(),
            'role' => $this->smallInteger(),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('taskuser');
    }
}
