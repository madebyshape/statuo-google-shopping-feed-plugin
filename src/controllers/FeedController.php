<?php

namespace statuo\GoogleShoppingFeed\controllers;

use Craft;
use craft\web\Controller;
use craft\web\View;
use statuo\GoogleShoppingFeed\GoogleShoppingFeed;
use yii\web\Response;

class FeedController extends Controller
{
    protected $allowAnonymous = ['index'];

    public function actionIndex(): Response
    {
        $settings = GoogleShoppingFeed::getInstance()->getSettings();
        $products = GoogleShoppingFeed::$plugin->elements->getProducts(null, $settings);

        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $headers = Craft::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');

        return $this->renderTemplate('google-shopping-feed/_products', [
            'products' => $products,
            'settings' => $settings
        ]);
    }
}
