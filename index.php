<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Speech to text</title>
	<style>
		.container {
			text-align: center;
			margin-top: 100px;
		}
		textarea {
			width: 500px;
			height: 250px;
			resize: none;
			font-size: 16px;
			padding: 10px 15px;
		}
		button {
			margin-top: 10px;
		}
		#confd {
			margin-top: 10px;
		}
		#countryLang {
			display: none;
		}
	</style>
</head>

<body>
	<div class="container">
		<textarea id="output"></textarea><br>
		<button id="start">Start</button>
		<button id="stop">Stop</button>
		<button id="cancel">Cancel</button>
		<select id="country"></select>
		<select id="countryLang"></select>
		<div id="confd">----</div>
	</div>
	<script>
		var output = document.getElementById("output");
		var start = document.getElementById("start");
		var stop = document.getElementById("stop");
		var cancel = document.getElementById("cancel");
		var country = document.getElementById("country");
		var countryLang = document.getElementById("countryLang");
		var confd = document.getElementById("confd");
		
		// now lets use web speech api
		var speechRecognition = speechRecognition || webkitSpeechRecognition;
		var recognizer = new speechRecognition();
		// new get languages from array supported by api
		// first copy array from a website
		
		var langList = [['العربية',       ['ar-SA']]];
		
		// first select a default language on page load
		recognizer.lang = "ar-SA";
		// now create a list of language to select on page
		for(var i=0; i<langList.length; i++){
			// add it in the select tag
			var countryList = countryList + '<option value="'+i+'">'+langList[i][0]+'</option>';
		}
		country.innerHTML = countryList;
		// some languages are used in more that one country Now specify languages for country
		country.onchange = function() {
			var countryVal = country.value;
			// we have to give the array variable to get data "langList"
			var selectCount = langList[countryVal];
			if(selectCount.length <= 2){
				var countryLangList = countryLangList + '<option value="'+selectCount[1][0]+'">'+selectCount[0]+'</option>';
			}else{
				for(var j=1; j<selectCount.length; j++){
				var countryLangList = countryLangList + '<option value="'+selectCount[j][0]+'">'+selectCount[j][1]+'</option>';
				}
			}
			countryLang.innerHTML = countryLangList;
			countryLang.style.display = "inline-block";
			recognizer.lang = countryLang.value;
		}
		// first set the value for lang 
		countryLang.onchange = function() {
			// it will get the value and assign to the "recognizer.lang" on selecting
			recognizer.lang = countryLang.value;
		}
		// now set controls
		start.onclick = function() {
			recognizer.start();
		}
		stop.onclick = function() {
			recognizer.stop();
		}
		cancel.onclick = function() {
			recognizer.abort();
			confd.innerHTML = "Cancled";
		}
		// when the recognizing start
		recognizer.onstart = function() {
			confd.innerHTML = "Listing ...";
		}
		recognizer.onspeechend = function() {
			stop.click();
		}
		recognizer.onresult = function(event) {
			var outText = event.results[0][0].transcript;
			var confidence = event.results[0][0].confidence*100;
			output.value = outText;
			confd.innerHTML = "Confidence: " + Math.round(confidence) + "%";
		}
		
		
	</script>
	
	<script src="//code.tidio.co/5nzgggr80qqoqdajdi2gciukele1rt57.js" async></script>
</body>
</html>
