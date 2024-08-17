
<div class="py-12">
    <div class="card">

        <div class="card-header">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your account's profile information.") }}
            </p>
        </div>
            <div class="card-body">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    <div class="row gy-3">
                        <div class="col-12">
                          <label class="form-label">Full Name</label>
                          <input type="text" name="name" class="form-control" placeholder="Enter First Name" value="{{Auth::user()->name}}">
                             <x-input-error :messages="$errors->get('name')" class="mt-2" />

                        </div>
                        <div class="col-12">
                          <label class="form-label">Email</label>
                          <input type="email" name="email"  class="form-control" placeholder="Enter Email" value="{{Auth::user()->email}}" readonly>
                              <x-input-error :messages="$errors->get('email')" class="mt-2" />

                        </div>
                </div>
                        <div class="col-12">
                          <label class="form-label">Phone</label>
                          <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{Auth::user()->phone_number}}">
                          <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />

                        </div>

                        <div class="col-12 mt-6">
                          <button type="submit" class="btn btn-primary-600">Submit</button>
                        </div>
                      </div>
                      <div class="flex items-center gap-4">
                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-success-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
              </div>
            </div>
        </div>
