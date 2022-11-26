@extends('layouts.admin')

@section('header')
    <link rel="stylesheet" href="{{ asset('shared_dasboard\css\admin\user\index.css') }}">
@endsection

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('panel') }}">Home</a></li>
                    <li class="breadcrumb-item active">Homepage Settings</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Logo</h4>
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-2"></div>
                        <div class="col-8 text-center">
                            <form action="{{ route('panel.admin.homesettings.logo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <img style="height: 20rem; width: 30rem;" src="{{ !empty($settings['site_logo']) ? asset($settings['site_logo']) : asset('site-logo/default-logo.png') }}"
                                    class="img-fluid img-thumbnail" id="output" alt="Profile">
                                <div class="pt-4" x-data>
                                    <div type="button" @click="$refs.logo.click()" class="btn btn-primary btn-sm"
                                        title="Upload new profile image"><i class="bi bi-files"></i> Browse Logo</div>
                                    <input type="file" accept="image/*" name="logo" class="hidden-xs-up"
                                        onchange="loadFile(event)" x-ref="logo" id="logo">
                                    <button type="button" id="deleteLogo" class="btn btn-danger btn-sm" title=""><i
                                            class="bi bi-trash"></i> Delete Logo</button>
                                    <button type="submit" class="btn btn-success btn-sm" title=""><i class="bi bi-save"></i>
                                        Save Logo</button>
                                </div>
                                @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                            </form>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contact Us</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.admin.homesettings.contact.update') }}" method="POST"
                        class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label">Contact Address</label>
                            <input type="text" name="contact_address" class="form-control"
                                value="{{ $settings['contact_address'] ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="form-label">
                                Contact Phone Number
                            </label>
                            <input type="number" name="phone_number" class="form-control"
                                value="{{ $settings['contact_mobile'] ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="form-label">
                                Contact Email
                            </label>
                            <input type="email" name="contact_email" class="form-control"
                                value="{{ $settings['contact_email'] ?? '' }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="" class="form-label">
                                Open Hours
                            </label>
                            <input type="text" name="open_hour" class="form-control"
                                value="{{ $settings['contact_open_hour'] ?? '' }}">
                        </div>

                        <div class="form-group mt-3">
                            <button style="float: right;" class="btn btn-sm btn-primary">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </main>
@endsection
@push('scripts')
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        $("#deleteLogo").click(function() {
            if (confirm('Are you sure you want to Delete Site Logo?')) {
                $.ajax({
                    url: "{{ route('panel.admin.homesettings.logo.delete') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == true) {
                            window.location.href = "";
                        } else {
                            window.location.href = "";
                        }
                    }
                });
            }
        });
    </script>
@endpush
