app.service('ReportService', function(CONFIG, $http) {
	this.getServiceData = function () {
		return $http.get(CONFIG.BASE_URL + '/report/service-chart');
	}

	this.getPeriodData = function () {
		return $http.get(CONFIG.BASE_URL + '/report/period-chart');
	}

	this.getDepartData = function () {
		return $http.get(CONFIG.BASE_URL + '/report/depart-chart');
	}
});