@extends('layouts.page')

@section('title')
<title>Viewing {{$data->name}}</title>
@endsection

@section('main')
<div class="container h-100">
    <h1 class="text-center">Viewing file {{$data->name}}</h1>
    <h3 class="">file name: {{$data->name}}</h3>
    <h3 class="">Amount of money for this receipt: {{$data->amount}}</h3>
    <a class="btn btn-primary" href="/file/edit/{{$data->id}}" role="button">edit</a>
    <a class="btn btn-primary" href="/file/serve/{{$data->id}}" role="button">view raw</a>
    <a class="btn btn-primary" href="/file/download/{{$data->id}}" role="button">download</a>
    <a class="btn btn-primary" href="/file/destroy/{{$data->id}}" role="button">delete this file</a>
    {{-- <iframe src="/file/serve/{{$data->id}}" ></iframe> --}}
    {{-- following code is from: https://stackoverflow.com/questions/23218332/how-to-do-auto-width-with-html-iframe --}}
    <?php
    $is_img = 0;
    foreach (array('.apng','.avif','.gif','.jpg','.jpeg','.jfif','.pjpeg','.pjp','.png','.svg','.webp') as $file_ext){
        if(str_ends_with($data->name,$file_ext)){
            $is_img = 1;
        }
    }
    ?>
    @if($is_img == 1)
        <img
        src="/file/serve/{{$data->id}}"
        frameborder="0"
        style="overflow:hidden;"/>
    @else
        <iframe
        src="/file/serve/{{$data->id}}"
        frameborder="0"
        style="overflow:hidden;height:100%;width:100%"></iframe>
    @endif
</div>
@endsection
