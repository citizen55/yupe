<?php

class m150928_000013_multistore_product_attribute_eav_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_product_attribute_eav}}",
            [
                "product_id" => "integer not null",
                "attribute" => "varchar(250) not null",
                "value" => "text",
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{multistore_product_attribute_eav}}_product_id", "{{multistore_product_attribute_eav}}", "product_id", false);
        $this->createIndex("ix_{{multistore_product_attribute_eav}}_attribute", "{{multistore_product_attribute_eav}}", "attribute", false);

        //fk
        $this->addForeignKey("fk_{{multistore_product_attribute_eav}}_product", "{{multistore_product_attribute_eav}}", "product_id", "{{multistore_product}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{multistore_product_attribute_eav}}_attribute", "{{multistore_product_attribute_eav}}", "attribute", "{{multistore_attribute}}", "name", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_product_attribute_eav}}");
    }
}
