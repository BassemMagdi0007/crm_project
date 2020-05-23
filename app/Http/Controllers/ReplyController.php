<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Complain;
class ReplyController extends Controller
{
    public function store(Request $request)
   {
     Reply::create([
        'reply' => $request->reply,
        'complain_id'=>$request->ComplainId,
     ]);
     $complain=Complain::find($request->ComplainId);
     $complain->state=2;
     $complain->update();
     return redirect()->route('complain.all',1)->with('message','replay has been sended to customer and we wait his replay or his rate');
    } 

}
