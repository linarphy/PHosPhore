window.addEventListener('load', function () {
	var sum=0,
		input_attributes=document.getElementsByTagName('fieldset')[1].getElementsByTagName('input');
	function calcSum() {
		sum=0;
		for (var i = input_attributes.length - 1; i >= 0; i--) {
			var value=input_attributes[i].value;
			if (value==='')
			{
				input_attributes[i].value='0';
				value='0';
			}
			sum+=parseInt(value, 10);
		}
	}
	for (var i = input_attributes.length - 1; i >= 0; i--) {
		input_attributes[i].addEventListener('input', function (event) {
			do {
				calcSum();
				if (sum>10)
				{
					event.target.value=parseInt(event.target.value, 10)-1;
				}
			} while (sum>10);
		});
	}
});