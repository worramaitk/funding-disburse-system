@extends('layouts.page')

@section('title')
<title>Debug page</title>
@endsection

@section('main')
    <div class="container mt-5">
        <form action="{{route('usertest')}}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5 "><br>Log in as a custom user (for depug purposes)</h3>

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
                <label for="amount">text: </label>
                <textarea type="text" class="form-control bg-light" id="text" name="text" class="border-gray-500 border-2" value="" >{"username":"admin91","first_name":"WORRAMAIT","last_name":"KOSITPAIBOON","staff_id":"6110110391","email":"mingmaomak@gmail.com","campus_id":"01","fac_id":"06","dept_id":"034","pos_id":"10","access_token":"fb245c4e018d59b77fbb6cfa00b7acc3aa2eeb1a","expires_in":1800,"token_type":"Bearer","scope":"userinfo","refresh_token":"b1abac663d80625ccc1ee0a84539d670ceca76ad"}</textarea>

            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Log in as a custom user</button>
        </form>
    </div>
@endsection

