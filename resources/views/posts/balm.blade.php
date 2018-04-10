@extends ('layouts.master')
<link href="{{ URL::asset('css/card.css') }}" rel="stylesheet">
@section ('content')

    <div align="center">

        <h1>Thai Text Visualization</h1>

        <div id="block_container">

            <div class="card-container">
                <div class="card" onclick="window.location='{{ url("wordcloud") }}'">
                    <div class="side"><img src="{{asset('image/wordcloud.jpg')}}" alt="Word Cloud"></div>
                    <div class="side back">Word Cloud</div>
                </div>
            </div>
            <div class="card-container">
                <div class="card" onclick="window.location='{{ url("bubblechart") }}'">
                    <div class="side"><img src="{{asset('image/bubble_chart.png')}}" alt="Bubble Chart"></div>
                    <div class="side back">Bubble Chart</div>
                </div>
            </div>
        </div>
        <div id="block_container">

            <div class="card-container">
                <div class="card" onclick="window.location='{{ url("circlepacking") }}'">
                    <div class="side"><img src="{{asset('image/circle_packing.png')}}" alt="Circle Packing"></div>
                    <div class="side back">Circle Packing</div>
                </div>
            </div>
            <div class="card-container">
                <div class="card" onclick="window.location='{{ url("dendrogram") }}'">
                    <div class="side"><img src="{{asset('image/dendrogram.png')}}" alt="Dendrogram"></div>
                    <div class="side back">Dendrogram</div>
                </div>
            </div>
        </div>
    </div>

@endsection
