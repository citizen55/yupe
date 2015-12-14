<?php

class m150928_000010_multistore_product_category_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_product_category}}",
            [
                "id" => "pk",
                "product_id" => "integer",
                "category_id" => "integer",
               // "is_main" => "boolean NOT NULL DEFAULT '0'", обновление 141014_210000
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{multistore_product_category}}_product_id", "{{multistore_product_category}}", "product_id", false);
        $this->createIndex("ix_{{multistore_product_category}}_category_id", "{{multistore_product_category}}", "category_id", false);
        //$this->createIndex("ix_{{multistore_product_category}}_is_main", "{{multistore_product_category}}", "is_main", false);

        //fk
        $this->addForeignKey("fk_{{multistore_product_category}}_product", "{{multistore_product_category}}", "product_id", "{{multistore_product}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{multistore_product_category}}_category", "{{multistore_product_category}}", "category_id", "{{multistore_category}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_product_category}}");
    }
}
