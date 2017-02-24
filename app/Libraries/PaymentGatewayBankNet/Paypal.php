<?php

namespace App\Libraries\PaymentGatewayBankNet;

use Log;
use App\Models\Order;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class Paypal
{
    const GATEWAY_NAME = 'paypal';

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    protected static function getApiContext()
    {
        return new ApiContext(new OAuthTokenCredential(config('services.paypal.client'), config('services.paypal.secret')));
    }

    public function payment()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $redirectUrl = new RedirectUrls();
        $redirectUrl->setReturnUrl(url('order/confirmPayment', ['gateway' => self::GATEWAY_NAME]))->setCancelUrl(url('order'));

        $amount = new Amount();
        $amount->setCurrency('USD')->setTotal(10);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setDescription('Thanh toán fitfood');

        $payment = new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrl)->setTransactions([$transaction]);

        try
        {
            $apiContext = self::getApiContext();

            $payment->create($apiContext);

            return $payment->getApprovalLink();
        }
        catch(PayPalConnectionException $ex)
        {
            Log::info($ex->getLine() . ' ' . $ex->getMessage());
        }
        catch(\Exception $e)
        {
            Log::info($e->getLine() . ' ' . $e->getMessage());
        }

        return false;
    }

    public static function completePayment($params)
    {
        if(!empty($params['paymentId']) && !empty($params['PayerID']))
        {
            $paymentId = $params['paymentId'];
            $payerId = $_GET['PayerID'];

            $apiContext = self::getApiContext();

            $payment = Payment::get($paymentId, $apiContext);

            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            try
            {
                $result = $payment->execute($execution, $apiContext);

                echo '<pre>';
                print_r($result);
                echo '</pre>';
                exit();

                $state = $result->getState();

                if($state == 'approved')
                {
                    echo 'Thanh toán thành công';
                }
            }
            catch(PayPalConnectionException $ex)
            {
                Log::info($ex->getLine() . ' ' . $ex->getMessage());
            }
            catch(\Exception $e)
            {
                Log::info($e->getLine() . ' ' . $e->getMessage());
            }
        }
    }
}