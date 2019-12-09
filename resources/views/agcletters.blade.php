@extends('template')
@section('content')
	<div class="panel">
		<div class="panel panel-header">
			<h1>AGC Letters</h1>
		</div>
		<div class="panel panel-body">
			<table class="table table-striped" style="table-layout: fixed; width: 100%">
				<tr>
					<th>Name</th>
					<th>Date</th>
					<th>Note</th>
				</tr>
				@foreach ($touchpoints as $touchpoint)
				<tr>
					<td>@if ($touchpoint->person) {{ $touchpoint->person->sort_name }} @else @endIf </td>
					<td>{{ $touchpoint->touched_at }}</td>
					<td>{{ $touchpoint->notes }}</td>
				</tr>
				@endforeach

			</table>

		</div>
	</div>
@stop
