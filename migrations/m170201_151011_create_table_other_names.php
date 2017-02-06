<?php

use yii\db\Migration;

class m170201_151011_create_table_other_names extends Migration
{
    public function up()
    {
        $this->createTable(
            'other_names',
            [
                'id' => $this->primaryKey(),
                'organization_name' => $this->string(),
                'code' => $this->string(),
                'type' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
        $this->addForeignKey('fk_other_names_npi', 'other_names', 'number', 'npi', 'number', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_other_names_npi', 'other_names');
        $this->dropTable('other_names');
    }
}
