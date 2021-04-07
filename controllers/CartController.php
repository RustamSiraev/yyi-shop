<?php


namespace app\controllers;

use app\models\Good;
use app\models\Order;
use app\models\OrderGood;
use yii\web\Controller;
use app\models\Cart;
use Yii;

class CartController extends Controller
{
    public function actionOpen()
    {
        $session = Yii::$app->session;
        $session->open();
//        $session->remove('cart');
//        $session->remove('cart.totalPrice');
//        $session->remove('cart.totalQuantity');
        return $this->renderPartial('cart', compact( 'session'));
    }

    public function actionAdd($name)
    {
        $good = new Good();
        $good = $good->getOneGood($name);
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($good);
        return $this->renderPartial('cart', compact('good', 'session'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.totalPrice');
        $session->remove('cart.totalQuantity');
        return $this->renderPartial('cart', compact('good', 'session'));
    }

    public function actionDelete($id)
    {
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalcCart($id);
        return $this->renderPartial('cart', compact('good', 'session'));
    }

    public function actionOrder()
    {
        $session = Yii::$app->session;
        $session->open();
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->date = date('Y-m-d H:i:s');
            $order->sum = $session['cart.totalPrice'];
            if ($order->save()) {
                Yii::$app->mailer->compose()
                    ->setFrom(['aaa$aaa.ru' => 'test test'])
                    ->setTo('bbb@bbb.ru')
                    ->setSubject('Ваш заказ принят')
                    ->send();
                $session->remove('cart');
                $session->remove('cart.totalPrice');
                $session->remove('cart.totalQuantity');
                return $this->render('success', compact( 'session'));
            }
        }
        $this->layout = 'empty-layout';
        return $this->render('order', compact('order', 'session'));
    }

}