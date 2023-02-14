<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.Landing.meta')

    <title>@yield('title') | Serv</title>

    @stack('before-style')
    @include('includes.Landing.style')
    @stack('after-style')
</head>

<body class="antialiased">
    <div class="relative">
        @include('includes.Landing.header')

        @include('sweetalert::alert')

        @yield('content')

        @include('includes.Landing.footer')

        @stack('before-script')
        @include('includes.Landing.script')
        @stack('after-script')

        {{-- Modals --}}
        @include('components.Modal.login')
        @include('components.Modal.register')
        @include('components.Modal.register-success')

        {{-- @if ($errors->has('email') || $errors->has('password'))
            <script>
            $(function() {
                // $('#loginModal').modal({
                //     show: true
                // });

                toggleModal('loginModal');
            });
            </script>
        @endif --}}
    </div>
</body>

</html>
