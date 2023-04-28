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
            <table class="table table-bordered border-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>username</th>
                        <th>amount</th>
                        <th>status</th>
                        <th>timestamps</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td><a href="{{ url('/file/show',$row->id) }}">{{ $row->id }}</a></td>
                            <td><a href="{{ url('/file/show',$row->id) }}">{{ $row->name }}</a></td>
                            <td><a href="{{ url('/file/show',$row->id) }}">{{ $row->username }}</a></td>
                            <td><a href="{{ url('/file/show',$row->id) }}">{{ $row->amount }}</a></td>
                            <?php
                                if($row->status == 'approved') {
                                    echo '<td class="p-3 mb-2 bg-success text-white">approved</td>' ;
                                } else if($row->status == 'denied') {
                                    echo '<td class="p-3 mb-2 bg-danger text-white">denied</td>' ;
                                } else if($row->status == 'pending'){
                                    echo '<td class="p-3 mb-2 bg-primary text-white">pending</td>' ;
                                } else {
                                    echo '<td>What the hell this shouldn\'t be possible</td>' ;
                                }
                            ?>
                            <td><a href="{{ url('/file/show',$row->id) }}">{{ $row->timestamps }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
