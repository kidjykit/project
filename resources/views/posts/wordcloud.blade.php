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
        <textarea id="text_area" name="text_area" class="form-control" style="width:100%;height:100%;"></textarea>
      </div>
    </section>
    <div class="variant variant--separator">
      <button class="btn btn-primary" onclick="process_data();" >Process</button>
    </div>
    <section class="variant">
      <div align="center">
        <h1>WordCloud</h1>
        <div id="canvas-container"></div>
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
      url:'/wordcloud/process',
      async:false,
      data: {"_token": "{{ csrf_token() }}",text_data: info},
      success: function(response){ // What to do if we succeed
        $('#canvas-container').empty();
        //$('#canvas-container').html($(this).val());
        $('#canvas-container').append('<canvas id="canvas_cloud" class="canvas" width="600px" height="500px"></canvas>');
        $('#canvas-container').append('<div id="box" class="tooltipme" hidden></div>');

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

                    gridSize: 13,
                    weightFactor: 10,
                    fontFamily: 'Finger Paint, cursive, sans-serif',
                    color: '#f0f0c0',
                    hover: drawBox,
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

      },
      error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        console.log(JSON.stringify(jqXHR));
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
      }
    });

  }
</script>

@endsection
