app.controller('creditorCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.loading = false;
    $scope.pager = [];
    $scope.creditors = [];
    $scope.creditor = {
        prename_id: '',
        supplier_name: '',
        supplier_address1: '',
        supplier_address2: '',
        supplier_address3: '',
        supplier_zipcode: '',
        supplier_phone: '',
        supplier_fax: '',
        supplier_email: '',
        supplier_taxid: '',
        supplier_back_acc: '',
        supplier_note: '',
        supplier_credit: '',
        supplier_taxrate: '',
        supplier_agent_name: '',
        supplier_agent_email: '',
        supplier_agent_contact: ''
    };


    $scope.getData = function(event) {
        console.log(event);
        $scope.creditors = [];
        $scope.loading = true;
        
        var searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();
        console.log(CONFIG.BASE_URL+ '/creditor/search/' +searchKey);

        $http.get(CONFIG.BASE_URL+ '/creditor/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.creditors = res.data.creditors.data;
            $scope.pager = res.data.creditors;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.creditors = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.creditors = res.data.creditors.data;
            $scope.pager = res.data.creditors;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.add = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            $http.post(CONFIG.BASE_URL + '/creditor/store', $scope.creditor)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        document.getElementById('frmNewCreditor').reset();
    }

    $scope.getCreditor = function(creditorId) {
        $http.get(CONFIG.BASE_URL + '/creditor/get-creditor/' +creditorId)
        .then(function(res) {
            console.log(res);
            $scope.creditor = res.data.creditor;
            // $("#prename_id").val($scope.creditor.prename_id).change();
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(creditorId) {
        console.log(creditorId);

        window.location.href = CONFIG.BASE_URL + '/creditor/edit/' + creditorId;
    };

    $scope.update = function(event, form, creditorId) {
        console.log(creditorId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.BASE_URL + '/creditor/update/', $scope.creditor)
            .then(function(res) {
                console.log(res);
            }, function(err) {
                console.log(err);
            });
        }
    };

    $scope.delete = function(creditorId) {
        console.log(creditorId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            // $http.delete()
            // .then(function(res) {
                // console.log(res);
            // }, function(err) {
                // console.log(err);
            // });
        }
    };
});