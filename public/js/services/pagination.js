app.service('PaginateService', function(CONFIG, $http) {
	this.createPagerNo = function (pager) {
		let pages = [];

	    if(pager.last_page > 10 && (pager.current_page) + 10 < pager.last_page) {
            pages = _.range(pager.current_page, pager.current_page + 10)
        } else if(pager.last_page > 10 && (pager.current_page) + 10 > pager.last_page) {
            pages = _.range(pager.current_page, pager.last_page + 1)
        } else {
            pages = _.range(pager.current_page, pager.last_page + 1)
        }

		return pages;
	}
});