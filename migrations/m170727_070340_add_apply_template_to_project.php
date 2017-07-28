<?php

use yii\db\Migration;

class m170727_070340_add_apply_template_to_project extends Migration
{
    public function up()
    {
        $this->addColumn('project', 'apply_template', $this->string());
    }

    public function down()
    {
        $this->dropColumn('project', 'apply_template');
    }
}
