@extends ('layouts.master')

@section ('content')

	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>
		<select id="test">
			<option value="0">select process</option>
			<option value="1">Word frequency</option>
			<option value="2">Document frequency</option>
			<option value="3">Term frequency</option>
			<option value="4">TF-IDF</option>
		</select>

		<div id="result"></div>

		{{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
		{{--<canvas id="canvas_cloud" width="800" height="400"></canvas>--}}
		{{--<script type="text/javascript" src="{!! asset('js/wordcloud2.js') !!}"></script>--}}

		{{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
		{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
		<script>

            $( document ).ready(function() {
                // Handler for .ready() called.
                $('#test').change(function() {
					if($('#test').val() == 2) {
						$('#result').html($(this).val());
                        $('#result').append('<canvas id="canvas_cloud" width="800" height="400"></canvas>');
                        $.getScript("{!! asset('js/wordcloud2.js') !!}", function () {

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

                                    gridSize: 10,
                                    weightFactor: 3,
                                    fontFamily: 'Finger Paint, cursive, sans-serif',
                                    color: '#f0f0c0',
                                    //hover: window.drawBox,
                                    click: function(item) {
                                        //document.getElementById('canvas_cloud').title = item[0] + ': ' + item[1];
                                        alert(item[0] + ': ' + item[1]);
                                    },
                                    ellipticity: 1,
                                    backgroundColor: '#001f00'
                                }

                            WordCloud(document.getElementById('canvas_cloud'), options);



                        });

                        }
					else{
					    $('#result').empty();
                        $('#result').html($(this).val());
					}
                });
            });



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
