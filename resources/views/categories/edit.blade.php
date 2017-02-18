<form method="post" action='/category/update'>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="category_id" value="{{ $category->id }}{{ old('category_id') }}">
	<div class="form-group">
		<input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$category->title}}@endif{{ old('title') }}"/>
	</div>
	<div class="form-group">
	<input type="submit" name='publish' class="btn btn-success" value = "Update"/>
	</div>
</form>