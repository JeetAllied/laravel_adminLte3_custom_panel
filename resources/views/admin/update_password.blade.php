@extends('admin.layout.layout')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-6">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Password</h3>
                            </div>

                            <!-- show validation errors -->
                            @if ($errors->any())
                                <div class="container mt-2">
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{url('admin/updatePassword')}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{Auth::guard('admin')->user()->email}}" readonly style="background-color: #666;">
                                    </div>
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" placeholder="Enter Current Password" name="current_password">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" class="form-control" id="new_password" placeholder="New Password" name="new_password">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" placeholder="Confirm Password" name="new_password_confirmation">
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </section>

    </div>

    @section('script')
        <script src="{{url('admin/js/custom.js')}}"></script>
    @endsection

@endsection
