@extends('layouts.page')

@section('title')
<title>Viewing {{$data->name}}</title>
@endsection

@section('main')
<div class="container">
    <h1 class="mt-5"><br>Viewing {{$data->name}}</h1>
    <iframe src="/file/serve/{{$data->id}}" ></iframe>
</div>
@endsection
