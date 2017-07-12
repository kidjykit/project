@extends ('layouts.master')

@section ('content')
	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>

		<canvas id="canvas_cloud" height="400" width="800"></canvas>

		<script type="text/javascript" src="{!! asset('js/wordcloud2.js') !!}"></script>
		<script>

            var options =
                {
                    list : [
                        // คำที่ตัดแล้วส่งมาเข้า list เพื่อจะทำ wordcloud
						@if (count($result1))
						@foreach($result1 as $results => $value)
							["{{ $results }}", "{{ $value }}"],  //["เกลือ", 100]
						@endforeach
						@endif

                    ],

                    gridSize: 1,
                    weightFactor: 3,
                    fontFamily: 'Finger Paint, cursive, sans-serif',
                    color: '#f0f0c0',
                    hover: window.drawBox,
                    click: function(item) {
                        alert(item[0] + ': ' + item[1]);
                    },
                    backgroundColor: '#001f00'
                }

            WordCloud(document.getElementById('canvas_cloud'), options);

		</script>

	@if (count($result1))
	<div class="form-group">
				@foreach($result1 as $results => $value)
						<li> {{ $results }} : {{ $value }}</li>
				@endforeach
						<li>{{ count($result1) }} word</li>
		</div>
	@endif

	</div>

@endsection
