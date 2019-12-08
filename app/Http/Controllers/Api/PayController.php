<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment\Cashier;
use App\sectiona_ticket;
use App\course_ticket;
use App\quiz_ticket;
<<<<<<< HEAD
=======
use App\diet;
>>>>>>> update 2019/12/08
class PayController extends Controller
{
    public function pay(Request $request) {


        $address = $request->address;
        $type = $request->type;
        /** Info */
        $info = [
            "sellerId" => env('2CHECKOUT_SELLER_ID'),
            "merchantOrderId" => rand(1000,100000),
            "token" => $request->token,
            "currency" => 'USD',
            "total" => $request->price,
            "billingAddr" => array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        ),
        "shippingAddr" => array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'testingtester@2co.com',
            "phoneNumber" => '555-555-5555'
        )
        ];

        $res = Cashier::pay($info);


        if(!$res['success']) {
            return response()->json(['msg' => $res],400);
        }

        /** INJECT_SERVER_WITH_TICKET */

        if($request->type == "sectiona") {
            $sectiona_ticket = sectiona_ticket::create([
                'user_id' => $request->user_id,
                'psychologicalcounseling_id' => $request->id,
                'price' => $request->price,
            ]);

            $ticket = sectiona_ticket::where('id',$sectiona_ticket->id)->first();
        }

        if($request->type == 'course') {
            $course_ticket = course_ticket::create([
                'user_id' => $request->user_id,
                'course_id' => $request->id,
                'price' => $request->price
            ]);
            $ticket = course_ticket::where('id',$course_ticket->id)->first();
        }

        if($request->type == 'quiz') {
            $quiz_ticket = quiz_ticket::create([
                'user_id' => $request->user_id,
                'quiz_id' => $request->id,
                'price' => $request->price
            ]);
            $ticket = quiz_ticket::where('id',$quiz_ticket->id)->first();
        }
<<<<<<< HEAD
=======

        if($request->type == 'diet') {
            $diet = diet::create([
                'user_id' => $request->user_id,
                'have' => 'done',
            ]);
            $ticket = diet::where('id',$diet->id)->first();
        }
>>>>>>> update 2019/12/08
        return response()->json(['msg' => $ticket],200);
        
    }
}
