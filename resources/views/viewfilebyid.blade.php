
@extends('layouts.head')
<title>Viewing {{$data->name}}</title>
@extends('layouts.top')

<!-- Begin page content -->
<main class="flex-shrink-0">
<div class="container">
    <h1 class="mt-5"><br>Viewing {{$data->name}}</h1>
    <iframe src="/file/serve/{{$data->id}}" ></iframe>
</div>
</main>

@extends('layouts.bottom')
