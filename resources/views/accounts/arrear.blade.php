@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ยอดหนี้ค้างจ่าย
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">ยอดหนี้ค้างจ่าย</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="accountCtrl">

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

                                        <option value="" selected="selected">-- กรุณาเลือก --</option>
                                        @foreach($debttypes as $debttype)

                                            <option value="{{ $debttype->debt_type_id }}">
                                                {{ $debttype->debt_type_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>เจ้าหนี้</label>
                                    <select id="creditor" class="form-control select2" style="width: 100%; font-size: 12px;">

                                        <option value="" selected="selected">-- กรุณาเลือก --</option>
                                        @foreach($creditors as $creditor)

                                            <option value="{{ $creditor->supplier_id }}">
                                                {{ $creditor->supplier_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                </div>                                
                            </div>

                            <div class="col-md-12">
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
                            <button ng-click="getArrearData('/account/arrear-rpt')" class="btn btn-info">
                                ค้นหา
                            </button>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">ยอดหนี้ค้างจ่าย</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table class="table table-bordered" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">#</th>
                                    <th style="width: 5%; text-align: center;">รหัสรายการ</th>
                                    <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
                                    <th style="width: 15%; text-align: left;">รายการ</th>
                                    <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
                                    <th style="width: 8%; text-align: center;">วันที่ตรวจรับ</th>
                                    <th style="text-align: left;">บริษัท</th>
                                    <th style="width: 8%; text-align: center;">เลขที่เอกสาร</th>
                                    <th style="width: 8%; text-align: center;">ยอดหนี้สุทธิ</th>
                                    <th style="width: 8%; text-align: center;">วันที่รับเอกสาร (ชุดเบิก-จ่าย)</th>
                                    <th style="width: 8%; text-align: center;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(index, debt) in debts">
                                    <td style="text-align: center;">@{{ index+pager.from }}</td>
                                    <td style="text-align: center;">@{{ debt.debt_id }}</td>
                                    <td style="text-align: left;">@{{ debt.debttype.debt_type_name }}</td>
                                    <td style="text-align: left;">@{{ debt.debt_type_detail }}</td>
                                    <td style="text-align: center;">@{{ debt.debt_date | thdate }}</td>
                                    <td style="text-align: center;">@{{ debt.debt_doc_recdate | thdate }}</td>
                                    <td style="text-align: left;">@{{ debt.supplier_name }}</td>
                                    <td style="text-align: center;">@{{ debt.deliver_no }}</td>
                                    <td style="text-align: right;">@{{ debt.debt_amount | number: 2 }}</td>
                                    <td style="text-align: center;">@{{ debt.app_recdoc_date | thdate }}</td>
                                    <td style="text-align: center;">
                                        @{{ (debt.debt_status==1) ? 'ขออนุมัติ' : 
                                            (debt.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                            (debt.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
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
                        <a  ng-show="debts.length"
                            ng-click="arrearToExcel('/account/arrear-excel')"
                            class="btn btn-success">
                            Excel
                        </a>

                        <ul ng-show="debts.length" class="pagination pagination-sm no-margin pull-right">                            
                            <li ng-if="pager.current_page !== 1">
                                <a href="#" ng-click="getArrearWithURL(pager.first_page_url)" aria-label="First">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>                            

                            <li ng-class="{'disabled': (pager.current_page==1)}">
                                <a href="#" ng-click="getArrearWithURL(pager.prev_page_url)" aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>
                            
                           <li ng-repeat="i in pages" ng-class="{'active': pager.current_page==i}">
                                <a href="#" ng-click="getArrearWithURL(pager.path + '?page=' +i)">
                                    @{{ i }}
                                </a>
                            </li>

                            <!-- <li ng-if="pager.current_page < pager.last_page && (pager.last_page - pager.current_page) > 10">
                                <a href="#" ng-click="getDataWithURL(pager.path)">
                                    ...
                                </a>
                            </li> -->
                            
                            <li ng-class="{'disabled': (pager.current_page==pager.last_page)}">
                                <a href="#" ng-click="getArrearWithURL(pager.next_page_url)" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            <li ng-if="pager.current_page !== pager.last_page">
                                <a href="#" ng-click="getArrearWithURL(pager.last_page_url)" aria-label="Last">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        </ul>
                    </div>

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