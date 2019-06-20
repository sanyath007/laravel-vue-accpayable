app.controller('approveCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.supplierDebtData = [];
    $scope.debts = [];
    $scope.debtPager = [];

    $scope.loading = false;
    $scope.pager = [];
    $scope.approvements = [];
    $scope.approvement = {
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
        $scope.approvements = [];
        $scope.loading = true;
        
        var searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();
        console.log(CONFIG.BASE_URL+ '/approve/search/' +searchKey);

        $http.get(CONFIG.BASE_URL+ '/approve/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.approvements = res.data.approvements.data;
            $scope.pager = res.data.approvements;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.approvements = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.approvements = res.data.approvements.data;
            $scope.pager = res.data.approvements;

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

        if(confirm("คุณต้องแก้ไขเจ้าหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.BASE_URL + '/creditor/update/', $scope.creditor)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.delete = function(creditorId) {
        console.log(creditorId);

        if(confirm("คุณต้องลบเจ้าหนี้เลขที่ " + creditorId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.BASE_URL + '/creditor/delete/' +creditorId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
                $scope.getData();
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.showSupplierDebtList = function(event) {
        // event.preventDefault();
        console.log(event);

        let creditor = $("#creditor_id").val();

        $http.get(baseUrl + '/debt/'+ creditor +'/list')
        .then(function (data) {
            console.log(data);
            $scope.debts = data.data.debts.data;
            $scope.debtPager = data.data.debts;

            $('#dlgSupplierDebtList').modal('show');
        });
    };

    $scope.addSupplierDebtData = function(supplierDebt) {
        $scope.supplierDebtData.push(supplierDebt);
        console.log($scope.supplierDebtData);
        calculateSupplierDebt();
    };

    function calculateSupplierDebt() {
        let vatAmt  = 0.0;
        let taxVal  = 0.0;
        let netVal  = 0.0;
        let netTotal = 0.0;
        let cheque = 0.0;
        let vatRate = $("#vatrate").val();

        angular.forEach($scope.supplierDebtData, function(debt) {
            netVal += debt.debt_total;
        });

        vatAmt = (netVal * vatRate) / 100;
        taxVal = (netVal * 1) / 100;
        netTotal = netVal + vatAmt;
        cheque = netTotal - taxVal;

        $("#net_val").val(netVal);
        $("#vatamt").val(vatAmt);
        $("#tax_val").val(taxVal);
        $("#net_total").val(netTotal);
        $("#cheque").val(cheque);
    }
});