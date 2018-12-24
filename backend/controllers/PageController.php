<?php

namespace smart\page\backend\controllers;

use Yii;
use yii\base\NotSupportedException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use dkhlystov\helpers\Translit;
use smart\base\BackendController;
use smart\page\backend\filters\PageFilter;
use smart\page\backend\forms\PageForm;
use smart\page\models\Page;

// use yii\filters\AccessControl;
// use yii\web\Controller;

class PageController extends BackendController
{

    /**
     * @inheritdoc
     * Disable csrf validation for image and file uploading
     */
    public function beforeAction($action)
    {
        if ($action->id == 'image' || $action->id == 'file') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

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
            'canAddPage' => $this->canAddPage(),
        ]);
    }

    /**
     * Create
     * @return string
     */
    public function actionCreate()
    {
        if (!$this->canAddPage()) {
            throw new NotSupportedException('You have exceeded the maximum number of pages.');
        }

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
            'object' => $object,
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
     * Make alias
     * @param string $title 
     * @return string
     */
    public function actionAlias($title)
    {
        return Json::encode([
            'title' => $title,
            'alias' => Translit::t($title),
        ]);
    }

    /**
     * Image upload
     * @return string
     */
    public function actionImage()
    {
        $name = Yii::$app->storage->prepare('file', [
            'image/png',
            'image/jpg',
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
        ]);

        if ($name === false) {
            throw new BadRequestHttpException(Yii::t('cms', 'Error occurred while image uploading.'));
        }

        return Json::encode([
            ['filelink' => $name],
        ]);
    }

    /**
     * File upload
     * @return string
     */
    public function actionFile()
    {
        $name = Yii::$app->storage->prepare('file');

        if ($name === false) {
            throw new BadRequestHttpException(Yii::t('cms', 'Error occurred while file uploading.'));
        }

        return Json::encode([
            ['filelink' => $name, 'filename' => urldecode(basename($name))],
        ]);
    }

    /**
     * Determining if there are a restrictions for adding page
     * @return boolean
     */
    private function canAddPage()
    {
        return $this->module->maxCount === null || Page::find()->count() < $this->module->maxCount;
    }

}
