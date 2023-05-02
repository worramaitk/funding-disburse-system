@extends('layouts.page')

@section('title')
<title>Upload new file</title>
@endsection

@section('main')
    <div class="container mt-5">
        <form action="{{ route('file-store') }}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5"><br>Upload File</h3>
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
                <input type="file" name="files[]" class="custom-file-input" id="chooseFile" multiple>
                <label class="custom-file-label" for="chooseFile">Select file</label>
                <br>
                <label for="amount">File name (if you choose to overwrite):</label>
                <input type="text" id="name" name="name" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">Amount of money for this receipt:</label>
                <input type="text" id="amount" name="amount" class="border-gray-500 border-2" value="0" >
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Upload Files</button>
        </form>
    </div>
@endsection

