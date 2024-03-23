<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $photo_to
 * @property int|null $status
 * @property string $datetime
 * @property string|null $description_denied
 * @property string|null $photo_after
 *
 * @property Category $category
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'user_id', 'status'], 'integer'],
            [['description', 'description_denied'], 'string'],
            [['datetime'], 'safe'],
            [['name', 'photo_to', 'photo_after'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['user_id', 'default', 'value' => Yii::$app->user->identity->getId()],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10*1024*1024],
            [['description_denied'], 'required', 'on' => 'cancel'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Название категории',
            'user_id' => 'Имя пользователя',
            'name' => 'Название заявки',
            'description' => 'Описание',
            'photo_to' => 'Фото до',
            'status' => 'Статус',
            'datetime' => 'Дата подачи',
            'description_denied' => 'Причина отказа',
            'photo_after' => 'Фото после',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function upload()
    {
        if ($this->validate()) {
            $rand  = Yii::$app->security->generateRandomString(8);
            $file_name = 'uploads/' . $this->imageFile->baseName . $rand . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($file_name);
            $this->photo_to = 'web/' . $file_name;
            return true;
        } else {
            return false;
        }
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['cancel'] = ['description_denied', 'status'];
        $scenarios['success'] = ['imageFile', 'status'];
        return $scenarios;
    }

    public function cancel()
    {
        $this->status = 2;
        if ($this->save()){
            return true;
        }
        return false;
    }
    public function success()
    {
        $this->status = 1;
        if ($this->validate()) {
            $rand  = Yii::$app->security->generateRandomString(8);
            $file_name = 'uploads/' . $this->imageFile->baseName . $rand . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($file_name);
            $this->photo_after = 'web/' . $file_name;
            if ($this->save(false)){
                return true;
            }
        } else {
            return false;
        }
    }
}
