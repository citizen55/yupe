<?php

class m150927_200000_multistore_category_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_category}}",
            [
                "id" => "pk",
                "parent_id" => "integer default null",
                "slug" => "varchar(150) not null",		//изменено в m150416_112008_rename_fields
                "name" => "varchar(250) not null",
                "image" => "varchar(250) default null",
                "short_description" => "text",
                "description" => "text",
                "meta_title" => "varchar(250) default null",
                "meta_description" => "varchar(250) default null",
                "meta_keywords" => "varchar(250) default null",
                "status" => "boolean not null default '1'",
				"sort" => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{multistore_category}}_slug", "{{multistore_category}}", "slug", true);
        $this->createIndex("ix_{{multistore_category}}_parent_id", "{{multistore_category}}", "parent_id", false);
        $this->createIndex("ix_{{multistore_category}}_status", "{{multistore_category}}", "status", false);

        //fk
        $this->addForeignKey("fk_{{multistore_category}}_parent", "{{multistore_category}}", "parent_id", "{{multistore_category}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_category}}");
    }
}
