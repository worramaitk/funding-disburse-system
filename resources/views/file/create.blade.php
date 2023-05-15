@extends('layouts.page')

@section('title')
<title>อัปโหลดใบเสร็จ</title>
@endsection

@section('main')
    <div class="container mt-5">
        <form action="{{ route('file-store') }}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5"><br>อัปโหลดใบเสร็จ</h3>
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
                <label class="custom-file-label" for="chooseFile">เลือกไฟล์ (สามารถเลือกหลายไฟล์พร้อมกันได้)</label>
                <br>
                <label for="amount">ตั้งชื่อไฟล์ใหม่ ถ้าเว้นช่องนี้ว่างจะไม่มีการเปลี่ยนชื่อไฟล์ (ถ้าเลือกอัปโหลดหลายไฟล์พร้อมกันจะเปลี่ยนชื่อไฟล์ทั้งหมด):</label>
                <input class="form-control bg-light" type="text" id="name" name="name" class="border-gray-500 border-2" value="" >
                <br>
                <label for="amount">กำหนดปริมาณเงิน (฿) (ถ้าเลือกอัปโหลดหลายไฟล์พร้อมกันจะทุกไฟล์จะมีจำนวนเงินเท่ากันทั้งหมด):</label>
                <input class="form-control bg-light" type="text" id="amount" name="amount" class="border-gray-500 border-2" value="0" >
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">อัปโหลดข้อมูล</button>
        </form>
    </div>
@endsection

