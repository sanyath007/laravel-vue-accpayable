app.controller('creditorCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.debts = [];
    $scope.creditor = [
        {
            supplier_prefix: '',
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
        }
    ];
    $scope.totalDebt = 0.00;
    $scope.loading = false;

    $scope.getData = function(URL) {
        $scope.debts = [];
        $scope.loading = true;
        
        var debtDate = ($("#debtDate").val()).split(",");
        var sDate = debtDate[0].trim();
        var eDate = debtDate[1].trim();
        var debtType = $("#debtType").val();
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;


    	$http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/1')
    	.then(function(res) {
    		console.log(res);
            $scope.debts = res.data.debts.data;
    		$scope.totalDebt = res.data.totalDebt;

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
        }
    }

    $scope.edit = function(debtId) {
        console.log(debtId);
        // $('#dlgEditForm').modal('show');

        var creditor = $("#debtType").val();

        if(creditor === '') {
            console.log("You doesn't select creditor !!!");
            toaster.pop('warning', "", "คุณยังไม่ได้เลือกเจ้าหนี้ !!!");
        } else {
            window.location.href = CONFIG.BASE_URL + '/debt/edit/' + creditor + '/' + debtId;
        }
    };

    $scope.delete = function(debtId) {
        console.log(debtId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
            // $http.delete()
            // .then(function(res) {
                // console.log(res);
            // }, function(err) {
                // console.log(err);
            // });
        }
    };
});