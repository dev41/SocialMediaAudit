<?php

use yii\db\Migration;

class m190326_124807_user__change_columns extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'token', $this->string(150)->null());
        $this->addColumn('{{%user}}', 'stripe_customer_id', $this->string(30)->null());
        $this->addColumn('{{%user}}', 'stripe_subscription_id', $this->string(30)->null());
        $this->addColumn('{{%user}}', 'first_name', $this->string(128)->notNull());
        $this->addColumn('{{%user}}', 'last_name', $this->string(128)->notNull());
        $this->addColumn('{{%user}}', 'tc_accept', $this->smallInteger(1)->notNull()->defaultValue(0));
        $this->addColumn('{{%user}}', 'plan_id', $this->integer()->defaultValue(null));
        $this->addColumn('{{%user}}', 'stripe_credit_card_id', $this->string(50)->defaultValue(null));
    }

    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'token', $this->string(150)->notNull());
        $this->dropColumn('{{%user}}', 'stripe_customer_id');
        $this->dropColumn('{{%user}}', 'stripe_subscription_id');
        $this->dropColumn('{{%user}}', 'first_name');
        $this->dropColumn('{{%user}}', 'last_name');
        $this->dropColumn('{{%user}}', 'tc_accept');
        $this->dropColumn('{{%user}}', 'plan_id');
        $this->dropColumn('{{%user}}', 'stripe_credit_card_id');
    }
}