<?php

class m150928_000000_multistore_product_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_product}}",
            [
                "id" => "pk",
                "type_id" => "integer default null",
                "producer_id" => "integer default null",
				"category_id" => "integer default null", // добалено с 141014_210000
				"org_id" => "integer not null",			//владелец товара
                "sku" => "varchar(100) default null",
                "name" => "varchar(250) not null",
                "slug" => "varchar(150) not null",				// изменено в m150416_112008_rename_fields
                "price" => "decimal(19,3) not null default '0'",
                "discount_price" => "decimal(19,3) default null", // m141218_091834_default_null
                "discount" => "decimal(19,3) default null",		// m141218_091834_default_null
                "description" => "text",
                "short_description" => "text",
                "data" => "text",
                "is_special" => "boolean not null default '0'",
                "length" => "decimal(19,3) null",
                "width" => "decimal(19,3) null",
                "height" => "decimal(19,3) null",
                "weight" => "decimal(19,3) null",
                "quantity" => "int(11) null",
                "in_stock" => "tinyint not null default '1'",
                "status" => "tinyint not null default '1'",
                "create_time" => "datetime not null",
                "update_time" => "datetime not null",
                "meta_title" => "varchar(250) default null",
                "meta_keywords" => "varchar(250) default null",
                "meta_description" => "varchar(250) default null",
				"image" => "varchar(250) default null",				// m141015_170000_store_product_image_column
				"average_price" => "decimal(19,3) default null",	// m150210_105811_add_price_column
				"purchase_price" => "decimal(19,3) default null",	// m150210_105811_add_price_column
				"recommended_price" => "decimal(19,3) default null",	// m150210_105811_add_price_column
				"position" => "integer not null default '1'",		// m150226_065935_add_product_position
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{multistore_product}}_slug", "{{multistore_product}}", "slug", true);
        $this->createIndex("ix_{{multistore_product}}_status", "{{multistore_product}}", "status", false);
        $this->createIndex("ix_{{multistore_product}}_type_id", "{{multistore_product}}", "type_id", false);
        $this->createIndex("ix_{{multistore_product}}_producer_id", "{{multistore_product}}", "producer_id", false);
		$this->createIndex("ix_{{multistore_product}}_category_id", "{{multistore_product}}", "category_id", false); // добавил индехс 28 09 15
		$this->createIndex("ix_{{multistore_product}}_org_id", "{{multistore_product}}", "org_id", false);
        $this->createIndex("ix_{{multistore_product}}_price", "{{multistore_product}}", "price", false);
        $this->createIndex("ix_{{multistore_product}}_discount_price", "{{multistore_product}}", "discount_price", false);
        $this->createIndex("ix_{{multistore_product}}_create_time", "{{multistore_product}}", "create_time", false);
        $this->createIndex("ix_{{multistore_product}}_update_time", "{{multistore_product}}", "update_time", false);

        //fk
        $this->addForeignKey("fk_{{multistore_product}}_type", "{{multistore_product}}", "type_id", "{{multistore_type}}", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_{{multistore_product}}_producer", "{{multistore_product}}", "producer_id", "{{multistore_producer}}", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_{{multistore_product}}_category", "{{multistore_product}}", "category_id", "{{multistore_category}}", "id", "SET NULL", "CASCADE");
		$this->addForeignKey("fk_{{multistore_product}}_org", "{{multistore_product}}", "org_id", "{{multistore_org}}", "id", "RESTRICT", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_product}}");
    }
}
