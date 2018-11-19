@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขข้อมูล
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขข้อมูล</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="debtCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">แก้ไขข้อมูล : {{ $debt->debt_id }}</h3>
                    </div>

                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>เจ้าหนี้ :</label>
                                    <input  type="text" 
                                            id="{{ $creditor->supplier_id }}" 
                                            name="{{ $creditor->supplier_id }}" 
                                            value="{{ $creditor->supplier_name }}" 
                                            class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>เลขที่รายการหนี้ :</label>
                                    <input type="text" id="" name="" value="{{ $debt->debt_id }}" class="form-control">
                                </div>                                

                                <div class="form-group">
                                    <label>ประเภทหนี้ :</label>
                                    <select id="debtType" 
                                            class="form-control select2" 
                                            style="width: 100%; font-size: 12px;">
                                        <option value="">-- กรุณาเลือก --</option>

                                        @foreach($debttypes as $debttype)

                                            <option value="{{ $debttype->debt_type_id }}" {{ ($debttype->debt_type_id == $debt->debt_type_id) ? 'selected' : '' }}>
                                                {{ $debttype->debt_type_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>เลขที่รับหนังสือ :</label>
                                    <input type="text" id="" name="" value="{{ $debt->debt_doc_recno }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>เลขที่หนังสือ :</label>
                                    <input type="text" id="" name="" value="{{ $debt->debt_doc_no }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>เลขที่ใบส่งของ/ใบกำกับภาษี :</label>
                                    <input type="text" id="" name="" value="{{ $debt->deliver_no }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>วันที่ลงบัญชี :</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="debtDate" value="{{ $debt->debt_date }}">
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->

                                <div class="form-group">
                                    <label>รายการ :</label>
                                    <input type="text" id="" name="" value="{{ $debt->debt_type_detail }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>วันที่รับหนังสือ :</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="debtDocRecDate" value="{{ $debt->debt_doc_recdate }}">
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->

                                <div class="form-group">
                                    <label>วันที่หนังสือ :</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="debtDocDate" value="{{ $debt->debt_doc_date }}">
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->

                                <div class="form-group">
                                    <label>วันที่ใบส่งของ/ใบกำกับภาษี :</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="deliverDate" value="{{ $debt->deliver_date }}">
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->

                            </div>

                            <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">ยอดหนี้</a>
                                </li>
                            </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a" style="padding: 10px;">
                                    <div class="col-md-6">       
                                        <div class="form-group">
                                            <label>ยอดหนี้ :</label>
                                            <input type="text" id="debtAmount" name="debtAmount" value="{{ $debt->debt_amount }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>จำนวนภาษี :</label>
                                            <input type="text" id="vatAmt" name="vatAmt" value="{{ $debt->debt_vat }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">       
                                        <div class="form-group">
                                            <label>VAT(%) :</label>
                                            <input type="text" id="vatRate" name="vatRate" value="{{ $debt->debt_vatrate }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>ยอดหนี้สุทธิ :</label>
                                            <input type="text" id="debtTotale" name="debtTotale" value="{{ $debt->debt_total }}" class="form-control">
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
                                            <input type="text" id="" name="" value="{{ $debt->debt_month }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>ปีงบประมาณ :</label>
                                            <input type="text" id="" name="" value="{{ $debt->debt_year }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">       
                                        <div class="form-group">
                                            <label>วันที่รับเอกสาร :</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="docReceive" value="{{ $debt->doc_receive }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>หมายเหตุ :</label>
                                            <input type="text" id="" name="" value="{{ $debt->debt_remark }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="getDebtData('/debt/rpt')" class="btn btn-warning pull-right">
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

            $('#debtDate').datepicker({
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#debtDocRecDate').datepicker({
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#debtDocDate').datepicker({
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#deliverDate').datepicker({
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#docReceive').datepicker({
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
    </script>

@endsection