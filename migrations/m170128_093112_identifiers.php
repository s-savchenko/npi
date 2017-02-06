<?php

use yii\db\Migration;

class m170128_093112_identifiers extends Migration
{
    public function up()
    {
        $this->createTable(
            'identifiers',
            [
                'id' => $this->primaryKey(),
                'code' => $this->string(),
                'issuer' => $this->string(),
                'state' => $this->string(),
                'identifier' => $this->string(),
                'desc' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
        $this->addForeignKey('fk_identifiers_npi', 'identifiers', 'number', 'npi', 'number', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_identifiers_npi', 'identifiers');
        $this->dropTable('identifiers');
    }
}
