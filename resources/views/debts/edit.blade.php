@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขข้อมูลหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขข้อมูลหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="debtCtrl" ng-init="getDebt('{{ $debt->debt_id }}')">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">แก้ไขข้อมูลหนี้ : @{{ debt.debt_id }}</h3>
                    </div>

                    <form id="frmEditDebt" name="frmEditDebt" method="post" action="{{ url('/debt/store') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        <input type="hidden" id="debt_id" name="debt_id" ng-model="debt.debt_id">
                        {{ csrf_field() }}
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    

                                </div><!-- /.col -->
                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="control-label">เจ้าหนี้ :</label>
                                        <input  type="text" 
                                                id="supplier_name" 
                                                name="supplier_name"
                                                value="{{ $creditor->supplier_name }}" 
                                                class="form-control"
                                                tabindex="0" readonly>
                                        <input  type="hidden" 
                                                id="supplier_id" 
                                                name="supplier_id" 
                                                value="{{ $creditor->supplier_id }}" 
                                                class="form-control">
                                    </div>                                

                                    <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_type_id.$error.required }">
                                        <label>ประเภทหนี้ :</label>
                                        <select id="debt_type_id" 
                                                name="debt_type_id"
                                                ng-model="debt.debt_type_id" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>

                                            @foreach($debttypes as $debttype)

                                                <option value="{{ $debttype->debt_type_id }}">
                                                    {{ $debttype->debt_type_name }}
                                                </option>

                                            @endforeach
                                            
                                        </select>
                                        <div class="help-block" ng-show="frmEditDebt.debt_type_id.$error.required">
                                            กรุณาเลือกประเภทหนี้
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>เลขที่รับหนังสือ :</label>
                                        <input  type="text" 
                                                id="debt_doc_recno" .
                                                name="debt_doc_recno" 
                                                ng-model="debt.debt_doc_recno" 
                                                class="form-control"
                                                tabindex="4">
                                    </div>

                                    <div class="form-group">
                                        <label>เลขที่หนังสือ :</label>
                                        <input type="text" id="debt_doc_no" name="debt_doc_no" ng-model="debt.debt_doc_no" class="form-control">
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmEditDebt.deliver_no.$error.required }">
                                        <label>เลขที่ใบส่งของ/ใบกำกับภาษี :</label>
                                        <input  type="text" 
                                                id="deliver_no" 
                                                name="deliver_no" 
                                                ng-model="debt.deliver_no" 
                                                class="form-control"
                                                tabindex="6" required>
                                        <div class="help-block" ng-show="frmEditDebt.deliver_no.$error.required">
                                            กรุณาเลือกคำนำหน้า
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_date.$error.required }">
                                        <label>วันที่ลงบัญชี :</label>

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
                                        <div class="help-block" ng-show="frmEditDebt.debt_date.$error.required">
                                            กรุณาเลือกวันที่ลงบัญชี
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>รายการ :</label>
                                        <input  type="text" 
                                                id="debt_type_detail" 
                                                name="debt_type_detail" 
                                                ng-model="debt.debt_type_detail" 
                                                class="form-control"
                                                tabindex="3">
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_doc_recdate.$error.required }">
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
                                        <div class="help-block" ng-show="frmEditDebt.debt_doc_recdate.$error.required">
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
                                                    class="form-control pull-right"
                                                    tabindex="7">
                                        </div><!-- /.input group -->
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmEditDebt.deliver_date.$error.required }">
                                        <label>วันที่ใบส่งของ/ใบกำกับภาษี :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="deliver_date" 
                                                    name="deliver_date" 
                                                    ng-model="debt.deliver_date" 
                                                    class="form-control pull-right"
                                                    tabindex="9" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmEditDebt.debt_doc_recdate.$error.required">
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
                                        <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_amount.$error.required || frmEditDebt.debt_amount.$error.pattern }">
                                            <label>ยอดหนี้ :</label>
                                            <input  type="text" 
                                                    id="debt_amount" 
                                                    name="debt_amount" 
                                                    ng-model="debt.debt_amount" 
                                                    class="form-control"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$"
                                                    tabindex="10" required>
                                            <div class="help-block" ng-show="frmEditDebt.debt_amount.$error.required">
                                                กรุณาระบุยอดหนี้
                                            </div>
                                            <div class="help-block" ng-show="frmEditDebt.debt_amount.$error.pattern">
                                                กรุณาระบุยอดหนี้เป็นตัวเลข
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_vat.$error.required || frmEditDebt.debt_vat.$error.pattern }">
                                            <label>จำนวนภาษี :</label>
                                            <input  type="text" 
                                                    id="debt_vat" 
                                                    name="debt_vat" 
                                                    ng-model="debt.debt_vat" 
                                                    class="form-control"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$"
                                                    tabindex="12" required>
                                            <div class="help-block" ng-show="frmEditDebt.debt_vat.$error.required">
                                                กรุณาระบุจำนวนภาษี
                                            </div>
                                            <div class="help-block" ng-show="frmEditDebt.debt_vat.$error.pattern">
                                                กรุณาระบุจำนวนภาษีเป็นตัวเลข
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">       
                                        <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_vatrate.$error.required || frmEditDebt.debt_vatrate.$error.pattern }">
                                            <label>VAT(%) :</label>
                                            <input  type="text" 
                                                    id="debt_vatrate" 
                                                    name="debt_vatrate" 
                                                    ng-model="debt.debt_vatrate"
                                                    ng-keyup="calculateVat(debt.debt_amount, debt.debt_vatrate)"
                                                    class="form-control"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$"
                                                    tabindex="11" required>
                                            <div class="help-block" ng-show="frmEditDebt.debt_vatrate.$error.required">
                                                กรุณาระบุอัตราภาษี (%)
                                            </div>
                                            <div class="help-block" ng-show="frmEditDebt.debt_vatrate.$error.pattern">
                                                กรุณาระบุอัตราภาษี (%) เป็นตัวเลข
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_total.$error.required || frmEditDebt.debt_total.$error.pattern }">
                                            <label>ยอดหนี้สุทธิ :</label>
                                            <input  type="text" 
                                                    id="debt_total" 
                                                    name="debt_total" 
                                                    ng-model="debt.debt_total" 
                                                    class="form-control"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$"
                                                    tabindex="13" required>
                                            <div class="help-block" ng-show="frmEditDebt.debt_total.$error.required">
                                                กรุณาระบุยอดหนี้สุทธิ
                                            </div>
                                            <div class="help-block" ng-show="frmEditDebt.debt_total.$error.pattern">
                                                กรุณาระบุยอดหนี้สุทธิเป็นตัวเลข
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
                                            <input  type="text" 
                                                    id="debt_month" 
                                                    name="debt_month"
                                                    ng-model="debt.debt_month"
                                                    class="form-control"
                                                    tabindex="14">
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error': frmEditDebt.debt_year.$error.required || frmEditDebt.debt_year.$error.pattern }">
                                            <label>ปีงบประมาณ (พ.ศ.) :</label>
                                            <input  type="text" 
                                                    id="debt_year" 
                                                    name="debt_year" 
                                                    ng-model="debt.debt_year" 
                                                    class="form-control"
                                                    pattern="[0-9]{4}"
                                                    tabindex="16" required>
                                            <div class="help-block" ng-show="frmEditDebt.debt_year.$error.required">
                                                กรุณาระบุปีงบประมาณ
                                            </div>
                                            <div class="help-block" ng-show="frmEditDebt.debt_year.$error.pattern">
                                                กรุณาระบุปีงบประมาณเป็นตัวเลข 4 หลัก
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">       
                                        <div class="form-group" ng-class="{ 'has-error': frmEditDebt.doc_receive.$error.required }">
                                            <label>วันที่รับเอกสาร :</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input  type="text" 
                                                        id="doc_receive" 
                                                        name="doc_receive" 
                                                        ng-model="debt.doc_receive" 
                                                        class="form-control pull-right"
                                                        tabindex="15" required>
                                            </div>
                                            <div class="help-block" ng-show="frmEditDebt.doc_receive.$error.required">
                                                กรุณาเลือกวันที่รับเอกสาร
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>หมายเหตุ :</label>
                                            <input  type="text" 
                                                    id="debt_remark" 
                                                    name="debt_remark" 
                                                    ng-model="debt.debt_remark" 
                                                    class="form-control"
                                                    tabindex="17">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="update($event, frmEditDebt, '{{ $debt->debt_id }}')" class="btn btn-warning pull-right">
                                แก้ไข
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