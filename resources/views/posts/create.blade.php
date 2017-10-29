@extends ('layouts.master')

@section ('content')
	<div class="col-sm-8 blog-main">
	<h1>Thai Text Visualization</h1>

	<form method="POST" action="/posts/show">
		{{ csrf_field() }}

  <div class="form-group">
    <label for="input">Input:</label>
    <textarea id="body" name="body" class="form-control" style="width:600px;height:300px;"></textarea>
  </div>
  <div class="form-group">
  <button type="submit" class="btn btn-primary">Process</button>
  </div>

	@include ('layouts.errors')

</form>

</div>
@endsection
