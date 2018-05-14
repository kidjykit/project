@extends ('layouts.master')
<link href="{{ URL::asset('css/seperator.css') }}" rel="stylesheet">
@section ('content')
<style>
/* Style the tab */
.tab {
		width: 440px;
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    -webkit-animation: fadeEffect 1s;
    animation: fadeEffect 1s;
}

/* Fade in tabs */
@-webkit-keyframes fadeEffect {
    from {opacity: 0;}
    to {opacity: 1;}
}

@keyframes fadeEffect {
    from {opacity: 0;}
    to {opacity: 1;}
}
</style>

		<main class="choose-ur-destiny">
		  <div class="container">
		    <section class="variant">
		      <div align="center" style="width:100%;height:70%;">
						<h1>Thai Text Visualization</h1>
						<br>
						<div class="tab">
							<button>Choose Input:</button>
							<button class="tablinks" onclick="typeinput(event, 'textarea')" id="defaultOpen">Text</button>
							<button class="tablinks" onclick="typeinput(event, 'file')">Files</button>
						</div>

						<div id="textarea" class="tabcontent">
							<form method="POST" action="/modal/vistext">
								{{ csrf_field() }}

						  <div class="form-group">
						    <label for="input">Input:</label>
						    <textarea id="textarea" name="textarea" class="form-control" style="width:440px;height:200px;"></textarea>
						  </div>
						  <div class="form-group">
						  <button type="submit" class="btn btn-primary">Process</button>
						  </div>
							@include ('layouts.errors')
							</form>
					</div>

					<div id="file" class="tabcontent">
						<form method="POST" action="/modal/visfile" enctype="multipart/form-data">
							{{ csrf_field() }}

					  <div class="form-group">
					    <label for="input">Input:</label>
					      <input type="file" name="textfile[]" id="uploader" multiple="multiple"/></input>
					  </div>
					  <div class="form-group">
					  <button type="submit" class="btn btn-primary">Process</button>
					  </div>
						<br>
						<br>
						<br>
						<br>
						<br>
						@include ('layouts.errors')
					</form>
		      </div>
		    </section>
				<div class="variant variant--separator">
		    </div>
		    <section class="variant">
		      <div align="center">
		        <h1>Visualization</h1>
		        <div id="canvas-container"></div>
		      </div>
		    </section>
		  </div>
			</div>
		</main>
<script>
function typeinput(evt, input) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(input).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>

@endsection
