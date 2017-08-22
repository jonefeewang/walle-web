<?php

use yii\db\Migration;

/**
 * Handles dropping some from table `task`.
 */
class m170821_031619_drop_some_column_from_task_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('task', 'developer');
        $this->dropColumn('task', 'reviewer');
        $this->dropColumn('task', 'deployer');
        $this->dropColumn('task', 'tester');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('task', 'developer', $this->string());
        $this->addColumn('task', 'reviewer', $this->string());
        $this->addColumn('task', 'deployer', $this->string());
        $this->addColumn('task', 'tester', $this->string());
    }
}
