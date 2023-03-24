<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- code based on https://www.youtube.com/watch?v=dFgzHOX84xQ&ab_channel=TraversyMedia -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--  <link rel="stylesheet" href="css/main.css" /> -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <title>Landing Page</title>

    <script>
      var currentdate = new Date(); 
      var currentTimeVar = currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds() + " "
                + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + "";  

      document.getElementById("currentTimeJs").innerHTML = currentTimeVar;
    </script>
  </head>
  <body class="bg-white dark:bg-gray-800">
    <!-- Navbar -->
    <nav class="width:100% mx-auto p-2 bg-black dark:bg-black">
      <!-- Flex container -->
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <div class="p-2 flex">
          <img class="object-scale-down h-10 bg-white" src="{{ asset('img/logo01.png') }}" alt="" />
          <button class="rounded-full p-2 bg-transparent text-white">ระบบเบิกจ่ายเงินรายวิชาโครงงาน คณะวิศวกรรมศาสตร์ มหาวิทยาลัยสงขลานครินทร์</button>
        </div> 
        <!-- Menu Items --> 
        <div class="hidden space-x-6 md:flex">
            <a href="{{ url('/home') }}" > <button class="rounded-full p-2 bg-gray-800 hover:bg-red-800 text-white">Home</button> </a>
            <a><button class="rounded-full p-2 bg-blue-800 text-blue-200 ">Upload files</button> </a>
            <a href="{{ url('/home/listfiles') }}" > <button class="rounded-full p-2 bg-gray-800 hover:bg-red-800 text-white">Files Uploaded</button> </a>
            <a> <button class="rounded-full p-2 bg-transparent text-white"> <a id = "currentTimeJs" class=" text-white"></a> </button> </a>
            @if (Route::has('login'))
                @auth
                    <button class="rounded-full p-2 bg-blue-800 text-blue-200 "">Logged in as: {{ Auth::user()->username }}</button> 
                    <a href="{{ url('/auth/logout') }}" > <button class="rounded-full p-2 bg-gray-800 hover:bg-red-800 text-white">Log out</button> </a>
                @else
                    <a href="{{ url('/auth/psu') }}" > <button class="rounded-full p-2 bg-gray-800 hover:bg-red-800 text-white">Log in with PSU Passport</button> </a>
                @endauth
            @endif
        </div>
        <!-- Button -->

        <!-- Hamburger Icon -->
        <button
          id="menu-btn"
          class="block hamburger pr-2 md:hidden focus:outline-none"
        >
          <span class="hamburger-top"></span>
          <span class="hamburger-middle"></span>
          <span class="hamburger-bottom"></span>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div class="md:hidden">
        <div
          id="menu"
          class="absolute flex-col items-center hidden self-end py-8 mt-10 space-y-6 font-bold bg-gray-800 sm:w-auto sm:self-center left-6 right-6 drop-shadow-md"
        >
          <a href="{{ url('/home') }}"  class=" text-white">Home</a>
          <a class=" text-blue-200 ">Upload files</a>
          <a href="{{ url('/home/listfiles') }}" class=" text-white">Files Uploaded</a>
          <a id = "currentTimeJs" class=" text-white"></a>
          @if (Route::has('login'))
            @auth
                <a class=" text-blue-200">Logged in as: {{ Auth::user()->username }}</a> 
                <a href="{{ url('/auth/logout') }}" class=" text-white" >Log out</a>
            @else
                <a href="{{ url('/auth/psu') }}" class=" text-white" > Log in with PSU Passport</a>
            @endauth
        @endif
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero">
      <div class="container mt-5">
          <form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
            <h3 class="text-center mb-5">Upload File</h3>
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
                  <input type="file" name="file" class="custom-file-input" id="chooseFile">
                  <label class="custom-file-label" for="chooseFile">Select file</label>
                  <br>
                  <label for="amount">Amount of money for this receipt:</label>
                  <input type="text" id="amount" name="amount" class="border-gray-500 border-2" value="0" >
              </div>
              <button type="submit" name="submit" class="rounded-full p-2 bg-gray-800 hover:bg-red-800 text-white">Upload Files</button> 
          </form>
      </div>
    </section>

    <!-- <script src="js/script.js"></script> -->
  </body>
</html>