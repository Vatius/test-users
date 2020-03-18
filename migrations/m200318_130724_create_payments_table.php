<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payments}}`.
 */
class m200318_130724_create_payments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer(),
            'value' => $this->float(),
            
            'created_at' => $this->timestamp()
        ]);

        $this->createIndex(
            'idx-payments-user',
            'payments',
            'user'
        );

        $this->addForeignKey(
            'fk-payments-user',
            'payments',
            'user',
            'users',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-payments-user',
            'payments'
        );

        $this->dropIndex(
            'idx-payments-user',
            'payments'
        );

        $this->dropTable('{{%payments}}');
    }
}
