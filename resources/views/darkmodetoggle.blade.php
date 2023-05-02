@extends('layouts.page')
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

<title>Test dark mode</title>

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
                        <button type="button" class="btn btn-dark" onclick="myFunction()">☀️/🌙</button>
                        @auth
                            <li>
                                <a class="nav-link disabled">Current user: {{ Auth::user()->username }}</a>
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

@section('main')
<style>
    body {
      padding: 25px;
      background-color: white;
      color: black;
      font-size: 25px;
    }

    .dark-mode {
      background-color: black;
      color: white;
    }
    </style>

    <h2>Toggle Dark/Light Mode</h2>
    <p>Click the button to toggle between dark and light mode for this page.</p>

    <script>
    function myFunction() {
       var element = document.main;
       element.classList.toggle("dark-mode");
    }
    </script>
@endsection

