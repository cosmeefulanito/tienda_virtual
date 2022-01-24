function controlTag(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; 
    else if (tecla==0||tecla==9)  return true;
    patron =/[0-9\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n); 
}

function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}

function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

function fntEmailValidate(email){
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}

function fntValidText(){
	let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
				this.classList.add('is-valid');
			}				
		});
	});
}

function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber) {
        validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
				this.classList.add('is-valid');
			}				
		});
	});
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
				// form-control-feedback
			}else{
				this.classList.remove('is-invalid');
				this.classList.add('is-valid');
			}				
		});
	});
}


function fntValidaRUT(){
	let validRUT = document.querySelectorAll(".validRut");
    validRUT.forEach(function(validRUT) {
        validRUT.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!Fn.validaRut(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
				this.classList.add('is-valid');
			}				
		});
	});
}

	var Fn = {
		// Valida el rut con su cadena completa "XXXXXXXX-X"
		validaRut : function (rutCompleto) {
			if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
				return false;
			var tmp 	= rutCompleto.split('-');
			var digv	= tmp[1]; 
			var rut 	= tmp[0];
			if ( digv == 'K' ) digv = 'k' ;
			return (Fn.dv(rut) == digv );
		},
		dv : function(T){
			var M=0,S=1;
			for(;T;T=Math.floor(T/10))
				S=(S+T%10*(9-M++%6))%11;
			return S?S-1:'k';
		}
	}




window.addEventListener('load', function() {
	fntValidText();
	fntValidEmail(); 
	fntValidNumber();
	fntValidaRUT();
}, false);