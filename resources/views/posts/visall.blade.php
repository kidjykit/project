@extends ('layouts.master')
<link href="{{ URL::asset('css/card.css') }}" rel="stylesheet">
<script type="text/javascript" src="{!! asset('js/d3.v4.min.js') !!}"></script>
<script src="https://rawgit.com/twitter/SentenTree/master/dist/sententree-standalone.min.js"></script>
@section ('content')
<link href="{{ URL::asset('css/modal_full.css') }}" rel="stylesheet">

<div id="js-modal" class="modal_full">
    <div class="card_modal">
        <div class="card_modal-content" align="center">
            <span id="js-toggleModal" class="icon-toggleModal"></span>
            <svg id="svg_area" width="600" height="600" font-family="sans-serif" font-size="10" text-anchor="middle"></svg>
            <div id="vismain"  width="750" height="600" font-family="sans-serif" font-size="10" text-anchor="middle" style="position: relative;"></div>

        </div>
    </div>
</div>
<div class="content ">
    <div align="center">

        <h1>Thai Text Visualization</h1>

        <div id="block_container">
                @if (!empty($body))
                <?php $result = ''; ?>
                <div class="card-container">
                    <div class="card" id="wordcloud-modal" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/wordcloud.jpg')}}" alt="Word Cloud"></div>
                        <div class="side back">Word Cloud</div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card" id="sententree-modal" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/SentenTree.png')}}" alt="Sentence Tree"></div>
                        <div class="side back">Sentence Tree</div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card" id="bubblechart-modal" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/bubble_chart.png')}}" alt="Bubble Chart"></div>
                        <div class="side back">Bubble Chart</div>
                    </div>
                </div>
                @endif

            @if (!empty($result))

                <?php $body = '';?>

                <div class="card-container">
                  <div class="card" id="sententree-modal-file" class="btn btn-info btn-lg">
                      <div class="side"><img src="{{asset('image/SentenTree.png')}}" alt="Sentence Tree"></div>
                      <div class="side back">Sentence Tree</div>
                  </div>
                </div>

                <div class="card-container">
                    <div class="card" onclick="process_file();" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                        <div class="side"><img src="{{asset('image/circle_packing.png')}}" alt="Circle Packing"></div>
                        <div class="side back">Circle Packing</div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card" id="dendrogram-modal-file" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/dendrogram.png')}}" alt="Dendrogram"></div>
                        <div class="side back">Dendrogram</div>
                    </div>
                </div>
        @endif


            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('js-toggleModal').addEventListener('click', function() {
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })

    //wordcloud-modal
    @if (!empty($body))
    document.getElementById('wordcloud-modal').addEventListener('click', function() {
        var x = <?php echo json_encode($body); ?>;
        $.ajax({
            type:'POST',
            url:'/wordcloud/process',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){ // What to do if we succeed
                $('#vismain').empty();

                document.getElementById("svg_area").style.display = "none";
                //$('#canvas-container').html($(this).val());
                $('#vismain').append('<canvas id="canvas_cloud" class="canvas" width="900" height="600"></canvas>');
                $('#vismain').append('<div id="box" class="tooltipme" position="relative" hidden ></div>');

                $.getScript("{!! asset('js/wordcloud2.js') !!}", function () {
                    var text = "";
                    var data_list2 = Array();
                    // var data_list = Array(["kit", 30],["นครสวรรค์", 40],["กรุงเทพ", 50],["บ้าน", 10]);
                    for(var x in response){
                        // text += '['+response[x].id +' , '+ response[x].value+']'+',';
                        data_list2.push(Array(response[x].id, response[x].value));
                    }
                    // console.log(data_list);
                    // console.log(data_list2);
                    var options =
                    {
                        list : data_list2,

                        gridSize: 20,
                        weightFactor: 8,
                        fontFamily: 'Finger Paint, cursive, sans-serif',
                        color: '#000000',
                        hover: drawBox,
                        ellipticity: 1,
                        backgroundColor: '#8eb1e2'
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

            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })


    //sententree-modal
    document.getElementById('sententree-modal').addEventListener('click', function() {
        var x = <?php echo json_encode($body); ?>;
        $.ajax({
            type:'POST',
            url:'/sentencetree/process',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){ // What to do if we succeed
                var data_list2 = Array(response);
                var i,a;
                var visnum=0;
                $('#vismain').empty();
                document.getElementById("svg_area").style.display = "none";
                // console.log(data_list2);
                data_list2.forEach(function each(item) {
                    var vis = document.createElement("div");
                    vis.id = 'vis'+(++visnum);
                    $('#vismain').append(vis);
                    $('#vismain').append('<p></p>');
                    //console.log(vis.id)
                    i = item;
                    a = item;
                    //console.log(item[0]); //File Name.
                    var indexsentenSet = -1;
                    var index = 0;
                    var sentenSet = [""];
                    var count = 4;
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
                        sentenSet[0] = {id:Math.floor(Math.random() * 1000000) + 400000,text:senten,count:Math.floor(Math.random() * 3000) + 500};
                    }
                    // console.log(sentenSet);


                    const container = document.querySelector('#vismain');
                    container.innerHTML = 'Loading ...';

                    //const data = [{id:123,text:'123 222 344 1111',count:123},{id:123,text:'123 222 34553',count:123},{id:123,text:'123 444 222',count:123}];
                    const data = sentenSet;
                    //console.log(data);
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

            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })

    //bubblechart-modal
    document.getElementById('bubblechart-modal').addEventListener('click', function() {
        var x = <?php echo json_encode($body); ?>;
        $.ajax({
            type:'POST',
            url:'/bubblechart/process',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){ // What to do if we succeed
                $('#vismain').empty();
                document.getElementById("svg_area").style.display = "block";
                var svg = d3.select("svg"),
                        width = +svg.attr("width"),
                        height = +svg.attr("height");

                var format = d3.format(",d");

                var color = d3.scaleOrdinal(d3.schemeCategory20c);

                var pack = d3.pack()
                        .size([width, height])
                        .padding(1.5);

                var root = d3.hierarchy({children: response})
                        .sum(function(d) { return d.value; })
                        .each(function(d) {
                            if (id = d.data.id) {
                                var id;
                                d.id = id+"";
                                d.package = id+"";
                                d.class = id+"";
                            }
                        });

                var node = svg.selectAll(".node")
                        .data(pack(root).leaves())
                        .enter().append("g")
                        .attr("class", "node")
                        .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

                node.append("circle")
                        .attr("id", function(d) { return d.id; })
                        .attr("r", function(d) { return d.r; })
                        .style("fill", function(d) { return color(d.package); });

                node.append("clipPath")
                        .attr("id", function(d) { return "clip-" + d.id; })
                        .append("use")
                        .attr("xlink:href", function(d) { return "#" + d.id; });

                node.append("text")
                        .attr("clip-path", function(d) { return "url(#clip-" + d.id + ")"; })
                        .selectAll("tspan")
                        .data(function(d) { return d.class.split(/(?=[A-Z][^A-Z])/g); })
                        .enter().append("tspan")
                        .attr("x", 0)
                        .attr("y", function(d, i, nodes) { return 13 + (i - nodes.length / 2 - 0.5) * 10; })
                        .text(function(d) { return d; });

                node.append("title")
                        .text(function(d) { return d.id + "\n" + format(d.value); });


            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })
    @endif

    @if (!empty($result))
    //sententree-modal
    document.getElementById('sententree-modal-file').addEventListener('click', function() {
        var x = <?php echo json_encode($result); ?>;
        $.ajax({
            type:'POST',
            url:'/sentencetree/processfile',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){ // What to do if we succeed
                var data_list2 = response;
                var i,a;
                var visnum=0;
                $('#vismain').empty();
                document.getElementById("svg_area").style.display = "none";
                // console.log(data_list2);
                data_list2.forEach(function each(item) {
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
                        sentenSet[0] = {id:Math.floor(Math.random() * 1000000) + 400000,text:senten,count:Math.floor(Math.random() * 3000) + 500};
                    }
                    // console.log(sentenSet);


                    const container = document.querySelector('#'+vis.id);
                    container.innerHTML = 'Loading ...';

                    //const data = [{id:123,text:'123 222 344 1111',count:123},{id:123,text:'123 222 34553',count:123},{id:123,text:'123 444 222',count:123}];
                    const data = sentenSet;
                    //console.log(data);
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

            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })

    //dendrogram-modal
    document.getElementById('dendrogram-modal-file').addEventListener('click', function() {
        var x = <?php echo json_encode($result); ?>;
        $.ajax({
            type:'POST',
            url:'/dendrogram/processfile',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){
              $('#vismain').empty();
              console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })
    @endif
</script>
@endsection
