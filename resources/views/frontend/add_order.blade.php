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
                    <div class="col-4">
                        <label class="form-label">Simple Clipping</label>
                        <input type="number" name="simple_clipping" class="form-control" id="sumField" placeholder="Simple Clipping" >
                       <x-input-error :messages="$errors->get('simple_clipping')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">In Clip 2 In 1</label>
                        <input type="number" name="in_clip_2_in_1" class="form-control" id="sumField" placeholder="In Clip 2 In 1" >
                       <x-input-error :messages="$errors->get('in_clip_2_in_1')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">In Clip 3 In </label>
                        <input type="number" name="in_clip_3_in_1" class="form-control" id="sumField" placeholder="In Clip 3 In" >
                       <x-input-error :messages="$errors->get('in_clip_3_in_1')" class="mt-2 text-danger" />
                    </div>
                </div>
                <div class="row gy-2">
                    <div class="col-4">
                        <label class="form-label">Layer Masking</label>
                        <input type="number" name="layer_masking" class="form-control" id="sumField" placeholder="Layer Masking" >
                       <x-input-error :messages="$errors->get('layer_masking')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Retouch</label>
                        <input type="number" name="retouch" class="form-control" id="sumField" placeholder="Retouch" >
                       <x-input-error :messages="$errors->get('retouch')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Neckjoin</label>
                        <input type="number" name="neckjoin" class="form-control" id="sumField" placeholder="Neckjoin" >
                       <x-input-error :messages="$errors->get('neckjoin')" class="mt-2 text-danger" />
                    </div>
                </div>
                <div class="row gy-2">
                    <div class="col-4">
                        <label class="form-label">Recolor</label>
                        <input type="number" name="recolor" class="form-control" id="sumField" placeholder="Enter Folder Name" >
                       <x-input-error :messages="$errors->get('recolor')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Neek Joint With Lequefy</label>
                        <input type="number" name="neek_joint_wit_lequefy" id="sumField" class="form-control" placeholder="Neek Joint With Lequefy" >
                       <x-input-error :messages="$errors->get('neek_joint_wit_lequefy')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Clipping with liquefy</label>
                        <input type="number" name="clipping_with_liquefy" id="sumField" class="form-control" placeholder="Clipping with liquefy" >
                       <x-input-error :messages="$errors->get('clipping_with_liquefy')" class="mt-2 text-danger" />
                    </div>
                </div>
                <div class="row gy-2">
                    <div class="col-4">
                        <label class="form-label">Vector Graphics</label>
                        <input type="number" name="vector_graphics" id="sumField" class="form-control" placeholder="Enter Folder Name" >
                       <x-input-error :messages="$errors->get('vector_graphics')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Complex Multi Path</label>
                        <input type="number" name="complex_multi_path" id="sumField" class="form-control" placeholder="Complex Multi Path" >
                       <x-input-error :messages="$errors->get('complex_multi_path')" class="mt-2 text-danger" />
                    </div>
                    <div class="col-4">
                        <label class="form-label">Total File <b class="text-danger"></b></label>
                        <input type="number" name="total_file" id="result"  class="form-control" placeholder="Total Files" readonly>
                       <x-input-error :messages="$errors->get('total_file')" class="mt-2 text-danger" />
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
            const sumFields = document.querySelectorAll('input#sumField');
            let sum = 0;

            sumFields.forEach(field => {
                sum += parseFloat(field.value) || 0;
            });

            document.getElementById('result').value = sum;
        }

        document.querySelectorAll('input#sumField').forEach(field => {
            field.addEventListener('input', sumSpecificFields);
        });
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

