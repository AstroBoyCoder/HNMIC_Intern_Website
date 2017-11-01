var personalimg_content_li = document.getElementsByClassName('personalimg_content_li');
var personalimg_content = document.getElementsByClassName('personalimg_content')[0];
var personalwrapperimg = document.getElementById('personalwrapperimg');
var screen = document.getElementById('screen');
var popup = document.getElementsByClassName('popup');
var html = document.getElementsByTagName('html')[0];

var bodyheight = document.body.scrollHeight;
	function Main(){
		addEvent(personalwrapperimg,'mousedown',function(e){
			var event = e||window.event;
			var tar = event.target || event.srcElement;
			var id = event.target.id || 0;
			console.log(id);
			if(tar.parentNode.className === 'personalimg_content_li'){
				screen.style.display = 'block';
				[].forEach.call(popup, function(item){
				
					if(item.id == id){
						console.log(id);
						item.style.display = 'block';
						html.style.overflow = 'hidden';
						screen.style.height = bodyheight + 'px';
					}
				});
				
			}
		})
	}

	Main()

	addEvent(screen,'click',function(e){
			screen.style.display = 'none';
			[].forEach.call(popup, function(item){
				item.style.display = "none";
			})
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