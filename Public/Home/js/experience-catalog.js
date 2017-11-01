var catalog_icon_ul = document.getElementsByClassName('catalog_icon_ul')[0];
var catalog_icon_ul_li = catalog_icon_ul.children;
var flag = false;//是否已经选择
var src= '_1';

function Main(){
	var len = catalog_icon_ul_li.length;
	//init
	for(var i = 0; i<len; i++){
		catalog_icon_ul_li[i].active = false;//当前哪个被选中
		addEvent(catalog_icon_ul_li[i],'click',function(e){
			var event = e||window.event;
			var tar = event.target || event.srcElement;
			if(tar.active){
				if(!tar.active){
					tar.className += src;
					tar.active = true;
					flag = true;
				}else{
					tar.className = tar.className.substring(0,tar.className.length - 2);
					tar.active = false;
					flag = false;
				}
			}

		})	

	}

}

Main()


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