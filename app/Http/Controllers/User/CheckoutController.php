<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Requests\User\Checkout\Store;
use Auth;
use Mail;
use App\Mail\Checkout\AfterCheckout;
use Str;
use Midtrans;

class CheckoutController extends Controller
{

    public function __construct()
    {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Camp $camp, Request $request)
    {
        if ($camp->isRegistered) {
            $request->session()->flash('error', "You already registered on {$camp->title} camp.");
            return redirect(route('user.dashboard'));
        }

        return view('checkout.create', ['camp' => $camp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Camp $camp)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['camp_id'] = $camp->id;

        $user = Auth::user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->occupation = $data['occupation'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->save();

        $checkout = Checkout::create($data);

        $this->getSnapRedirect($checkout);

        Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

        return redirect()->route('checkout.success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    public function success()
    {
        return view('checkout.success');
    }

    /**
     * Midtrans callback handler
     */
    public function getSnapRedirect(Checkout $checkout)
    {
        $orderId = $checkout->id . '-' . Str::random(5);
        $price = $checkout->camp->price * 1000;
        $checkout->midtrans_booking_code = $orderId;

        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $price
        ];

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->camp->title} Camp"
        ];

        $userData = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'address' => $checkout->user->address,
            'city' => '',
            'postal_code' => '',
            'phone' => $checkout->user->phone,
            'country_code' => 'IDN'
        ];

        $customer_details = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'email' => $checkout->user->email,
            'phone' => $checkout->user->phone,
            'billing_address' => $userData,
            'shipping_address' => $userData
        ];

        $midtrans_payload = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details
        ];

        try {
            $paymentUrl = Midtrans\Snap::createTransaction($midtrans_payload)->redirect_url;
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();

            return $paymentUrl;
        } catch (\Exception $error) {
            return false;
        }
    }

    public function midtransCallback(Request $request)
    {
        $notif = $request->method() == 'POST' ? new Midtrans\Notification() : Midtrans\Transaction::status($request->order_id);

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $checkout_id = explode('-', $notif->order_id)[0];

        $checkout = Checkout::find($checkout_id);

        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
                $checkout->payment_status = 'pending';
            } else if ($fraud == 'accept') {
                $checkout->payment_status = 'paid';
            }
        } else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
                $checkout->payment_status = 'failed';
            } else if ($fraud == 'accept') {
                $checkout->payment_status = 'failed';
            }
        } else if ($transaction_status == 'deny') {
            $checkout->payment_status = 'failed';
        } else if ($transaction_status == 'settlement') {
            $checkout->payment_status = 'paid';
        } else if ($transaction_status == 'pending') {
            $checkout->payment_status = 'pending';
        } else if ($transaction_status == 'expire') {
            $checkout->payment_status = 'failed';
        }

        $checkout->save();
        return view('checkout.success');
    }
}
