<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teste".
 *
 * @property integer $id
 * @property string $teste
 */
class Teste extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teste';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teste'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teste' => 'Teste',
        ];
    }
}
