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
            [['asiento'], function ($attribute, $params, $validator) {
                $reserva = Reservas::find()
                    ->where([
                        'vuelo_id' => $this->vuelo_id,
                        'asiento' => $this->asiento,
                        'usuario_id' => $this->usuario_id,
                    ])->one();

                $vuelo = Vuelos::find()
                    ->where(['id' => $this->vuelo_id])
                    ->one();

                if ($reserva !== null) {
                    $this->addError($attribute, 'Ese asiento está ocupado');
                }
                if ($vuelo->plazas == 0 || $this->asiento > $vuelo->plazas) {
                    $this->addError($attribute, 'No hay plazas');
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

    public function formName()
    {
        return '';
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
