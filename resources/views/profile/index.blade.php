@extends('layouts.app')

@section('main')
<!-- Profile Page Title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                </ol>
            </div>
            <h4 class="page-title">Profile</h4>
        </div>
    </div>
</div>     
<!-- End Profile Page Title --> 

<div class="row">
    <div class="col-sm-12">
        <!-- Profile Card -->
        <div class="card bg-primary">
            <div class="card-body profile-user-box">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="media">
                            <span class="float-left m-2 mr-4 rounded-circle bg-light text-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 40px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->name, strrpos($user->name, ' ') + 1, 1)) }}
                            </span>
                            <div class="media-body">
                                <h4 class="mt-1 mb-1 text-white">{{ $user->name }}</h4>
                                <p class="font-13 text-white-50">Authorized User</p>
                                <!-- You can add more user-related information here -->
                                <ul class="mb-0 list-inline text-light">
                                    <li class="list-inline-item mr-3">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-light">
                                            <i class="mdi mdi-account-edit mr-1"></i> Edit Profile
                                        </a>
                                    </li>
                                </ul>
                            </div> <!-- end media-body-->
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row -->
            </div> <!-- end card-body / profile-user-box-->
        </div><!-- end profile / card -->
    </div> <!-- end col-->
</div>
<!-- end row -->
@endsection
