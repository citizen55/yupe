<?php

class m150927_220000_multistore_type_attribute_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_type_attribute}}",
            [
                "type_id" => "int(11) not null",
                "attribute_id" => "int(11) not null",
            ],
            $this->getOptions()
        );
        $this->addPrimaryKey("pk_{{multistore_type_attribute}}", "{{multistore_type_attribute}}", "type_id, attribute_id");

        $this->addForeignKey("fk_{{multistore_type_attribute}}_type", "{{multistore_type_attribute}}", "type_id", "{{multistore_type}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_type_attribute}}");
    }
}
