<?php

class m150927_150010_multistore_attribute_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_attribute}}",
            [
                "id" => "pk",
                "group_id" => "integer null",
                "name" => "varchar(250) not null",
                "title" => "varchar(250) default null",
                "type" => "tinyint(4) null default null",
                "unit" => "varchar(30) null",
                "required" => "boolean not null default '0'",
            ],
            $this->getOptions()
        );

        //index
        $this->createIndex("ux_{{multistore_attribute}}_name_group", "{{multistore_attribute}}", "name, group_id", true);
        $this->createIndex("ix_{{multistore_attribute}}_title", "{{multistore_attribute}}", "title", false);

        //fk
        $this->addForeignKey("fk_{{multistore_attribute}}_group", "{{multistore_attribute}}", "group_id", "{{multistore_attribute_group}}", "id", "CASCADE", "CASCADE");

    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_attribute}}");
    }
}
