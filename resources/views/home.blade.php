@extends('layouts.page')

@section('title')
<title>Home</title>
@endsection

@section('main')
<div class="container">
    <h1 class="mt-5"> ประกาศ </h1>
    <?php
    if($announcementDoesNotExist){
    ?>
        <p class="lead">ขณะนี้ยังไม่มีประกาศ</p>
    <?php
    } else {
        foreach($data as $row){
    ?>
        <p class="lead">{{$row->title}}</p>
        <p>{{$row->text}}</p>
        <p class="lead"> ประกาศเมื่อ: {{$row->created_at}} โดย: {{$row->username}} , แก้ไขครั้งสุดท้ายเมื่อ: {{$row->updated_at}} , id: {{$row->id}}</p>
    <?php
        }
    }
    ?>

    <!-- Admin can manipulate existing announcements -->
    @auth
        @if(!(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"))
        <h1 class="mb-5">แก้ไขประกาศ</h1>
        <!-- check if announcement exist, if so show admin options to update them. -->
        <?php

        if(!$announcementDoesNotExist){
            foreach($data as $row){
        ?>
            <div class="container mt-5">
                <form action="{{ route('admin-update',$row->id) }}" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control bg-light" id="title" name="title" class="border-gray-500 border-2" value="{{$row->title}}" >
                        <br>
                        <label for="amount">เนื้อหา: </label>
                        <textarea type="text" class="form-control bg-light" id="text" name="text" class="border-gray-500 border-2" value="" >{{$row->text}}</textarea>
                        <p class="lead"> ประกาศเมื่อ: {{$row->created_at}} โดย: {{$row->username}} , แก้ไขครั้งสุดท้ายเมื่อ: {{$row->updated_at}} , id: {{$row->id}}</p>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">แก้ไขประกาศนี้</button>
                    <a class="btn btn-block mt-4 btn-danger" href="{{ route('admin-destroy',$row->id) }}" role="button">ลบประกาศนี้ออก</a>
                </form>
            </div>
        <?php
            }
        }
        ?>

        <!-- create a new announcement -->
            <div class="container mt-5">
                <h1 class="mb-5">เพิ่มประกาศ</h1>
                <form action="{{ route('admin-store') }}" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control bg-light" id="title" name="title" class="border-gray-500 border-2" value="" >
                        <br>
                        <label for="amount">เนื้อหา: </label>
                        <textarea type="text" class="form-control bg-light" id="text" name="text" class="border-gray-500 border-2" value="" ></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">สร้างประกาศนี้</button>
                </form>
            </div>
        @endif
    @endauth
</div>
@endsection
