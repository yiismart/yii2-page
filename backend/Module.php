<?php

namespace smart\page\backend;

use Yii;
use yii\helpers\Html;
use smart\base\BackendModule;

class Module extends BackendModule
{

    /**
     * @var integer|null max page count. If set to null, there are no limit to count of pages. 
     */
    public $maxCount;

    /**
     * @inheritdoc
     */
    public static function security()
    {
        $auth = Yii::$app->getAuthManager();
        if ($auth->getRole('Page') === null) {
            $role = $auth->createRole('Page');
            $auth->add($role);
        }
    }

    /**
     * @inheritdoc
     */
    public function menu(&$items)
    {
        if (!Yii::$app->user->can('Page')) {
            return;
        }

        $items['page'] = [
            'label' => '<i class="fas fa-globe"></i> ' . Html::encode(Yii::t('page', 'Pages')),
            'encode' => false,
            'url' => ['/page/page/index'],
        ];
    }

}
