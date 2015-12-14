<?php

class m150927_180000_multistore_attribute_option_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_attribute_option}}",
            [
                "id" => "pk",
                "attribute_id" => "int(11) null default null",
                "position" => "tinyint(4) null default null",
                "value" => "varchar(255) null default ''",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{multistore_attribute_option}}_attribute_id", "{{multistore_attribute_option}}", "attribute_id", false);
        $this->createIndex("ix_{{multistore_attribute_option}}_position", "{{multistore_attribute_option}}", "position", false);

        //fk
        $this->addForeignKey("fk_{{multistore_attribute_option}}_attribute", "{{multistore_attribute_option}}", "attribute_id", "{{multistore_attribute}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_attribute_option}}");
    }
}
