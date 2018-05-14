@extends ('layouts.master')

@section ('content')
    <div class="col-sm-8 blog-main">
        <h1>Thai Text Visualization</h1>

        <form method="POST" action="/apizip" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="input">Input:</label><br>
                <input type="file" name="textword[]" id="uploader" multiple="multiple"/>
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
@endsection
