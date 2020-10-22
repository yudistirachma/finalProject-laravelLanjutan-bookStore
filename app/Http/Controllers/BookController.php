<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Http\Resources\BookResource;
use Midtrans;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books=Book::all();
        return BookResource::collection($notes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payment(Request $request)
    {
        $order=Order::create([
            'amount'=>$request->amount,
            'method'=>$request->method,
            'id_book'=>$request->id_book
        ]);

        $order->order_id=$order->id.'-'.Str::random(5);
        $order->save();

        $response_midtrans=$this->midtrans_store($order);

        return response()->json([
            'response_code'=>'00',
            'response_msg'=>'success',
            'data'=>$response_midtrans

        ]);
    }

    protected function midtrans_store(Order $order){


        $server_key=base64_encode(config('app.midtrans.server_key'));
        $base_uri=config('app.midtrans.base_uri');
        $uri=$base_uri.'/v2/charge';
        $client=new Client([

            'base_uri'=>$base_uri
        ]);

        $headers=[
            'Accept'=>'application/json',
            'Authorization'=>'Basic '.$server_key,
            'Content-Type'=>'application/json'


        ];



        switch($order->method){

            case'bca':
                $body=[
                    'payment_type'=>'bank_transfer',
                    'transaction_details'=>[

                        "order_id"=>$order->order_id,
                        "gross_amount"=>$order->amount
                    ],
                    'bank_transfer'=>[
                        'bank'=>'bca'


                    ]


                ];
            break;
            case 'permata':
                $body=[
                        'payment_type'=>'permata',
                        'transaction_details'=>[

                            "order_id"=>$order->order_id,
                            "gross_amount"=>$order->amount
                        ]


                ];
            break;
            default:
                $body=[];
            break;
        }
        $res=$client->post('/v2/charge',[
            'headers'=>$headers,
            'body'  =>json_encode($body)

        ]);
        
        return json_decode($res->getBody());
    }
    public function generate(Request $request)
    {
        Midtrans\Config::$serverKey=config('app.midtrans.server_key');
        Midtrans\Config::$isSanitized=true;
        Midtrans\Config::$is3ds=true;

        $midtrans_transaction=Midtrans\Snap::createTransaction($request->data);
        return response()->json([
            'response_code'=>'00',
            'response_msg'=>'success',
            'data'=>$midtrans_transaction

        ]);

    }
}
