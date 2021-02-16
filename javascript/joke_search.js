function jokeSearch(value){

	let ajax = new XMLHttpRequest();
	let jokes = document.querySelector('#jokes');

	ajax.onreadystatechange = function(){
		//readystate = done, status = ok
		if (this.readyState == 4 && this.status == 200){
			
			jokes.innerHTML = this.responseText;
			//console.log(this.responseText);
		}

	};
	ajax.open('GET', '/novice_to_ninja/joke/search?s=' + value, true);
	ajax.send();

}