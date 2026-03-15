<?php

namespace App\Http\Controllers;

use App\Models\OrderField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderFieldController extends Controller
{
    public function index(): View
    {
        abort_if(Auth::user()->role !== 0, 403);

        $fields = OrderField::orderBy('sort_order')->orderBy('id')->get();

        return view('frontend.order_fields', [
            'fields' => $fields,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if(Auth::user()->role !== 0, 403);

        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'field_key' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/', Rule::unique('order_fields', 'field_key')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_required' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $fieldKey = $data['field_key'] ?? '';
        if ($fieldKey === '') {
            $fieldKey = Str::slug($data['label'], '_');
        }

        $baseKey = $fieldKey;
        $suffix = 1;
        while (OrderField::where('field_key', $fieldKey)->exists()) {
            $fieldKey = $baseKey . '_' . $suffix;
            $suffix++;
        }

        OrderField::create([
            'label' => $data['label'],
            'field_key' => $fieldKey,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_required' => (bool) ($data['is_required'] ?? false),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return back()->with('success', 'Order field added successfully.');
    }

    public function destroy(OrderField $orderField): RedirectResponse
    {
        abort_if(Auth::user()->role !== 0, 403);

        $orderField->delete();

        return back()->with('success', 'Order field deleted successfully.');
    }

    public function toggleActive(OrderField $orderField): RedirectResponse
    {
        abort_if(Auth::user()->role !== 0, 403);

        $orderField->update([
            'is_active' => ! $orderField->is_active,
        ]);

        $message = $orderField->is_active
            ? 'Order field activated successfully.'
            : 'Order field deactivated successfully.';

        return back()->with('success', $message);
    }
}
