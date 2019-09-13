<?php

namespace Omnipay\PayPalReference\Message;

use Omnipay\PayPal\Message\AbstractRequest;

/**
 * PayPal Express Authorize Request
 */
class DoReferenceTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('referenceId', 'amount');

        $data = $this->getBaseData();
        $data['METHOD'] = 'DoReferenceTransaction';
        $data['REFERENCEID'] = $this->getParameter('referenceId');
        $data['AMT'] = $this->getAmount();
        $data['CURRENCYCODE'] = $this->getCurrency();
        $data['PAYMENTACTION'] = 'Sale';

        $card = $this->getCard();
        if ($card) {
            $data['SHIPTONAME'] = $card->getName();
            $data['SHIPTOSTREET'] = $card->getAddress1();
            $data['SHIPTOSTREET2'] = $card->getAddress2();
            $data['SHIPTOCITY'] = $card->getCity();
            $data['SHIPTOSTATE'] = $card->getState();
            $data['SHIPTOCOUNTRY'] = $card->getCountry();
            $data['SHIPTOZIP'] = $card->getPostcode();
            $data['SHIPTOPHONENUM'] = $card->getPhone();
        }

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new CreateBillingAgreementResponse($this, $data);
    }
    
    public function setReferenceId($value)
    {
        return $this->setParameter('referenceId', $value);
    }
}
