<?php

use yii\db\Migration;

class m261029_153306_historial_componentes extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%diagnostico_componente}}', [
            'id' => $this->primaryKey(),
            'diagnostico_id' => $this->integer()->notNull(),
            'componente_id' => $this->integer()->null(),

            // Copia histórica de los datos del componente
            'tipo' => $this->string(40)->notNull(),
            'marca' => $this->string(100)->null(),
            'modelo' => $this->string(100)->null(),
            'numero_serie' => $this->string(100)->null(),
            'capacidad' => $this->string(50)->null(),
            'estado' => $this->string(30)->notNull(),
            'observaciones' => $this->text()->null(),
        ]);

        $this->createIndex(
            'idx-diagnostico_componente-diagnostico_id',
            '{{%diagnostico_componente}}',
            'diagnostico_id'
        );

        $this->createIndex(
            'idx-diagnostico_componente-componente_id',
            '{{%diagnostico_componente}}',
            'componente_id'
        );

        $this->addForeignKey(
            'fk-diagnostico_componente-diagnostico_id',
            '{{%diagnostico_componente}}',
            'diagnostico_id',
            '{{%diagnostico}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-diagnostico_componente-componente_id',
            '{{%diagnostico_componente}}',
            'componente_id',
            '{{%componente}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-diagnostico_componente-componente_id',
            '{{%diagnostico_componente}}'
        );

        $this->dropForeignKey(
            'fk-diagnostico_componente-diagnostico_id',
            '{{%diagnostico_componente}}'
        );

        $this->dropTable('{{%diagnostico_componente}}');
    }
}
