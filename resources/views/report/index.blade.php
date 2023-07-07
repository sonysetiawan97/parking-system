@extends('layout.menu')

@section('body')

@section('menu')
<a class="navbar-brand text-white" href="parking">Parking</a>
<a class="navbar-brand text-white" href="report">Report</a>
@endsection

@if(\Session::get('error'))
<div class="alert alert-warning" role="alert">
  {!! \Session::get('error') !!}
</div>
@endif

<div class="row">
  <div class="col d-flex justify-content-start m-3 border rounded">
    <form method="GET" action="{{ route('report') }}" class="p-3">
      @csrf
      <div class="row">
        <div class="col mb-3">
          <label for="start_date" class="form-label">Tanggal Mulai:</label>
          <input type="date" class="form-control" id="start_date" name="start_date" value="{{ isset($params['start_date']) ? $params['start_date'] : '' }}">
        </div>
        <div class="col mb-3">
          <label for="end_date" class="form-label">Tanggal Berakhir:</label>
          <input type="date" class="form-control" id="end_date" name="end_date" value="{{ isset($params['end_date']) ? $params['end_date'] : '' }}">
        </div>
        <div class="col align-self-center">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col d-flex justify-content-end m-3">
    <form method="GET" action="{{ route('report_export') }}">
      @csrf
      <input type="hidden" class="form-control" id="start_date_report" name="start_date" value="{{ isset($params['start_date']) ? $params['start_date'] : '' }}">
      <input type="hidden" class="form-control" id="end_date_report" name="end_date" value="{{ isset($params['end_date']) ? $params['end_date'] : '' }}">
      <button type="submit" class="btn btn-primary">Export</button>
    </form>
  </div>
</div>

<div class="row">
  <div class="col d-flex justify-content-center m-3">
    <table class="table">
      <thead class="table-light">
        <tr>
          @foreach($tableHeader as $header)
          <th>{{ $header['label'] }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($tableEntries as $entry)
        <tr>
          @foreach($tableHeader as $header)
          <td>{{ $entry[$header['name']] }}</td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('start_date').addEventListener('change', (evt) => {
      const {
        target
      } = evt
      if (target) {
        const {
          value
        } = target
        document.getElementById('start_date_report').value = value
      }
    })

    document.getElementById('end_date').addEventListener('change', (evt) => {
      const {
        target
      } = evt
      if (target) {
        const {
          value
        } = target
        document.getElementById('end_date_report').value = value
      }
    })
  })
</script>