@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการตัดจ่ายหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการตัดจ่ายหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="paymentCtrl" ng-init="getData()">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">ค้นหาข้อมูล</h3>
                    </div>

                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">

                            <div class="col-md-6"> 
                                <!-- Date and time range -->
                                <div class="form-group">
                                    <label>ระหว่างวันที่-วันที่:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="debtDate">
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>เจ้าหนี้</label>
                                    <input type="text" id="searchKey" ng-keyup="getData($event)" class="form-control">
                                </div><!-- /.form group -->
                            </div>
                            <div class="col-md-6"> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="showall" name="showall" ng-click="getDebtData('/payment/search/0')"> แสดงทั้งหมด
                                    </label>
                                </div>
                            </div>

                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <a href="{{ url('/payment/add') }}" class="btn btn-success"> สร้างรายการตัดจ่ายหนี้</a>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">รายการตัดจ่ายหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 3%; text-align: center;">#</th>
                                    <!-- <th style="width: 5%; text-align: center;">รหัส</th> -->
                                    <th style="width: 10%; text-align: center;">เลขที่ บค.</th>
                                    <th style="width: 7%; text-align: center;">วันที่</th>
                                    <th style="width: 8%; text-align: center;">เลขที่เช็ค</th>
                                    <th style="width: 7%; text-align: center;">วันที่เช็ค</th>
                                    <th style="text-align: left;">สั่งจ่าย</th>
                                    <th style="width: 8%; text-align: center;">ฐานภาษี</th>
                                    <th style="width: 8%; text-align: center;">ณ ที่จ่าย</th>
                                    <th style="width: 8%; text-align: center;">ยอดสุทธิ</th>
                                    <!-- <th style="width: 5%; text-align: center;">สถานะ</th> -->
                                    <th style="width: 6%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(index, payment) in payments">
                                    <td style="text-align: center;">@{{ index+pager.from }}</td>
                                    <!-- <td style="text-align: center;">@{{ payment.payment_id }}</td> -->
                                    <td style="text-align: center;">@{{ payment.paid_doc_no }}</td>
                                    <td style="text-align: center;">@{{ payment.paid_date | thdate }}</td>
                                    <td style="text-align: center;">@{{ payment.cheque_no }}</td>
                                    <td style="text-align: center;">@{{ payment.cheque_date | thdate }}</td>
                                    <td style="text-align: left;">@{{ payment.pay_to }}</td>
                                    <td style="text-align: right;">@{{ payment.net_val | number: 2 }}</td>
                                    <td style="text-align: right;">@{{ payment.net_amt | number: 2 }}</td>
                                    <td style="text-align: right;">@{{ payment.total | number: 2 }}</td>
                                    <!-- <td style="text-align: center;">@{{ payment.paid_stat }}</td> -->
                                    <td style="text-align: center;">
                                        <a ng-click="edit(payment.payment_id)" class="text-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a ng-click="popupApproveDebtList(payment.payment_id)" class="text-info">
                                            <i class="fa fa-search"></i>
                                        </a>

                                        @if(Auth::user()->person_id == '1300200009261')

                                            <a ng-click="delete(payment.payment_id)" class="text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        @endif
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">

                            <li ng-if="pager.current_page !== 1">
                                <a ng-click="getDataWithURL(pager.first_page_url)" aria-label="Previous">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>
                        
                            <li ng-class="{'disabled': (pager.current_page==1)}">
                                <a ng-click="getDataWithURL(pager.first_page_url)" aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>
                           
                            <li ng-if="pager.current_page < pager.last_page && (pager.last_page - pager.current_page) > 10">
                                <a href="@{{ pager.url(pager.current_page + 10) }}">
                                    ...
                                </a>
                            </li>
                        
                            <li ng-class="{'disabled': (pager.current_page==pager.last_page)}">
                                <a ng-click="getDataWithURL(pager.next_page_url)" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            <li ng-if="pager.current_page !== pager.last_page">
                                <a ng-click="getDataWithURL(pager.last_page_url)" aria-label="Previous">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-footer -->

                </div><!-- /.box -->

                <!-- Modal -->
                <div class="modal fade" id="dlgPaymentDebtList" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="">รายการหนี้</h4>
                            </div>
                            <div class="modal-body" style="padding-top: 0; padding-bottom: 0;">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" style="font-size: 12px; margin-top: 20px;">
                                        <thead>
                                            <tr>
                                                <th style="width: 2%; text-align: center;">#</th>
                                                <th style="width: 5%; text-align: center;">รหัส</th>
                                                <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                                                <th style="width: 7%; text-align: center;">เลขที่ใบส่งของ</th>
                                                <!-- <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th> -->
                                                <th style="text-align: left;">ประเภทหนี้</th>
                                                <th style="width: 20%; text-align: left;">รายละเอียด</th>
                                                <th style="width: 6%; text-align: center;">ยอดหนี้</th>
                                                <th style="width: 6%; text-align: center;">ภาษี</th>
                                                <th style="width: 6%; text-align: center;">สุทธิ</th>
                                                <!-- <th style="width: 6%; text-align: center;">สถานะ</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(index, debt) in debts">
                                                <td class="text-center">@{{ debt.seq_no }}</td>
                                                <td>@{{ debt.debt_id }}</td>
                                                <td>@{{ debt.debt.debt_date | thdate }}</td>
                                                <td>@{{ debt.debt.deliver_no }}</td>
                                                <!-- <td>@{{ debt.deliver_date }}</td> -->
                                                <td>@{{ debttypes[debt.debt.debt_type_id] }}</td>
                                                <td>@{{ debt.debt.debt_type_detail }}</td>
                                                <td class="text-right">@{{ debt.debt.debt_amount | number:2 }}</td>
                                                <td class="text-right">@{{ debt.debt.debt_vat | number:2 }}</td>
                                                <td class="text-right">@{{ debt.debt.debt_total | number:2 }}</td>
                                                <!-- <td>@{{ debt.debt_status }}</td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.table-responsive -->

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    ตกลง
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Date range picker with time picker
            $('#debtDate').daterangepicker({
                timePickerIncrement: 30,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: " , ",
                }
            }, function(e) {
                console.log(e);
            });
        });
    </script>
@endsection