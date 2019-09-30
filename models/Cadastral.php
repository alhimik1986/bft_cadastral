<?php

namespace aalhimik1986\bftcadastral\models;

use Yii;

/**
 * This is the model class for table "cadastral".
 *
 * @property int $id
 * @property string $cadastral_number
 * @property string $address
 * @property string $price
 * @property int $area
 */
class Cadastral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cadastral';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cadastral_number', 'address', 'price', 'area'], 'required'],
            [['price'], 'number'],
            [['area'], 'integer'],
            [['cadastral_number', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cadastral_number' => 'Кадастровый номер',
            'address' => 'Адрес',
            'price' => 'Кадастровая цена (рубли)',
            'area' => 'Площадь (квадратные метры)',
        ];
    }
}
