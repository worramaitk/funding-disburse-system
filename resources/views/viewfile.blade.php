<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>View Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
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
    <a class="navbar-brand" >ระบบเบิกจ่ายเงิน รายวิชาโครงงาน</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home/uploadfiles') }}">Upload new file</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home/listfiles') }}">Files Uploaded</a>
            </li>
        </ul>


        <form class="d-flex" role="search">
            @auth
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li>
                        <a class="nav-link disabled">Logged in as: {{ Auth::user()->username }}</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/auth/logout') }}">Log out</a>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li>
                        <a class="nav-link" href="{{ url('/auth/psu') }}">Log in with PSU passport</a>
                    </li>
                </ul>
            @endauth
        </form>
    </div>
    </div>
</nav>
</header>

<!-- Begin page content -->
<main class="flex-shrink-0">
<div class="container">
    <h1 class="mt-5"><br>{{$data->name}}</h1>
    <iframe src="/file/serve/{{$data->id}}" ></iframe>
</div>
</main>

<!-- Footer ; "float-start" adjust text to the left while "float-end" adjust text to the right -->
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <p class="float-start">© 2023 คณะวิศวกรรมศาสตร์ มหาวิทยาลัยสงขลานครินทร์</p>
        <p class="float-end"><a href="https://oauth2.eng.psu.ac.th/policies/privacy">นโยบายความเป็นส่วนตัว</a> <a href="https://oauth2.eng.psu.ac.th/policies/terms">ข้อกำหนดในการให้บริการ</a></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="../assets/dist/js/bootstrap.bundle.min.js"></script> --}}


</body>
</html>
