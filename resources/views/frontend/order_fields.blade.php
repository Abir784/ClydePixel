<x-app-layout>
    <x-slot name="header">Order Fields</x-slot>

    <div class="card mb-24">
        <div class="card-body">
            <h6 class="mb-16">Add New Field</h6>
            <form action="{{ route('order.fields.store') }}" method="POST">
                @csrf
                <div class="row gy-3">
                    <div class="col-md-4">
                        <label class="form-label">Field Label <b class="text-danger">*</b></label>
                        <input type="text" name="label" value="{{ old('label') }}" class="form-control" placeholder="e.g. Shadow Creation">
                        <x-input-error :messages="$errors->get('label')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Field Key (optional)</label>
                        <input type="text" name="field_key" value="{{ old('field_key') }}" class="form-control" placeholder="shadow_creation">
                        <x-input-error :messages="$errors->get('field_key')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sort Order</label>
                        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control">
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-4">
                        <div class="form-check mb-0">
                            <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">Required</label>
                        </div>
                        <div class="form-check mb-0">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary-600">Add Field</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="mb-16">Configured Fields</h6>
            <div class="table-responsive">
                <table class="table border-primary-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Label</th>
                            <th>Key</th>
                            <th>Sort</th>
                            <th>Required</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fields as $index => $field)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $field->label }}</td>
                                <td><code>{{ $field->field_key }}</code></td>
                                <td>{{ $field->sort_order }}</td>
                                <td>{{ $field->is_required ? 'Yes' : 'No' }}</td>
                                <td>{{ $field->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('order.fields.toggle-active', $field->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $field->is_active ? 'btn-warning' : 'btn-success' }}">
                                                {{ $field->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('order.fields.delete', $field->id) }}" method="POST" onsubmit="return confirm('Delete this field?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No fields configured yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        @if(session('success'))
            <script>
                Swal.fire({
                    title: '{{ session('success') }}',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                });
            </script>
        @endif
    </x-slot>
</x-app-layout>
