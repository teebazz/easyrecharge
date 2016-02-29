<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function initOrder(Request $request)
    {
        //dd($request->all());
        if($request['type'] == 'units'){
            //dd($request->all());
            //$data['network'] = $request['network'].' '.$request['type'].' '.$request['amount'].' for '.$request['phone'];

            $data['network']	= $request['network'];
            $data['type']		= $request['type'];
            $data['amount']		= $request['amount'];
            $data['phone']		= $request['phone'];

            $data['title']		= 'Order';
            return view('orders',$data);
        }
    }

    public function confirmPay(Request $request)
    {
        $authVals	    	= Auth::user();
        $data['trans']		= rand(0,999999999);
        $data['network']	= $request['network'];
        $data['type']		= $request['type'];
        $data['amount']		= $request['amount'];
        $data['phone']		= $request['phone'];
        if(isset($request['onlinePay'])){
            $vary = [
                'transaction_id' => $data['trans'],
                'user_id'		 => $authVals->id,
                'amount'		 => $request['amount'],
                'method'		 => 'online',
                'phone'		 	 => $request['phone'],
                'status'		 => 'pending'
            ];
            $insert = DB::table('transactions')->insert($vary);
            dd($data);
        }
    }

}
