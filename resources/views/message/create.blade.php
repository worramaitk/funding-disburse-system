@extends('layouts.page')

@section('title')
<title>send new message</title>
@endsection

@section('main')
    <div class="container mt-5">
        <form action="{{ route('message-store',$data->id) }}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5"><br>send new message</h3>
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
                <label for="amount">username of the recipient: </label>
                <input type="text" id="usernamerecipi" name="name" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">title: </label>
                <input type="text" id="title" name="title" class="border-gray-500 border-2" value="0" >
                <br>
                <label for="amount">text: </label>
                <textarea type="text" id="text" name="text" class="border-gray-500 border-2" value="0" ></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">send this message</button>
        </form>
    </div>
@endsection

