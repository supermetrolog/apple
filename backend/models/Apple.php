<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property int|null $color
 * @property int $status
 * @property int $eaten
 * @property string|null $created_at
 * @property string|null $drop_at
 */
class Apple extends \yii\db\ActiveRecord
{
    private const MIN_APPLES_COLOR_NUMBER = 0;
    private const MAX_APPLES_COLOR_NUMBER = 2;
    private const COLOR_RED = 0;
    private const COLOR_YELLOW = 1;
    private const COLOR_GREEN = 2;
    private const COLOR_SPOILED = 3;
    private const STATUS_ON_THE_TREE = 0;
    private const STATUS_ON_THE_GROUND = 1;
    private const STATUS_SPOILED = 2;
    private const MIN_EATEN = 0;
    private const MAX_EATEN = 100;
    private const MAX_SPOILED_TIME = 5;
    private const MIN_APPLES_COUNT = 5;
    private const MAX_APPLES_COUNT = 12;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'status', 'eaten'], 'integer'],
            [['created_at', 'drop_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'status' => 'Status',
            'eaten' => 'Eaten',
            'created_at' => 'Created At',
            'drop_at' => 'Drop At',
        ];
    }
    public static function CHECK_SPOILED()
    {
        $apples = self::findAll(['status' => self::STATUS_ON_THE_GROUND]);
        foreach ($apples as $apple) {
            $diff = round((time() - strtotime($apple->drop_at)) / 60 / 60, 1);
            // var_dump($diff);
            if ($diff >= self::MAX_SPOILED_TIME) {
                $apple->status = self::STATUS_SPOILED;
                $apple->color = self::COLOR_SPOILED;
                $apple->save();
            }
        }
    }
    public function getRandomCount()
    {
        return rand(self::MIN_APPLES_COUNT, self::MAX_APPLES_COUNT);
    }
    public function getRandomColor()
    {
        return rand(self::MIN_APPLES_COLOR_NUMBER, self::MAX_APPLES_COLOR_NUMBER);
    }
    public function generateApples()
    {
        $this->deleteAll();
        $count = $this->getRandomCount();

        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            $apple->color = $this->getRandomColor();
            $apple->save();
        }

        return true;
    }
    public function getEatenPercent()
    {
        if ($this->eaten > self::MIN_EATEN) {
            return self::MAX_EATEN - $this->eaten;
        }
        return self::MAX_EATEN;
    }
    public static function getColorList()
    {
        return [
            self::COLOR_RED => 'color-red',
            self::COLOR_YELLOW => 'color-yellow',
            self::COLOR_GREEN => 'color-green',
            self::COLOR_SPOILED => 'color-spoiled',
        ];
    }
    public function getColorClass()
    {
        $colorList = self::getColorList();
        return $colorList[$this->color];
    }
    public function drop()
    {
        if (!$this->status == self::STATUS_ON_THE_TREE) {
            return $this->addError('error', 'Нельзя съесть это яблоко!');
        }
        $this->status = self::STATUS_ON_THE_GROUND;
        $this->drop_at = date('Y-m-d H:i:s');
        return $this->save();
    }
    public function eat($eaten)
    {
        if (!$this->status == self::STATUS_ON_THE_GROUND || $this->status == self::STATUS_SPOILED) {
            return $this->addError('error', 'Нельзя съесть это яблоко!');
        }
        $this->eaten += $eaten;
        if ($this->eaten >= self::MAX_EATEN) {
            return $this->delete();
        }
        return $this->save();
    }
}
