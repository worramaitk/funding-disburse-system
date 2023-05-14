@extends('layouts.page')

@section('title')
<title>Home</title>
@endsection

@section('main')
<div class="container">
    <h1 class="mt-5"> ประกาศ </h1>
    <?php
    if($announcementexists){
    ?>
        <p class="lead">{{$title}}</p>
        <p>{{$text}}</p>
        <p class="lead">สร้างเมื่อ: {{$createdat}} โดย: {{$username}} , แก้ไขครั้งสุดท้ายเมื่อ: {{$updatedat}}</p>
    <?php
    } else {
    ?>
        <p class="lead">ขณะนี้ยังไม่มีประกาศ</p>
    <?php
        }
    ?>

    @auth
        @if(!(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"))


            <div class="container mt-5">
                <form action="{{ route('announce') }}" method="post" enctype="multipart/form-data">
                  <h1 class="text-center mb-5">เพิ่ม/แก้ไขประกาศ</h1>
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
                        <label for="amount">หัวข้อ:</label>
                        <input type="text" class="form-control bg-light" id="title" name="title" class="border-gray-500 border-2" value="{{$title}}" >
                        <br>
                        <label for="amount">เนื้อหา: </label>
                        <textarea type="text" class="form-control bg-light" id="text" name="text" class="border-gray-500 border-2" value="" >{{$text}}</textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">เพิ่ม/แก้ไขประกาศ</button>
                    <a class="btn btn-block mt-4 btn-danger" href="/admin/del" role="button">ลบประกาศออก</a>
                </form>
            </div>


        @endif
    @endauth
</div>
@endsection
