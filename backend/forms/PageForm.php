<?php

namespace smart\page\backend\forms;

use Yii;
use yii\helpers\HtmlPurifier;
use smart\base\Form;

class PageForm extends Form
{

    /**
     * @var boolean
     */
    public $active = true;

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
    public $content;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => Yii::t('page', 'Active'),
            'title' => Yii::t('page', 'Title'),
            'alias' => Yii::t('page', 'Alias'),
            'content' => Yii::t('page', 'Content'),
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
            ['content', 'string'],
            ['title', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function assignFrom($object)
    {
        $this->active = $object->active == 0 ? '0' : '1';
        $this->title = $object->title;
        $this->alias = $object->alias;
        $this->content = $object->content;

        Yii::$app->storage->cacheObject($object);
    }

    /**
     * @inheritdoc
     */
    public function assignTo($object)
    {
        $object->active = $this->active == 1;
        $object->title = $this->title;
        $object->alias = $this->alias;
        $object->modifyDate = gmdate('Y-m-d H:i:s');
        $object->content = HtmlPurifier::process($this->content, function($config) {
            $config->set('Attr.EnableID', true);
            $config->set('HTML.SafeIframe', true);
            $config->set('URI.SafeIframeRegexp', '%^(?:https?:)?//(?:www.youtube.com/embed/|player.vimeo.com/video/|yandex.ru/map-widget/)%');
        });

        Yii::$app->storage->storeObject($object);
    }

}
