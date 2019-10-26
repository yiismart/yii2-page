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
    public $alias;

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
            'alias' => Yii::t('page', 'Friendly URL'),
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
            ['alias', 'string', 'max' => 200],
            ['alias', 'match', 'pattern' => '/^[a-z0-9\-_]*$/'],
            ['alias', 'unique', 'targetClass' => Page::className(), 'when' => function ($model, $attribute) {
                $object = Page::findOne($this->_id);
                return $object === null || $object->alias != $this->alias;
            }],
            ['text', 'string'],
            [['title', 'alias'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function map()
    {
        return [
            ['active', 'boolean'],
            [['title', 'alias'], 'string'],
            ['text', 'html'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function assignFrom($object, $attributeNames = null)
    {
        parent::assignFrom($object, $attributeNames);

        $this->_id = $object->id;
    }

    /**
     * @inheritdoc
     */
    public function assignTo($object, $attributeNames = null)
    {
        parent::assignTo($object, $attributeNames);

        $object->modifyDate = gmdate('Y-m-d H:i:s');
    }
}
