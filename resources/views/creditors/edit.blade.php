@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขข้อมูล : {{ $creditor->supplier_id }}
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขข้อมูล</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="creditorCtrl" ng-init="getCreditor('{{ $creditor->supplier_id }}')">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">แก้ไขข้อมูล</h3>
                    </div>

                    <form id="frmEditCreditor" name="frmEditCreditor" method="put" action="{{ url('/creditor/update') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                        
                        <div class="box-body">

                            <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">ข้อมูลทั่วไป</a>
                                </li>
                                <li>
                                    <a href="#2a" data-toggle="tab">ข้อมูลเพิ่มเติม</a>
                                </li>
                            </ul>

                            <!-- ข้อมูลทั่วไป -->
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a" style="padding: 10px;">
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.prename_id.$invalid}">
                                            <label class="control-label">คำนำหน้า :</label>
                                            <select id="prename_id"
                                                    name="prename_id"
                                                    ng-model="creditor.prename_id"
                                                    class="form-control select2" 
                                                    style="width: 100%; font-size: 12px;" required>

                                                @foreach($prefixs as $prefix)

                                                    <option value="{{ $prefix->prename_id }}">
                                                        {{ $prefix->prename_name }}
                                                    </option>

                                                @endforeach
                                                
                                            </select>
                                            <div class="help-block" ng-show="frmEditCreditor.prename_id.$error.required">
                                                กรุณาเลือกคำนำหน้า
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_address1.$invalid}">
                                            <label class="control-label">ที่อยู่เลขที่ :</label>
                                            <input type="text" id="supplier_address1" name="supplier_address1" ng-model="creditor.supplier_address1" class="form-control" required>
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_address1.$error.required">
                                                กรุณากรอกที่อยู่ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_address3.$invalid}">
                                            <label class="control-label">ที่อยู่ (จ.) :</label>
                                            <input type="text" id="supplier_address3" name="supplier_address3" ng-model="creditor.supplier_address3" class="form-control" required>
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_address3.$error.required">
                                                กรุณากรอกที่อยู่ (จ.) ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_phone.$invalid}">
                                            <label class="control-label">โทรศัพท์ :</label>
                                            <input type="text" id="supplier_phone" name="supplier_phone" ng-model="creditor.supplier_phone" class="form-control">
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_phone.$error.required">
                                                กรุณากรอกเบอร์โทรศัพท์ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_email.$invalid}">
                                            <label class="control-label">E-mail :</label>
                                            <input type="text" id="supplier_email" name="supplier_email" ng-model="creditor.supplier_email" class="form-control">
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_email.$error.required">
                                                กรุณากรอกที่อยู่อีเมล์ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_taxid.$invalid}">
                                            <label class="control-label">เลขที่ประจำตัวผู้เสียภาษี :</label>
                                            <input type="text" id="supplier_taxid" name="supplier_taxid" ng-model="creditor.supplier_taxid" class="form-control" required>
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_taxid.$error.required">
                                                กรุณากรอกเลขที่ประจำตัวผู้เสียภาษีก่อน
                                            </div>
                                        </div><!-- /.form group -->
                                    </div>

                                    <div class="col-md-6">                                
                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_name.$invalid}">
                                            <label class="control-label">ชื่อเจ้าหนี้ :</label>
                                            <input type="text" id="supplier_name" name="supplier_name" ng-model="creditor.supplier_name" class="form-control" required>
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_name.$error.required">
                                                กรุณากรอกชื่อเจ้าหนี้ก่อน
                                            </div>
                                        </div>    

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_address2.$invalid}">
                                            <label class="control-label">ที่อยู่ (ต.และ อ.) :</label>
                                            <input type="text" id="supplier_address2" name="supplier_address2" ng-model="creditor.supplier_address2" class="form-control" required>
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_address2.$error.required">
                                                กรุณากรอกที่อยู่ (ต.และ อ.) ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_zipcode.$invalid}">
                                            <label class="control-label">รหัสไปรษณีย์ :</label>
                                            <input type="text" id="supplier_zipcode" name="supplier_zipcode" ng-model="creditor.supplier_zipcode" class="form-control" required>
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_zipcode.$error.required">
                                                กรุณากรอกรหัสไปรษณีย์ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_fax.$invalid}">
                                            <label class="control-label">แฟกซ์ :</label>
                                            <input type="text" id="supplier_fax" name="supplier_fax" ng-model="creditor.supplier_fax" class="form-control">
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_fax.$error.required">
                                                กรุณากรอกบอร์แฟกซ์ก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_back_acc.$invalid}">
                                            <label class="control-label">เลขที่บัญชี :</label>
                                            <input type="text" id="supplier_back_acc" name="supplier_back_acc" ng-model="creditor.supplier_back_acc" class="form-control">
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_back_acc.$error.required">
                                                กรุณากรอกเลขที่บัญชีก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_note.$invalid}">
                                            <label class="control-label">หมายเหตุ :</label>
                                            <input type="text" id="supplier_note" name="supplier_note" ng-model="creditor.supplier_note" class="form-control">
                                            <div class="help-block" ng-show="frmEditCreditor.supplier_note.$error.required">
                                                กรุณากรอกหมายเหตุก่อน
                                            </div>
                                        </div>

                                    </div>
                                </div>                            

                                <!-- ข้อมูลเพิ่มเติม -->
                                <div class="tab-pane" id="2a" style="padding: 10px;">
                                    <div class="row">
                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_credit.$invalid}">
                                                <label class="control-label">เครดิต (วัน) :</label>
                                                <input type="text" id="supplier_credit" name="supplier_credit" ng-model="creditor.supplier_credit" class="form-control" required>
                                                <div class="help-block" ng-show="frmEditCreditor.supplier_credit.$error.required">
                                                    กรุณากรอกจำนวนวันเครดิตก่อน
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_taxrate.$invalid}">
                                                <label class="control-label">อัตราภาษีที่หัก (%) :</label>
                                                <input type="text" id="supplier_taxrate" name="supplier_taxrate" ng-model="creditor.supplier_taxrate" class="form-control" required>
                                                <div class="help-block" ng-show="frmEditCreditor.supplier_taxrate.$error.required">
                                                    กรุณากรอกอัตราภาษีที่หักก่อน
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_agent_name.$invalid}">
                                                <label class="control-label">ชื่อผู้ติดต่อ :</label>
                                                <input type="text" id="supplier_agent_name" name="supplier_agent_name" ng-model="creditor.supplier_agent_name" class="form-control">
                                                <div class="help-block" ng-show="frmEditCreditor.supplier_agent_name.$error.required">
                                                    กรุณากรอกชื่อผู้ติดต่อก่อน
                                                </div>
                                            </div>

                                            <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_agent_email.$invalid}">
                                                <label class="control-label">อีเมล์ผู้ติดต่อ :</label>
                                                <input type="text" id="supplier_agent_email" name="supplier_agent_email" ng-model="creditor.supplier_agent_email" class="form-control">
                                                <div class="help-block" ng-show="frmEditCreditor.supplier_agent_email.$error.required">
                                                    กรุณากรอกอีเมล์ผู้ติดต่อก่อน
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditCreditor.supplier_agent_contact.$invalid}">
                                                <label class="control-label">เบอร์ผู้ติดต่อ :</label>
                                                <input type="text" id="supplier_agent_contact" name="supplier_agent_contact" ng-model="creditor.supplier_agent_contact" class="form-control">
                                                <div class="help-block" ng-show="frmEditCreditor.supplier_agent_contact.$error.required">
                                                    กรุณากรอกเบอร์ผู้ติดต่อก่อน
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="update($event, frmEditCreditor, creditor.supplier_id)" class="btn btn-warning pull-right">
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
        });
    </script>

@endsection