<?php

use Phinx\Migration\AbstractMigration;

class InitDb extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->query("CREATE TABLE `suggestions_types` (
                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                      `type` varchar(32) NOT NULL DEFAULT '',
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `type` (`type`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->query("CREATE TABLE `suggestions` (
                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                      `type_id` int(11) unsigned NOT NULL DEFAULT '0',
                      `content` text,
                      `created_at` datetime NOT NULL,
                      `updated_at` datetime NOT NULL,
                      PRIMARY KEY (`id`),
                      KEY `type_id` (`type_id`),
                      CONSTRAINT `suggestions_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `suggestions_types` (`id`) ON DELETE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->query("DROP TABLE `suggestions`");
        $this->query("DROP TABLE `suggestions_types`");
    }
}