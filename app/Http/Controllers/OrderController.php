<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Models\Order;
use App\Models\OrderField;
use App\Notifications\OrderCompleted;
use App\Notifications\OrderPlaced;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    function OrderForm(){
        $orderFields = OrderField::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('frontend.add_order', [
            'orderFields' => $orderFields,
        ]);
    }
    function OrderPost(Request $request){
        $orderFields = OrderField::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        $rules = [
            'name' => 'required|string|max:255',
            'folder_name' => 'required|string|max:255',
            'hours' => 'required|numeric|max:24|min:0',
            'minutes' => 'required|numeric|max:59|min:0',
            'comment' => 'nullable|string',
        ];

        $messages = [
            'deadline.after'=>'The deadline cannot be before the present time',
        ];

        foreach ($orderFields as $field) {
            $rules['dynamic_fields.' . $field->field_key] = ($field->is_required ? 'required' : 'nullable') . '|integer|min:0';
            $messages['dynamic_fields.' . $field->field_key . '.required'] = $field->label . ' is required.';
        }

        $validatedData = $request->validate($rules, $messages);

        $dynamicValues = [];
        $totalFiles = 0;
        foreach ($orderFields as $field) {
            $value = $validatedData['dynamic_fields'][$field->field_key] ?? null;
            if ($value === null || $value === '') {
                continue;
            }

            $castValue = (int) $value;
            $dynamicValues[$field->field_key] = $castValue;
            $totalFiles += $castValue;
        }

        $deadline = now()->addHours((int) $validatedData['hours']);
        $deadline=$deadline->addMinutes((int) $validatedData['minutes']);
        Order::create([
            'name' => $validatedData['name'],
            'folder_name' => $validatedData['folder_name'],
            'added_by' => Auth::user()->id,
            'last_updated_by' => Null,
            'total_file' => $totalFiles,
            'dynamic_fields' => $dynamicValues,
            'status' =>0,
            'deadline' => $deadline,
            'comment' => $validatedData['comment'] ?? null,
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
        $query = Order::where('status', '!=', 5);

        if ((int) Auth::user()->role === 2) {
            $query->where('added_by', Auth::id());
        }

        $order_list = $query->paginate(10);

        return view('frontend.order_list',[
            'order_list'=>$order_list,
        ]);
    }
    function OrderConfirmedList(){
        $query = Order::where('status', 5);

        if ((int) Auth::user()->role === 2) {
            $query->where('added_by', Auth::id());
        }

        $order_list = $query->paginate(10);

        return view('frontend.corfirmed_order_list',[
            'order_list'=>$order_list,
        ]);
    }
    function StatusChange(Request $request, $id, $status){
        abort_if(! in_array((int) Auth::user()->role, [0, 1], true), 403);

        if (! in_array((int) $status, [0, 1, 2, 3, 4, 5], true)) {
            abort(422);
        }

       Order::where('id',$id)->update([
            'status'=>$status,
            'last_updated_by'=>Auth::user()->id,
          'updated_at'=>now(),
        ]);
        $order=Order::where('id',$id)->first();
        if($status ==5){
            $details=[
                'name' => $order->name,
                'deadline' => now()->format('d-M-y h:i A'),
            ];
            $mails=Mail::all();
            foreach($mails as $mail){
                Notification::route('mail',$mail->email)->notify(new OrderCompleted($details));
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
            ]);
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
        $order = Order::findOrFail($id);

        if ((int) Auth::user()->role === 2 && (int) $order->added_by !== (int) Auth::id()) {
            abort(403);
        }

        $orderWorkItems = $this->buildOrderWorkItems($order);

        return view('frontend.order_show',[
            'order'=>$order,
            'orderWorkItems' => $orderWorkItems,
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

    private function buildOrderWorkItems(Order $order): array
    {
        $dynamicValues = (array) ($order->dynamic_fields ?? []);
        $definitions = OrderField::whereIn('field_key', array_keys($dynamicValues))->get()->keyBy('field_key');

        $items = [];
        foreach ($dynamicValues as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $label = $definitions[$key]->label ?? Str::of($key)->replace('_', ' ')->title();
            $items[] = [
                'label' => $label,
                'value' => $value,
            ];
        }

        return $items;
    }
}
