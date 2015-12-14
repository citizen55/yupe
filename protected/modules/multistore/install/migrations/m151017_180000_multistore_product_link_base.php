<?php

class m151017_180000_multistore_product_link_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            '{{multistore_product_link_type}}',
            [
                'id' => 'pk',
                'code' => 'string not null',
                'title' => 'string not null',
            ],
            $this->getOptions()
        );

        $this->createIndex('ux_{{multistore_product_link_type}}_code', '{{multistore_product_link_type}}', 'code', true);
        $this->createIndex('ux_{{multistore_product_link_type}}_title', '{{multistore_product_link_type}}', 'title', true);

        $this->insert('{{multistore_product_link_type}}', ['code' => 'similar', 'title' => 'Похожие']);
        $this->insert('{{multistore_product_link_type}}', ['code' => 'related', 'title' => 'Сопутствующие']);

        $this->createTable(
            '{{multistore_product_link}}',
            [
                'id' => 'pk',
                'type_id' => 'int null',
                'product_id' => 'int not null',
                'linked_product_id' => 'int not null',
            ],
            $this->getOptions()
        );

        $this->createIndex('ux_{{multistore_product_link}}_product', '{{multistore_product_link}}', ['product_id', 'linked_product_id'], true);

        $this->addForeignKey('fk_{{multistore_product_link}}_product', '{{multistore_product_link}}', 'product_id', '{{multistore_product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_{{multistore_product_link}}_linked_product', '{{multistore_product_link}}', 'linked_product_id', '{{multistore_product}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_{{multistore_product_link}}_type', '{{multistore_product_link}}', 'type_id', '{{multistore_product_link_type}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{multistore_product_link_type}}');
        $this->dropTable('{{multistore_product_link}}');
    }
}
