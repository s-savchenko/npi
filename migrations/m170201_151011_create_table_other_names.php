<?php

use yii\db\Migration;

class m170201_151011_create_table_other_names extends Migration
{
    public function up()
    {
        $this->createTable(
            'other_names',
            [
                'organization_name' => $this->string(),
                'code' => $this->string(),
                'type' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
    }

    public function down()
    {
        $this->dropTable('other_names');
    }
}
