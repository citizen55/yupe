<?php

class m150928_000018_multistore_product_image_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_product_image}}",
            [
                "id" => "pk",
                "product_id" => "integer not null",
                "name" => "varchar(250) not null",
                "title" => "varchar(250) null",
               // "is_main" => "boolean not null default '0'", изменения m141015_170000_store_product_image_column от 28 09 15
            ],
            $this->getOptions()
        );

        //fk
        $this->addForeignKey("fk_{{multistore_product_image}}_product", "{{multistore_product_image}}", "product_id", "{{multistore_product}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_product_image}}");
    }
}
