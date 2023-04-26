@extends('layouts.page')

@section('title')
<title>Debug page</title>
@endsection

@section('main')
    <div class="container mt-5">
        <form action="{{route('usertest')}}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5"><br>Log in as a custom user</h3>
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

            <div class="custom-user">
                <br>
                <label for="amount">username:</label>
                <input type="text" id="username" name="username" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">first_name:</label>
                <input type="text" id="first_name" name="first_name" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">last_name:</label>
                <input type="text" id="last_name" name="last_name" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">staff_id:</label>
                <input type="text" id="staff_id" name="staff_id" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">email:</label>
                <input type="text" id="email" name="email" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">campus_id:</label>
                <input type="text" id="campus_id" name="campus_id" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">fac_id:</label>
                <input type="text" id="fac_id" name="fac_id" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">dept_id:</label>
                <input type="text" id="dept_id" name="dept_id" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">pos_id:</label>
                <input type="text" id="pos_id" name="pos_id" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">access_token:</label>
                <input type="text" id="access_token" name="access_token" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">expires_in:</label>
                <input type="text" id="expires_in" name="expires_in" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">token_type:</label>
                <input type="text" id="token_type" name="token_type" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">scope:</label>
                <input type="text" id="scope" name="scope" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">refresh_token:</label>
                <input type="text" id="refresh_token" name="refresh_token" class="border-gray-500 border-2" value="" >
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Log in as a custom user</button>
        </form>
    </div>
@endsection

