<?php

use yii\db\Migration;

/**
 * Class m190723_130025_delete_stripe_credit_card_id
 */
class m190723_130025_delete_stripe_credit_card_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user}}', 'stripe_credit_card_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user}}', 'stripe_credit_card_id', $this->string(50)->defaultValue(null));
    }
}
