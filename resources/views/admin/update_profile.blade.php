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
                            <li class="breadcrumb-item active">Update Profile</li>
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
                                <h3 class="card-title">Update Profile</h3>
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

                            <form method="POST" action="{{url('admin/updateProfile')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{Auth::guard('admin')->user()->email}}" readonly style="background-color: #666;">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{Auth::guard('admin')->user()->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Enter mobile" name="mobile" value="{{Auth::guard('admin')->user()->mobile}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="profile_image">Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input mb-2" id="profile_image" placeholder="Profile Image" name="profile_image">
                                            <label class="custom-file-label" for="profile_image">Image</label>
                                        </div>
                                        @if(!empty(Auth::guard('admin')->user()->image))
                                            <img src="{{asset(Auth::guard('admin')->user()->image)}}" alt="{{Auth::guard('admin')->user()->name}}" width="80" class="mt-2" />
                                        @endif
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

@endsection
