<?php

namespace smart\page\models;

use smart\seo\db\Entity;
use smart\storage\components\StoredInterface;

class Page extends Entity implements StoredInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * Find page by friendly URL
     * @param sring $url page friendly URL or id
     * @return Page
     */
    public static function findByAlias($url)
    {
        $object = static::findOne(['url' => $url]);
        if ($object === null) {
            $object = static::findOne(['id' => $url]);
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
