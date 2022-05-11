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
use craft\commerce\Plugin;
use craft\web\Controller;
use pdaleramirez\superpaymentadjuster\elements\PaymentAdjuster;
use pdaleramirez\superpaymentadjuster\SuperPaymentAdjuster;
use pdaleramirez\superpaymentadjuster\web\assets\PaymentAdjusterIndexAsset;

/**
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class PaymentAdjusterController extends Controller
{

    protected int|bool|array $allowAnonymous = ['index'];

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

        $element->baseAmount = $element->baseAmount !== null ? Craft::$app->formatter->asDecimal($element->baseAmount) : null;
        $element->percentAmount = $element->percentAmount !== null ? Craft::$app->formatter->asDecimal($element->percentAmount) : null;

        $gateways = Plugin::getInstance()->getGateways()->getAllCustomerEnabledGateways();

        $gatewayOptions = [];
        if (count($gateways) > 0) {
            foreach ($gateways as $key => $gateway) {
                $gatewayOptions[$key]['label'] = $gateway->name;
                $gatewayOptions[$key]['value'] = $gateway->handle;
            }
        }

        $adjusters = SuperPaymentAdjuster::getInstance()->getPaymentAdjuster()->getTypes();

        $typeOptions = [];
        if (count($adjusters) > 0) {
            foreach ($adjusters as $key => $adjuster) {
                $typeOptions[$key]['label'] = ucwords($adjuster);
                $typeOptions[$key]['value'] = $adjuster;
            }
        }

        return $this->renderTemplate('super-payment-adjuster/payment-adjusters/_edit', [
            'element' => $element,
            'gatewayOptions' => $gatewayOptions,
            'typeOptions' => $typeOptions,
            'continueEditingUrl' => 'super-payment-adjuster/payment-adjusters/edit/{id}'
        ]);
    }

    public function actionSave()
    {
        $paymentAdjuster = new PaymentAdjuster();
        $paymentAdjuster->id = Craft::$app->getRequest()->getBodyParam('id');;

        if ($paymentAdjuster->id) {
            $paymentAdjuster = Craft::$app->getElements()->getElementById($paymentAdjuster->id, PaymentAdjuster::class);
        }
        $paymentAdjuster->enabled = Craft::$app->getRequest()->getBodyParam('enabled');
        $paymentAdjuster->title = Craft::$app->getRequest()->getBodyParam('title');
        $paymentAdjuster->name = Craft::$app->getRequest()->getBodyParam('name');
        $paymentAdjuster->handle = Craft::$app->getRequest()->getBodyParam('handle');
        $paymentAdjuster->description = Craft::$app->getRequest()->getBodyParam('description');
        $paymentAdjuster->gatewayHandle = Craft::$app->getRequest()->getBodyParam('gatewayHandle');
        $paymentAdjuster->method = Craft::$app->getRequest()->getBodyParam('method');
        $paymentAdjuster->type = Craft::$app->getRequest()->getBodyParam('type');
        $paymentAdjuster->amountType = Craft::$app->getRequest()->getBodyParam('amountType');
        $paymentAdjuster->baseAmount = Craft::$app->getRequest()->getBodyParam('baseAmount');
        $paymentAdjuster->percentAmount = Craft::$app->getRequest()->getBodyParam('percentAmount');

        if (!Craft::$app->getElements()->saveElement($paymentAdjuster)) {
            Craft::$app->getUrlManager()->setRouteParams([
                'paymentAdjuster' => $paymentAdjuster
            ]);

            $error = Craft::t('super-payment-adjuster', 'Unable to save payment adjuster.');
            $this->setFailFlash($error);

            return null;
        }

        $this->setSuccessFlash(Craft::t('super-payment-adjuster', 'Payment Adjuster Saved'));

        return $this->redirectToPostedUrl($paymentAdjuster);
    }
}
