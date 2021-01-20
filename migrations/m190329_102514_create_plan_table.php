<?php

use yii\db\Migration;

class m190329_102514_create_plan_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%plan}}', [
            'id' => $this->primaryKey(),
            'stripe_id' => $this->string(25)->notNull(),
            'name' => $this->string(50)->notNull(),
            'interval' => $this->string(25)->notNull(),
            'amount' => $this->integer()->notNull(),
            'currency' => $this->string(5)->notNull()->defaultValue('USD'),
            'product_name' => $this->string(50)->notNull(),
            'created_at' => $this->timestamp(),
        ], $tableOptions);

        $this->batchInsert('{{%plan}}', ['stripe_id', 'name', 'product_name', 'interval', 'amount'], [
            ['basic', 'Basic Plan', 'SocialMediaAudit', 'month', 3900],
            ['advanced', 'Advanced Plan', 'SocialMediaAudit', 'month', 7900],
        ]);

        $this->addForeignKey('fk_user_plan', '{{%user}}', 'plan_id', '{{%plan}}', 'id', 'SET NULL', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_plan', '{{%user}}');
        $this->dropTable('{{%plan}}');
    }
}
