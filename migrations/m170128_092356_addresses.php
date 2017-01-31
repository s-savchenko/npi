<?php

use yii\db\Migration;

class m170128_092356_addresses extends Migration
{
    public function up()
    {
        $this->createTable(
            'addresses',
            [
                'id' => $this->primaryKey(),
                'city' => $this->string(),
                'address_2' => $this->string(),
                'telephone_number' => $this->string(),
                'fax_number' => $this->string(),
                'state' => $this->string(),
                'postal_code' => $this->string(),
                'address_1' => $this->string(),
                'country_code' => $this->string(),
                'country_name' => $this->string(),
                'address_type' => $this->string(),
                'address_purpose' => $this->string(),
                'number' => $this->bigInteger()
            ]
        );
    }

    public function down()
    {
        $this->dropTable('addresses');
    }
}
