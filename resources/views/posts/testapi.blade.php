@extends ('layouts.master')

@section ('content')
    <div class="col-sm-8 blog-main">
        <h1>Thai Text Segmentation</h1>

        <form method="POST" action="/apizip" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="input">Input:</label><br>
                <input type="file" name="textword[]" id="uploader" multiple="multiple"/>
                <br>
                            <label for="chkDict">
                                <input type="checkbox" id="chkDict" />
                                Do you have more dictionary?
                            </label>
                            <div id="dvDict" style="display: none">
                                Dict:
                                <input type="file" name="dictdoc" id="dict" multiple="multiple"/></input>
                            </div>
            </div>
            <div class="form-group">
                <label for="input">API KEY: (Test KEY: geFZYVLJS2)</label><br>
                <input type="input" name="apikey" id="uploader" multiple="multiple"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>

            @include ('layouts.errors')

        </form>

    </div>
<script>
  $(function () {
      $("#chkDict").click(function () {
          if ($(this).is(":checked")) {
              $("#dvDict").show();
          } else {
              $("#dvDict").hide();
          }
        });
  });
</script>
@endsection
