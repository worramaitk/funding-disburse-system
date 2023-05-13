@extends('layouts.page')

@section('title')
<title>Home</title>
@endsection

@section('main')
<div class="container">
    <h1 class="mt-5">Announcement</h1>
    <?php
    if($announcementexists){
    ?>
        <p class="lead">{{$title}}</p>
        <p>{{$text}}</p>
        <p class="lead">Created at: {{$createdat}} by: {{$username}} , Last updated at: {{$updatedat}}</p>
    <?php
    } else {
    ?>
        <p class="lead">There is currently no announcements.</p>
    <?php
        }
    ?>

    @auth
        @if(!(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"))


            <div class="container mt-5">
                <form action="{{ route('announce') }}" method="post" enctype="multipart/form-data">
                  <h1 class="text-center mb-5">Create/update annoucement</h1>
                    @csrf
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                  @endif
                  @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
                    <div class="custom-file">
                        <label for="amount">Title:</label>
                        <input type="text" id="title" name="title" class="border-gray-500 border-2" value="{{$title}}" >
                        <br>
                        <label for="amount">Text: </label>
                        <textarea type="text" id="text" name="text" class="border-gray-500 border-2" value="" >{{$text}}</textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Create/update annoucement</button>
                </form>
            </div>

            <a class="btn p-1 btn-danger" href="/admin/del" role="button">Delete/reset announcement</a>
        @endif
    @endauth
</div>
@endsection
