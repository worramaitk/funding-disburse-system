@extends('layouts.page')

@section('title')
<title>แก้ไขข้อมูล</title>
@endsection

@section('main')
    <div class="container mt-5">
        <form action="{{ route('file-update',$data->id) }}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5">แก้ไขข้อมูล</h3>
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
                <br>
                <label for="amount">ตั้งชื่อไฟล์ใหม่ ถ้าเว้นช่องนี้ว่างจะไม่มีการเปลี่ยนชื่อไฟล์:</label>
                <input class="form-control bg-light" type="text" id="name" name="name" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">กำหนดปริมาณเงินใหม่ (฿) ถ้าเว้นช่องนี้ว่างจะไม่มีการเปลี่ยนปริมาณเงิน:</label>
                <input class="form-control bg-light" type="text" id="amount" name="amount" class="border-gray-500 border-2" value="" >
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">แก้ไขข้อมูล</button>
        </form>
    </div>
@endsection

