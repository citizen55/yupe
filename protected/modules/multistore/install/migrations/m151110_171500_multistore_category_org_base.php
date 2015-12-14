<?php

class m151110_171500_multistore_category_org_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
         $this->createTable(
            "{{multistore_category_org}}",
            [
                "id" => "pk",
				"org_id" => "integer not null",
                "category_id" =>"integer not null",
            ],
            $this->getOptions()
        );

        //index
        $this->createIndex("ix_{{multistore_category_org}}_org_id", "{{multistore_category_org}}", "org_id", false);
        $this->createIndex("ix_{{multistore_category_org}}_category_id", "{{multistore_category_org}}", "category_id", false);
		//fk
		$this->addForeignKey("fk_{{multistore_category_org}}_org", "{{multistore_category_org}}", "org_id", "{{multistore_org}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{multistore_category_org}}_category", "{{multistore_category_org}}", "category_id", "{{multistore_category}}", "id", "CASCADE", "CASCADE");

    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_type_org}}");
    }
}
