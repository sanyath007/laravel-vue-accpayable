@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            สร้างรายการขออนุมัติเบิก-จ่ายหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">สร้างรายการขออนุมัติเบิก-จ่ายหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="approveCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">สร้างรายการขออนุมัติ</h3>
                    </div>

                    <form id="frmNewDebt" name="frmNewDebt" method="post" action="{{ url('/debt/store') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.creditor_id.$error.required }">
                                        <label>เจ้าหนี้ :</label>
                                        <select id="creditor_id" 
                                                name="creditor_id"
                                                ng-model="debt.creditor_id" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($creditors as $creditor)

                                                <option value="{{ $creditor->supplier_id }}">
                                                    {{ $creditor->supplier_name }}
                                                </option>

                                            @endforeach
                                            
                                        </select>
                                        <div class="help-block" ng-show="frmNewDebt.creditor_id.$error.required">
                                            กรุณาเลือกเจ้าหนี้
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_doc_recno.$error.required }">
                                        <label>เลขที่ขออนุมัติ :</label>
                                        <input  type="text" 
                                                id="debt_doc_recno" .
                                                name="debt_doc_recno" 
                                                ng-model="debt.debt_doc_recno" 
                                                class="form-control"
                                                tabindex="4" required>
                                        <div class="help-block" ng-show="frmNewDebt.debt_doc_recno.$error.required">
                                            กรุณาระบุเลขที่ใบส่งของ/ใบกำกับภาษี
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.deliver_no.$error.required }">
                                        <label>เลขที่รับเอกสาร :</label>
                                        <input  type="text" 
                                                id="deliver_no" 
                                                name="deliver_no" 
                                                ng-model="debt.deliver_no" 
                                                class="form-control"
                                                tabindex="8" required>
                                        <div class="help-block" ng-show="frmNewDebt.deliver_no.$error.required">
                                            กรุณาระบุเลขที่ใบส่งของ/ใบกำกับภาษี
                                        </div>
                                    </div>

                                </div><!-- /.col -->

                                <div class="col-md-6">

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_date.$error.required }">
                                        <label>วันที่ขออนุมัติ :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="debt_date" 
                                                    name="debt_date" 
                                                    ng-model="debt.debt_date" 
                                                    class="form-control pull-right"
                                                    tabindex="1" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewDebt.debt_date.$error.required">
                                            กรุณาเลือกวันที่ลงบัญชี
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_doc_recdate.$error.required }">
                                        <label>วันที่รับหนังสือ :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="debt_doc_recdate" 
                                                    name="debt_doc_recdate" 
                                                    ng-model="debt.debt_doc_recdate" 
                                                    class="form-control pull-right"
                                                    tabindex="5" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewDebt.debt_doc_recdate.$error.required">
                                            กรุณาเลือกวันที่รับหนังสือ
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
                                        <a class="btn btn-primary" ng-click="showSupplierDebtList($event)">เพิ่ม</a>
                                        <a class="btn btn-danger" ng-click="">ลบ</a>

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
                                                    <td>@{{ (index + 1) }}</td>
                                                    <td>@{{ debt.debt_id }}</td>
                                                    <td>@{{ debt.debt_date | thdate }}</td>
                                                    <td>@{{ debt.deliver_no }}</td>
                                                    <td>@{{ debt.deliver_date | thdate }}</td>
                                                    <td>@{{ debt.debt_type_detail }}</td>
                                                    <td class="text-right">@{{ debt.debt_amount | number:2 }}</td>
                                                    <td class="text-right">@{{ debt.debt_vat | number:2 }}</td>
                                                    <td class="text-right">@{{ debt.debt_total | number:2 }}</td>
                                                </tr>   
                                            </tbody>
                                        </table>

                                        <div class="col-md-9"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>VAT (%) :</label>
                                                <input type="text" id="vatrate" name="vatrate" value="7" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ภาษีมูลค่าเพิ่ม :</label>
                                                <input type="text" id="vatamt" name="vatamt" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ฐานภาษี :</label>
                                                <input type="text" id="net_val" name="net_val" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ภาษีหัก ณ ที่จ่าย :</label>
                                                <input type="text" id="tax_val" name="tax_val" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ยอดสุทธิ :</label>
                                                <input type="text" id="net_total" name="net_total" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>ยอดจ่ายเช็ค :</label>
                                                <input type="text" id="cheque" name="cheque" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="store($event, frmNewDebt)" class="btn btn-success pull-right">
                                บันทึก
                            </button>
                        </div><!-- /.box-footer -->
                    </form>

                </div><!-- /.box -->

                <!-- Modal -->
                <div class="modal fade" id="dlgSupplierDebtList" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog">
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
                                                <!-- <th style="text-align: left;">ประเภทหนี้</th> -->
                                                <th style="width: 6%; text-align: center;">ยอดหนี้</th>
                                                <th style="width: 6%; text-align: center;">ภาษี</th>
                                                <th style="width: 6%; text-align: center;">สุทธิ</th>
                                                <!-- <th style="width: 6%; text-align: center;">สถานะ</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="(index, debt) in debts">
                                                <td class="text-center">
                                                    <a ng-click="addSupplierDebtData(debt)" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-check-square"></i>
                                                    </a>
                                                </td>
                                                <td>@{{ debt.debt_id }}</td>
                                                <td>@{{ debt.debt_date }}</td>
                                                <td>@{{ debt.deliver_no }}</td>
                                                <!-- <td>@{{ debt.deliver_date }}</td> -->
                                                <!-- <td>@{{ debt.debt_type_detail }}</td> -->
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
                                        <a ng-click="getDataWithURL(debtPager.first_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (debtPager.current_page==1)}">
                                        <a ng-click="getDataWithURL(debtPager.first_page_url)" aria-label="Prev">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>
                                   
                                    <li ng-if="debtPager.current_page < debtPager.last_page && (debtPager.last_page - debtPager.current_page) > 10">
                                        <a href="@{{ debtPager.url(debtPager.current_page + 10) }}">
                                            ...
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (debtPager.current_page==debtPager.last_page)}">
                                        <a ng-click="getDataWithURL(debtPager.next_page_url)" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>

                                    <li ng-if="debtPager.current_page !== debtPager.last_page">
                                        <a ng-click="getDataWithURL(debtPager.last_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
                                </ul>

                                <button type="button" class="btn btn-primary" ng-click="addNewLocation($event)">
                                    Save
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    Close
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

            $('#debt_date').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#debt_doc_recdate').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#debt_doc_date').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#deliver_date').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#doc_receive').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });
        });
    </script>

@endsection