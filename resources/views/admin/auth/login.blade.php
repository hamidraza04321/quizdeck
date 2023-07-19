<!DOCTYPE HTML>
<html>
<head>
    <title>{{ \App\Settings::find(1)->app_name }} | LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ \App\Settings::find(1)->logo }}"/>
    <link rel="stylesheet" href="{{ asset('/admin/assets/auth/css/style.css') }}" type="text/css" media="all" />
    <link href="{{ asset('/admin/assets/auth/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/admin/assets/libs/toastr/build/toastr.css') }}">
</head>
<body>
    <input type="hidden" id="base_url" value="{{ asset('/') }}">
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="context">
        <h1>Welcome to {{ \App\Settings::find(1)->app_name }}</h1>
        <div class="sub-main-w3">
            <!-- vertical tabs -->
            <div class="vertical-tab">
                <div id="section1" class="section-w3ls">
                    <input type="radio" name="sections" id="option1" checked>
                    <label for="option1" class="icon-left-w3pvt"><span class="fa fa-user-circle" aria-hidden="true"></span>Login</label>
                    <article class="login-form">
                        <div class="loading"></div>
                        <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <h3 class="legend">Login Here</h3>
                            <div class="input input-username margin-bottom-8px">
                                <span class="fa fa-user" aria-hidden="true"></span>
                                <input id="username" type="text" placeholder="Username" name="username" required />
                            </div>
                            <div class="input input-password mb-0">
                                <span class="fa fa-key" aria-hidden="true"></span>
                                <input id="password" type="password" placeholder="Password" name="password" required />
                            </div>
                            <button type="submit" class="btn submit" id="login-btn">Login</button>
                        </form>
                    </article>
                </div>
                <div id="section2" class="section-w3ls">
                    <input type="radio" name="sections" id="option2">
                    <label for="option2" class="icon-left-w3pvt"><span class="fa fa-pencil-square" aria-hidden="true"></span>Register</label>
                    <article class="register-form">
                        @if(\App\Settings::find(1)->user_registration == 0)
                            <h2 class="message-wrap">Sorry! There have no permission to register from administrator.</h2>
                        @else
                            <div class="loading-regster"></div>
                            <form action="#" method="post">
                                <h3 class="legend">Register Here</h3>
                                <div class="input input-register-fullname">
                                    <span class="fa fa-user-o" aria-hidden="true"></span>
                                    <input id="register-fullname" type="text" placeholder="Enter Your Full Name" name="name" required />
                                </div>
                                <div class="input input-register-username">
                                    <span class="fa fa-user-o" aria-hidden="true"></span>
                                    <input id="register-username" type="text" placeholder="Username" name="name" required />
                                </div>
                                <div class="input input-register-password">
                                    <span class="fa fa-key" aria-hidden="true"></span>
                                    <input id="register-password" type="password" placeholder="Password" name="password" required />
                                </div>
                                <button type="submit" id="register-btn" class="btn submit">Register</button>
                            </form>
                        @endif
                    </article>
                </div>
                <div id="section3" class="section-w3ls">
                    <input type="radio" name="sections" id="option3">
                    <label for="option3" class="icon-left-w3pvt"><span class="fa fa-lock" aria-hidden="true"></span>Forgot Password?</label>
                    <article class="reset-password">
                        <div class="loading-reset-password"></div>
                        <form action="{{ route('password.email') }}" method="POST" id="reset-password-form" style="min-height: 308px;">
                            @csrf
                            <h3 class="legend last">Reset Password</h3>
                            <p class="para-style">Enter your email address below and we'll send you an email with instructions.</p>
                            <div class="input input-email">
                                <span class="fa fa-envelope-o" aria-hidden="true"></span>
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" placeholder="Enter Your Email">
                            </div>
                            <button type="submit" id="btn-reset-password" class="btn submit last-btn">Reset</button>
                        </form>
                    </article>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <script src="{{ asset('/admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/sweetalert/all.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/auth/auth.js') }}"></script>
    <script>
        @if($show_reset_password_alert)
            Swal.fire(
                'Password Reset',
                'Password Reset Successfully.',
                'success'
            );
        @endif
        @if(Session::has('logout'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Logout Successfully !'
            })
        @endif
    </script>
</body>
</html>