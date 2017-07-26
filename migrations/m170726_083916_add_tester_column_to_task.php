<?php

use yii\db\Migration;

class m170726_083916_add_tester_column_to_task extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'tester', $this->string());
    }

    public function down()
    {
        $this->dropColumn('task', 'tester');
    }
}
