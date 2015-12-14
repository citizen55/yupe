<?php

class m150928_000020_multistore_product_variant_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_product_variant}}",
            [
                "id" => "pk",
                "product_id" => "integer not null",
                "attribute_id" => "integer not null",
                "attribute_value" => "varchar(255) null default null",
                "amount" => "float null",
                "type" => "tinyint not null",
                "sku" => "varchar(50) null",
				"position" => "integer not null default '1'",
            ],
            $this->getOptions()
        );
        $this->createIndex("idx_{{multistore_product_variant}}_product", "{{multistore_product_variant}}", "product_id");
        $this->createIndex("idx_{{multistore_product_variant}}_attribute", "{{multistore_product_variant}}", "attribute_id");
        $this->createIndex("idx_{{multistore_product_variant}}_value", "{{multistore_product_variant}}", "attribute_value");
        //fk
        $this->addForeignKey("fk_{{multistore_product_variant}}_product", "{{multistore_product_variant}}", "product_id", "{{multistore_product}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{multistore_product_variant}}_attribute", "{{multistore_product_variant}}", "attribute_id", "{{multistore_attribute}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_product_variant}}");
    }
}
