<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BookResource;
use Midtrans;
class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','checkRole'])->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Book $book)
    {
        $books = $book->get();

        return view('book.index', compact('books'));
    }


     public function get_book(Book $book)
    {
        $books = $book->get();

        return view('book.index', compact('books'));
    }
    public function list(Book $book)
    {
        $books = $book->get();

        return $books;
    }

    public function productList(Book $book)
    {
        $books = $book->get();

        return view('book.list', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'title' => 'required|string',
            'description' => 'string',
            'price' => 'required|integer',
            'picture' => 'required|image|mimes:jpg,png,svg,jpeg|max:2048'
        ]);

        $picture = request()->file('picture') ? request()->file('picture')->store('images/books') : null;

        $book = Book::create([
            'title' => request()->title,
            'description' => request()->description,
            'price' => request()->price,
            'picture' => $picture
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Book $book)
    {
        request()->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'picture' => 'image|mimes:jpg,png,svg,jpeg|max:2048'
        ]);

        if (request()->file('picture')) {
            Storage::delete($book->picture);
            $picture = request()->file('picture')->store("images/books");
        } else {
            $picture = $book->picture;
        }

        $book->update([
            'name' => request()->name,
            'price' => request()->price,
            'picture' => $picture
        ]);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Storage::delete($book->picture);
        $book->delete();
        
        return redirect('/');
    }


    public function payment(Request $request)
    {
         
        $order=Order::create([
            'amount'=>$request['data'][0]['amount'],
            'method'=>$request['data'][0]['method'],
            'id_book'=>$request['data'][0]['id_book']
        ]);
       
       $order->order_id='order-'.$order->order_id;
      $order->save();

       $response_midtrans=$this->midtrans_store($order);

        return response()->json([
            'response_code'=>'00',
            'response_msg'=>'success',
             'data'=>$response_midtrans,
             'order_id'=>$order->id

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
       $gross_amount=$request->data['transaction_details']['gross_amount'];
       $order_id=$request->data['transaction_details']['order_id'];
       $complete_request = array(
            'transaction_details' => array(
                'gross_amount' => $gross_amount,
                'order_id' =>$order_id,
            )
        );
     // print_r($complete_request);
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
