

function validatepassword() {
	// body...
	var password = document.getElementById('checkpassword');
	if(password.value.length < 8){
       console.log("short");
	}else{
      if (password.value.isNaN) {
      	 console.log("no number");
      }else{
      	 console.log("number");
      }
	}
}