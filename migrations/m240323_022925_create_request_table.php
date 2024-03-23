<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category}}`
 * - `{{%user}}`
 */
class m240323_022925_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'description' => $this->text(),
            'photo_to' => $this->string(),
            'status' => $this->integer()->defaultValue(0),
            'datetime' => $this->timestamp(),
            'description_denied' => $this->text(),
            'photo_after' => $this->string(),
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-request-category_id}}',
            '{{%request}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-request-category_id}}',
            '{{%request}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-request-user_id}}',
            '{{%request}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-request-category_id}}',
            '{{%request}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-request-category_id}}',
            '{{%request}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-request-user_id}}',
            '{{%request}}'
        );

        $this->dropTable('{{%request}}');
    }
}
