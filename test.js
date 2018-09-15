var myModule = (function() {
	var MyFunc = function(){
		console.log('in myFunc');
	}

	console.log('bottom of module');

	return {
		myFunc: MyFunc
	}
})();

myModule.myFunc();
