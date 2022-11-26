@extends('layouts.users')

@section('head')
    <style>
        .section-50 {
            padding: 50px 0;
        }

        .m-b-50 {
            margin-bottom: 50px;
        }

        .dark-link {
            color: #333;
        }

        .heading-line {
            position: relative;
            padding-bottom: 5px;
        }

        .heading-line:after {
            content: "";
            height: 4px;
            width: 75px;
            background-color: #29B6F6;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .notification-ui_dd-content {
            margin-bottom: 30px;
        }

        .notification-list {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 20px;
            margin-bottom: 7px;
            background: #fff;
            -webkit-box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .notification-list--unread {
            border-left: 2px solid #29B6F6;
        }

        .notification-list .notification-list_content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .notification-list .notification-list_content .notification-list_img img {
            height: 48px;
            width: 48px;
            border-radius: 50px;
            margin-right: 20px;
        }

        .notification-list .notification-list_content .notification-list_detail p {
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .notification-list .notification-list_feature-img img {
            height: 48px;
            width: 48px;
            border-radius: 5px;
            margin-left: 20px;
        }

    </style>
@endsection

@section('content')
    <div main id="main" class="main">
        <h1>Dashboard</h1>
        <!-- accordion begins -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>

        <section class="section-50">
            <div class="container">
                <h3 class="m-b-50 heading-line">Unread Notifications <i class="fa fa-bell text-muted"></i></h3>

                <div class="notification-ui_dd-content">
                    @forelse ($unread as $unredNotification)
                        <div class="notification-list notification-list--unread">
                            <div class="notification-list_content">
                                <div class="notification-list_img">

                                </div>
                                <div class="notification-list_detail">
                                    <p><b>{{ $unredNotification->data['message'] }}</b></p>
                                    <p class="text-muted"></p>
                                    <p class="text-muted"><small>{{ $unredNotification->created_at->diffForHumans() }}</small></p>
                                </div>
                            </div>
                            <div class="notification-list_feature-img">
                                <a data-id="{{ $unredNotification->id }}" class="mark-as-read"  href="#0"><p class="text-muted text-success"><small>Mark as Read</small></p></a>
                            </div>
                        </div>
                    @empty
                    <div class="notification-list notification-list--unread">
                        <div class="notification-list_content">
                            <div class="notification-list_img">

                            </div>
                            <div class="notification-list_detail">
                                <p class="text-muted">There are no new Notifications</p>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="section-50">
            <div class="container">
                <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3>

                <div class="notification-ui_dd-content">
                    @forelse ($notifications->where('read_at', '!=', null) as $notification)
                        <div class="notification-list">
                            <div class="notification-list_content">
                                <div class="notification-list_img">

                                </div>
                                <div class="notification-list_detail">
                                    <p><b>{{ $notification->data['message'] }}</b></p>
                                    <p class="text-muted"></p>
                                    <p class="text-muted"><small>{{ $notification->created_at->diffForHumans() }}</small></p>
                                </div>
                            </div>
                            <div class="notification-list_feature-img">
                                <a href="#0" data-id="{{ $notification->id }}" class="delelte-notification"><p class="text-muted text-danger"><small>Delete</small></p></a>
                            </div>
                        </div>
                    @empty
                    <div class="notification-list notification-list--unread">
                        <div class="notification-list_content">
                            <div class="notification-list_img">

                            </div>
                            <div class="notification-list_detail">
                                <p class="text-muted">There are no new Notifications</p>
                            </div>
                        </div>
                    </div>
                    @endforelse

                </div>
                {{ $notifications->links() }}
            </div>
        </section>
    </div>

@endsection
@section('scripts')
    <script>
        $('.mark-as-read').click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('user.notification.read') }}",
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id
                },
                success: function(response) {
                    window.location.href = "{{ route('user.notification.index') }}";
                }
            });
        });

        $('.delelte-notification').click(function() {
            if (confirm('Are you sure you want to Delete this Notification?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('user.notification.delete') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id
                    },
                    success: function(response) {
                        window.location.href = "{{ route('user.notification.index') }}";
                    }
                });
            }
        });
    </script>
@endsection
