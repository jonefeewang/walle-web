<?php

use yii\db\Migration;

class m170726_054816_add_reqm_type_column_content_column_developer_column_reviewer_column_deployer_column_to_task extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'reqm_type', $this->string());
        $this->addColumn('task', 'content', $this->text());
        $this->addColumn('task', 'developer', $this->string());
        $this->addColumn('task', 'reviewer', $this->string());
        $this->addColumn('task', 'deployer', $this->string());
    }

    public function down()
    {
        $this->dropColumn('task', 'reqm_type');
        $this->dropColumn('task', 'content');
        $this->dropColumn('task', 'developer');
        $this->dropColumn('task', 'reviewer');
        $this->dropColumn('task', 'deployer');
    }
}
