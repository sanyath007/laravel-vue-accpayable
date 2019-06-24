@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            สร้างรายการตัดจ่ายหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">สร้างรายการตัดจ่ายหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="paymentCtrl" ng-init="initData()">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">สร้างรายการตัดจ่ายหนี้</h3>
                    </div>

                    <form id="frmNewApprove" name="frmNewApprove" method="post" action="{{ url('/approve/store') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.creditor_id.$error.required }">
                                        <label>เจ้าหนี้ :</label>
                                        <select id="creditor_id" 
                                                name="creditor_id"
                                                ng-model="approve.creditor_id"
                                                ng-change="clearSupplierDebtData()"
                                                class="form-control select2"
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="0" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($creditors as $creditor)

                                                <option value="{{ $creditor->supplier_id }}">
                                                    {{ $creditor->supplier_name }}
                                                </option>

                                            @endforeach
                                            
                                        </select>
                                        <div class="help-block" ng-show="frmNewApprove.creditor_id.$error.required">
                                            กรุณาเลือกเจ้าหนี้
                                        </div>
                                    </div>


                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.app_doc_no.$error.required }">
                                        <label>เลขที่ บค. :</label>
                                        <input  type="text" 
                                                id="app_doc_no" .
                                                name="app_doc_no" 
                                                ng-model="approve.app_doc_no" 
                                                class="form-control"
                                                tabindex="4" required>
                                        <div class="help-block" ng-show="frmNewApprove.app_doc_no.$error.required">
                                            กรุณาระบุเลขที่ บค.
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.app_recdoc_no.$error.required }">
                                        <label>เลขที่เช็ค :</label>
                                        <input  type="text" 
                                                id="app_recdoc_no" 
                                                name="app_recdoc_no" 
                                                ng-model="approve.app_recdoc_no" 
                                                class="form-control"
                                                tabindex="8" required>
                                        <div class="help-block" ng-show="frmNewApprove.app_recdoc_no.$error.required">
                                            กรุณาระบุเลขที่เช็ค
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.budget_id.$error.required }">
                                        <label>ธนาคาร :</label>
                                        <select id="budget_id" 
                                                name="budget_id"
                                                ng-model="approve.budget_id"
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($budgets as $budget)

                                                <option value="{{ $budget->budget_id }}">
                                                    {{ $budget->budget_name }}
                                                </option>

                                            @endforeach
                                            
                                        </select>
                                        <div class="help-block" ng-show="frmNewApprove.budget_id.$error.required">
                                            กรุณาเลือกประเภทงบประมาณ
                                        </div>
                                    </div>

                                </div><!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.app_doc_no.$error.required }">
                                        <label>รหัสรายการขออนุมัติ :</label>                                       
                                        <div class="input-group">
                                            <input  type="text" 
                                                    id="app_doc_no" .
                                                    name="app_doc_no" 
                                                    ng-model="approve.app_doc_no" 
                                                    class="form-control"
                                                    tabindex="4" required>

                                            <div class="input-group-addon">
                                                <a ng-click="popupApproveSelection($event)" style="cursor: pointer;">...</a>
                                            </div>
                                        </div>
                                        <div class="help-block" ng-show="frmNewApprove.app_doc_no.$error.required">
                                            กรุณาระบุรหัสรายการขออนุมัติ
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.app_date.$error.required }">
                                        <label>วันที่ บค. :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="app_date" 
                                                    name="app_date" 
                                                    ng-model="approve.app_date" 
                                                    class="form-control pull-right"
                                                    tabindex="1" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewApprove.app_date.$error.required">
                                            กรุณาเลือกวันที่ บค.
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.app_recdoc_date.$error.required }">
                                        <label>วันที่เช็ค :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="app_recdoc_date" 
                                                    name="app_recdoc_date" 
                                                    ng-model="approve.app_recdoc_date" 
                                                    class="form-control pull-right"
                                                    tabindex="5" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewApprove.app_recdoc_date.$error.required">
                                            กรุณาเลือกวันที่เช็ค
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewApprove.app_recdoc_no.$error.required }">
                                        <label>ผู้รับเช็ค :</label>
                                        <input  type="text" 
                                                id="app_recdoc_no" 
                                                name="app_recdoc_no" 
                                                ng-model="approve.app_recdoc_no" 
                                                class="form-control"
                                                tabindex="8" required>
                                        <div class="help-block" ng-show="frmNewApprove.app_recdoc_no.$error.required">
                                            กรุณาระบุผู้รับเช็ค
                                        </div>
                                    </div>
                                    
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                    
                            <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">รายการหนี้</a>
                                </li>
                            </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a" style="padding: 10px;">

                                    <div class="col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" style="font-size: 12px; margin-top: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 3%; text-align: center;">#</th>
                                                        <th style="width: 6%; text-align: center;">รหัส</th>
                                                        <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                                                        <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                                        <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th>
                                                        <th style="text-align: left;">ประเภทหนี้</th>
                                                        <th style="width: 7%; text-align: center;">ยอดหนี้</th>
                                                        <th style="width: 7%; text-align: center;">ภาษี</th>
                                                        <th style="width: 7%; text-align: center;">สุทธิ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="(index, debt) in supplierDebtData">
                                                        <td>
                                                            <input type="checkbox" 
                                                                    ng-click="addSupplierDebtToRemove($event, debt)">
                                                        </td>
                                                        <td>@{{ debt.debt_id }}</td>
                                                        <td>@{{ debt.debt_date | thdate }}</td>
                                                        <td>@{{ debt.deliver_no }}</td>
                                                        <td>@{{ debt.deliver_date | thdate }}</td>
                                                        <td>@{{ debt.debttype.debt_type_name }}</td>
                                                        <td class="text-right">@{{ debt.debt_amount | number:2 }}</td>
                                                        <td class="text-right">@{{ debt.debt_vat | number:2 }}</td>
                                                        <td class="text-right">@{{ debt.debt_total | number:2 }}</td>
                                                    </tr>   
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr style="margin: 0; margin-bottom: 10px;">

                                        <div class="col-md-6">
                                            <div class="form-group" ng-class="{ 'has-error': frmNewApprove.budget_id.$error.required }">
                                                <label>ประเภทงบประมาณ :</label>
                                                <select id="budget_id" 
                                                        name="budget_id"
                                                        ng-model="approve.budget_id"
                                                        class="form-control select2" 
                                                        style="width: 100%; font-size: 12px;"
                                                        tabindex="2" required>
                                                    <option value="" selected="selected">-- กรุณาเลือก --</option>

                                                    @foreach($budgets as $budget)

                                                        <option value="{{ $budget->budget_id }}">
                                                            {{ $budget->budget_name }}
                                                        </option>

                                                    @endforeach
                                                    
                                                </select>
                                                <div class="help-block" ng-show="frmNewApprove.budget_id.$error.required">
                                                    กรุณาเลือกประเภทงบประมาณ
                                                </div>
                                            </div>

                                            <span class="col-md-12" style="margin: 10px 5px; font-weight: bold;">
                                                (@{{ approve.cheque_str }})
                                            </span>
                                        </div>
                                        
                                        <div class="col-md-6">                                            
                                            <div class="form-group col-md-6">
                                                <label>ฐานภาษี :</label>
                                                <input type="text" 
                                                        id="net_val" 
                                                        name="net_val"
                                                        ng-model="approve.net_val" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>                                            
                                            <div class="form-group col-md-6">
                                                <label>ภาษีมูลค่าเพิ่ม :</label>
                                                <input type="text" 
                                                        id="vatamt" 
                                                        name="vatamt"
                                                        ng-model="approve.vatamt" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>ส่วนลด :</label>
                                                <input type="text" 
                                                        id="discount" 
                                                        name="discount"
                                                        ng-model="approve.discount" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>ค่าปรับ :</label>
                                                <input type="text" 
                                                        id="fine" 
                                                        name="fine"
                                                        ng-model="approve.fine" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>VAT (%) :</label>
                                                <input type="text" 
                                                        id="vatrate" 
                                                        name="vatrate"
                                                        ng-model="approve.vatrate" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>ภาษีหัก ณ ที่จ่าย :</label>
                                                <input type="text" 
                                                        id="tax_val" 
                                                        name="tax_val"
                                                        ng-model="approve.tax_val" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>                                            
                                            <div class="form-group col-md-6">
                                                <label>ยอดสุทธิ :</label>
                                                <input type="text" 
                                                        id="net_total" 
                                                        name="net_total"
                                                        ng-model="approve.net_total" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>ยอดจ่ายเช็ค :</label>
                                                <input type="text" 
                                                        id="cheque" 
                                                        name="cheque"
                                                        ng-model="approve.cheque" 
                                                        class="form-control text-right"
                                                        tabindex="1" required>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="store($event, frmNewApprove)" class="btn btn-success pull-right">
                                บันทึก
                            </button>
                        </div><!-- /.box-footer -->
                    </form>

                </div><!-- /.box -->

                <!-- Modal -->
                <div class="modal fade" id="dlgApproveSelection" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                                                <th style="width: 6%; text-align: center;">ยอดหนี้</th>
                                                <th style="width: 6%; text-align: center;">ภาษี</th>
                                                <th style="width: 6%; text-align: center;">สุทธิ</th>
                                                <!-- <th style="width: 6%; text-align: center;">สถานะ</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(index, debt) in debts">
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                            ng-click="addSupplierDebtData($event, debt)">
                                                </td>
                                                <td>@{{ debt.debt_id }}</td>
                                                <td>@{{ debt.debt_date }}</td>
                                                <td>@{{ debt.deliver_no }}</td>
                                                <!-- <td>@{{ debt.deliver_date }}</td> -->
                                                <td>@{{ debt.debttype.debt_type_name }}</td>
                                                <td class="text-right">@{{ debt.debt_amount | number:2 }}</td>
                                                <td class="text-right">@{{ debt.debt_vat | number:2 }}</td>
                                                <td class="text-right">@{{ debt.debt_total | number:2 }}</td>
                                                <!-- <td>@{{ debt.debt_status }}</td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /.table-responsive -->

                            </div>
                            <div class="modal-footer">
                                <ul class="pagination pagination-sm no-margin pull-left">
                                    <li ng-if="debtPager.current_page !== 1">
                                        <a ng-click="getSupplierDebtDataWithURL(debtPager.first_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (debtPager.current_page==1)}">
                                        <a ng-click="getSupplierDebtDataWithURL(debtPager.first_page_url)" aria-label="Prev">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>
                                   
                                    <li ng-if="debtPager.current_page < debtPager.last_page && (debtPager.last_page - debtPager.current_page) > 10">
                                        <a href="@{{ debtPager.url(debtPager.current_page + 10) }}">
                                            ...
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (debtPager.current_page==debtPager.last_page)}">
                                        <a ng-click="getSupplierDebtDataWithURL(debtPager.next_page_url)" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>

                                    <li ng-if="debtPager.current_page !== debtPager.last_page">
                                        <a ng-click="getSupplierDebtDataWithURL(debtPager.last_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
                                </ul>

                                <span class="pull-left" style="margin: 5px 10px;">
                                    @{{ debtPager.current_page+ ' of '+debtPager.last_page }} pages
                                </span>

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

            $('#app_date').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#app_recdoc_date').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });
        });
    </script>

@endsection