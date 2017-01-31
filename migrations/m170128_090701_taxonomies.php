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
                'primary' => $this->boolean(),
                'license' => $this->string(),
                'desc' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
    }

    public function down()
    {
        $this->dropTable('taxonomies');
    }
}
