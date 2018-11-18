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
                                        <a href="" ng-show="(debt.debt_status==0)">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="" ng-show="(debt.debt_status==0)">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>             
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <!-- Loading (remove the following to stop the loading)-->
                    <div ng-show="loading" class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- end loading -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">

                        </ul>
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->

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
            });
        });
    </script>

@endsection