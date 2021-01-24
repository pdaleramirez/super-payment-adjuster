<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\controllers;

use Craft;
use craft\web\Controller;
use pdaleramirez\superpaymentadjuster\elements\PaymentAdjuster;
use pdaleramirez\superpaymentadjuster\web\assets\PaymentAdjusterIndexAsset;

/**
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class PaymentAdjusterController extends Controller
{
    
    protected $allowAnonymous = ['index', 'do-something'];
    
    /**
     * @return mixed
     */
    public function actionPaymentAdjusterIndex()
    {
        Craft::$app->getView()->registerAssetBundle(PaymentAdjusterIndexAsset::class);
        
        return $this->renderTemplate('super-payment-adjuster/payment-adjusters/_index');
    }
    
    public function actionEdit($id = null, PaymentAdjuster $element = null)
    {
        if ($element == null) {
     
            if ($id == 'new') {
                $element = new PaymentAdjuster();
            
            } else {
                $element = Craft::$app->getElements()->getElementById($id, PaymentAdjuster::class);
            }

            if ($element == null) {
                throw new \Exception("Invalid adjuster page");
            }
        }
        
   
        return $this->renderTemplate('super-payment-adjuster/payment-adjusters/_edit', [
            'element' => $element
        ]);
    }
    
    public function actionSave()
    {
        $paymentAdjuster = new PaymentAdjuster();
        $paymentAdjuster->id = Craft::$app->getRequest()->getBodyParam('id');;

        if ($paymentAdjuster->id) {
            $paymentAdjuster = Craft::$app->getElements()->getElementById($paymentAdjuster->id, PaymentAdjuster::class);
        }

        $paymentAdjuster->title = Craft::$app->getRequest()->getBodyParam('title');
        $paymentAdjuster->handle = Craft::$app->getRequest()->getBodyParam('handle');

        if (!Craft::$app->getElements()->saveElement($paymentAdjuster)) {
            Craft::$app->getUrlManager()->setRouteParams([
                'paymentAdjuster' => $paymentAdjuster
            ]);
            
            $error = Craft::t('super-payment-adjuster', 'Unable to save payment adjuster.');
            $this->setFailFlash($error);

            return null;
        }
    }
}
