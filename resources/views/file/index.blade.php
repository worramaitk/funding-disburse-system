<?php
function echocell($string,$link,$class = "")
{
    echo '<td class="'.$class.' text-dark"><a href="'.url('/file/show',$link).'">'.$string.'</a></td>';
}            ?>

@extends('layouts.page')

@section('title')
<title>Your files</title>
@endsection

@section('main')
    <div class="container">

        <style>
.custom-card.bg-light {
  background-color: blanchedalmond !important;
  /* border-radius: 3px; */
  color: dimgray;
  /* text-decoration: underline; */
}

.custom-card.bg-dark {
  background-color: darkslategray !important;
  /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
  color: gainsboro;
  /* text-decoration: overline; */
}

.approved-card.bg-light {
  background-color: rgb(128, 255, 128) !important;
  /* border-radius: 3px; */
  color: black;
  /* text-decoration: underline; */
}

.approved-card.bg-dark {
  background-color: rgb(0, 100, 0) !important;
  /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
  color: white;
  /* text-decoration: overline; */
}

.denied-card.bg-light {
  background-color: rgb(255, 128, 128) !important;
  /* border-radius: 3px; */
  color: black;
  /* text-decoration: underline; */
}

.denied-card.bg-dark {
  background-color: rgb(100, 0, 0) !important;
  /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
  color: white;
  /* text-decoration: overline; */
}

.pending-card.bg-light {
  background-color: rgb(128, 128, 255) !important;
  /* border-radius: 3px; */
  color: black;
  /* text-decoration: underline; */
}

.pending-card.bg-dark {
  background-color: rgb(0, 0, 100) !important;
  /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
  color: white;
  /* text-decoration: overline; */
}
            td a {
                display: block;
                padding: 5px;
            }
            /* a {
    color: black;
    text-decoration: underline;
} */
            .table-sm>:not(caption)>*>* {
                padding: 0rem 0rem;
            }
            .table-hover>tbody>tr:hover>* {
                --bs-table-accent-bg: var(--bs-table-hover-bg);
                color: var(--bs-table-hover-color);
            }
        </style>

        {{-- <div class="table-responsive">
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
                            // echocell($row->id,$row->id);
                            // echocell($row->name,$row->id);
                            // echocell($row->username,$row->id);
                            // echocell($row->amount,$row->id);

                            // echocell($row->created_at,$row->id);
                            // echocell($row->updated_at,$row->id);
                            ?>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
        {{-- <div class="d-grid gap-3 mb-3"> --}}
        <div class="row">
            <div class="col-12">
                <h1 class="pt-4 text-center">Your uploaded Files</h1>
                <h2 class="text-center">Total amount of money:
                    <?php
                        $totalamount = 0;
                        foreach ($data as $row) {
                            $totalamount = $totalamount + $row->amount;
                        }
                        echo $totalamount;
                    ?>
                </h2>
            </div>
            {{-- gap-3 defines spacing between each cards --}}
            <?php
            foreach($data as $row){
            ?>
            <div class="col-md-6 col-lg-4">
            <?php
            if($row->status == 'approved') {
            ?>
                <div class="card my-3 approved-card bg-light" style="width: 18rem;">
            <?php
            } else if($row->status == 'denied') {
            ?>
                <div class="card my-3 denied-card bg-light" style="width: 18rem;">
            <?php
            } else if($row->status == 'pending'){
            ?>
                <div class="card my-3 pending-card bg-light" style="width: 18rem;">
            <?php
            } else {
            ?>
                <div class="card my-3" style="width: 18rem;">
            <?php
            }
            ?>
                <?php
                $is_img = false;
                $img_count = 0;
                foreach (array('.apng','.avif','.gif','.jpg','.jpeg','.jfif','.pjpeg','.pjp','.png','.svg','.webp') as $file_ext){
                    if(str_ends_with($row->name,$file_ext)){
                        $is_img = true;
                    }
                }
                if($is_img){
                ?>
                    <img src="/file/serve/{{$row->id}}" class="card-img-top" alt="#'.$row->id''">
                <?php
                    $img_count += 1;
                }
                ?>
                    <div class="card-body">
                        <h5 class="card-title">{{$row->name}}</h5>
                        <p class="card-text">id: {{$row->id}} <br> username: {{$row->username}} <br> amount: {{$row->amount}} <br> created_at: {{$row->created_at}} <br> updated_at: {{$row->updated_at}} status: {{$row->status}}</p>
                        <a class="btn p-1 btn-primary" href="/file/edit/{{$row->id}}" role="button">edit</a>
                        <a class="btn p-1 btn-primary" href="/file/serve/{{$row->id}}" role="button">view raw</a>
                        <?php
                        $uselessvar = 0; //check if admin
                        if (Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"){
                            $uselessvar++;
                        } else {
                        ?>
                        <a class="btn p-1 btn-primary" href="/file/download/{{$row->id}}" role="button">download</a>
                        <a class="btn p-1 btn-primary" href="/file/destroy/{{$row->id}}" role="button">delete this file</a>
                        <a class="btn p-1 btn-success" href="/admin/approve/{{$row->id}}" role="button">approve</a>
                        <a class="btn p-1 btn-danger" href="/admin/deny/{{$row->id}}" role="button">deny</a>
                        <?php
                        } //closing admin check if statement
                        ?>
                    </div>
                </div>
            </div>
            <?php
            } //closing for each statement
            ?>



@endsection
