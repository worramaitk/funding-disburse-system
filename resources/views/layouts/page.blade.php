<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    @yield('title')
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
        font-size: 3.5rem;
        }
    }

    .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    main > .container {
        padding: 60px 15px 0;
    }

    /* Footer */
    .footer.bg-light {
        background-color: rgb(240, 240, 240) !important;
        /* border-radius: 3px; */
        /* color: dimgray; */
        /* text-decoration: underline; */
    }

    .footer.bg-dark {
        background-color: rgb(32, 32, 32) !important;
        /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
        /* color: gainsboro; */
        /* text-decoration: overline; */
    }

    /* dropdown-menu */
    .dropdown-menu.bg-light {
        background-color: rgb(240, 240, 240) !important;
        /* border-radius: 3px; */
        color: black;
        /* text-decoration: underline; */
    }

    .dropdown-menu.bg-dark {
        background-color: rgb(32, 32, 32) !important;
        /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
        color: white;
        /* text-decoration: overline; */
    }

    /* dropdown-item */
    .dropdown-item.bg-light {
        background-color: rgb(240, 240, 240) !important;
        /* border-radius: 3px; */
        color: black;
        /* text-decoration: underline; */
    }

    .dropdown-item.bg-dark {
        background-color: rgb(32, 32, 32) !important;
        /* box-shadow: 10px 5px 5px rgba(246, 255, 219, 0.5); */
        color: white;
        /* text-decoration: overline; */
    }
    </style>

    <!-- Custom styles for this template -->
    <link href="sticky-footer-navbar.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-image: linear-gradient(black,rgb(64, 64, 64), rgb(16, 16, 16));">
            <div class="container-fluid">
            <a class="navbar-brand">ระบบเบิกจ่ายเงิน รายวิชาโครงงาน</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-1 mb-md-0">
                <li class="nav-item">
                    {{-- me-2 from https://getbootstrap.com/docs/5.2/utilities/spacing/ --}}
                    {{-- code from https://laraveldaily.com/post/how-to-check-current-url-or-route --}}
                    @if (request()->is('home'))
                        <a class="btn btn-primary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                    @else
                        <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/home') }}">
                    @endif
                    <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="37"
                                    height="37"
                                    fill="white"
                                    stroke="white"
                                    viewBox="1 1 20 20"
                                    preserveAspectRatio="xMinYMin meet"
                                    {{-- Without “home” style="margin-top: -0.5rem !important; margin-left: -0.5rem !important; margin-right: -0.65rem !important;" --}}
                                    style="margin-top: -0.95rem !important; margin-bottom: -0.5rem !important; margin-left: -0.5rem !important; margin-right: -0.3rem !important;"
                                    {{-- This line causes some weird black line inside the moon SVG
                                        class="bi bi-brightness-high" --}}
                                    >
                                    {{-- moon SVG from https://www.svgrepo.com/svg/381328/weather-moon --}}
                                    <path d="M19.0167 7.1419C19.6261 7.50161 20 8.15658 20 8.86423V18.0001C20 19.1047 19.1046 20.0001 18 20.0001H16C14.8954 20.0001 14 19.1047 14 18.0001V14C14 12.8955 13.1046 12 12 12V12C10.8954 12 10 12.8955 10 14V18.0001C10 19.1047 9.10457 20.0001 8 20.0001H6C4.89543 20.0001 4 19.1047 4 18.0001V8.86423C4 8.15658 4.37395 7.50161 4.98335 7.1419L10.9833 3.60023C11.6106 3.23 12.3894 3.23 13.0167 3.60023L19.0167 7.1419Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>

                                    </svg> </a>
                {{-- </li>
                <li class="nav-item"> --}}
                    @if (request()->is('file/create'))
                        <a class="btn btn-primary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                    @else
                        <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/file/create') }}">
                    @endif
                    Upload new file</a>
                {{-- </li>
                <li class="nav-item"> --}}
                    @if (request()->is('file/index'))
                        <a class="btn btn-primary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                    @else
                        <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/file/index') }}">
                    @endif
                    Your files</a>
                </li>
                @auth
                    @if(!(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"))
                        <li class="nav-item">
                            @if (request()->is('admin'))
                                <a class="btn btn-success mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
                            @else
                                <a class="btn btn-success mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/admin') }}">
                            @endif
                            Admin</a>
                        </li>
                    @endif
                @endauth
                </ul>


                <form class="d-flex" role="search">
                    <ul class="navbar-nav me-auto mb-1 mb-md-0">
                        <li>
                            <div class="form-check form-switch ms-auto">
                                <!-- LIGHT SWITCH -->
                                {{-- https://github.com/han109k/light-switch-bootstrap --}}
                                <label class="form-check-label ms-3" for="lightSwitch">
                                    <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="50"
                                    height="50"
                                    fill="white"
                                    stroke="white"
                                    viewBox="0 0 25 25"
                                    preserveAspectRatio="xMinYMin meet"
                                    {{-- This line causes some weird black line inside the moon SVG
                                        class="bi bi-brightness-high" --}}
                                    >
                                    {{-- moon SVG from https://www.svgrepo.com/svg/381328/weather-moon --}}
                                    <path
                                    d="M20.14,14.84a.58.58,0,0,0-.19,0H19.9l-.25.11h0a8.3,8.3,0,0,1-2.95.53A8.51,8.51,0,0,1,8.17,7a8,8,0,0,1,.39-2.5.79.79,0,0,0,.06-.22,1.1,1.1,0,0,0,0-.18,1,1,0,0,0-1-1,.86.86,0,0,0-.36.07h0L7,3.32A10,10,0,1,0,21,16.39a0,0,0,0,1,0,0l.09-.19a.75.75,0,0,0,0-.16,1.1,1.1,0,0,0,0-.18A1,1,0,0,0,20.14,14.84ZM12,20.5A8.5,8.5,0,0,1,6.83,5.26,9.29,9.29,0,0,0,6.67,7a10,10,0,0,0,12.4,9.71A8.54,8.54,0,0,1,12,20.5Z"
                                    />
                                    </svg>
                                </label>
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="lightSwitch"
                                    style="height: 40px; width: 100px;"
                                />
                            </div>
                        </li>
                        @auth
                        <li>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Current user: {{ Auth::user()->username }}
                            </button>
                            <ul class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButton1">
                              <li><a class="dropdown-item bg-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">User information</a></li>
                              <li><a class="dropdown-item bg-light" href="{{ url('/auth/logout') }}">Log out</a></li>
                            </ul>
                          </div>
                        </li>
                        @else
                        <li>
                            <a class="btn btn-primary mt-1 mb-1 me-2" href="{{ url('/auth/psu') }}" role="button">Log in with PSU Passport</a>
                        </li>
                        @endauth
                    </ul>
                </form>
            </div>
            </div>
        </nav>
        </header>

<!-- Begin page content -->
{{-- <main class="flex-shrink-0 h-75"> --}}
<main role="main" class="container">

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @auth
                        User information
                    @else
                        You're not logged in!
                    @endauth</h5>
                <!-- x shaped close button, we don't need it as there's already another close button in the footer -->
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  -->
                </div>
                <div class="modal-body">
                    @auth
                    <p>
                        username:       {{ Auth::user()->username       }}<br>
                        first_name:     {{ Auth::user()->first_name     }}<br>
                        last_name:      {{ Auth::user()->last_name      }}<br>
                        staff_id:       {{ Auth::user()->staff_id       }}<br>
                        email:          {{ Auth::user()->email          }}<br>
                        campus_id:      {{ Auth::user()->campus_id      }}<br>
                        fac_id:         {{ Auth::user()->fac_id         }}<br>
                        dept_id:        {{ Auth::user()->dept_id        }}<br>
                        pos_id:         {{ Auth::user()->pos_id         }}<br>
                        access_token:   {{ Auth::user()->access_token   }}<br>
                        expires_in:     {{ Auth::user()->expires_in     }}<br>
                        token_type:     {{ Auth::user()->token_type     }}<br>
                        scope:          {{ Auth::user()->scope          }}<br>
                        refresh_token:  {{ Auth::user()->refresh_token  }}<br>
                    </p>
                @else
                    <p>Please log in first!</p>
                @endauth
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    @yield('main')

</main>

<!-- Footer ; "float-start" adjust text to the left while "float-end" adjust text to the right -->
<footer class="footer mt-auto py-3 bg-light">
    {{-- mt-auto py-3 bg-light --}}
    <div class="container">
        <p class="float-start">© 2023 คณะวิศวกรรมศาสตร์ มหาวิทยาลัยสงขลานครินทร์ </p>
        <p class="float-end">
            @if (request()->is('licenses'))
                <a class="btn btn-primary mt-1 mb-1 me-2 disabled" role="button" aria-disabled="true">
            @else
                <a class="btn btn-primary mt-1 mb-1 me-2" role="button" aria-current="page" href="{{ url('/licenses') }}">
            @endif
            open source licenses</a>
            <a class="btn btn-success mt-1 mb-1 me-2" href="https://oauth2.eng.psu.ac.th/policies/privacy">นโยบายความเป็นส่วนตัว</a>
            <a class="btn btn-success mt-1 mb-1 me-2"href="https://oauth2.eng.psu.ac.th/policies/terms">ข้อกำหนดในการให้บริการ</a></p>
    </div>
</footer>


<script>
document.getElementById("toastbtn").onclick = function() {
  var toastElList = [].slice.call(document.querySelectorAll('.toast'))
  var toastList = toastElList.map(function(toastEl) {
    return new bootstrap.Toast(toastEl)
  })
  toastList.forEach(toast => toast.show())
  console.log("button clicked")
}
</script>
    {{-- <script src="../assets/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- Light Switch -->
    <script>

        /**
         *  Light Switch @version v0.1.4
         */

         (function () {
          let lightSwitch = document.getElementById('lightSwitch');
          if (!lightSwitch) {
            return;
          }

          /**
           * @function darkmode
           * @summary: changes the theme to 'dark mode' and save settings to local stroage.
           * Basically, replaces/toggles every CSS class that has '-light' class with '-dark'
           */
          function darkMode() {
            document.querySelectorAll('.bg-light').forEach((element) => {
              element.className = element.className.replace(/-light/g, '-dark');
            });

            document.querySelectorAll('.link-dark').forEach((element) => {
              element.className = element.className.replace(/link-dark/, 'text-white');
            });

            document.body.classList.add('bg-dark');

            if (document.body.classList.contains('text-dark')) {
              document.body.classList.replace('text-dark', 'text-light');
            } else {
              document.body.classList.add('text-light');
            }

            // Tables
            var tables = document.querySelectorAll('table');
            for (var i = 0; i < tables.length; i++) {
              // add table-dark class to each table
              tables[i].classList.add('table-dark');
            }

            // set light switch input to true
            if (!lightSwitch.checked) {
              lightSwitch.checked = true;
            }
            localStorage.setItem('lightSwitch', 'dark');
          }

          /**
           * @function lightmode
           * @summary: changes the theme to 'light mode' and save settings to local stroage.
           */
          function lightMode() {
            document.querySelectorAll('.bg-dark').forEach((element) => {
              element.className = element.className.replace(/-dark/g, '-light');
            });

            document.querySelectorAll('.text-white').forEach((element) => {
              element.className = element.className.replace(/text-white/, 'link-dark');
            });

            document.body.classList.add('bg-light');

            if (document.body.classList.contains('text-light')) {
              document.body.classList.replace('text-light', 'text-dark');
            } else {
              document.body.classList.add('text-dark');
            }

            // Tables
            var tables = document.querySelectorAll('table');
            for (var i = 0; i < tables.length; i++) {
              if (tables[i].classList.contains('table-dark')) {
                tables[i].classList.remove('table-dark');
              }
            }

            if (lightSwitch.checked) {
              lightSwitch.checked = false;
            }
            localStorage.setItem('lightSwitch', 'light');
          }

          /**
           * @function onToggleMode
           * @summary: the event handler attached to the switch. calling @darkMode or @lightMode depending on the checked state.
           */
          function onToggleMode() {
            if (lightSwitch.checked) {
              darkMode();
            } else {
              lightMode();
            }
          }

          /**
           * @function getSystemDefaultTheme
           * @summary: get system default theme by media query
           */
          function getSystemDefaultTheme() {
            const darkThemeMq = window.matchMedia('(prefers-color-scheme: dark)');
            if (darkThemeMq.matches) {
              return 'dark';
            }
            return 'light';
          }

          function setup() {
            var settings = localStorage.getItem('lightSwitch');
            if (settings == null) {
              settings = getSystemDefaultTheme();
            }

            if (settings == 'dark') {
              lightSwitch.checked = true;
            }

            lightSwitch.addEventListener('change', onToggleMode);
            onToggleMode();
          }

          setup();
        })();

            </script>
</body>
</html>
