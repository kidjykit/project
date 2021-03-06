@extends ('layouts.master')

@section ('content')
	<div class="col-sm-8 blog-main">
	<h1>Process text</h1>

	<script type="text/javascript" src="{!! asset('js/d3.v4.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/sententree-standalone.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/fusionchart.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('js/fusioncharts.charts.js') !!}"></script>
    <div id="vismain"></div>

		@if(isset($result))

            <script>
                'use strict';
                var segment_word = <?php echo json_encode($result)?>;
                //console.log(segment_word)

                var i,a;
                var visnum=0;

                segment_word.forEach(function each(item) {
//
                    var vis = document.createElement("div");
                    vis.id = 'vis'+(++visnum);
                    $('#vismain').append(vis);
                    $('#vismain').append('<p></p>');
                    //console.log(vis.id)
                    i = item[1];
                    a = item[1];
                    //console.log(item[0]); //File Name.
                    var indexsentenSet = -1;
                    var index = 0;
                    var sentenSet = [""];
                    var count = 4;
//                    i.forEach(function eachel(item2) {
//                      //console.log("i = "+ i + item2);  //Each Word In File Name.
//
//                        if(  index%count == 0){
//                            sentenSet[++indexsentenSet]={id:Math.floor(Math.random() * 1000000) + 400000,text:item2,count:Math.floor(Math.random() * 3000) + 500};
//                        }else{
//                            sentenSet[indexsentenSet].text += ' '+item2
//                        }
//                        index++;
//                    })
                    var Ncount = 7;
                    if(a.length>Ncount){

                        for (var i = 0; i <= a.length-Ncount; i++) {
                            //console.log(i);
                            var senten = [""];
                            for(var j = 0; j < Ncount ;j++){
                                //console.log(j+'array J = '+a[i+j]);
                                if(j==0){
                                    senten += a[i+j];
                                }
                                else{
                                    senten += ' '+ a[i+j];
                                }
                            }
                            sentenSet[i] = {id:Math.floor(Math.random() * 1000000) + 400000,text:senten,count:Math.floor(Math.random() * 5000) + 300};
                        }
                    }
                    else{
                        var senten = [""];
                        for (var i = 0; i <= a.length-1; i++) {
                            //console.log(i + 'value = ' + a[i]);
                            if(i==0){
                                senten += a[i];
                            }
                            else{
                                senten += ' '+ a[i];
                            }
                        }
                        sentenSet[0] = {id:Math.floor(Math.random() * 1000000) + 400000,text:senten,count:Math.floor(Math.random() * 3000) + 500};;;
                    }
                    //console.log(sentenSet);


                    const container = document.querySelector('#'+vis.id);
                    container.innerHTML = 'Loading ...';

                    //const data = [{id:123,text:'123 222 344 1111',count:123},{id:123,text:'123 222 34553',count:123},{id:123,text:'123 444 222',count:123}];
                    const data = sentenSet;
                    console.log(data);
                    console.time('Build model');
                    const model = new SentenTree.SentenTreeBuilder()
                    // enforce tokenize by space
                        .tokenize(SentenTree.tokenizer.tokenizeBySpace)
                        .transformToken(token => (/score(d|s)?/.test(token) ? 'score' : token))
                    // you can adjust the maxSupportRatio (0-1)
                    // higher maxsupport will tend to group the graph together in one piece
                    // lower maxsupport will break it into multiple graphs
                .buildModel(data, { maxSupportRatio: 1 });
                    console.timeEnd('Build model');

                    container.innerHTML = '';

                    new SentenTree.SentenTreeVis(container)
                        .data(model.getRenderedGraphs(3))
                        .on('nodeClick', node => {
                        //console.log('node', node);
                    })
                })



//                for (i in segment_word)
//                    for (j in segment_word[i])
//                        if(j<=1)
//                            //console.log("i = "+ i +"j = "+ j)
//                            //console.log(segment_word[i][0])
//                            document.getElementById("demo").innerHTML += segment_word[i][0];
//                            for (kk in segment_word[i][j])
//                                if(j!=0)
//                                console.log(segment_word[i][j][kk])


            </script>

			{{--<li>Total Document = {{count($result)}}</li>--}}
			{{--@foreach($result as $dataword)--}}
				{{--<li>{{$dataword[0]}}</li>--}}
				{{--@foreach($dataword[1] as $wordSeg => $TermFrequency)--}}
					{{--<li> -- {{$wordSeg}} : {{$TermFrequency}}</li>--}}

				{{--@endforeach--}}
			{{--@endforeach--}}
			{{--<br>--}}

            {{--@foreach($df as $DocFrequency => $DocFrequencyValue)--}}

                {{--<li>{{$DocFrequency}} : Document Frequency = {{$DocFrequencyValue}}</li>--}}
            {{--@endforeach--}}
			<br>

        {{--Create visualize for TFIDF--}}
			@foreach($tfidf as $TFIDF_Doc_Name => $TFIDF_Word_Name)
				<!-- <li>Document Name = {{$TFIDF_Doc_Name}}</li> -->
                <div id="{{$TFIDF_Doc_Name}}">FusionCharts will render here name {{$TFIDF_Doc_Name}}</div>

                <script>
                    FusionCharts.ready(function () {
                        var revenueChart = new FusionCharts({
                            type: 'column3d',
                            renderAt: '{{$TFIDF_Doc_Name}}',
                            width: '600',
                            height: '400',
                            dataFormat: 'json',
                            dataSource: {
                                "chart": {
                                    "caption": "Term Frequency Inverse Document Frequency",
                                    "subCaption": "{{$TFIDF_Doc_Name}}",
                                    "xAxisName": "Words",
                                    "yAxisName": "TFIDF Value",
                                    "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f20000,#00c500",
                                    "valueFontColor": "#000000",
                                    "baseFont": "Times New Roman",
																		"baseFontSize": "16",
                                    "captionFontSize": "16",
                                    "subcaptionFontSize": "16",
                                    "subcaptionFontBold": "0",
                                    "placeValuesInside": "1",
                                    "rotateValues": "1",
                                    "showShadow": "0",
                                    "divlineColor": "#999999",
                                    "divLineIsDashed": "1",
                                    "divlineThickness": "1",
                                    "divLineDashLen": "1",
                                    "divLineGapLen": "1",
                                    "canvasBgColor": "#ffffff",
                                    "labelDisplay": "rotate",
                                    "slantLabels": "1"
                                },

                                "data": [
                                    <?php $countword=0; ?>
                                @foreach($TFIDF_Word_Name as $wordname => $tfidfValue)
                                        @if($countword<=9)
                                        {
                                            "label": "{{$wordname}}",
                                            "value": "{{round($tfidfValue,3)}}"
                                        },
                                        @endif
                                        <?php $countword++; ?>
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
            {{--END Of Create visualize for TFIDF--}}
		@endif
	</div>

@endsection
