@extends('layouts.page')

@section('title')
<title>Home</title>
@endsection

@section('main')
    <div class="container">
        <h1 class="mt-5"><br>ระบบเบิกจ่ายเงิน รายวิชาโครงงาน </h1>
        <p class="lead">คณะวิศวกรรมศาสตร์ มหาวิทยาลัยสงขลานครินทร์</p>
        <p class="lead">สร้างด้วย Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
    </div>

    <button type="button" class="btn btn-primary" id="toastbtn">Show Toast</button>

    <div class="toast">
      <div class="toast-header">
        <strong class="me-auto">Toast Header</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <p>Some text insstide the toast body</p>
      </div>
    </div>
@endsection
