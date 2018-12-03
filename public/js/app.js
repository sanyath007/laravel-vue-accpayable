var app = angular.module('app', ['xeditable','ngTagsInput','toaster','ngAnimate','angularModalService']);

app.constant('CONFIG', {
    'APP_NAME' : 'Accounts Payable System',
    'APP_VERSION' : '1.0.0',
    'GOOGLE_ANALYTICS_ID' : '',
    // 'BASE_URL' : window.location.protocol+ '//' +window.location.host+ '/public',
    'BASE_URL' : window.location.protocol+ '//' +window.location.host+ '/public/laravel-accpayable/public',
    'SYSTEM_LANGUAGE' : 'TH'
});

app.run(function(editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
    editableOptions.activate = 'select';
});

app.controller('ModalController', function($scope, close){
	// close('Success!');
});

app.filter('thdate', function($filter)
{
 	return function(input)
 	{
  		if(input == null){ return ""; } 

  		var arrDate = input.split('-');
  		var thdate = arrDate[2]+ '/' +arrDate[1]+ '/' +(parseInt(arrDate[0])+543);
 
  		return thdate;
 	};
});
