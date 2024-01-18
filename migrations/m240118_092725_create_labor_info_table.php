<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%labor_info}}`.
 */
class m240118_092725_create_labor_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%labor_info}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'service_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-labor_info-service_id',
            '{{%labor_info}}',
            'service_id'
        );

        $this->addForeignKey(
            'fk-labor_info-service_id',
            '{{%labor_info}}',
            'service_id',
            '{{%service_info}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%labor_info}}');
    }
}
