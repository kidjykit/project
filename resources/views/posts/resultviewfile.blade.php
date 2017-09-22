@extends ('layouts.master')

@section ('content')
	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>

		@if(isset($result))
			<li>Total Document = {{count($result)}}</li>
			@foreach($result as $aa)
				<li>{{$aa[0]}}</li>
				@foreach($aa[2] as $word => $tf)
					<li> -- {{$word}} : {{$tf}}</li>
				@endforeach
			@endforeach
			<br>
            @foreach($df as $dff => $value)

                <li>{{$dff}} : Document Frequency = {{$value}}</li>
            @endforeach
		@endif
	</div>

@endsection
