@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ยอดหนี้รายประเภทหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">ยอดหนี้รายประเภทหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="reportCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ค้นหาข้อมูล</h3>
                    </div>
                    
                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ประเภทหนี้</label>
                                    <select id="debtType" class="form-control select2" style="width: 100%; font-size: 12px;">

                                        <option selected="selected">-- กรุณาเลือก --</option>
                                        
                                        @foreach($debttypes as $debttype)

                                            <option value="{{ $debttype->debt_type_id }}">
                                                {{ $debttype->debt_type_name }}
                                            </option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>

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
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="showall" name="showall"> แสดงทั้งหมด
                                    </label>
                                </div>
                            </div>
                        
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <button ng-click="getDebtData('/debt-debttype/rpt')" class="btn btn-primary">ค้นหา</button>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title">ยอดหนี้รายประเภทหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table class="table table-bordered" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">#</th>
                                    <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
                                    <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                    <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
                                    <th style="text-align: left;">เจ้าหนี้</th>
                                    <th style="width: 8%; text-align: center;">ยอดหนี้</th>
                                    <th style="width: 8%; text-align: center;">ภาษี</th>
                                    <th style="width: 8%; text-align: center;">สุทธิ</th>
                                    <th style="width: 8%; text-align: center;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="debt in debts">
                                    <td style="text-align: center;">@{{ debt.debt_id }}</td>
                                    <td style="text-align: left;">@{{ debt.debt_date | thdate }}</td>
                                    <td style="text-align: center;">@{{ debt.deliver_no }}</td>
                                    <td style="text-align: left;">@{{ debt.debt_type_name }}</td>
                                    <td style="text-align: left;">@{{ debt.supplier_name }}</td>
                                    <td style="text-align: center;">@{{ debt.debt_amount | number:2 }}</td>
                                    <td style="text-align: center;">@{{ debt.debt_vat | number:2 }}</td>
                                    <td style="text-align: center;">@{{ debt.debt_total | number:2 }}</td>                                    
                                    <td style="text-align: center;">@{{ debt.debt_status }}</td>             
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