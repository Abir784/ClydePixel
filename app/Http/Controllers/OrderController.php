<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Mail;
use App\Notifications\OrderCompleted;
use App\Notifications\OrderPlaced;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use OrderMail as GlobalOrderMail;

class OrderController extends Controller
{
    function OrderForm(){
        return view('frontend.add_order');
    }
    function OrderPost(Request $request){
       $validatedData= $request->validate([
            'name' => 'required|string|max:255',
            'folder_name' => 'required|string|max:255',
            'simple_clipping' => 'nullable|integer',
            'in_clip_2_in_1' => 'nullable|integer',
            'in_clip_3_in_1' => 'nullable|integer',
            'layer_masking' => 'nullable|integer',
            'retouch' => 'nullable|integer',
            'neckjoin' => 'nullable|integer',
            'recolor' => 'nullable|integer',
            'neek_joint_wit_lequefy' => 'nullable|integer',
            'clipping_with_liquefy' => 'nullable|integer',
            'vector_graphics' => 'nullable|integer',
            'complex_multi_path' => 'nullable|integer',
            'total_file' => 'nullable|integer',
            'status' => 'nullable|integer',
            'hours' => 'required|numeric|max:24|min:0',
            'minutes' => 'required|numeric|max:59|min:0',
            'comment' => 'nullable|string',
        ],[
            'total_file.required'=>'At least one file required',
            'deadline.after'=>'The deadline cannot be before the present time',
        ]);
        $deadline=Carbon::now('Asia/Dhaka')->addHours((int) $validatedData['hours']);
        $deadline=$deadline->addMinutes((int) $validatedData['minutes']);
            Order::create([
            'name' => $validatedData['name'],
            'folder_name' => $validatedData['folder_name'],
            'added_by' => Auth::user()->id,
            'last_updated_by' => Null,
            'simple_clipping' => $validatedData['simple_clipping'] ?? null,
            'in_clip_2_in_1' => $validatedData['in_clip_2_in_1'] ?? null,
            'in_clip_3_in_1' => $validatedData['in_clip_3_in_1'] ?? null,
            'layer_masking' => $validatedData['layer_masking'] ?? null,
            'retouch' => $validatedData['retouch'] ?? null,
            'nechjoin' => $validatedData['neckjoin'] ?? null,
            'recolor' => $validatedData['recolor'] ?? null,
            'neek_joint_wit_lequefy' => $validatedData['neek_joint_wit_lequefy'] ?? null,
            'clipping_with_liquefy' => $validatedData['clipping_with_liquefy'] ?? null,
            'vector_graphics' => $validatedData['vector_graphics'] ?? null,
            'complex_multi_path' => $validatedData['complex_multi_path'] ?? null,
            'total_file' => $validatedData['total_file'] ?? null,
            'status' =>0,
            'deadline' => $deadline,
            'comment' => $validatedData['comment'] ?? null,
            'created_at' => Carbon::now('Asia/Dhaka'),
        ]);

        $details=[
            'name' => $validatedData['name'],
            'deadline' => Carbon::parse($deadline)->format('d-M-y h:i A'),
        ];
        $mails=Mail::all();
        foreach($mails as $mail){
            Notification::route('mail',$mail->email)->notify(new OrderPlaced($details));
        }

        return back()->with('success','Order Created Successfully');
    }
    function OrderList(){
        $order_list = Order::where('status','!=',5)->paginate(10);
        return view('frontend.order_list',[
            'order_list'=>$order_list,
        ]);
    }
    function OrderConfirmedList(){
        $order_list = Order::where('status',5)->paginate(10);
        return view('frontend.corfirmed_order_list',[
            'order_list'=>$order_list,
        ]);
    }
    function StatusChange($id,$status){
       Order::where('id',$id)->update([
            'status'=>$status,
            'last_updated_by'=>Auth::user()->id,
            'updated_at'=>Carbon::now('Asia/Dhaka'),
        ]);
        $order=Order::where('id',$id)->first();
        if($status ==5){
            $details=[
                'name' => $order->name,
                'deadline' => Carbon::now('Asia/Dhaka'),
            ];
            $mails=Mail::all();
            foreach($mails as $mail){
                Notification::route('mail',$mail->email)->notify(new OrderCompleted($details));
            }
        }
        return back();

    }
    function OrderDelete(Request $request){
        $orderId = $request->input('id');

        $order = Order::find($orderId);

        if ($order) {
            $order->delete();
            return response()->json(['success' => 'Order deleted successfully']);
        } else {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }
    function OrderView($id){
        $order= Order::where('id',$id)->first();

        return view('frontend.order_show',[
            'order'=>$order,
        ]);
    }
    function EmailAdd(){
        $mails=Mail::all();
        return view('frontend.email_add',[
            'mails'=>$mails,
        ]);
    }
    function EmailPost(Request $request){
        $data=$request->validate([
            'email'=>'required|email',
            'name'=>'required|string',
        ]);
        Mail::create([
            'email'=>$data['email'],
            'name'=>$data['name'],
        ]);
        return back();

    }
}
