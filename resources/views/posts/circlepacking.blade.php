@extends ('layouts.master')
<script src="js/d3.v4.min.js"></script>
<link href="{{ URL::asset('css/seperator.css') }}" rel="stylesheet">
@section ('content')

  <!DOCTYPE html>
  <meta charset="utf-8">
  <style>

    circle {
      fill: rgb(31, 119, 180);
      fill-opacity: .25;
      stroke: rgb(31, 119, 180);
      stroke-width: 1px;
    }

    .leaf circle {
      fill: #ff7f0e;
      fill-opacity: 1;
    }

    text {
      font: 10px sans-serif;
      text-anchor: middle;
    }

  </style>

  <main class="choose-ur-destiny">
    <div class="container">
      <section class="variant">
        <div align="center">
          <h1>Input</h1>
          <textarea id="text_area" name="text_area" class="form-control" style="width:100%;height:100%;"></textarea>
        </div>
      </section>
      <div class="variant variant--separator">
        <button class="btn btn-primary" onclick="process_data();" >Process</button>
      </div>
      <section class="variant">
        <div align="center">
          <h1>Circle Packing</h1>
          <svg id="svg_area" width="750" height="750" ></svg>
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
        url:'/circlepacking/process',
        async:false,
        data: {"_token": "{{ csrf_token() }}",text_data: info},
        success: function(response){ // What to do if we succeed
          console.log(response);
          var svg = d3.select("svg"),
                  diameter = +svg.attr("width"),
                  g = svg.append("g").attr("transform", "translate(2,2)"),
                  format = d3.format(",d");

          var pack = d3.pack()
                  .size([diameter - 4, diameter - 4]);

          root = d3.hierarchy(response)
                  .sum(function(d) { return d.size; })
                  .sort(function(a, b) { return b.value - a.value; });

          var node = g.selectAll(".node")
                  .data(pack(root).descendants())
                  .enter().append("g")
                  .attr("class", function(d) { return d.children ? "node" : "leaf node"; })
                  .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

          node.append("title")
                  .text(function(d) { return d.data.name + "\n" + format(d.value); });

          node.append("circle")
                  .attr("r", function(d) { return d.r; });

          node.filter(function(d) { return !d.children; }).append("text")
                  .attr("dy", "0.3em")
                  .text(function(d) { return d.data.name.substring(0, d.r / 3); });

        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
    }

  </script>

@endsection
