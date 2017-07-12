@extends ('layouts.master')

@section ('content')
	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>

		@if(isset($result))
			@foreach($result as $aa)
				<li>{{$aa[0]}}</li>
				@foreach($aa[1] as $aas)
					<li>{{$aas}}</li>
					@endforeach
				@endforeach
		@endif
	</div>

@endsection
