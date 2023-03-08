<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-left sm:items-left min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="sm:fixed sm:top-0 sm:left-0 p-6">
            <a class="text-xl font-semibold text-gray-900 hover:text-gray-900 dark:text-white dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ระบบเบิกจ่ายเงินรายวิชาโครงงาน คณะวิศวกรรมศาสตร์ มหาวิทยาลัยสงขลานครินทร์</a>
            </div> 
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6">
                    @auth
                        <a href="{{ url('/home') }}" class="text-xl font-semibold text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ไปที่หน้าหลัก</a>
                    @else
                        <a href="{{ url('/auth/psu') }}" class="text-xl font-semibold text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">คลิกเพื่อล็อกอินด้วย PSU Passport</a>
                    @endauth
                </div>
            @endif
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center bg-white">
                    <img src="{{ asset('img/logo01.png') }}" alt="PSU Engineering logo">
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        สร้างด้วย Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
