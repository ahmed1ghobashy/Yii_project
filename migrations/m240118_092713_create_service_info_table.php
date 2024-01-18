<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_info}}`.
 */
class m240118_092713_create_service_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_info}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price' =>$this->integer(),
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_info}}');
    }
}
