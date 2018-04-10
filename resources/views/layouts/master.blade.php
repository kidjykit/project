<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">


    <title>Process</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">


    <!-- Custom styles for this template -->
    <link href="/css/blog.css" rel="stylesheet">


    {{--Load jQuery--}}
    <script type="text/javascript" src="{!! asset('js/jquery-1.12.4.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/jquery-ui.js') !!}"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
      #canvas-container {
        /*overflow-x: auto;*/
        /*overflow-y: visible;*/
        position: relative;
        margin-top: 20px;
        margin-bottom: 20px;
      }
      .canvas {
        display: block;
        position: relative;
        overflow: hidden;
      }

      #box {
        pointer-events: none;
        position: absolute;
        box-shadow: 0 0 200px 200px rgba(255, 255, 255, 0.5);
        border-radius: 50px;
        cursor: pointer;
      }

      .canvas.hide {
        display: none;
      }
      .tooltipme {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
      }

      /* Tooltip text */
      .tooltipme .tooltiptext {
        visibility: visible;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text - see examples below! */
        position: absolute;
      }

    </style>

  </head>

  <body>

   @include ('layouts.nav')


   <!-- <div class="blog-header">
     <div class="container">
       <h1 class="blog-title">The Kidjy Blog</h1>
       <p class="lead blog-description">An example blog template built with Bootstrap.</p>
     </div>
   </div> -->

    <div class="container" >
        @yield ('content')
    </div><!-- /.container -->

  </body>
</html>
