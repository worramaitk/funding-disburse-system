@extends('layouts.page')

@section('title')
<title>Your files</title>
@endsection

@section('main')
    <div class="container">
        <br />
        <h1 class="text-center text-primary">Your uploaded Files</h1>
        <h2 class="text-center">Total amount of money:
            <?php
                $totalamount = 0;
                foreach ($data as $row) {
                    $totalamount = $totalamount + $row->amount;
                }
                echo $totalamount;
            ?>

        </h2>
        <br />

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>username</th>
                        <th>amount</th>
                        <th>view</th>
                        <th>send message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->amount }}</td>
                            <td><a href="{{ url('/file/show',$row->id) }}">view</a></td>
                            <td><a href="{{ url('/message/create',$row->id) }}">send</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
