

<x-app-layout>
    <x-slot name="header">
       Add User
    </x-slot>

    <div class="py-12">
        <div class="card">
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                              <label class="form-label">Full Name</label>
                              <input type="text" name="name" class="form-control" placeholder="Enter First Name">
                                 <x-input-error :messages="$errors->get('name')" class="mt-2" />

                            </div>
                            <div class="col-12">
                              <label class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" placeholder="Enter Email">
                                  <x-input-error :messages="$errors->get('email')" class="mt-2" />

                            </div>
                            <div class="col-12">
                              <label class="form-label">Phone</label>
                              <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number" >
                              <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />

                            </div>
                            <div class="col-12">
                              <label class="form-label">Password</label>
                              <input type="password" name="password" class="form-control" placeholder="Enter Password" autocomplete="new-password">
                              <x-input-error :messages="$errors->get('password')" class="mt-2" />

                            </div>
                            <div class="col-12">
                              <label class="form-label">Confirm Password</label>
                              <input type="password" name="password_confirmation" class="form-control"  placeholder="Enter Confirm Password" autocomplete="new-password">

                            </div>
                            <div class="col-12">
                              <label class="form-label">Role</label>
                              <Select class="form-select" name="role">
                                  <option value="">--Select Role--</option>

                                  @if (Auth::user()->role==0)
                                  <option value="0">Super Admin</option>
                                  @endif
                                  <option value="1">Admin</option>
                                  <option value="2">Client</option>
                              </Select>
                              <x-input-error :messages="$errors->get('role')" class="mt-2" />

                            </div>
                            <div class="col-12">
                              <button type="submit" class="btn btn-primary-600">Submit</button>
                            </div>
                          </div>
                    </form>

                  </div>
                </div>
        </div>
<x-slot name="script">
    @if(session('success'))
    <script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "User added",
            showConfirmButton: false,
            timer: 1500
            });
    </script>
    @endif
</x-slot>



</x-app-layout>
