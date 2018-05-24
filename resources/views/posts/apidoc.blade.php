@extends ('layouts.master')
@section ('content')
<style>
p {
    font-family: "Times New Roman", Times, serif;
}
h1 {
    font-family: "Times New Roman", Times, serif;
}
h2 {
    font-family: "Times New Roman", Times, serif;
}

pre {
    font-family: "Times New Roman", Times, serif;
}
</style>
<div class="container">
<h1>REST API</h1>
<p>

	This topic will show you how to run our API, where REST API is an easy way to execute tasks. Because of this call. POSTMAN can be run directly.
</p>
<hr>
<h1>Sent value</h1>
<p> Method : POST
</p>
<p> URI : http://206.189.80.141/api
</p>
<table border="1" width="30%">
	<tr bgcolor="#00FF00">
		<td>
			KEY
		</td>
		<td>
			Value
		</td>
		<td>
			Type
		</td>
	</tr>
	<tr>
		<td>
			apikey
		</td>
		<td>
			Key
		</td>
		<td>
			String
		</td>
	</tr>
	<tr>
		<td>
			textword[]
		</td>
		<td>
			Text Files
		</td>
		<td>
			File Array
		</td>
	</tr>
</table>
<p></p>
<hr>
<h1>Return value</h1>
<p> JSON Format
</p>
<pre>
Example :
[{
"Filename" : "doc_1.txt",
"Wordsegment" : ["กฎหมาย","ค้าขาย","เป็นธรรม"],
"Process_time" : "0.01 ms"
}]
</pre>
<hr>
<h1>Example</h1>

<p> URI : http://206.189.80.141/api
</p>
<img src="image/api1.jpg" alt="POSTMAN">
<p>
</p>
<h2> Case:1 apikey incorrect
</h2>

<img src="image/apinocor.jpg" alt="apinocorrect">

<p>
</p>
<h2> Case:2 apikey correct
</h2>

<img src="image/apicor.jpg" alt="apicorrect">
</div>

@endsection
