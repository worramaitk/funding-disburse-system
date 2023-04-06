@extends('layouts.page')

@section('title')
<title>Your files</title>
@endsection

@section('main')
    <div class="container">
        <br />
        <h1 class="text-center text-primary">Your uploaded Files</h1>
        <br />

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>username</th>
                        <th>amount</th>
                        <th>edit</th>
                        <th>view</th>
                        <th>download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            {{-- <td> <a href="{{ Storage::download($row->file_path); }}"> {{ $row->file_path }} </a> </td> --}}
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->amount }}</td>
                            <td><a href="{{ url('/file/edit',$row->id) }}">edit</a></td>
                            <td><a href="{{ url('/file/show',$row->id) }}">view</a></td>
                            <td><a href="{{ url('/file/download',$row->id) }}">download</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
