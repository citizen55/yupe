<?php

class m150927_210000_multistore_type_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_type}}",
            [
                "id" => "pk",
                "name" => "varchar(255) not null",
                "main_category_id" => "int(11) null default null",
                "categories" => "text null default null",
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{multistore_type}}_name", "{{multistore_type}}", "name", true);

        $this->addForeignKey("fk_{{multistore_type}}_main_category", "{{multistore_type}}", "main_category_id", "{{multistore_category}}", "id", "SET NULL", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_type}}");
    }
}
