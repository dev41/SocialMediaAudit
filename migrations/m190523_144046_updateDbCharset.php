<?php

use yii\db\Migration;

/**
 * Class m190523_144046_updateDbCharset
 */
class m190523_144046_updateDbCharset extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // DB
        $database = Yii::$app->db->createCommand("SELECT DATABASE()")->queryScalar();

        $this->execute("
        SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
        START TRANSACTION;
        
        ALTER DATABASE $database CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        
        ALTER TABLE `ca_auth_assignment`
        DROP FOREIGN KEY `ca_auth_assignment_ibfk_1`;
        
        ALTER TABLE `ca_auth_item`
        DROP FOREIGN KEY `ca_auth_item_ibfk_1`;
        
        ALTER TABLE `ca_auth_item_child`
        DROP FOREIGN KEY `ca_auth_item_child_ibfk_1`,
        DROP FOREIGN KEY `ca_auth_item_child_ibfk_2`;
        
        ALTER TABLE `ca_check`
        DROP FOREIGN KEY `fk-check-wid`;
        
        ALTER TABLE `ca_user`
        DROP INDEX `idx-user-access_token`;

        ALTER TABLE ca_agency_audits CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_agency_leads CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_agency_profile CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_auth_rule CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_auth_item CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_auth_item_child CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_auth_assignment CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_check CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_migration CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_queue CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_user CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        ALTER TABLE ca_website CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
        
        ALTER TABLE `ca_auth_assignment`
        ADD CONSTRAINT `ca_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ca_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
        
        ALTER TABLE `ca_auth_item`
        ADD CONSTRAINT `ca_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ca_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;
        
        ALTER TABLE `ca_auth_item_child`
        ADD CONSTRAINT `ca_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ca_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT `ca_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ca_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
        
        ALTER TABLE `ca_check`
        ADD CONSTRAINT `fk-check-wid` FOREIGN KEY (`wid`) REFERENCES `ca_website` (`id`) ON DELETE CASCADE;
        COMMIT;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190523_144046_updateDbCharset cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_144046_updateDbCharset cannot be reverted.\n";

        return false;
    }
    */
}
