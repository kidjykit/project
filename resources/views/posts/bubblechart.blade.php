@extends ('layouts.master')
<script src="js/d3.v4.min.js"></script>
<link href="{{ URL::asset('css/seperator.css') }}" rel="stylesheet">
@section ('content')

<!DOCTYPE html>
<main class="choose-ur-destiny">
  <div class="container">
    <section class="variant">
      <div align="center">
        <h1>Input</h1>
        <textarea id="text_area" name="text_area" class="form-control" style="width:700px;height:700px;"></textarea>
      </div>
    </section>
    <div class="variant variant--separator">
      <button class="btn btn-primary" onclick="process_data();" >Process</button>
    </div>
    <section class="variant">
      <div align="center">
        <h1>Bubble Chart</h1>
        <svg id="svg_area" width="750" height="750" font-family="sans-serif" font-size="10" text-anchor="middle"></svg>
      </div>
    </section>
  </div>
</main>

<script>

  function process_data() {
    var info = $('#text_area').val();
    $("#svg_area").empty();
    $.ajax({
      type:'POST',
      url:'/bubblechart/process',
      async:false,
      data: {"_token": "{{ csrf_token() }}",text_data: info},
      success: function(response){ // What to do if we succeed
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



  }



</script>

@endsection