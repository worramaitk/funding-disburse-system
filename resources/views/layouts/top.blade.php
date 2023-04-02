</head>
<body class="d-flex flex-column h-100">

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand">ระบบเบิกจ่ายเงิน รายวิชาโครงงาน</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    {{-- code from https://laraveldaily.com/post/how-to-check-current-url-or-route --}}
                    @if (request()->is('home'))
                        <a class="nav-link active" aria-current="page">Home</a>
                    @else
                        <a class="nav-link" href="{{ url('/home') }}">Home</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (request()->is('file/upload'))
                        <a class="nav-link active" aria-current="page">Upload new file</a>
                    @else
                        <a class="nav-link" href="{{ url('/file/upload') }}">Upload new file</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (request()->is('file/listyours'))
                        <a class="nav-link active" aria-current="page">Your files</a>
                    @else
                        <a class="nav-link" href="{{ url('/file/listyours') }}">Your files</a>
                    @endif
                </li>
                </ul>


                <form class="d-flex" role="search">
                    @auth
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li>
                                <a class="nav-link disabled">Current user: {{ Auth::user()->username }}</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ url('/auth/logout') }}">Log out</a>
                            </li>
                        </ul>
                    @else
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li>
                                <a class="nav-link" href="{{ url('/auth/psu') }}">Log in with PSU passport</a>
                            </li>
                        </ul>
                    @endauth
                </form>
            </div>
            </div>
        </nav>
        </header>


