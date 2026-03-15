<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderField;
use App\Models\User;
use App\Notifications\OrderCompleted;
use App\Notifications\OrderPlaced;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    function OrderForm(){
        $orderFields = OrderField::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $clientEmails = User::where('role', 2)
            ->whereNotNull('email')
            ->orderBy('email')
            ->pluck('email');

        return view('frontend.add_order', [
            'orderFields' => $orderFields,
            'clientEmails' => $clientEmails,
        ]);
    }
    function OrderPost(Request $request){
        $orderFields = OrderField::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $isAdminCreator = in_array((int) Auth::user()->role, [0, 1], true);

        $clientEmails = User::where('role', 2)
            ->whereNotNull('email')
            ->pluck('email')
            ->map(fn (string $email) => trim($email))
            ->filter()
            ->values()
            ->all();

        $rules = [
            'name' => 'required|string|max:255',
            'folder_name' => 'required|string|max:255',
            'hours' => 'required|numeric|max:24|min:0',
            'minutes' => 'required|numeric|max:59|min:0',
            'comment' => 'nullable|string',
            'associated_email' => $isAdminCreator
                ? ['nullable', 'email', 'max:255', Rule::in($clientEmails)]
                : ['prohibited'],
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
        $associatedEmail = null;
        if ($isAdminCreator) {
            $selectedAssociatedEmail = $validatedData['associated_email'] ?? null;
            $associatedEmail = $selectedAssociatedEmail ?: Auth::user()->email;
        }

        $order = Order::create([
            'name' => $validatedData['name'],
            'folder_name' => $validatedData['folder_name'],
            'added_by' => Auth::user()->id,
            'last_updated_by' => Null,
            'total_file' => $totalFiles,
            'dynamic_fields' => $dynamicValues,
            'status' =>0,
            'deadline' => $deadline,
            'comment' => $validatedData['comment'] ?? null,
            'associated_email' => $associatedEmail,
        ]);

        $details=[
            'name' => $order->name,
            'deadline' => Carbon::parse($order->deadline)->format('d-M-y h:i A'),
        ];
        $this->sendOrderNotification($order, new OrderPlaced($details));

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

        $order = Order::findOrFail($id);

        $order->update([
            'status'=>$status,
            'last_updated_by'=>Auth::user()->id,
            'updated_at'=>now(),
        ]);

        if($status ==5){
            $details=[
                'name' => $order->name,
                'deadline' => now()->format('d-M-y h:i A'),
            ];
            $this->sendOrderNotification($order, new OrderCompleted($details));
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

    private function sendOrderNotification(Order $order, object $notification): void
    {
        $emails = $this->getNotificationEmailsForOrder($order);

        foreach ($emails as $email) {
            Notification::route('mail', $email)->notify($notification);
        }
    }

    private function getNotificationEmailsForOrder(Order $order): array
    {
        $emails = User::whereIn('role', [0, 1])
            ->whereNotNull('email')
            ->pluck('email')
            ->map(fn (string $email) => trim($email))
            ->filter()
            ->all();

        $creator = User::find($order->added_by);
        if ($creator && (int) $creator->role === 2 && ! empty($creator->email)) {
            $emails[] = trim($creator->email);
        }

        if ($creator && in_array((int) $creator->role, [0, 1], true) && ! empty($order->associated_email)) {
            $emails[] = trim($order->associated_email);
        }

        return array_values(array_unique($emails));
    }
}
