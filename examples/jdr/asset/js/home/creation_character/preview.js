window.addEventListener('load', function () {
	var submit=document.getElementById('btn_preview');
	submit.addEventListener('click', function (event) {
		event.preventDefault();
		var xhr=new XMLHttpRequest(),
			name=document.getElementsByTagName('fieldset')[0].getElementsByTagName('input')[0].value,
			race=document.getElementsByTagName('fieldset')[0].getElementsByTagName('select')[0].options[document.getElementsByTagName('fieldset')[0].getElementsByTagName('select')[0].selectedIndex].value,
			rpgClass=document.getElementsByTagName('fieldset')[0].getElementsByTagName('select')[1].options[document.getElementsByTagName('fieldset')[0].getElementsByTagName('select')[1].selectedIndex].value,
			attr=document.getElementsByTagName('fieldset')[1];
		var str=attr.getElementsByTagName('input')[0].value,
			dex=attr.getElementsByTagName('input')[1].value,
			con=attr.getElementsByTagName('input')[2].value,
			int_=attr.getElementsByTagName('input')[3].value,
			cha=attr.getElementsByTagName('input')[4].value,
			agi=attr.getElementsByTagName('input')[5].value,
			mag=attr.getElementsByTagName('input')[6].value,
			acu=attr.getElementsByTagName('input')[7].value;
		xhr.open('GET', '?custom_route_mode=0&application=generator&action=character&name='+name+'&class='+rpgClass+'&race='+race+'&str='+str+'&dex='+dex+'&con='+con+'&int_='+int_+'&cha='+cha+'&agi='+agi+'&mag='+mag+'&acu='+acu);
		xhr.responseType="document";
		xhr.send(null);
		xhr.addEventListener('load', function () {
			if (document.getElementById('preview'))
			{
				document.getElementById('preview').remove();
			}
			var container=document.createElement('div'),
				preview  =xhr.responseXML.getElementById('character');
			container.appendChild(preview);
			container.setAttribute('id', 'preview');
			document.getElementById('container').appendChild(container);
		});
	});
});