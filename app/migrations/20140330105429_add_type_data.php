<?php

use Phinx\Migration\AbstractMigration;

class AddTypeData extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute("INSERT INTO suggestions_types (type) VALUES ('text');");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute("DELETE FROM suggestions_types WHERE type='text';");
    }
}