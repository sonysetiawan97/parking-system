@extends('layout.app')

@section('content')
<nav class="navbar sticky-top navbar-light bg-primary mb-3">
    <div class="container-fluid d-flex justify-content-between px-5 py-1">
        <div>
            @yield('menu')
        </div>
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>
@yield('body')
@endsection