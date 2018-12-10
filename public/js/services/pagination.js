app.service('PaginationService', function(CONFIG, $http) {
	this.convToDbDate = function (date) {
		arrDate = date.split('/');

		return (parseInt(arrDate[2]) - 543)+ '-' +arrDate[1]+ '-' +arrDate[0];
	}

	this.convFromDbDate = function (date) {
		arrDate = date.split('-');

		return arrDate[2]+ '/' +arrDate[1]+ '/' +(parseInt(arrDate[0]) + 543);
	}
});