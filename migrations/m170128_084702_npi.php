<?php

use yii\db\Migration;

class m170128_084702_npi extends Migration
{
    public function up()
    {
        $this->createTable(
            'npi',
            [
                'id' => $this->primaryKey(),
                'number' => $this->bigInteger(),
                'last_updated_epoch' => $this->bigInteger(),
                'enumeration_type' => $this->string(),
                'created_epoch' => $this->bigInteger(),
                'status' => $this->string(),
                'credential' => $this->string(),
                'first_name' => $this->string(),
                'last_name' => $this->string(),
                'middle_name' => $this->string(),
                'name' => $this->string(),
                'sole_proprietor' => $this->string(),
                'gender' => $this->string(),
                'last_updated' => $this->string(),
                'name_prefix' => $this->string(),
                'enumeration_date' => $this->string(),
            ]
        );

        $this->createIndex('npi-number-unique', 'npi', 'number', true);
    }

    public function down()
    {
        $this->dropIndex('npi-number-unique', 'npi');
        $this->dropTable('npi');
    }
}