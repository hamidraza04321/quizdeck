<!DOCTYPE HTML>
<html>
<head>
    <title>{{ \App\Settings::find(1)->app_name }} | RESET PASSWORD</title>
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
        <div class="sub-main-w3">
            <!-- vertical tabs -->
            <article class="reset-password">
                <div class="loading-reset-password-form"></div>
                <form method="POST" action="{{ route('password.update') }}" id="reset-password-form">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <h3 class="legend">Reset Password</h3>
                    <div class="input input-email" style="margin-bottom: 8px;">
                        <span class="fa fa-envelope-o" aria-hidden="true"></span>
                        <input id="email" type="email" placeholder="Email" name="email" required value="{{ $email ?? old('email') }}" />
                    </div>
                    <div class="input input-new-password" style="margin-bottom: 8px;">
                        <span class="fa fa-key" aria-hidden="true"></span>
                        <input id="new-password" type="password" placeholder="New Password" name="password" required />
                    </div>
                    <div class="input input-confirm-password mb-0" style="margin-bottom: 8px; margin-top:8px;">
                        <span class="fa fa-key" aria-hidden="true"></span>
                        <input id="confirm-password" type="password" placeholder="Confirm Password" name="password_confirmation" required />
                    </div>
                    <button type="submit" class="btn submit" id="reset-password-btn">Reset</button>
                </form>
            </article>
            <div class="clear"></div>
        </div>
    </div>
    <script src="{{ asset('/admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/libs/sweetalert/all.min.js') }}"></script>
    <script src="{{ asset('/admin/assets/auth/auth.js') }}"></script>
</body>
</html>