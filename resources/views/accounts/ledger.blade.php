@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            บัญชีแยกประเภทเจ้าหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">บัญชีแยกประเภทเจ้าหนี้</li>
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

                    <form id="frmSearch" name="frmSearch" role="form" action="{{ url(('/account/ledger')) }}" method="GET">
                        <div class="box-body">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>ระหว่างวันที่ :</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input  type="text" 
                                                id="sdate" 
                                                name="sdate"
                                                class="form-control pull-right"
                                                tabindex="1" required>
                                    </div><!-- /.input group -->
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>ถึงวันที่ :</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input  type="text" 
                                                id="edate" 
                                                name="edate"
                                                class="form-control pull-right"
                                                tabindex="1" required>
                                    </div><!-- /.input group -->
                                </div>

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
                            <button ng-click="getLedgerData($event, '/account/ledger')" class="btn btn-info">
                                ค้นหา
                            </button>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">บัญชีแยกประเภทเจ้าหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        @foreach($creditors as $creditor)

                        <div>
                            <h4>{{ $creditor->supplier_id }} - {{ $creditor->supplier_name }}</h4>

                            <table class="table table-bordered table-striped" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th style="width: 3%; text-align: center;">#</th>
                                        <th style="width: 5%; text-align: center;">รหัสรายการ</th>
                                        <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
                                        <th style="width: 8%; text-align: center;">เลขที่เอกสาร</th>
                                        <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
                                        <th style="text-align: left;">รายการ</th>
                                        <!-- <th style="width: 6%; text-align: center;">เลขที่เช็ค</th> -->
                                        <th style="width: 8%; text-align: center;">เครดิต</th>
                                        <th style="width: 8%; text-align: center;">เดบิต</th>
                                        <th style="width: 8%; text-align: center;">ยอดคงเหลือ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                        $index = 0;
                                        $totalDebit = 0;
                                        $totalCredit = 0;
                                    ?>

                                    @foreach($debts as $debt)
                                        @if($debt->supplier_id==$creditor->supplier_id)

                                            <?php
                                                $totalDebit += $debt->debt_amount;
                                                $totalCredit += $debt->rcpamt;
                                            ?>

                                            <tr>
                                                <td style="text-align: center;">{{ ++$index }}</td>
                                                <td style="text-align: center;">{{ $debt->debt_id }}</td>
                                                <td style="text-align: center;">{{ convThDateFromDb($debt->debt_date) }}</td>
                                                <td style="text-align: center;">{{ $debt->deliver_no }}</td>
                                                <td style="text-align: left;">{{ $debt->debt_type_name }}</td>
                                                <td style="text-align: left;">{{ $debt->debt_type_detail }}</td>
                                                <!-- <td style="text-align: center;">{{ $debt->cheque_no }}</td> -->
                                                <td style="text-align: right;">{{ number_format($debt->debt_amount,2) }}</td>
                                                <td style="text-align: right;">{{ number_format($debt->rcpamt,2) }}</td>
                                                <td style="text-align: right;">
                                                    {{ ($debt->rcpamt) ? number_format(($debt->rcpamt - $debt->debt_amount),2) : number_format($debt->debt_amount,2) }}
                                                </td>
                                            </tr>

                                        @endif
                                    @endforeach

                                    <tr>
                                        <td colspan="6" style="text-align: right;">รวม</td>
                                        <td style="text-align: right;">{{ number_format($totalDebit,2) }}</td>
                                        <td style="text-align: right;">{{ number_format($totalCredit,2) }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>  

                        @endforeach                   
                        
                    </div><!-- /.box-body -->

                    <!-- Loading (remove the following to stop the loading)-->
                    <div ng-show="loading" class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- end loading -->

                    <div class="box-footer clearfix">

                        <a  ng-show="'{{ count($debts) }}'"
                            ng-click="ledgerToExcel('/account/ledger-excel')"
                            class="btn btn-success">
                            Excel
                        </a>

                        <ul ng-show="debts.length" class="pagination pagination-sm no-margin pull-right">                            
                            <!-- <li ng-if="pager.current_page !== 1">
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
                            </li> -->

                            <!-- <li ng-if="pager.current_page < pager.last_page && (pager.last_page - pager.current_page) > 10">
                                <a href="#" ng-click="getDataWithURL(pager.path)">
                                    ...
                                </a>
                            </li> -->
                            
                            <!-- <li ng-class="{'disabled': (pager.current_page==pager.last_page)}">
                                <a href="#" ng-click="getArrearWithURL(pager.next_page_url)" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            <li ng-if="pager.current_page !== pager.last_page">
                                <a href="#" ng-click="getArrearWithURL(pager.last_page_url)" aria-label="Last">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li> -->
                        </ul>
                    </div>

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            $('#sdate').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            }).datepicker("setDate", "<?=convDateFromDb($sdate)?>");;

            $('#edate').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            }).datepicker("setDate", "<?=convDateFromDb($edate)?>");
        });
    </script>

@endsection