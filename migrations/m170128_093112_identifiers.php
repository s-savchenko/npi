<?php

use yii\db\Migration;

class m170128_093112_identifiers extends Migration
{
    public function up()
    {
        $this->createTable(
            'identifiers',
            [
                'code' => $this->string(),
                'issuer' => $this->string(),
                'state' => $this->string(),
                'identifier' => $this->string(),
                'desc' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
    }

    public function down()
    {
        $this->dropTable('identifiers');
    }
}
