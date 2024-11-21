<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register | Hyper - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    </head>

    <body class="loading authentication-bg">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <a href="index.html">
                                    <span><img src="assets/images/logo.png" alt="" height="18"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Free Sign Up</h4>
                                    <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
                                </div>

                                <!-- Validation Errors -->
                                <x-validation-errors class="mb-4" />

                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Name -->
                                    <div class="form-group">
                                        <x-label for="name" value="{{ __('Name') }}" />
                                        <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group">
                                        <x-label for="email" value="{{ __('Email') }}" />
                                        <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group">
                                        <x-label for="password" value="{{ __('Password') }}" />
                                        <x-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-group">
                                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                        <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    </div>

                                    <!-- Contact -->
                                    <div class="form-group">
                                        <x-label for="contact" value="{{ __('Contact') }}" />
                                        <x-input id="contact" class="form-control" type="text" name="contact" :value="old('contact')" required />
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group">
                                        <x-label for="address" value="{{ __('Address') }}" />
                                        <x-input id="address" class="form-control" type="text" name="address" :value="old('address')" required />
                                    </div>

                                    <!-- Contact Person -->
                                    <div class="form-group">
                                        <x-label for="contact_person" value="{{ __('Contact Person') }}" />
                                        <x-input id="contact_person" class="form-control" type="text" name="contact_person" :value="old('contact_person')" required />
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <x-label for="status" value="{{ __('Status') }}" />
                                        <x-input id="status" class="form-control" type="text" name="status" :value="old('status')" required />
                                    </div>

                                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="form-group">
                                            <x-label for="terms">
                                                <div class="flex items-center">
                                                    <x-checkbox name="terms" id="terms" required />
                                                    <div class="ms-2">
                                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </x-label>
                                        </div>
                                    @endif

                                    <div class="form-group mb-0 text-center">
                                        <x-button class="btn btn-primary">
                                            {{ __('Register') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Already have account? <a href="{{ route('login') }}" class="text-muted ml-1"><b>Log In</b></a></p>
                            </div> <!-- end col-->
                        </div> <!-- end row -->

                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end container -->
        </div> <!-- end page -->

        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
        </footer>

        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
    </body>
</html>
