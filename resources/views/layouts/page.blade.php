<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    @yield('title')
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
        font-size: 3.5rem;
        }
    }

    .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    main > .container {
        padding: 60px 15px 0;
    }

    </style>

    <!-- Custom styles for this template -->
    <link href="sticky-footer-navbar.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand">ระบบเบิกจ่ายเงิน รายวิชาโครงงาน</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-1 mb-md-0">
                <li class="nav-item">
                    {{-- me-2 from https://getbootstrap.com/docs/5.2/utilities/spacing/ --}}
                    {{-- code from https://laraveldaily.com/post/how-to-check-current-url-or-route --}}
                    @if (request()->is('home'))
                        <a class="btn btn-secondary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                    @else
                        <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/home') }}">
                    @endif
                    Home</a>
                </li>
                <li class="nav-item">
                    @if (request()->is('file/create'))
                        <a class="btn btn-secondary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                    @else
                        <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/file/create') }}">
                    @endif
                    Upload new file</a>
                </li>
                <li class="nav-item">
                    @if (request()->is('file/index'))
                        <a class="btn btn-secondary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                    @else
                        <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/file/index') }}">
                    @endif
                    Your files</a>
                </li>
                </ul>


                <form class="d-flex" role="search">
                    <ul class="navbar-nav me-auto mb-1 mb-md-0">
                        @auth
                            <li>
                                <div class="form-check form-switch ms-auto">
                                    <!-- LIGHT SWITCH -->
                                    {{-- https://github.com/han109k/light-switch-bootstrap --}}
                                    <label class="form-check-label ms-3" for="lightSwitch">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="50"
                                        height="50"
                                        fill="white"
                                        stroke="white"
                                        viewBox="0 0 25 25"
                                        preserveAspectRatio="xMinYMin meet"
                                        {{-- This line causes some weird black line inside the moon SVG
                                            class="bi bi-brightness-high" --}}
                                        {{-- viewBox="0 0 16 16 0" --}}
                                        >
                                        {{-- moon SVG from https://www.svgrepo.com/svg/381328/weather-moon --}}
                                        <path
                                        d="M20.14,14.84a.58.58,0,0,0-.19,0H19.9l-.25.11h0a8.3,8.3,0,0,1-2.95.53A8.51,8.51,0,0,1,8.17,7a8,8,0,0,1,.39-2.5.79.79,0,0,0,.06-.22,1.1,1.1,0,0,0,0-.18,1,1,0,0,0-1-1,.86.86,0,0,0-.36.07h0L7,3.32A10,10,0,1,0,21,16.39a0,0,0,0,1,0,0l.09-.19a.75.75,0,0,0,0-.16,1.1,1.1,0,0,0,0-.18A1,1,0,0,0,20.14,14.84ZM12,20.5A8.5,8.5,0,0,1,6.83,5.26,9.29,9.29,0,0,0,6.67,7a10,10,0,0,0,12.4,9.71A8.54,8.54,0,0,1,12,20.5Z"
                                        />
                                        </svg>
                                    </label>
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="lightSwitch"
                                        style="height: 40px; width: 100px;"
                                    />
                                </div>
                            </li>
                            <li>
                                <a class="nav-link">Current user: {{ Auth::user()->username }}</a>
                            </li>
                            <li>
                                <a class="btn btn-primary" href="{{ url('/auth/logout') }}" role="button">Log out</a>
                            </li>
                        @else
                            <li>
                                <a class="btn btn-primary" href="{{ url('/auth/psu') }}" role="button">Log in with PSU Passport</a>
                            </li>
                        @endauth
                    </ul>
                </form>
            </div>
            </div>
        </nav>
        </header>

<!-- Begin page content -->
<main class="flex-shrink-0 h-75">
    @yield('main')
</main>

<!-- Footer ; "float-start" adjust text to the left while "float-end" adjust text to the right -->
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <p class="float-start">© 2023 คณะวิศวกรรมศาสตร์ มหาวิทยาลัยสงขลานครินทร์ </p>
        <p class="float-end"><a href="https://oauth2.eng.psu.ac.th/policies/privacy">นโยบายความเป็นส่วนตัว</a> <a href="https://oauth2.eng.psu.ac.th/policies/terms">ข้อกำหนดในการให้บริการ</a></p>
    </div>
</footer>


<script>
document.getElementById("toastbtn").onclick = function() {
  var toastElList = [].slice.call(document.querySelectorAll('.toast'))
  var toastList = toastElList.map(function(toastEl) {
    return new bootstrap.Toast(toastEl)
  })
  toastList.forEach(toast => toast.show())
  console.log("button clicked")
}
</script>
    {{-- <script src="../assets/dist/js/bootstrap.bundle.min.js"></script> --}}

</body>
</html>
