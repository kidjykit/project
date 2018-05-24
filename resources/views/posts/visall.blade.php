@extends ('layouts.master')
<link href="{{ URL::asset('css/card.css') }}" rel="stylesheet">
<script type="text/javascript" src="{!! asset('js/d3.v4.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/sententree-standalone.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/fusionchart.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/fusioncharts.charts.js') !!}"></script>
@section ('content')
<meta charset="utf-8">
<link href="{{ URL::asset('css/modal_full.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/dendrogram.css') }}" rel="stylesheet">

<div id="js-modal" class="modal_full" style="background: #ffffff;">
    <div class="card_modal">
        <div class="card_modal-content" align="center">
          <div id="contentapp" style="position: absolute; top:0; left:center;">
            <svg id="svg_area" width="960" height="1000" font-family="sans-serif" font-size="20" text-anchor="middle"></svg>
            <div id="vismain"  width="750" height="600" font-family="sans-serif" font-size="10" text-anchor="middle" style="position: relative;"></div>
          </div>
            <span id="js-toggleModal" class="icon-toggleModal"></span>
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
                        <div class="side back">Word Cloud(Word Frequency)</div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card" id="sententree-modal" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/SentenTree.png')}}" alt="Sentence Tree"></div>
                        <div class="side back">Sentence Tree(Word Frequency with two word)</div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card" id="bubblechart-modal" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/bubble_chart.png')}}" alt="Bubble Chart"></div>
                        <div class="side back">Bubble Chart(Word Frequency)</div>
                    </div>
                </div>
                @endif

            @if (!empty($result))

                <?php $body = '';?>

                <div class="card-container">
                  <div class="card" id="sententree-modal-file" class="btn btn-info btn-lg">
                      <div class="side"><img src="{{asset('image/SentenTree.png')}}" alt="Sentence Tree"></div>
                      <div class="side back">Sentence Tree<br>(Word Frequency)</div>
                  </div>
                </div>

                <div class="card-container">
                      <div class="card" id="columnchart-modal-file" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/column_chart.jpg')}}" alt="Column Chart"></div>
                        <div class="side back">
                          <pre>Column Chart</pre>
                          <pre>(TFIDF)</pre>
                        </div>
                    </div>
                </div>

                <div class="card-container">
                      <div class="card" id="wordcloud-modal-tfidf" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/wordcloud.jpg')}}" alt="Word Cloud"></div>
                        <div class="side back">
                          <pre>Word Cloud</pre>
                          <pre>(TFIDF)</pre>
                        </div>
                    </div>
                </div>

                <div class="card-container">
                    <div class="card" id="dendrogram-modal-file" class="btn btn-info btn-lg">
                        <div class="side"><img src="{{asset('image/dendrogram.png')}}" alt="Dendrogram"></div>
                        <div class="side back">Dendrogram(Word Frequency with filter document)</div>
                    </div>
                </div>
        @endif


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
                    var options =
                    {
                        list : data_list2,

                        gridSize: 20,
                        weightFactor: 5,
                        fontFamily: 'Finger Paint, cursive, sans-serif',
                        color: '#000000',
                        hover: drawBox,
                        ellipticity: 1,
                        backgroundColor: '#ffffff'
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
    //sententree-modal-file
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
                    var hname = document.createElement("h1");
                    var vis = document.createElement("div");
                    vis.id = 'vis'+(++visnum);
                    hname.appendChild(document.createTextNode("Sentence Tree of "+item[0]));
                    $('#vismain').append(hname);
                    $('#vismain').append(vis);
                    $('#vismain').append('<hr style="border-width: 5px;"><p></p>');
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
              // console.log(response);
              $('#vismain').empty();
              document.getElementById("svg_area").style.display = "block";
              var svg = d3.select("svg"),
                        width = +svg.attr("width"),
                        height = +svg.attr("height"),
                        g = svg.append("g").attr("transform", "translate(100,0)");
                var tree = d3.cluster()
                        .size([height, width - 250]);
                var stratify = d3.stratify()
                        .parentId(function(d) { return d.id.substring(0, d.id.lastIndexOf(".")); });
                    var root = stratify(response)
                            .sort(function(a, b) { return (a.height - b.height) || a.id.localeCompare(b.id); });
                    tree(root);
                    var link = g.selectAll(".link")
                            .data(root.descendants().slice(1))
                            .enter().append("path")
                            .attr("class", "link")
                            .attr("d", function(d) {
                                return "M" + d.y + "," + d.x
                                        + "C" + (d.parent.y + 100) + "," + d.x
                                        + " " + (d.parent.y + 100) + "," + d.parent.x
                                        + " " + d.parent.y + "," + d.parent.x;
                            });
                    var node = g.selectAll(".node")
                            .data(root.descendants())
                            .enter().append("g")
                            .attr("class", function(d) { return "node" + (d.children ? " node--internal" : " node--leaf"); })
                            .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
                    node.append("circle")
                            .attr("r", 2.5);
                    node.append("text")
                            .attr("dy", 3)
                            .attr("x", function(d) { return d.children ? -8 : 8; })
                            .style("font", "20px times new roman")
                            .style("text-anchor", function(d) { return d.children ? "end" : "start"; })
                            .text(function(d) { return d.id.substring(d.id.lastIndexOf(".") + 1); });

            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
        this.classList.toggle('open');
        document.getElementById('js-modal').classList.toggle('open');
    })

    //columnchart-modal
    document.getElementById('columnchart-modal-file').addEventListener('click', function() {
        var x = <?php echo json_encode($tfidf); ?>;
        $.ajax({
            type:'POST',
            url:'/columnchart/processfile',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){
              var visnum=0;
              $('#vismain').empty();
              document.getElementById("svg_area").style.display = "none";
              Object.keys(response).forEach(function each(item) {
                //console.log(response[item].id);
                var vis = document.createElement("div");
                vis.id = response[item].id;
                $('#vismain').append(vis);
                $('#vismain').append('<p></p>');
                var datalist = Array();
                Object.keys(response[item].value).forEach(function each(tdidf) {
                  if(datalist.length<9){
                  datalist.push({"label": tdidf, "value": response[item].value[tdidf]});}
                })
                // console.log(datalist);

                // [
                //   {
                //     "label": Object.keys(item[1]),
                //     "value": Object.values(item[1])
                //   },
                // ]
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        type: 'column3d',
                        renderAt: response[item].id,
                        width: '600',
                        height: '400',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "caption": "Term Frequency Inverse Document Frequency",
                                "subCaption": response[item].id,
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

                            "data": datalist
                        }
                    });
                    revenueChart.render();
                });

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

    //wordcloud-modal-tfidf
    document.getElementById('wordcloud-modal-tfidf').addEventListener('click', function() {
        var x = <?php echo json_encode($tfidf); ?>;
        $.ajax({
            type:'POST',
            url:'/wordcloud/processfile',
            async:false,
            data: {"_token": "{{ csrf_token() }}",text_data: x},
            success: function(response){ // What to do if we succeed


              var visnum=0;
              $('#vismain').empty();
              document.getElementById("svg_area").style.display = "none";
              Object.keys(response).forEach(function each(item) {
                //console.log(response[item].id);
                var hname = document.createElement("h1");
                var viscanvas = document.createElement("canvas");
                var vistooltip = document.createElement("div");
                hname.appendChild(document.createTextNode("TFIDF of "+response[item].id));
                viscanvas.id = response[item].id;
                viscanvas.class = "canvas";
                viscanvas.width = "900";
                viscanvas.height = "600";
                vistooltip.id = response[item].id;
                vistooltip.position = "relative";
                vistooltip.hidden = true;
                $('#vismain').append(hname);
                $('#vismain').append(viscanvas);
                $('#vismain').append(vistooltip);
                $('#vismain').append('<p></p>');
                var datalist = Array();
                Object.keys(response[item].value).forEach(function each(tdidf) {
                  if(datalist.length<50){

                  datalist.push(Array(tdidf, response[item].value[tdidf]));
                  }
                })
// console.log(datalist);
                $.getScript("{!! asset('js/wordcloud2.js') !!}", function () {
                    var options =
                    {
                        list : datalist,

                        gridSize: 20,
                        weightFactor: 3000,
                        fontFamily: 'Finger Paint, cursive, sans-serif',
                        color: '#000000',
                        hover: drawBox,
                        ellipticity: 1,
                        backgroundColor: '#ccffe6'
                    }
                    WordCloud(viscanvas.id, options);

                    var $box = vistooltip.id;
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
              })
                // $('#vismain').empty();
                //
                // document.getElementById("svg_area").style.display = "none";
                // //$('#canvas-container').html($(this).val());
                // $('#vismain').append('<canvas id="canvas_cloud" class="canvas" width="900" height="600"></canvas>');
                // $('#vismain').append('<div id="box" class="tooltipme" position="relative" hidden ></div>');



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
