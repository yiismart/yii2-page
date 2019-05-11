<?php

namespace smart\page\backend\filters;

use Yii;
use yii\data\ActiveDataProvider;
use smart\base\FilterInterface;
use smart\page\models\Page;

class PageFilter extends Page implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('page', 'Title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getDataProvider($config = [])
    {
        $query = self::find();
        $query->andFilterWhere(['like', 'title', $this->title]);

        $config['query'] = $query;
        return new ActiveDataProvider($config);
    }
}
