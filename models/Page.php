<?php

namespace smart\page\models;

use yii\helpers\Url;
use smart\db\ActiveRecord;
use smart\sitemap\behaviors\SitemapBehavior;
use smart\storage\components\StoredInterface;

class Page extends ActiveRecord implements StoredInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'sitemap' => [
                'class' => SitemapBehavior::className(),
                'loc' => function($model) {
                    return Url::toRoute(['/page/page/index', 'alias' => $model->alias]);
                },
            ],
        ];
    }

    /**
     * Find page by friendly URL
     * @param sring $alias page friendly URL or id
     * @return Page
     */
    public static function findByAlias($alias)
    {
        $object = static::findOne(['alias' => $alias]);
        if ($object === null) {
            $object = static::findOne(['id' => $alias]);
        }

        return $object;
    }

    /**
     * Parsing html for files in <img> and <a>.
     * @param string $content 
     * @return string[]
     */
    protected function getFilesFromContent($content)
    {
        if (preg_match_all('/(?:src|href)="([^"]+)"/i', $content, $matches)) {
            return $matches[1];
        }

        return [];      
    }

    /**
     * @inheritdoc
     */
    public function getOldFiles()
    {
        return $this->getFilesFromContent($this->getOldAttribute('text'));
    }

    /**
     * @inheritdoc
     */
    public function getFiles()
    {
        return $this->getFilesFromContent($this->getAttribute('text'));
    }

    /**
     * @inheritdoc
     */
    public function setFiles($files)
    {
        $content = $this->text;
        foreach ($files as $from => $to) {
            $content = str_replace($from, $to, $content);
        }

        $this->text = $content;
    }
}
