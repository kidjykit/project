@extends ('layouts.master')
<script src="js/d3.v4.min.js"></script>
<script src="https://rawgit.com/twitter/SentenTree/master/dist/sententree-standalone.min.js"></script>
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
        <h1>Sentence Tree</h1>
        <div id="vismain"></div>
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
      url:'/sentencetree/process',
      async:false,
      data: {"_token": "{{ csrf_token() }}",text_data: info},
      success: function(response){ // What to do if we succeed
        var data_list2 = Array(response);
        var i,a;
        var visnum=0;
        // console.log(data_list2);
        data_list2.forEach(function each(item) {
//
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
                sentenSet[0] = {id:Math.floor(Math.random() * 1000000) + 400000,text:senten,count:Math.floor(Math.random() * 3000) + 500};;;
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

  }
</script>

@endsection
