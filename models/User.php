<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
      return [
        [['full_name', 'password', 'username'], 'string'],
        [['birth_date'],'date'],
        [['email'],'email'],
        [['username'],'unique'],
      ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Nome Completo',
            'birth_date' => 'Data de Nascimento',
            'email' => 'E-mail',
            'username' => 'Nome de Usuário',
            'password' => 'Senha',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
      return User::find()->where(['email' => $email])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        // return $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
      return Yii::$app->getSecurity()
      ->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
      if (parent::beforeSave($insert)) {
        $this->password = Yii::$app->getSecurity()
        ->generatePasswordHash($this->password);
        return true;
      } else {
        return false;
      }
    }


}
