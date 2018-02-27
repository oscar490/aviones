<?php

namespace app\models;

/**
 * This is the model class for table "aeropuertos".
 *
 * @property int $id
 * @property string $id_aero
 * @property string $den_aero
 *
 * @property Vuelos[] $vuelos
 * @property Vuelos[] $vuelos0
 */
class Aeropuertos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aeropuertos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_aero', 'den_aero'], 'required'],
            [['id_aero'], 'string', 'max' => 3],
            [['den_aero'], 'string', 'max' => 255],
            [['id_aero'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_aero' => 'Id Aero',
            'den_aero' => 'Aeropuerto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVuelos()
    {
        return $this->hasMany(Vuelos::className(), ['origen_id' => 'id'])->inverseOf('origen');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVuelos0()
    {
        return $this->hasMany(Vuelos::className(), ['destino_id' => 'id'])->inverseOf('destino');
    }
}
