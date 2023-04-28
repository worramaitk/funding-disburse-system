<?php
function echocell($string,$link,$class = "")
{
    echo '<td class="'.$class.'"><a href="'.url('/file/show',$link).'">'.$string.'</a></td>';
}            ?>

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

        <style>
            td a {
                display: block;
                padding: 5px;
            }
            a {
    color: black;
    text-decoration: underline;
}
            .table-sm>:not(caption)>*>* {
                padding: 0rem 0rem;
            }
            .table-hover>tbody>tr:hover>* {
                --bs-table-accent-bg: var(--bs-table-hover-bg);
                color: var(--bs-table-hover-color);
            }
        </style>

        <div class="table-responsive">
            <table class="table table-sm table-bordered border-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>username</th>
                        <th>amount</th>
                        <th>status</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <?php
                            echocell($row->id,$row->id);
                            echocell($row->name,$row->id);
                            echocell($row->username,$row->id);
                            echocell($row->amount,$row->id);
                            if($row->status == 'approved') {
                                echocell('approved',$row->id,"table-success");
                            } else if($row->status == 'denied') {
                                echocell('denied',$row->id,"table-danger");
                            } else if($row->status == 'pending'){
                                echocell('pending',$row->id,"table-primary");
                            } else {
                                echo '<td>What the hell this shouldn\'t be possible</td>' ;
                            }
                            echocell($row->created_at,$row->id);
                            echocell($row->updated_at,$row->id);
                            ?>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
