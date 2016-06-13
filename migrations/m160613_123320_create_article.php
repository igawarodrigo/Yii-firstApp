<?php

use yii\db\Migration;

/**
 * Handles the creation for table `article`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m160613_123320_create_article extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'title' => $this->string(250)->notNull(),
            'content' => $this->text()->notNull(),
            'written_on' => $this->date(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-article-author_id',
            'article',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-article-author_id',
            'article',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-article-author_id',
            'article'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-article-author_id',
            'article'
        );

        $this->dropTable('article');
    }
}
