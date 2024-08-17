<x-app-layout>
    <x-slot name="header">
            {{ __('Users List') }}
    </x-slot>

    <div class="py-12">
    <div class="card">
        <div class="card-header">
            <div class="card-body">



    <div class="dashboard-main-body">
        <div class="card h-100 p-0 radius-12">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <a href="{{url('register')}}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                    Add New User
                </a>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">
                            <div class="d-flex align-items-center gap-10">
                                S.L
                            </div>
                          </th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Designation</th>
                          <th scope="col" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($users_list as $key=>$user )
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-10">
                                    {{$key+1}}
                                </div>
                            </td>

                          <td>
                            <div class="d-flex align-items-center">

                              <div class="flex-grow-1">
                                <span class="text-md mb-0 fw-normal text-secondary-light">{{$user->name}}</span>
                              </div>
                            </div>
                          </td>
                          <td><span class="text-md mb-0 fw-normal text-secondary-light">{{$user->email}}</span></td>
                          @if ($user->role == 0)
                          <td>Super Admin</td>
                          @elseif($user->role == 1)
                          <td>Admin</td>
                          @else
                          <td>Client</td>

                          @endif
                          <td class="text-center">
                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                <button type="button" onclick="EyeView('{{$user->name}}','{{$user->email}}','{{$user->phone_number}}','{{$user->role}}','{{$user->created_at}}')" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                </button>

                                <button type="button" onclick="Deletion('{{$user->id}}')" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                </a>
                            </div>
                          </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"> No Users Added Yet</td>
                        </tr>

                        @endforelse

                      </tbody>

                    </table>
                <div class="col-3 mt-3">
                    {{ $users_list->links() }}
                </div>
             </div>
           </div>
         </div>
        </div>
    </div>
 </div>



<x-slot name="script">
<script>
        function EyeView(name,email,phone,role,created_at){
            if (role == 0){
            var role= 'Super Admin'
            }else if(role==1){
                var role = 'Admin'

            }else{
                var role = 'Client'
            }
            var date=new Date(created_at)
            var date_format = date.toDateString()
            Swal.fire({
            title: "",
            icon: "info",
            html: `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title></title>
                </head>
                <body>
                    <h5> User Information</h5>
                    <table border="1" cellpadding="10px">
                        <thead>
                            <tr>
                                <th>Name: </th>
                                <td>${name}</td>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Email: </th>
                                <td>${email} </td>

                            </tr>
                            <tr>
                                <th>Phone: </th>
                                <td>${phone} </td>

                            </tr>
                                <tr>
                                <th>Role: </th>
                                <td>${role} </td>

                            </tr>       <tr>
                                <th>Joining Date: </th>
                                <td>${date_format} </td>

                            </tr>
                        </tbody>
                    </table>
                </body>
                </html>
            `,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonAriaLabel: "Thumbs up, great!",

    });

}
</script>






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
                    url: '{{ route('user.delete') }}',
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













