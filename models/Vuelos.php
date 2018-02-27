<?php

namespace app\models;

/**
 * This is the model class for table "vuelos".
 *
 * @property int $id
 * @property string $id_vuelo
 * @property int $origen_id
 * @property int $destino_id
 * @property int $comp_id
 * @property string $salida
 * @property string $llegada
 * @property string $plazas
 * @property string $precio
 *
 * @property Reservas[] $reservas
 * @property Aeropuertos $origen
 * @property Aeropuertos $destino
 * @property Companias $comp
 */
class Vuelos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vuelos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vuelo', 'salida', 'llegada', 'plazas', 'precio'], 'required'],
            [['origen_id', 'destino_id', 'comp_id'], 'default', 'value' => null],
            [['origen_id', 'destino_id', 'comp_id'], 'integer'],
            [['salida', 'llegada'], 'safe'],
            [['plazas', 'precio'], 'number'],
            [['id_vuelo'], 'string', 'max' => 6],
            [['id_vuelo'], 'unique'],
            [['origen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aeropuertos::className(), 'targetAttribute' => ['origen_id' => 'id']],
            [['destino_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aeropuertos::className(), 'targetAttribute' => ['destino_id' => 'id']],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companias::className(), 'targetAttribute' => ['comp_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vuelo' => 'Iden. Vuelo',
            'origen_id' => 'Origen ID',
            'destino_id' => 'Destino ID',
            'comp_id' => 'Comp ID',
            'salida' => 'Salida',
            'llegada' => 'Llegada',
            'plazas' => 'Número de plazas',
            'precio' => 'Precio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::className(), ['vuelo_id' => 'id'])->inverseOf('vuelo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrigen()
    {
        return $this->hasOne(Aeropuertos::className(), ['id' => 'origen_id'])->inverseOf('vuelos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestino()
    {
        return $this->hasOne(Aeropuertos::className(), ['id' => 'destino_id'])->inverseOf('vuelos0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(Companias::className(), ['id' => 'comp_id'])->inverseOf('vuelos');
    }
}
