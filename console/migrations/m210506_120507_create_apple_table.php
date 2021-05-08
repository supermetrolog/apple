<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m210506_120507_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->smallInteger()->notNull()->defaultValue(null),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'eaten' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'drop_at' => $this->timestamp()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}
