app.service('ReportService', function(CONFIG, $http) {
	this.initBarChart = function(_container, _title, _categories, _ytitle) {
        return {
            chart: {
                renderTo: _container,
                type: 'column'
            },
            title: {
                text: _title
            },
            xAxis: {
                categories: _categories
            },
            yAxis: {
                title: {
                    enabled: true,
                    text: _ytitle
                }
            },
            series: []
        };
    };

    this.initStackChart = function(_container, _title, _categories, _ytitle) {
        return {
            chart: {
                renderTo: _container,
                type: 'column'
            },
            title: {
                text: _title
            },
            xAxis: {
                categories: _categories
            },
            yAxis: {
		        min: 0,
		        title: {
		            text: _ytitle
		        },
		        stackLabels: {
		            enabled: true,
		            style: {
		                fontWeight: 'bold',
		                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
		            }
		        }
		    },
		    plotOptions: {
		        column: {
		            stacking: 'normal',
		            dataLabels: {
		                enabled: true,
		                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
		            }
		        }
		    },
            series: []
        };
    };

    this.initBarChart = function(_container, _title, _categories) {
        return {
            chart: {
                renderTo: _container,
                type: 'column'
            },
            title: {
                text: _title
            },
            xAxis: {
                categories: _categories
            },
            series: []
        };
    };

    this.initPieChart = function(_container, _title) {
        return {
            chart: {
                renderTo: _container,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: _title
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'สัดส่วนการให้บริการ',
                data: []
            }]
        };
    };

	this.getSeriesData = function (url, data) {
		return $http.get(CONFIG.BASE_URL + url + data);
	}
});