@extends('app')

@section('title')
	Categories
@endsection

@section('content')

@if(!empty($categories))
	@foreach ($categories as $category)
		<tr>
			<th>{{ $category->id }}</th>
			<td>{{ $category->title }}</td>
		</tr>
	@endforeach
@endif

@endsection