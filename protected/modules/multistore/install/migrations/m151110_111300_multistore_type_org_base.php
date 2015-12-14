<?php
// таблица типов организации, например
class m151110_111300_multistore_type_org_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
         $this->createTable(
            "{{multistore_type_org}}",
            [
                "id" => "pk",
                "parent_id" => "integer default null",
                "slug" => "varchar(150) not null",		
                "name" => "varchar(250) not null",
                "image" => "varchar(250) default null",
                "meta_title" => "varchar(250) default null",
                "meta_description" => "varchar(250) default null",
                "meta_keywords" => "varchar(250) default null",
                "status" => "boolean not null default '1'",
				"sort" => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //index
        $this->createIndex("ux_{{multistore_type_org}}_slug", "{{multistore_type_org}}", "slug", true);
		$this->createIndex("ix_{{multistore_type_org}}_parent_id", "{{multistore_type_org}}", "parent_id", false);
        $this->createIndex("ix_{{multistore_type_org}}_status", "{{multistore_type_org}}", "status", false);
		
		//fk
		$this->addForeignKey("fk_{{multistore_type_org}}_parent", "{{multistore_type_org}}", "parent_id", "{{multistore_type_org}}", "id", "CASCADE", "CASCADE");

    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_type_org}}");
    }
}
