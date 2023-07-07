@extends('layout.app')

@section('content')
<div class="row">
    <div class="col d-flex justify-content-center m-5">
        <form method="POST" action="{{ route('login') }}" class="p-3 border rounded">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection