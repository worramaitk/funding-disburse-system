@extends('layouts.page')

@section('title')
<title>Home</title>
@endsection

@section('main')
    <div class="container">

        @auth
        <h1 class="mt-5"><br>Welcome!</h1>
        <p class="lead">This is your user information:</p>
        <p>
            username:   {{ Auth::user()->username   }}<br>
            first_name: {{ Auth::user()->first_name }}<br>
            last_name:  {{ Auth::user()->last_name  }}<br>
            staff_id:   {{ Auth::user()->staff_id   }}<br>
            email:      {{ Auth::user()->email      }}<br>
            campus_id:  {{ Auth::user()->campus_id  }}<br>
            fac_id:     {{ Auth::user()->fac_id     }}<br>
            dept_id:    {{ Auth::user()->dept_id    }}<br>
            pos_id:     {{ Auth::user()->pos_id     }}<br>
        </p>
        <p class="lead">made with Laravel ver. {{ Illuminate\Foundation\Application::VERSION }} (PHP ver. {{ PHP_VERSION }})</p>
        @else
        <h1 class="mt-5"><br>Welcome!</h1>
        <p class="lead">Log in with PSU Passport to get started</p>
        @endauth
    </div>
@endsection
