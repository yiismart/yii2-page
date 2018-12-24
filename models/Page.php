<?php

namespace smart\page\models;

use yii\db\ActiveRecord;
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
     * Find page by alias
     * @param sring $alias page alias or id
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
        return $this->getFilesFromContent($this->getOldAttribute('content'));
    }

    /**
     * @inheritdoc
     */
    public function getFiles()
    {
        return $this->getFilesFromContent($this->content);
    }

    /**
     * @inheritdoc
     */
    public function setFiles($files)
    {
        $content = $this->content;
        foreach ($files as $from => $to) {
            $content = str_replace($from, $to, $content);
        }

        $this->content = $content;
    }

}
