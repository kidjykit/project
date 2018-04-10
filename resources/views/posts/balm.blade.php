@extends ('layouts.master')
<link href="{{ URL::asset('css/card.css') }}" rel="stylesheet">
@section ('content')
    <div class="col-sm-8 blog-main text-center">

        <h1>Thai Text Visualization</h1>

        <div id="block_container">

            <div class="card-container">
                <div class="card">
                    <div class="side"><img src="{{asset('image/wordcloud.jpg')}}" alt="Word Cloud"></div>
                    <div class="side back">Word Cloud</div>
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <div class="side"><img src="{{asset('image/bubble_chart.png')}}" alt="Bubble Chart"></div>
                    <div class="side back">Bubble Chart</div>
                </div>
            </div>
        </div>
        <div id="block_container">

            <div class="card-container">
                <div class="card">
                    <div class="side"><img src="{{asset('image/circle_packing.png')}}" alt="Circle Packing"></div>
                    <div class="side back">Circle Packing</div>
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <div class="side"><img src="{{asset('image/dendrogram.png')}}" alt="Dendrogram"></div>
                    <div class="side back">Dendrogram</div>
                </div>
            </div>
        </div>
    </div>

@endsection
