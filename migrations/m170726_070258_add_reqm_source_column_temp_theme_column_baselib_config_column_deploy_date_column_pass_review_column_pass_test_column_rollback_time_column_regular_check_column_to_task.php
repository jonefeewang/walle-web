<?php

use yii\db\Migration;

class m170726_070258_add_reqm_source_column_temp_theme_column_baselib_config_column_deploy_date_column_pass_review_column_pass_test_column_rollback_time_column_regular_check_column_to_task extends Migration
{
    public function up()
    {
        $this->addColumn('task', 'reqm_source', $this->string());
        $this->addColumn('task', 'temp_theme', $this->text());
        $this->addColumn('task', 'baselib_config', $this->text());
        $this->addColumn('task', 'deploy_time', $this->date());
        $this->addColumn('task', 'pass_review', $this->boolean());
        $this->addColumn('task', 'pass_test', $this->boolean());
        $this->addColumn('task', 'rollback_time', $this->smallinteger());
        $this->addColumn('task', 'regular_check', $this->text());
    }

    public function down()
    {
        $this->dropColumn('task', 'reqm_source');
        $this->dropColumn('task', 'temp_theme');
        $this->dropColumn('task', 'baselib_config');
        $this->dropColumn('task', 'deploy_time');
        $this->dropColumn('task', 'pass_review');
        $this->dropColumn('task', 'pass_test');
        $this->dropColumn('task', 'rollback_time');
        $this->dropColumn('task', 'regular_check');
    }
}
