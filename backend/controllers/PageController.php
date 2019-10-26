<?php

namespace smart\page\backend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use dkhlystov\helpers\Translit;
use smart\base\BackendController;
use smart\imperavi\ImperaviControllerTrait;
use smart\page\backend\filters\PageFilter;
use smart\page\backend\forms\PageForm;
use smart\page\models\Page;

class PageController extends BackendController
{
    use ImperaviControllerTrait;

    /**
     * List
     * @return string
     */
    public function actionIndex()
    {
        $model = new PageFilter;
        $model->load(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Create
     * @return string
     */
    public function actionCreate()
    {
        $object = new Page;
        $model = new PageForm;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->assignTo($object);
            if ($object->save()) {
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Changes saved successfully.'));
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update
     * @param integer $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $object = Page::findOne($id);
        if ($object === null) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        $model = new PageForm;
        $model->assignFrom($object);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->assignTo($object);
            if ($object->save()) {
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Changes saved successfully.'));
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'object' => $object,
        ]);
    }

    /**
     * Delete
     * @param integer $id
     * @return string
     */
    public function actionDelete($id)
    {
        $object = Page::findOne($id);
        if ($object === null) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        if ($object->delete()) {
            Yii::$app->storage->removeObject($object);
            Yii::$app->session->setFlash('success', Yii::t('cms', 'Item deleted successfully.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Make friendly URL
     * @param string $title 
     * @return string
     */
    public function actionMakeAlias($title)
    {
        return Json::encode(Translit::t($title));
    }
}
