<?php

class m151110_133000_multistore_org_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{multistore_org}}",
            [
                "id" => "pk",
				"slug" => "varchar(150) not null",
                "name" => "varchar(250) not null",
                "image" => "varchar(250) default null",
				"user_id" => "integer not null",
				"type_id" => "integer not null",
				"phone_1" => "integer(11) default null",
				"phone_2" => "integer(11) default null",
				"fax" => "integer(11) default null",
				"location" => "varchar(250) default null",
            ],
            $this->getOptions()
        );

        //index
        $this->createIndex("ux_{{multistore_org}}_slug", "{{multistore_org}}", "slug", true);
		//@todo: this change isn't write эти индексы не записаны в базу данных
		$this->createIndex("ix_{{multistore_org}}_user", "{{multistore_org}}", "user_id", true);
		$this->createIndex("ix_{{multistore_org}}_type", "{{multistore_org}}", "type_id", true);

        //fk
        $this->addForeignKey("fk_{{multistore_org}}_user", "{{multistore_org}}", "user_id", "{{user_user}}", "id");
		$this->addForeignKey("fk_{{multistore_org}}_typeorg", "{{multistore_org}}", "type_id", "{{multistore_type_org}}", "id");
    }

    public function safeDown()
    {
        $this->dropTable("{{multistore_org}}");
    }
}
