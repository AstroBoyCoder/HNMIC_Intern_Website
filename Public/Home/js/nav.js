	var navb=document.getElementsByClassName("navb")[0];
	var body = document.getElementsByTagName('body')[0];
	function getScroll(){
		if(document.body.scrollTop + document.documentElement.scrollTop == 0 ){
			navb.style.height = 70+ 'px';
			navb.className = 'navb';
		}else{
			navb.style.height = 50 + 'px';
			navb.className = 'navbb';
		}	
	}
	body.onscroll = function(){
		getScroll();
	}