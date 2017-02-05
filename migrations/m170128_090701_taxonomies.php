<?php

use yii\db\Migration;

class m170128_090701_taxonomies extends Migration
{
    public function up()
    {
        $this->createTable(
            'taxonomies',
            [
                'id' => $this->primaryKey(),
                'state' => $this->string(),
                'code' => $this->string(),
                'primary' => $this->string(),
                'license' => $this->string(),
                'desc' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
        $this->addForeignKey('fk_taxonomies_npi', 'taxonomies', 'number', 'npi', 'number', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_taxonomies_npi', 'taxonomies');
        $this->dropTable('taxonomies');
    }
}
