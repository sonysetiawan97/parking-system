@extends('layout.menu')

@section('body')
<div class="row">
    @if(\Session::get('success'))
    <div class="alert alert-primary" role="alert">
        {!! \Session::get('success') !!}
    </div>
    @endif
    <div class="col d-flex justify-content-center m-5">
        <form method="POST" action="{{ route('checkout') }}" class="p-3 border rounded">
            @csrf
            <div class="mb-3">
                <label for="unique_code" class="form-label">Kode Unik:</label>
                <input type="text" class="form-control" id="unique_code" name="unique_code" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection