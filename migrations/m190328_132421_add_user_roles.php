<?php

use yii\db\Migration;

class m190328_132421_add_user_roles extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%auth_item}}', ['name', 'type', 'description'], [
            ['freePlan', 1, 'PDF Free Plan']
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%auth_item}}', ['name' => 'freePlan']);
    }
}
