<div class="tab-content pt-2">

    <div class="tab-pane fade show active profile-overview" id="profile-overview">
        <!-- <h5 class="card-title">About</h5>
  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

        <h5 class="card-title">Profile Details</h5>

        <div class="row">
            <div class="col-lg-3 col-md-4 label ">Full Name</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->name }}</div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Country</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->country }}</div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">State</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->state }}</div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Town</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->town }}</div>
        </div>

        <!-- <div class="row">
    <div class="col-lg-3 col-md-4 label">Job</div>
    <div class="col-lg-9 col-md-8">Web Designer</div>
  </div> -->

        <div class="row">
            <div class="col-lg-3 col-md-4 label">My Referral Link</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->myCode }}</div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Phone</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->phone }}</div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 label">Email</div>
            <div class="col-lg-9 col-md-8">{{ $loggedUser->email }}</div>
        </div>

    </div>

    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

        <!-- Profile Edit Form -->
        <form action="{{ route('profile.update', $loggedUser->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                <div class="col-md-8 col-lg-9">
                    <img style="height: 5rem; width:5rem;" src="{{ $loggedUser->image() }}"
                        class="img-fluid rounded-circle" id="output" alt="Profile">
                    <div class="pt-2" x-data>
                        <div type="button" @click="$refs.profile_image.click()" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></div>
                        <input type="file" accept="image/*" name="profile_image" class="hidden-xs-up" onchange="loadFile(event)" x-ref="profile_image" id="profile_image">
                        <button type="button" id="deleteProfileImage" class="btn btn-danger btn-sm"
                            title="Remove my profile image"><i class="bi bi-trash"></i></button>
                    </div>
                    @error('profile_image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                <div class="col-md-8 col-lg-9">
                    <input name="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror"
                        id="fullName" value="{{ $loggedUser->name }}">
                    @error('full_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="Job" class="col-md-4 col-lg-3 col-form-label">Gender: </label>
                <div class="col-md-8 col-lg-9">
                    {{-- <input name="job" type="text" class="form-control @error('title') is-invalid @enderror" id="Job" value="{{$loggedUser->gender}}"> --}}
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">Select Gender</option>
                        <option value="male" {{ $loggedUser->gender === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $loggedUser->gender === 'female' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                    @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                <div class="col-md-8 col-lg-9">
                    <input name="country" type="text" class="form-control @error('country') is-invalid @enderror"
                        id="Country" value="{{ $loggedUser->country }}">
                    @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="state" class="col-md-4 col-lg-3 col-form-label">State</label>
                <div class="col-md-8 col-lg-9">
                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state"
                        value="{{ $loggedUser->state }}">
                    @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                <div class="col-md-8 col-lg-9">
                    <input name="address" type="text" class="form-control @error('address') is-invalid @enderror"
                        id="Address" value="{{ $loggedUser->town }}">
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                <div class="col-md-8 col-lg-9">
                    <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="Phone"
                        value="{{ $loggedUser->phone }}">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        id="Email" value="{{ $loggedUser->email }}">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form><!-- End Profile Edit Form -->

    </div>

    <div class="tab-pane fade pt-3" id="profile-settings">

        <!-- Settings Form -->
        <form>

            <div class="row mb-3">
                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                <div class="col-md-8 col-lg-9">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="changesMade" checked>
                        <label class="form-check-label" for="changesMade">
                            Changes made to your account
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="newProducts" checked>
                        <label class="form-check-label" for="newProducts">
                            Information on new products and services
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proOffers">
                        <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                        <label class="form-check-label" for="securityNotify">
                            Security alerts
                        </label>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form><!-- End settings Form -->

    </div>

    <div class="tab-pane fade pt-3" id="profile-change-password">
        <!-- Change Password Form -->
        <form action="{{ route('profile.password', $loggedUser->id) }}" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                <div class="col-md-8 col-lg-9">
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="currentPassword">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                <div class="col-md-8 col-lg-9">
                    <input name="newpassword" type="password" class="form-control @error('newpassword') is-invalid @enderror" id="newPassword">
                    @error('newpassword') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                <div class="col-md-8 col-lg-9">
                    <input name="renewpassword" type="password" class="form-control @error('renewpassword') is-invalid @enderror" id="renewPassword">
                    @error('renewpassword') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </form><!-- End Change Password Form -->

    </div>

</div><!-- End Bordered Tabs -->

@section('scripts')
    <script>

        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        $("#deleteProfileImage").click(function() {
            if (confirm('Are you sure you want to Delete Profile Picture?')) {
                $.ajax({
                    url: "{{ route('profile.image', $user->id) }}",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == true) {
                            window.location.href = "{{ route('profile', $user->id) }}";
                        } else {
                            window.location.href = "{{ route('profile', $user->id) }}";
                        }
                    }
                });
            }
        });
    </script>
@endsection
