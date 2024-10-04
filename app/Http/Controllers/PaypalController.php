<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PayController; 
use Omnipay\Omnipay; 

class PaypalController extends Controller
{
    private $gateway;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest'); 
        $this->gateway->setClientId('PAYPAL_CLIENT_ID'); 
        $this->gateway->setSecreate('PAYPAL_CLIENT_SECREATE'); 
        $this->gateway->setTestMode(true); 
    }
    public function pay(Request $request){
        try{
             $response = $this->gateway->purchase(array(
                'amount' => $request->amount, 
                'currency' => env('PayPAL_Currency'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error'),
             ));
             if($response){
                $response->redirect();
             }else{
                return $request->getMessage(); 
             }
       }catch(\Throwable $th){
            return $th->getMessage();

       }
    }
}
