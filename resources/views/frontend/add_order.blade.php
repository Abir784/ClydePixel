<x-app-layout>
    <x-slot name="header">
            {{ __('Add Order') }}
    </x-slot>

<div class="card">
    <div class="card-body">
        <form action="{{ route('order.post')}}" method="POST">
            @csrf
            <div class="row gy-3">
                <div class="col-12">
                  <label class="form-label">Name <b class="text-danger">*</b></label>
                  <input type="text" name="name" class="form-control" placeholder="Enter Name" >
                     <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                </div>
                <div class="col-12 mb-2">
                    <label class="form-label">Folder Name <b class="text-danger">*</b></label>
                    <input type="text" name="folder_name" class="form-control" placeholder="Enter Folder Name" >
                       <x-input-error :messages="$errors->get('folder_name')" class="mt-2 text-danger" />
                </div>
                <div class="col-12 mt-2">
                    <b>
                        Type of job :<br>
                        Enter the number of files in each category.
                    </b>
                </div>
                <div class="row gy-2">
                    @forelse ($orderFields->where('is_active', true) as $field)
                        <div class="col-4">
                            <label class="form-label">{{ $field->label }} @if($field->is_required)<b class="text-danger">*</b>@endif</label>
                            <input
                                type="number"
                                name="dynamic_fields[{{ $field->field_key }}]"
                                class="form-control sum-field"
                                min="0"
                                value="{{ old('dynamic_fields.' . $field->field_key) }}"
                                placeholder="{{ $field->label }}"
                            >
                            <x-input-error :messages="$errors->get('dynamic_fields.' . $field->field_key)" class="mt-2 text-danger" />
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                No active order fields are configured. Ask a super admin to add fields from Order Fields.
                            </div>
                        </div>
                    @endforelse
                    <div class="col-4">
                        <label class="form-label">Total File <b class="text-danger"></b></label>
                        <input type="number" name="total_file" id="result"  class="form-control" placeholder="Total Files" readonly>
                    </div>
                </div>
                <div class="row gy-2">
                    <div class="col-6">
                        <label class="form-label">Deadline <b class="text-danger">*</b></label>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <input type="number" name="hours" id="hours" class="form-control" name="hours" min="0" max="100" value="0" required>
                            </div>
                            <div class="col-auto">
                                Hr <span>:</span>
                            </div>
                            <div class="col-auto">
                                <input type="number" name="minutes" id="minutes" class="form-control" name="minutes" min="0" max="59" value="0" required>
                            </div>
                            <div class="col-auto">
                                Min
                            </div>
                       <x-input-error :messages="$errors->get('hours')" class="mt-2 text-danger" />
                        <x-input-error :messages="$errors->get('minutes')" class="mt-2 text-danger" />

                        </div>


                    </div>
                    <div class="col-6">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" cols="" rows=""></textarea>
                    </div>


                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary-600">Submit</button>
                </div>
              </div>

    </div>
</div>



<x-slot name="script">
    <script>
        function sumSpecificFields() {
            const sumFields = document.querySelectorAll('.sum-field');
            let sum = 0;

            sumFields.forEach(field => {
                sum += parseFloat(field.value) || 0;
            });

            document.getElementById('result').value = sum;
        }

        document.querySelectorAll('.sum-field').forEach(field => {
            field.addEventListener('input', sumSpecificFields);
        });
        sumSpecificFields();
    </script>
    @if(session('success'))
    <script>
        let timerInterval;
        Swal.fire({
        title: "Order Created Successfully",
        html: "",
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
            timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log("I was closed by the timer");
        }
        });

    </script>
    @endif

        <script>
            function getTime() {
                const hours = document.getElementById('hours').value;
                const minutes = document.getElementById('minutes').value;
                alert(`Timer set for: ${hours} hours and ${minutes} minutes.`);
            }
        </script>
</x-slot>


</x-app-layout>

