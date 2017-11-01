	var main_box = document.getElementsByClassName('main_box')[0];
	var navlogin = document.getElementsByClassName('navlogin')[0];
	var screen = document.getElementById('screen');
	var html = document.getElementsByTagName('html')[0];
	var bodyheight = document.body.scrollHeight;
	addEvent(navlogin,'click',function(){
		screen.style.height = bodyheight+"px";
		main_box.style.display = 'block';
		screen.style.display = 'block';
		html.style.overflow = 'hidden';
	})

	addEvent(screen,'click',function(){
		screen.style.display = 'none';
		main_box.style.display = 'none';
		html.style.overflow = 'visible';
	})


	function addEvent(elem, type, handle){
	if(elem.addEventListener) {
		elem.addEventListener(type, handle, false);
	}else if(elem.attachEvent){
		// elem.attachEvent('on' + type, function(){
		// 	handle.call(elem)
		// });
	elem['temp' + type + handle] = handle;
	elem[type + handle] = function (){
		elem['temp' + type + handle].call(elem);
	}
	elem.attachEvent('on'+ type , elem[type+handle]);
	
	}else{
		elem['on' + type] = handle;
	}
}