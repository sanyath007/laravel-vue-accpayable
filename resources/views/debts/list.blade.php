@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการรับหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการรับหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="debtCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ค้นหาข้อมูล</h3>
                    </div>

                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>เจ้าหนี้</label>
                                    <select id="debtType" class="form-control select2" style="width: 100%; font-size: 12px;">

                                        <option value="" selected="selected">-- กรุณาเลือก --</option>
                                        @foreach($creditors as $creditor)

                                            <option value="{{ $creditor->supplier_id }}">
                                                {{ $creditor->supplier_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                </div>
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

                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">ยอดหนี้ทั้งหมด</div>
                                    <div class="panel-body" style="height: 90px; text-align: right;">
                                        <h2 style="color: red;">
                                            @{{ totalDebt | number: 2 }} 
                                        </h2>
                                    </div>
                                </div>
                            </div>                        
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <button ng-click="getDebtData('/debt/rpt')" class="btn btn-info">
                                ค้นหา
                            </button>
                            <a ng-click="addNewDebt($event)" class="btn btn-primary">
                                เพิ่มรายการ
                            </a>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">รายการรับหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <ul  class="nav nav-tabs">
                            <li class="active">
                                <a  href="#1a" data-toggle="tab">รายการรอดำเนินการ</a>
                            </li>
                            <li>
                                <a href="#2a" data-toggle="tab">รายหารขออนุมัติเบิก-จ่าย</a>
                            </li>
                            <li>
                                <a href="#3a" data-toggle="tab">รายการชำระแล้ว</a>
                            </li>
                        </ul>

                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="1a" style="padding: 10px;">
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align: center;">#</th>
                                            <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th>
                                            <th style="text-align: left;">เจ้าหนี้</th>
                                            <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 8%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 8%; text-align: center;">ภาษี</th>
                                            <th style="width: 8%; text-align: center;">สุทธิ</th>
                                            <th style="width: 8%; text-align: center;">สถานะ</th>
                                            <th style="width: 5%; text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="debt in debts">
                                            <td style="text-align: center;">@{{ debt.debt_id }}</td>
                                            <td style="text-align: center;">@{{ debt.debt_date }}</td>
                                            <td style="text-align: center;">@{{ debt.deliver_no }}</td>
                                            <td style="text-align: left;">@{{ debt.deliver_date }}</td>
                                            <td style="text-align: left;">@{{ debt.supplier_name }}</td>
                                            <td style="text-align: left;">@{{ debt.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_amount }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_vat }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_total }}</td>
                                            <td style="text-align: center;">
                                                @{{ (debt.debt_status==1) ? 'ขออนุมัติ' : 
                                                    (debt.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                    (debt.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
                                            </td>             
                                            <td style="text-align: center;">
                                                <a  href="#" 
                                                    ng-click="editDebt(debt.debt_id)" 
                                                    ng-show="(debt.debt_status==0)" 
                                                    class="text-warnong">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a  href="#" 
                                                    ng-click="deleteDebt(debt.debt_id)" 
                                                    ng-show="(debt.debt_status==0)" 
                                                    class="text-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>             
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">

                                </ul>
                            </div>
                            <div class="tab-pane" id="2a" style="padding: 10px;">
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align: center;">#</th>
                                            <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th>
                                            <th style="text-align: left;">เจ้าหนี้</th>
                                            <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 8%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 8%; text-align: center;">ภาษี</th>
                                            <th style="width: 8%; text-align: center;">สุทธิ</th>
                                            <th style="width: 8%; text-align: center;">สถานะ</th>
                                            <th style="width: 5%; text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="debt in debts">
                                            <td style="text-align: center;">@{{ debt.debt_id }}</td>
                                            <td style="text-align: center;">@{{ debt.debt_date }}</td>
                                            <td style="text-align: center;">@{{ debt.deliver_no }}</td>
                                            <td style="text-align: left;">@{{ debt.deliver_date }}</td>
                                            <td style="text-align: left;">@{{ debt.supplier_name }}</td>
                                            <td style="text-align: left;">@{{ debt.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_amount }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_vat }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_total }}</td>
                                            <td style="text-align: center;">
                                                @{{ (debt.debt_status==1) ? 'ขออนุมัติ' : 
                                                    (debt.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                    (debt.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
                                            </td>             
                                            <td style="text-align: center;">
                                                <a ng-click="editDebt(debt.debt_id)" ng-show="(debt.debt_status==0)">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a ng-click="deleteDebt(debt.debt_id)" ng-show="(debt.debt_status==0)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>             
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">

                                </ul>
                            </div>
                            <div class="tab-pane" id="3a" style="padding: 10px;">
                                <table class="table table-bordered" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align: center;">#</th>
                                            <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th>
                                            <th style="text-align: left;">เจ้าหนี้</th>
                                            <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 8%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 8%; text-align: center;">ภาษี</th>
                                            <th style="width: 8%; text-align: center;">สุทธิ</th>
                                            <th style="width: 8%; text-align: center;">สถานะ</th>
                                            <th style="width: 5%; text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="debt in debts">
                                            <td style="text-align: center;">@{{ debt.debt_id }}</td>
                                            <td style="text-align: center;">@{{ debt.debt_date }}</td>
                                            <td style="text-align: center;">@{{ debt.deliver_no }}</td>
                                            <td style="text-align: left;">@{{ debt.deliver_date }}</td>
                                            <td style="text-align: left;">@{{ debt.supplier_name }}</td>
                                            <td style="text-align: left;">@{{ debt.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_amount }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_vat }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_total }}</td>
                                            <td style="text-align: center;">
                                                @{{ (debt.debt_status==1) ? 'ขออนุมัติ' : 
                                                    (debt.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                    (debt.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
                                            </td>             
                                            <td style="text-align: center;">
                                                <a ng-click="editDebt(debt.debt_id)" ng-show="(debt.debt_status==0)">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a ng-click="deleteDebt(debt.debt_id)" ng-show="(debt.debt_status==0)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>             
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">

                                </ul>
                            </div>
                        </div>

                        
                    </div><!-- /.box-body -->

                    <!-- Loading (remove the following to stop the loading)-->
                    <div ng-show="loading" class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- end loading -->

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Modal -->
        <div class="modal fade" id="dlgEditForm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="">เพิ่มรายการสถานที่</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">ชื่อสถานที่</label>
                            <input type="text" id="locationName" name="locationName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">ที่อยู่</label>
                            <input type="text" id="locationAddress" name="locationAddress" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">ถนน</label>
                            <input type="text" id="locationRoad" name="locationRoad" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ID">จังหวัด</label>
                            <select 
                                id="chw_id"
                                name="chw_id" 
                                class="form-control" 
                                ng-model="selectedChangwat" 
                                ng-change="getAmphur($event, selectedChangwat)">
                                <option value="">-- กรุณาเลือกจังหวัด --</option>
                                <option value="@{{ c.chw_id }}" ng-repeat="c in changwats">
                                    @{{ c.changwat }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ID">อำเภอ</label>
                            <select 
                                id="amp_id"
                                name="amp_id" 
                                class="form-control" 
                                ng-model="selectedAmphur"
                                ng-change="getTambon($event, selectedAmphur)">
                                <option value="">-- กรุณาเลือกอำเภอ --</option>
                                <option value="@{{ a.id }}" ng-repeat="a in amphurs">
                                    @{{ a.amphur }}
                                </option>
                            </select>
                        </div>                    

                        <div class="form-group">
                            <label for="ID">ตำบล</label>                    
                            <select 
                                id="tam_id"
                                name="tam_id" 
                                class="form-control" 
                                ng-model="selectedTambon">
                                <option value="">-- กรุณาเลือกตำบล --</option>
                                <option value="@{{ t.id }}" ng-repeat="t in tambons">
                                    @{{ t.tambon }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">รหัสไปรษณี</label>
                            <input type="text" id="locationPostcode" name="locationPostcode" class="form-control">
                        </div>              
                    </div>
                    <div class="modal-footer">
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
            });
        });
    </script>

@endsection