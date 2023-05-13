@extends('layouts.page')

@section('title')
<title>Home</title>
@endsection

@section('main')
    <div class="container">
        <h1 class="mt-5">Open source licenses</h1>
        <p class="lead">Laravel ver. {{ Illuminate\Foundation\Application::VERSION }} (PHP ver. {{ PHP_VERSION }}) </p>
        <p>The Laravel framework is open-sourced software licensed under the MIT license.</p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://laravel.com/">Laravel website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://opensource.org/licenses/MIT">MIT License</a>
        <p class="lead">Bootstrap ver. 5.3.0 </p>
        <p>Bootstrap is released under the MIT license and is copyright 2023.</p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://getbootstrap.com">Bootstrap website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://getbootstrap.com/docs/5.3/about/license/">Bootstrap License</a>
        <p class="lead">Vectors and icons by SVG Repo.</p>
        <p>"Weather Moon SVG Vector" and "Home 1 SVG Vector" were licensed under CC Attribution License.</p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com">SVG Repo website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com/page/licensing#CC%20Attribution">SVG Repo License</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com/svg/381328/weather-moon">Weather Moon SVG Vector</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com/svg/488999/home-1">Home 1 SVG Vector</a>
    </div>
@endsection

