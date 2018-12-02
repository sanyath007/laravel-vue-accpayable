@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            เพิ่มข้อมูลหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">เพิ่มข้อมูลหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="debtCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">เพิ่มข้อมูลหนี้</h3>
                    </div>

                    <form id="frmNewDebt" name="frmNewDebt" method="post" action="{{ url('/debt/store') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="control-label">เจ้าหนี้ :</label>
                                        <input  type="text" 
                                                id="supplier_name" 
                                                name="supplier_name"
                                                value="{{ $creditor->supplier_name }}" 
                                                class="form-control"
                                                readonly>
                                        <input  type="hidden" 
                                                id="supplier_id" 
                                                name="supplier_id" 
                                                value="{{ $creditor->supplier_id }}" 
                                                class="form-control">
                                    </div>

                                </div><!-- /.col -->
                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_id.$error.required }">
                                        <label>เลขที่รายการหนี้ :</label>
                                        <input  type="text" 
                                                id="debt_id" 
                                                name="debt_id" 
                                                ng-model="debt.debt_id" 
                                                class="form-control" readonly required>
                                        <div class="help-block" ng-show="frmNewDebt.debt_id.$error.required">
                                            กรุณาเลือกคำนำหน้า
                                        </div>
                                    </div>                                

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_type_id.$error.required }">
                                        <label>ประเภทหนี้ :</label>
                                        <select id="debt_type_id" 
                                                name="debt_type_id"
                                                ng-model="debt.debt_type_id" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($debttypes as $debttype)

                                                <option value="{{ $debttype->debt_type_id }}">
                                                    {{ $debttype->debt_type_name }}
                                                </option>

                                            @endforeach
                                            
                                        </select>
                                        <div class="help-block" ng-show="frmNewDebt.debt_type_id.$error.required">
                                            กรุณาเลือกคำนำหน้า
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>เลขที่รับหนังสือ :</label>
                                        <input  type="text" 
                                                id="debt_doc_recno" .
                                                name="debt_doc_recno" 
                                                ng-model="debt.debt_doc_recno" 
                                                class="form-control" required>
                                        <div class="help-block" ng-show="frmNewDebt.debt_doc_recno.$error.required">
                                            กรุณาเลือกคำนำหน้า
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>เลขที่หนังสือ :</label>
                                        <input type="text" id="debt_doc_no" name="debt_doc_no" ng-model="debt.debt_doc_no" class="form-control">
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.deliver_no.$error.required }">
                                        <label>เลขที่ใบส่งของ/ใบกำกับภาษี :</label>
                                        <input  type="text" 
                                                id="deliver_no" 
                                                name="deliver_no" 
                                                ng-model="debt.deliver_no" 
                                                class="form-control" required>
                                        <div class="help-block" ng-show="frmNewDebt.deliver_no.$error.required">
                                            กรุณาเลือกคำนำหน้า
                                        </div>
                                    </div>

                                </div><!-- /.col -->

                                <div class="col-md-6">

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_date.$error.required }">
                                        <label>วันที่ลงบัญชี :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="debt_date" 
                                                    name="debt_date" 
                                                    ng-model="debt.debt_date" 
                                                    class="form-control pull-right" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewDebt.debt_date.$error.required">
                                            กรุณาเลือกวันที่ลงบัญชี
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>รายการ :</label>
                                        <input  type="text" 
                                                id="debt_type_detail" 
                                                name="debt_type_detail" 
                                                ng-model="debt.debt_type_detail" 
                                                class="form-control">
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
                                                    class="form-control pull-right" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewDebt.debt_doc_recdate.$error.required">
                                            กรุณาเลือกวันที่รับหนังสือ
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>วันที่หนังสือ :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="debt_doc_date" 
                                                    name="debt_doc_date" 
                                                    ng-model="debt.debt_doc_date" 
                                                    class="form-control pull-right">
                                        </div><!-- /.input group -->
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewDebt.deliver_date.$error.required }">
                                        <label>วันที่ใบส่งของ/ใบกำกับภาษี :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="deliver_date" 
                                                    name="deliver_date" 
                                                    ng-model="debt.deliver_date" 
                                                    class="form-control pull-right" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewDebt.deliver_date.$error.required">
                                            กรุณาเลือกวันที่ใบส่งของ/ใบกำกับภาษี
                                        </div>
                                    </div>
                                    
                                </div><!-- /.col -->
                            </div><!-- /.row -->

                            <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">ยอดหนี้</a>
                                </li>
                            </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a" style="padding: 10px;">
                                    <div class="col-md-6">       
                                        <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_amount.$error.required }">
                                            <label>ยอดหนี้ :</label>
                                            <input  type="text" 
                                                    id="debt_amount" 
                                                    name="debt_amount" 
                                                    ng-model="debt.debt_amount" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmNewDebt.debt_amount.$error.required">
                                                กรุณาเลือกคำนำหน้า
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_vat.$error.required }">
                                            <label>จำนวนภาษี :</label>
                                            <input  type="text" 
                                                    id="debt_vat" 
                                                    name="debt_vat" 
                                                    ng-model="debt.debt_vat" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmNewDebt.debt_vat.$error.required">
                                                กรุณาระบุจำนวนภาษี
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">       
                                        <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_vatrate.$error.required }">
                                            <label>VAT(%) :</label>
                                            <input  type="text" 
                                                    id="debt_vatrate" 
                                                    name="debt_vatrate" 
                                                    ng-model="debt.debt_vatrate" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmNewDebt.debt_vatrate.$error.required">
                                                กรุณาระบุอัตราภาษี (%)
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_total.$error.required }">
                                            <label>ยอดหนี้สุทธิ :</label>
                                            <input  type="text" 
                                                    id="debt_total" 
                                                    name="debt_total" 
                                                    ng-model="debt.debt_total" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmNewDebt.debt_total.$error.required">
                                                กรุณาระบุยอดหนี้สุทธิ
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">เพิ่มเติม</a>
                                </li>
                            </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a" style="padding: 10px;">
                                    <div class="col-md-6">       
                                        <div class="form-group">
                                            <label>ประจำเดือน :</label>
                                            <input type="text" id="" name="" class="form-control">
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error': frmNewDebt.debt_year.$error.required }">
                                            <label>ปีงบประมาณ :</label>
                                            <input  type="text" 
                                                    id="debt_year" 
                                                    name="debt_year" 
                                                    ng-model="debt.debt_year" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmNewDebt.debt_year.$error.required">
                                                กรุณาระบุปีงบประมาณ
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">       
                                        <div class="form-group" ng-class="{ 'has-error': frmNewDebt.doc_receive.$error.required }">
                                            <label>วันที่รับเอกสาร :</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input  type="text" 
                                                        id="doc_receive" 
                                                        name="doc_receive" 
                                                        ng-model="debt.doc_receive" 
                                                        class="form-control pull-right" required>
                                            </div>
                                            <div class="help-block" ng-show="frmNewDebt.doc_receive.$error.required">
                                                กรุณาระบุปีงบประมาณ
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>หมายเหตุ :</label>
                                            <input  type="text" 
                                                    id="debt_remark" 
                                                    name="debt_remark" 
                                                    ng-model="debt.debt_remark" 
                                                    class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="store($event, frmNewDebt)" class="btn btn-success pull-right">
                                บันทึก
                            </button>
                        </div><!-- /.box-footer -->
                    </form>

                </div><!-- /.box -->

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