<?php

namespace smart\page\backend\forms;

use Yii;
use smart\base\Form;
use smart\page\models\Page;

class PageForm extends Form
{
    /**
     * @var boolean
     */
    public $active = 1;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $text;

    /**
     * @var integer
     */
    private $_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => Yii::t('page', 'Active'),
            'title' => Yii::t('page', 'Title'),
            'url' => Yii::t('page', 'Friendly URL'),
            'text' => Yii::t('page', 'Text'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['active', 'boolean'],
            ['title', 'string', 'max' => 100],
            ['url', 'string', 'max' => 200],
            ['url', 'match', 'pattern' => '/^[a-z0-9\-_]*$/'],
            ['url', 'unique', 'targetClass' => Page::className(), 'when' => function ($model, $attribute) {
                $object = Page::findOne($this->_id);
                return $object === null || $object->url != $this->url;
            }],
            ['text', 'string'],
            [['title', 'url'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function assignFrom($object)
    {
        $this->active = self::fromBoolean($object->active);
        $this->title = self::fromString($object->title);
        $this->url = self::fromString($object->url);
        $this->text = self::fromHtml($object->text);

        $this->_id = $object->id;

        Yii::$app->storage->cacheObject($object);
    }

    /**
     * @inheritdoc
     */
    public function assignTo($object)
    {
        $object->active = self::toBoolean($this->active);
        $object->title = self::toString($this->title);
        $object->url = self::toString($this->url);
        $object->text = self::toHtml($this->text);

        $object->modifyDate = gmdate('Y-m-d H:i:s');

        Yii::$app->storage->storeObject($object);
    }
}
