@extends ('layouts.master')

@section ('content')

	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>
		<select id="test">
			<option value="0">select process</option>
			<option value="1" selected>Word frequency</option>
			<option value="2">Document frequency</option>
			<option value="3">Term frequency</option>
			<option value="4">TF-IDF</option>
		</select>

        <div id="canvas-container"></div>
		<script>

            $( document ).ready(function() {
                // Handler for .ready() called.
                $('#test').change(function() {
					if($('#test').val() == 1) {
                        $('#canvas-container').empty();
						//$('#canvas-container').html($(this).val());
                        $('#canvas-container').append('<canvas id="canvas_cloud" class="canvas" width="1024" height="640"></canvas>');
                        $('#canvas-container').append('<div id="box" class="tooltipme" hidden></div>');

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

                                    gridSize: 13,
                                    weightFactor: 5,
                                    fontFamily: 'Finger Paint, cursive, sans-serif',
                                    color: '#f0f0c0',
                                    hover: drawBox,
//                                    click: function(item) {
//                                        //document.getElementById('canvas_cloud').title = item[0] + ': ' + item[1];
//                                        alert(item[0] + ': ' + item[1]);
//                                    },
                                    ellipticity: 1,
                                    backgroundColor: '#001f00'
                                }
                            WordCloud(document.getElementById('canvas_cloud'), options);

                            var $box = document.getElementById('box');
                            function drawBox(item, dimension) {

                                if (!dimension) {
                                    $box.hidden= true;

                                    return;
                                }

                                $box.hidden= false;
                                $box.style.left = dimension.x  + 'px';
                                $box.style.top = dimension.y + 'px';
                                $box.style.width = dimension.w + 'px';
                                $box.style.height = dimension.h + 'px';
                                $box.innerHTML = "<span class='tooltiptext'>" + item[0] + ': ' + item[1] + "</span>";
                            }
                        });

                        }
                    else if($('#test').val() == 2) {
                        $('#canvas-container').empty();
                        //$('#canvas-container').html($(this).val());
                        $('#canvas-container').append('<canvas id="canvas_cloud" class="canvas" width="1024" height="640"></canvas>');
                        $('#canvas-container').append('<div id="box" class="tooltipme" hidden></div>');

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

                                    gridSize: 13,
                                    weightFactor: 5,
                                    fontFamily: 'Finger Paint, cursive, sans-serif',
                                    color: '#f0f0c0',
                                    hover: drawBox,
//                                    click: function(item) {
//                                        //document.getElementById('canvas_cloud').title = item[0] + ': ' + item[1];
//                                        alert(item[0] + ': ' + item[1]);
//                                    },
                                ellipticity: 1,
                                backgroundColor: '#001f00'
                            }
                            WordCloud(document.getElementById('canvas_cloud'), options);

                            var $box = document.getElementById('box');
                            function drawBox(item, dimension) {

                                if (!dimension) {
                                    $box.hidden= true;

                                    return;
                                }

                                $box.hidden= false;
                                $box.style.left = dimension.x  + 'px';
                                $box.style.top = dimension.y + 'px';
                                $box.style.width = dimension.w + 'px';
                                $box.style.height = dimension.h + 'px';
                                $box.innerHTML = "<span class='tooltiptext'>" + item[0] + ': ' + item[1] + "</span>";
                            }
                        });

                    }
                    else if($('#test').val() == 3) {
                        $('#canvas-container').empty();
                        //$('#canvas-container').html($(this).val());
                        $('#canvas-container').append('<canvas id="canvas_cloud" class="canvas" width="1024" height="640"></canvas>');
                        $('#canvas-container').append('<div id="box" class="tooltipme" hidden></div>');

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

                                    gridSize: 13,
                                    weightFactor: 5,
                                    fontFamily: 'Finger Paint, cursive, sans-serif',
                                    color: '#f0f0c0',
                                    hover: drawBox,
//                                    click: function(item) {
//                                        //document.getElementById('canvas_cloud').title = item[0] + ': ' + item[1];
//                                        alert(item[0] + ': ' + item[1]);
//                                    },
                                ellipticity: 1,
                                backgroundColor: '#001f00'
                            }
                            WordCloud(document.getElementById('canvas_cloud'), options);

                            var $box = document.getElementById('box');
                            function drawBox(item, dimension) {

                                if (!dimension) {
                                    $box.hidden= true;

                                    return;
                                }

                                $box.hidden= false;
                                $box.style.left = dimension.x  + 'px';
                                $box.style.top = dimension.y + 'px';
                                $box.style.width = dimension.w + 'px';
                                $box.style.height = dimension.h + 'px';
                                $box.innerHTML = "<span class='tooltiptext'>" + item[0] + ': ' + item[1] + "</span>";
                            }
                        });

                    }
                    else if($('#test').val() == 4) {
                        $('#canvas-container').empty();
                        //$('#canvas-container').html($(this).val());
                        $('#canvas-container').append('<canvas id="canvas_cloud" class="canvas" width="1024" height="640"></canvas>');
                        $('#canvas-container').append('<div id="box" class="tooltipme" hidden></div>');

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

                                    gridSize: 13,
                                    weightFactor: 5,
                                    fontFamily: 'Finger Paint, cursive, sans-serif',
                                    color: '#f0f0c0',
                                    hover: drawBox,
//                                    click: function(item) {
//                                        //document.getElementById('canvas_cloud').title = item[0] + ': ' + item[1];
//                                        alert(item[0] + ': ' + item[1]);
//                                    },
                                ellipticity: 1,
                                backgroundColor: '#001f00'
                            }
                            WordCloud(document.getElementById('canvas_cloud'), options);

                            var $box = document.getElementById('box');
                            function drawBox(item, dimension) {

                                if (!dimension) {
                                    $box.hidden= true;

                                    return;
                                }

                                $box.hidden= false;
                                $box.style.left = dimension.x  + 'px';
                                $box.style.top = dimension.y + 'px';
                                $box.style.width = dimension.w + 'px';
                                $box.style.height = dimension.h + 'px';
                                $box.innerHTML = "<span class='tooltiptext'>" + item[0] + ': ' + item[1] + "</span>";
                            }
                        });

                    }
					else{
					    $('#canvas-container').empty();
					}
                });
            });



		</script>

	{{--@if (count($result1))--}}
	{{--<div class="form-group">--}}
				{{--@foreach($result1 as $results => $value)--}}
						{{--<li> {{ $results }} : {{ $value }}</li>--}}
				{{--@endforeach--}}
						{{--<li>{{ count($result1) }} word</li>--}}
		{{--</div>--}}
	{{--@endif--}}

	</div>

@endsection
