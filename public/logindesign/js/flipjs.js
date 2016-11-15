var loginButton = document.getElementById("loginButton");
var registerButton = document.getElementById("registerButton");
var registerButtonNotify = document.getElementById("registerButtonNotify");

loginButton.onclick = function(){
	document.querySelector("#flipper").classList.toggle("flip");
}

registerButton.onclick = function(){
	document.querySelector("#flipper").classList.toggle("flip");
}

registerButtonNotify.onclick = function(){
	alert("Please verify your email to activate your account");
}