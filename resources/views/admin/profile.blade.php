@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->  
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content">
            <!-- Centered forms -->
            <?php if(isset($data['success_msg']) && $data['success_msg']){ ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">Well done!</span> <?php echo $data['success_msg']; ?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($data['danger_msg']) && $data['danger_msg']){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-styled-left alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">Oh snap!</span> <?php echo $data['danger_msg']; ?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($errors->all()) && $errors->all()){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-styled-left alert-dismissible">


                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach ($errors->all() as $error)

                            <span class="font-weight-semibold">Oh snap!</span> {{ $error }}
                            <br>
                        @endforeach


                    </div>
                </div>

            </div>
            <?php } ?>
            @if(session()->has('success'))

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Well done!</span> {{ session()->get('success') }}
                        </div>
                    </div>
                </div>


            @endif
            @if(session()->has('error'))

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-styled-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Oh snap!</span>{{ session()->get('error') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <div class="header-elements-inline">
                                        <h5 class="card-title">Profile Settings</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <form action="{{ url('admin/profile/update') }}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <div class="form-group required">
                                            <label class="control-label">Username:</label>
                                            <input type="text" name = "name" class="form-control" value="{{Auth::user()->name}}" >
                                        </div>

                                        <div class="form-group">
                                            <label>Email Address:</label>
                                            <input type="text" class="form-control" value="{{Auth::user()->email}}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" placeholder="Type Your Password" class="form-control" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password:</label>
                                            <input type="password" class="form-control" placeholder="Re-Type Your Password" name="cpassword">
                                        </div>
                                        <div class="form-group">
                                            <label>Choose Profile Picture:</label>
                                            <input type="file" class="form-control" name="avtar_url" >
                                        </div>

                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /form centered -->

        </div>
        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection
