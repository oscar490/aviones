<?php

namespace app\models;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $vuelo_id
 * @property string $asiento
 * @property string $fecha_hora
 *
 * @property Usuarios $usuario
 * @property Vuelos $vuelo
 */
class Reservas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'vuelo_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['asiento'], 'required'],
            [['asiento'], 'number'],
            [['vuelo_id'], function ($attribute, $params, $validator) {
                $vuelo = Vuelos::findOne(['id_vuelo' => $this->$attribute]);
                if ($vuelo !== null) {
                    $this->$attribute = $vuelo->id;

                    if ($vuelo->plazas == 0) {
                        $this->$attribute = $this->getOldAttribute($attribute);
                        $this->addError($attribute, 'No quedan plazas');
                    }
                } else {
                    $this->addError($attribute, 'No existe el vuelo');
                }
            }],
            [['asiento'], function ($attribute, $params, $validator) {
                $reserva = Reservas::findOne([
                    'asiento' => $this->$attribute,
                    'vuelo_id' => $this->vuelo_id,
                ]);
                if ($reserva !== null) {
                    $this->addError($attribute, 'Ese asiento ya está reservado');
                }
            }],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['vuelo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vuelos::className(), 'targetAttribute' => ['vuelo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'vuelo_id' => 'Identificador de vuelo',
            'asiento' => 'Número de asiento',
            'fecha_hora' => 'Fecha de reserva',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVuelo()
    {
        return $this->hasOne(Vuelos::className(), ['id' => 'vuelo_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $vuelo = Vuelos::findOne(['id' => $this->vuelo_id]);
                $vuelo->plazas = $vuelo->plazas - 1;
                $vuelo->save();
            }
            return true;
        }
        return false;
    }
}
