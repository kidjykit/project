@extends ('layouts.master')

@section ('content')
	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>
		<script type="text/javascript" src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
		<script type="text/javascript" src="https://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>

		{{--<div id="chart-container">FusionCharts will render here</div>--}}
        {{--<div id="chart-container1">FusionCharts will render here</div>--}}

		{{--<script>--}}
            {{--FusionCharts.ready(function () {--}}
                {{--var revenueChart = new FusionCharts({--}}
                    {{--type: 'column3d',--}}
                    {{--renderAt: 'chart-container',--}}
                    {{--width: '500',--}}
                    {{--height: '300',--}}
                    {{--dataFormat: 'json',--}}
                    {{--dataSource: {--}}
                        {{--"chart": {--}}
                            {{--"caption": "Monthly revenue for last year",--}}
                            {{--"subCaption": "Harry's SuperMart",--}}
                            {{--"xAxisName": "Month",--}}
                            {{--"yAxisName": "Revenues (In USD)",--}}
                            {{--"paletteColors": "#0075c2",--}}
                            {{--"valueFontColor": "#ffffff",--}}
                            {{--"baseFont": "Helvetica Neue,Arial",--}}
                            {{--"captionFontSize": "14",--}}
                            {{--"subcaptionFontSize": "14",--}}
                            {{--"subcaptionFontBold": "0",--}}
                            {{--"placeValuesInside": "1",--}}
                            {{--"rotateValues": "1",--}}
                            {{--"showShadow": "0",--}}
                            {{--"divlineColor": "#999999",--}}
                            {{--"divLineIsDashed": "1",--}}
                            {{--"divlineThickness": "1",--}}
                            {{--"divLineDashLen": "1",--}}
                            {{--"divLineGapLen": "1",--}}
                            {{--"canvasBgColor": "#ffffff"--}}
                        {{--},--}}

                        {{--"data": [--}}
                            {{--{--}}
                                {{--"label": "Jan",--}}
                                {{--"value": "420000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Feb",--}}
                                {{--"value": "810000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Mar",--}}
                                {{--"value": "720000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Apr",--}}
                                {{--"value": "550000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "May",--}}
                                {{--"value": "910000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Jun",--}}
                                {{--"value": "510000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Jul",--}}
                                {{--"value": "680000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Aug",--}}
                                {{--"value": "620000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Sep",--}}
                                {{--"value": "610000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Oct",--}}
                                {{--"value": "490000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Nov",--}}
                                {{--"value": "900000"--}}
                            {{--},--}}
                            {{--{--}}
                                {{--"label": "Dec",--}}
                                {{--"value": "730000"--}}
                            {{--}--}}
                        {{--]--}}
                    {{--}--}}
                {{--});--}}
                {{--revenueChart.render();--}}
            {{--});--}}
		{{--</script>--}}

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
			<br>

        {{--Create visualize for TFIDF--}}
			@foreach($tfidf as $tfidfDN => $tfidfWN)
				<li>Document Name = {{$tfidfDN}}</li>
                <div id="{{$tfidfDN}}">FusionCharts will render here name {{$tfidfDN}}</div>

                <script>
                    FusionCharts.ready(function () {
                        var revenueChart = new FusionCharts({
                            type: 'column3d',
                            renderAt: '{{$tfidfDN}}',
                            width: '500',
                            height: '300',
                            dataFormat: 'json',
                            dataSource: {
                                "chart": {
                                    "caption": "Term Frequency Inverse Document Frequency",
                                    "subCaption": "{{$tfidfDN}}",
                                    "xAxisName": "Words",
                                    "yAxisName": "TFIDF Value",
                                    "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f20000,#00c500",
                                    "valueFontColor": "#ffffff",
                                    "baseFont": "Helvetica Neue,Arial",
                                    "captionFontSize": "14",
                                    "subcaptionFontSize": "14",
                                    "subcaptionFontBold": "0",
                                    "placeValuesInside": "1",
                                    "rotateValues": "1",
                                    "showShadow": "0",
                                    "divlineColor": "#999999",
                                    "divLineIsDashed": "1",
                                    "divlineThickness": "1",
                                    "divLineDashLen": "1",
                                    "divLineGapLen": "1",
                                    "canvasBgColor": "#ffffff"
                                },

                                "data": [
                                @foreach($tfidfWN as $wordname => $tfidfValue)
                                    { "label": "{{$wordname}}", "value": "{{round($tfidfValue,3)}}"},
                                @endforeach
//                                    {
//                                        "label": "Dec",
//                                        "value": "730000"
//                                    }
                                ]
                            }
                        });
                        revenueChart.render();
                    });
                </script>
			@endforeach
		@endif
	</div>

@endsection
