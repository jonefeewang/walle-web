<?php

use yii\db\Migration;

class m170825_030941_drop_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('task', 'reqm_source');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('task', 'reqm_source', $this->string());
    }
}