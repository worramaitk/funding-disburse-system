@extends('layouts.page')

@section('title')
<title>ใบเสร็จทั้งหมดของคุณ</title>
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

        {{-- <div class="d-grid gap-3 mb-3"> --}}
        <div class="row">
            <div class="col-12">
                <h1 class="pt-4 text-center">
                    <?php
                        echo $titleText;
                    ?>
                </h1>
                <h2 class="text-center">
                    <?php
                        echo $total;
                    ?>
                </h2>
            </div>
            {{-- gap-3 defines spacing between each cards --}}
            <?php
            foreach($data as $row){
            ?>



            <div class="col-md-6 col-lg-4">
                <div class="card my-3
            <?php
            if($row->status == 'approved') {
                echo ' approved-card bg-light';
            } else if($row->status == 'denied') {
                echo ' denied-card bg-light';
            } else if($row->status == 'pending'){
                echo ' pending-card bg-light';
            } else {
                echo ' bg-light';
            }
            ?>
            " style="width: 18rem;">
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
                        <p class="card-text">id: {{$row->id}} <br> username: {{$row->username}} <br> ปริมาณเงิน(฿): {{$row->amount}} <br> created_at: {{$row->created_at}} <br> updated_at: {{$row->updated_at}} status: {{$row->status}}</p>
                        <a class="btn p-1 btn-primary" href="/file/edit/{{$row->id}}" role="button">แก้ไข</a>
                        <a class="btn p-1 btn-primary" href="/file/serve/{{$row->id}}" role="button">ดูไฟล์นี้เปล่าๆ</a>
                        <a class="btn p-1 btn-primary" href="/file/download/{{$row->id}}" role="button">ดาวน์โหลด</a>
                        <a class="btn p-1 btn-primary" href="/file/destroy/{{$row->id}}" role="button">ลบไฟล์นี้</a>
                        <?php
                        $uselessvar = 0; //check if admin
                        if (Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"){
                            $uselessvar++;
                        } else {
                        ?>
                        <a class="btn p-1 btn-success" href="/admin/approve/{{$row->id}}" role="button">อนุมัติ</a>
                        <a class="btn p-1 btn-danger" href="/admin/deny/{{$row->id}}" role="button">ปฏิเสธ</a>
                        <?php
                        } //closing admin check if statement
                        ?>
                    </div>
                </div>
            </div>
            <?php
            } //closing “foreach($data as $row)” statement
            ?>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {!! $data->links() !!}
            </div>

@endsection
