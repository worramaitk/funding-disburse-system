@extends('layouts.page')

@section('title')
<title>Event Calendar</title>
<link href="{{ url('/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('/css/calendar.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main')
<div class="content home">
    <?= $calendar?>
</div>
@endsection
