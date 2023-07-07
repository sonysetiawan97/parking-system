@extends('layout.menu')

@section('body')

@section('menu')
<a class="navbar-brand text-white" href="parking">Parking</a>
<a class="navbar-brand text-white" href="report">Report</a>
@endsection

<div class="row">
    @if(\Session::get('success'))
    <div class="alert alert-primary" role="alert">
        {!! \Session::get('success') !!}
    </div>
    @endif
    <div class="col d-flex justify-content-center m-5">
        <form method="POST" action="{{ route('parking') }}" class="p-3 border rounded">
            @csrf
            <div class="mb-3">
                <label for="car_number_plate" class="form-label">No Polisi:</label>
                <input type="text" class="form-control" id="car_number_plate" name="car_number_plate" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection