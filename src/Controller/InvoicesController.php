<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * @property \App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['ipn']);

        if (in_array($this->request->action, ['ipn'])) {
            $this->eventManager()->off($this->Csrf);
            $this->eventManager()->off($this->Security);
        }
    }

    public function ipn()
    {
        $this->autoRender = false;

        if (!empty($this->request->query['payment_method']) && !empty($this->request->data)) {
            $payment_method = $this->request->query['payment_method'];

            if ($payment_method == 'paypal') {
                $this->ipnPaypal($this->request->data);
                return null;
            }

            if ($payment_method == 'payza') {
                $this->ipnPayza($this->request->data);
                return null;
            }

            if ($payment_method == 'skrill') {
                $this->ipnSkrill($this->request->data);
                return null;
            }

            if ($payment_method == 'webmoney') {
                $this->ipnWebmoney($this->request->data);
                return null;
            }

            if ($payment_method == 'coinpayments') {
                $this->ipnCoinPayments($this->request->data);
                return null;
            }

            if ($payment_method == 'perfectmoney') {
                $this->ipnPerfectMoney($this->request->data);
                return null;
            }

            if ($payment_method == 'payeer') {
                $this->ipnPayeer($this->request->data);
                return null;
            }
        }

        // Coinbase IPN
        $raw_body = json_decode(file_get_contents('php://input'));
        if (isset($raw_body->type)) {
            $this->ipnCoinbase($raw_body);
            return null;
        }
    }

    protected function ipnPayeer($data)
    {
        // Rejecting queries from IP addresses not belonging to Payeer
        if (!in_array(get_ip(), ['185.71.65.92', '185.71.65.189', '149.202.17.210'])) {
            return null;
        }

        if (isset($data['m_operation_id']) && isset($data['m_sign'])) {
            $m_key = get_option('payeer_secret_key');
            // Forming an array for signature generation
            $arHash = [
                $data['m_operation_id'],
                $data['m_operation_ps'],
                $data['m_operation_date'],
                $data['m_operation_pay_date'],
                $data['m_shop'],
                $data['m_orderid'],
                $data['m_amount'],
                $data['m_curr'],
                $data['m_desc'],
                $data['m_status']
            ];

            // Adding additional parameters to the array if such parameters have been transferred
            if (isset($data['m_params'])) {
                $arHash[] = $data['m_params'];
            }

            // Adding the secret key to the array
            $arHash[] = $m_key;

            // Forming a signature
            $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

            $invoice_id = (int)$data['m_orderid'];
            $invoice = $this->Invoices->get($invoice_id);

            // If the signatures match and payment status is “Complete”
            if ($data['m_sign'] == $sign_hash && $data['m_status'] == 'success') {
                // Here you can mark the invoice as paid or transfer funds to your customer
                // Returning that the payment was processed successfully
                $invoice->status = 1;
                $invoice->paid_date = date("Y-m-d H:i:s");
                $this->Invoices->save($invoice);
                $message = 'VERIFIED';
            } else {
                // If not, returning an error
                $invoice->status = 4;
                $this->Invoices->save($invoice);
                $message = 'INVALID';
            }

        }

        $this->Invoices->successPayment($invoice);
    }

    protected function ipnPerfectMoney($data)
    {
        $perfectmoney_account = get_option('perfectmoney_account');
        $perfectmoney_passphrase = get_option('perfectmoney_passphrase');

        $concatFields = $data['PAYMENT_ID'] . ':' . $data['PAYEE_ACCOUNT'] . ':' .
            $data['PAYMENT_AMOUNT'] . ':' . $data['PAYMENT_UNITS'] . ':' .
            $data['PAYMENT_BATCH_NUM'] . ':' .
            $data['PAYER_ACCOUNT'] . ':' . $perfectmoney_passphrase . ':' .
            $data['TIMESTAMPGMT'];

        $hash = strtoupper(md5($concatFields));

        if ($hash == $data['V2_HASH']) {
            $invoice_id = (int)$data['PAYMENT_ID'];
            $invoice = $this->Invoices->get($invoice_id);

            if ($data['PAYMENT_AMOUNT'] == $invoice->amount &&
                $data['PAYEE_ACCOUNT'] == $perfectmoney_account &&
                $data['PAYMENT_UNITS'] == get_option('currency_code')
            ) {
                $invoice->status = 1;
                $invoice->paid_date = date("Y-m-d H:i:s");
                $this->Invoices->save($invoice);
                $message = 'VERIFIED';
            } else {
                $invoice->status = 4;
                $this->Invoices->save($invoice);
                $message = 'INVALID';
            }
        }

        $this->Invoices->successPayment($invoice);
    }

    protected function ipnWebmoney($data)
    {
        if (isset($data['LMI_PAYMENT_NO'])) {
            $invoice_id = (int)$data['LMI_PAYMENT_NO'];
            $invoice = $this->Invoices->get($invoice_id);

            if ($invoice->amount == $data['LMI_PAYMENT_AMOUNT']) {
                $invoice->status = 1;
                $invoice->paid_date = date("Y-m-d H:i:s");
                $this->Invoices->save($invoice);
                $message = 'VERIFIED';
            } else {
                $invoice->status = 4;
                $this->Invoices->save($invoice);
                $message = 'INVALID';
            }

            $this->Invoices->successPayment($invoice);
        }
    }

    protected function ipnCoinPayments($data)
    {
        $merchant_id = get_option('coinpayments_merchant_id');
        $secret = get_option('coinpayments_ipn_secret');

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            \Cake\Log\Log::write('error', 'No HMAC signature sent');
            exit();
        }

        $request = file_get_contents('php://input');
        if ($request === false || empty($request)) {
            \Cake\Log\Log::write('error', 'Error reading POST data');
            exit();
        }

        $merchant = isset($_POST['merchant']) ? $_POST['merchant'] : '';
        if (empty($merchant)) {
            \Cake\Log\Log::write('error', 'No Merchant ID passed');
            exit();
        }
        if ($merchant != $merchant_id) {
            \Cake\Log\Log::write('error', 'Invalid Merchant ID');
            exit();
        }

        $hmac = hash_hmac("sha512", $request, $secret);
        if ($hmac != $_SERVER['HTTP_HMAC']) {
            \Cake\Log\Log::write('error', 'HMAC signature does not match');
            exit();
        }

        $invoice_id = intval($_POST['custom']);
        $amount1 = floatval($_POST['amount1']);
        $status = intval($_POST['status']);

        $invoice = $this->Invoices->get($invoice_id);

        // Check amount against order total
        if ($amount1 < $invoice->amount) {
            \Cake\Log\Log::write('error', 'Amount is less than order total!');
            exit();
        }

        if ($status >= 100 || $status == 2) {
            $invoice->status = 1;
            $invoice->paid_date = date("Y-m-d H:i:s");
            $this->Invoices->save($invoice);
            $message = 'VERIFIED';
        } elseif ($status < 0) {
            $invoice->status = 4;
            $this->Invoices->save($invoice);
            $message = 'INVALID';
        }

        $this->Invoices->successPayment($invoice);
    }

    protected function ipnCoinbase($data)
    {
        // Todo check IPN https://developers.coinbase.com/api/v2?shell#show-a-checkout

        $invoice_id = (int)$data->data->metadata->invoice_id;
        $invoice = $this->Invoices->get($invoice_id);

        if ($data->type == 'wallet:orders:paid') {
            $invoice_amount = (float)$invoice->amount;
            $coinbase_amount = (float)$data->data->amount->amount;

            if ($invoice_amount != $coinbase_amount) {
                $invoice->status = 4;
                $this->Invoices->save($invoice);
                $message = 'INVALID';
            } else {
                $invoice->status = 1;
                $invoice->paid_date = date("Y-m-d H:i:s");
                $this->Invoices->save($invoice);
                $message = 'VERIFIED';
            }
        }

        if ($data->type == 'wallet:orders:mispaid') {
            $invoice->status = 4;
            $this->Invoices->save($invoice);
            $message = 'INVALID';
        }

        $this->Invoices->successPayment($invoice);
    }

    protected function ipnPayza($data)
    {
        $token = [
            'token' => urlencode($data['token'])
        ];

        // https://dev.payza.eu/resources/references/ipn-variables

        $url = 'https://secure.payza.eu/ipn2.ashx';

        $res = curlRequest($url, 'POST', $token)-body;

        if (strlen($res) > 0) {
            $invoice_id = (int)$data['apc_1'];
            $invoice = $this->Invoices->get($invoice_id);

            if (urldecode($res) != "INVALID TOKEN") {
                switch ($data['ap_transactionstate']) {
                    case 'Refunded':
                        $invoice->status = 5;
                        break;
                    case 'Completed':
                        $invoice->status = 1;
                        $invoice->paid_date = date("Y-m-d H:i:s");
                        break;
                }

                $this->Invoices->save($invoice);
                $message = 'VERIFIED';
            } else {
                $invoice->status = 4;
                $this->Invoices->save($invoice);
                $message = 'INVALID';
            }

            $this->Invoices->successPayment($invoice);
        }
    }

    protected function ipnSkrill($data)
    {
        $concatFields = $data['merchant_id']
            . $data['transaction_id']
            . strtoupper(md5(get_option('skrill_secret_word')))
            . $data['mb_amount']
            . $data['mb_currency']
            . $data['status'];

        $MBEmail = get_option('skrill_email');


        $invoice_id = (int)$data['transaction_id'];
        $invoice = $this->Invoices->get($invoice_id);

        if ($invoice->amount == $data['amount']) {
            if (strtoupper(md5($concatFields)) == $data['md5sig'] &&
                $data['status'] == 2 &&
                $data['pay_to_email'] == $MBEmail
            ) {
                $invoice->status = 1;
                $invoice->paid_date = date("Y-m-d H:i:s");
                $this->Invoices->save($invoice);
                $message = 'VERIFIED';
            }
        } else {
            $invoice->status = 4;
            $this->Invoices->save($invoice);
            $message = 'INVALID';
        }

        $this->Invoices->successPayment($invoice);
    }

    protected function ipnPaypal($data)
    {
        $data['cmd'] = '_notify-validate';

        // https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNTesting/?mark=IPN%20troubleshoot#invalid

        $paypalURL = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

        if (get_option('paypal_sandbox', 'no') == 'no') {
            $paypalURL = 'https://ipnpb.paypal.com/cgi-bin/webscr';
        }

        $res = curlRequest($paypalURL, 'POST', $data)->body;

        $invoice_id = (int)$data['custom'];
        $invoice = $this->Invoices->get($invoice_id);

        if (strcmp($res, "VERIFIED") == 0) {
            switch ($data['payment_status']) {
                case 'Refunded':
                    $invoice->status = 5;
                    break;
                case 'Completed':
                    $invoice->status = 1;
                    $invoice->paid_date = date("Y-m-d H:i:s");
                    break;
            }

            $this->Invoices->save($invoice);
            $message = 'VERIFIED';
        } elseif (strcmp($res, "INVALID") == 0) {
            $invoice->status = 4;
            $this->Invoices->save($invoice);
            $message = 'INVALID';
        }

        $this->Invoices->successPayment($invoice);
    }
}
