<x-app-layout>
    <x-slot name="header"> Emails</x-slot>

    <div class="conrainer">
        <div class="card">
            <div class="card-body">
                <div class="card-header mb-5">
                    <b>Enter the Emails you want to send Notifications of Order Creation and Order Completion.</b>
                </div>
                <form action="{{route('email.post')}}" method="POST">
                    @csrf
                    <div class="row gy-3">
                        <div class="col-12">
                          <label class="form-label">Name <b class="text-danger">*</b></label>
                          <input type="text" name="name" class="form-control" required placeholder="Enter Email" >
                             <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                        </div>
                    <div class="row gy-3">
                        <div class="col-12">
                          <label class="form-label">Email <b class="text-danger">*</b></label>
                          <input type="email" name="email" class="form-control" required placeholder="Enter Email" >
                             <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-600">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table border-primary-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check style-check d-flex align-items-center">
                                <label class="form-check-label">S.L</label>
                            </div>
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mails as $key=>$mail )
                    <tr>

                        <td>{{$key+1}}</td>
                        <td>{{$mail->name}}</td>

                        <td>{{$mail->email}}</td>

                        <td>
                            <button type="button" onclick="Deletion('{{$mail->id}}')" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>

                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
    <x-slot name="script">


<script>
    function Deletion(id){
     Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
             if (result.isConfirmed) {
                 $.ajax({
                     url: '{{ route('email.delete') }}',
                     type: 'POST',
                     data: {
                         id: id,
                         _token: '{{ csrf_token() }}'
                     },
                     success: function(response) {
                         Swal.fire(
                             'Deleted!',
                             response.success,
                             'success'
                         ).then(() => {
                             location.reload();
                         });;

                     },
                     error: function(xhr, status, error) {
                         Swal.fire(
                             'Error!',
                             xhr.responseJSON.error,
                             'error'
                         );
                     }
                 });
             }
         });
         }
     </script>

    </x-slot>
</x-app-layout>
