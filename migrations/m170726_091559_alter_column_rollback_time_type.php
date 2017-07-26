<?php

use yii\db\Migration;

class m170726_091559_alter_column_rollback_time_type extends Migration
{
    public function up()
    {
        $this->alterColumn('task', 'rollback_time', $this->string());
    }

    public function down()
    {
        $this->alterColumn('task', 'rollback_time', $this->smallInteger());
    }
}
