<?php

class m150927_150000_multistore_attribute_group_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{multistore_attribute_group}}',
            [
                'id' => 'pk',
                'name' => "varchar(255) not null",
                'position' => "integer not null default '1'",
            ],
            $this->getOptions()
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{multistore_attribute_group}}');
    }
}
