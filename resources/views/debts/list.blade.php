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

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="showall" name="showall" ng-click="getDebtData('/debt/rpt')"> แสดงทั้งหมด
                                    </label>
                                </div>
                                
                                <div class="form-group">
                                    <label>เจ้าหนี้</label>
                                    <select id="debtType"
                                            ng-model="cboDebtType"
                                            ng-change="getDebtData('/debt/rpt'); getDebtChart(cboDebtType)"
                                            class="form-control select2"
                                            style="width: 100%; font-size: 12px;">

                                        <option value="" selected="selected">-- กรุณาเลือก --</option>
                                        @foreach($creditors as $creditor)

                                            <option value="{{ $creditor->supplier_id }}">
                                                {{ $creditor->supplier_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div id="barContainer" style="width: 100%; height: 200px; margin: 0 auto; margin-top: 20px;"></div>

                                <!-- <div class="panel panel-primary">
                                    <div class="panel-heading">ยอดหนี้ทั้งหมด</div>
                                    <div class="panel-body" style="height: 90px; text-align: right;">
                                        <h2 style="color: red;">
                                            @{{ totalDebt | number: 2 }} 
                                        </h2>
                                    </div>
                                </div> -->

                            </div>                        
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <a ng-click="add($event)" class="btn btn-primary">
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
                                <a href="#1a" data-toggle="tab">รายการรอดำเนินการ</a>
                            </li>
                            <li>
                                <a href="#2a" data-toggle="tab">รายหารขออนุมัติเบิก-จ่าย</a>
                            </li>
                            <li>
                                <a href="#3a" data-toggle="tab">รายการชำระแล้ว</a>
                            </li>
                            <li>
                                <a href="#4a" data-toggle="tab">รายการลดหนี้ศูนย์</a>
                            </li>
                        </ul>

                        <!-- รายการรอดำเนินการ -->
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="1a" style="padding: 10px;">

                                <div class="form-group pull-right">
                                    <input  type="text" 
                                            id="table_search" 
                                            name="table_search"
                                            ng-model="searchKeyword"
                                            class="form-control pull-right" 
                                            placeholder="ค้นหาเลขที่ใบส่งของ">                                       
                                </div>

                                <table class="table table-bordered table-striped" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%; text-align: center;">#</th>
                                            <th style="width: 6%; text-align: center;">รหัสรายการ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ใบส่งของ</th>
                                            <!-- <th style="text-align: left;">เจ้าหนี้</th> -->
                                            <th style="text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 7%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 7%; text-align: center;">ภาษี</th>
                                            <th style="width: 7%; text-align: center;">สุทธิ</th>
                                            <th style="width: 6%; text-align: center;">สถานะ</th>
                                            <th style="width: 8%; text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="(index, debt) in debts">
                                            <td style="text-align: center;">@{{ index+debtPager.from }}</td>
                                            <td style="text-align: center;">@{{ debt.debt_id }}</td>
                                            <td style="text-align: center;">@{{ debt.debt_date | thdate }}</td>
                                            <td style="text-align: center;">@{{ debt.deliver_no }}</td>
                                            <td style="text-align: center;">@{{ debt.deliver_date | thdate }}</td>
                                            <!-- <td style="text-align: left;">@{{ debt.supplier_name }}</td> -->
                                            <td style="text-align: left;">@{{ debt.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_amount | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_vat | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ debt.debt_total | number: 2 }}</td>
                                            <td style="text-align: center;">
                                                <span class="label label-info" ng-show="paid.debt_status!=0">
                                                    @{{ (debt.debt_status==1) ? 'ขออนุมัติ' : 
                                                        (debt.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                        (debt.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
                                                </span>
                                            </td>             
                                            <td style="text-align: center;">
                                                <a  ng-click="setzero(debt.debt_id)" 
                                                    ng-show="(debt.debt_status==0)" 
                                                    class="btn btn-primary btn-xs" 
                                                    title="ลดหนี้ศูนย์">
                                                    <i class="fa fa-credit-card"></i>
                                                </a>
                                                <a  ng-click="edit(debt.debt_id)" 
                                                    ng-show="(debt.debt_status==0)" 
                                                    class="btn btn-warning btn-xs"
                                                    title="แก้ไขรายการ">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a  ng-click="delete(debt.debt_id)" 
                                                    ng-show="(debt.debt_status==0)" 
                                                    class="btn btn-danger btn-xs"
                                                    title="ลบรายการ">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>             
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li ng-if="debtPager.current_page !== 1">
                                        <a href="#" ng-click="getDebtWithURL(debtPager.first_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (debtPager.current_page==1)}">
                                        <a href="#" ng-click="getDebtWithURL(debtPager.prev_page_url)" aria-label="Prev">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>

                                    <li ng-repeat="i in debtPages" ng-class="{'active': debtPager.current_page==i}">
                                        <a href="#" ng-click="getDebtWithURL(debtPager.path + '?page=' +i)">
                                            @{{ i }}
                                        </a>
                                    </li>
                                   
                                    <!-- <li ng-if="debtPager.current_page < debtPager.last_page && (debtPager.last_page - debtPager.current_page) > 10">
                                        <a href="#" ng-click="debtPager.path">
                                            ...
                                        </a>
                                    </li> -->
                                
                                    <li ng-class="{'disabled': (debtPager.current_page==debtPager.last_page)}">
                                        <a href="#" ng-click="getDebtWithURL(debtPager.next_page_url)" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>

                                    <li ng-if="debtPager.current_page !== debtPager.last_page">
                                        <a href="#" ng-click="getDebtWithURL(debtPager.last_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- รายหารขออนุมัติเบิก-จ่าย -->
                            <div class="tab-pane" id="2a" style="padding: 10px;">
                                <table class="table table-bordered table-striped" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%; text-align: center;">#</th>
                                            <th style="width: 6%; text-align: center;">รหัสรายการ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ใบส่งของ</th>
                                            <!-- <th style="text-align: left;">เจ้าหนี้</th> -->
                                            <th style="text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 7%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 7%; text-align: center;">ภาษี</th>
                                            <th style="width: 7%; text-align: center;">สุทธิ</th>
                                            <th style="width: 6%; text-align: center;">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="(index, app) in apps">
                                            <td style="text-align: center;">@{{ index+appPager.from }}</td>
                                            <td style="text-align: center;">@{{ app.debt_id }}</td>
                                            <td style="text-align: center;">@{{ app.debt_date | thdate }}</td>
                                            <td style="text-align: center;">@{{ app.deliver_no }}</td>
                                            <td style="text-align: center;">@{{ app.deliver_date | thdate }}</td>
                                            <!-- <td style="text-align: left;">@{{ app.supplier_name }}</td> -->
                                            <td style="text-align: left;">@{{ app.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ app.debt_amount | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ app.debt_vat | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ app.debt_total | number: 2 }}</td>
                                            <td style="text-align: center;">
                                                @{{ (app.debt_status==1) ? 'ขออนุมัติ' : 
                                                    (app.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                    (app.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
                                            </td>            
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li ng-if="appPager.current_page !== 1">
                                        <a href="#" ng-click="getAppWithURL(appPager.first_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (appPager.current_page==1)}">
                                        <a href="#" ng-click="getAppWithURL(appPager.prev_page_url)" aria-label="Prev">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>
                                    
                                    <li ng-repeat="i in appPages" ng-class="{'active': appPager.current_page==i}">
                                        <a href="#" ng-click="getAppWithURL(appPager.path + '?page=' +i)">
                                            @{{ i }}
                                        </a>
                                    </li>

                                    <!-- <li ng-if="appPager.current_page < appPager.last_page && (appPager.last_page - appPager.current_page) > 10">
                                        <a href="@{{ appPager.url(appPager.current_page + 10) }}">
                                            ...
                                        </a>
                                    </li> -->
                                
                                    <li ng-class="{'disabled': (appPager.current_page==appPager.last_page)}">
                                        <a href="#" ng-click="getAppWithURL(appPager.next_page_url)" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>

                                    <li ng-if="appPager.current_page !== appPager.last_page">
                                        <a href="#" ng-click="getAppWithURL(appPager.last_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- รายการชำระแล้ว -->
                            <div class="tab-pane" id="3a" style="padding: 10px;">
                                <table class="table table-bordered table-striped" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%; text-align: center;">#</th>
                                            <th style="width: 6%; text-align: center;">รหัสรายการ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ใบส่งของ</th>
                                            <!-- <th style="text-align: left;">เจ้าหนี้</th> -->
                                            <th style="text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 7%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 7%; text-align: center;">ภาษี</th>
                                            <th style="width: 7%; text-align: center;">สุทธิ</th>
                                            <th style="width: 6%; text-align: center;">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="(index, paid) in paids">
                                            <td style="text-align: center;">@{{ index+paidPager.from }}</td>
                                            <td style="text-align: center;">@{{ paid.debt_id }}</td>
                                            <td style="text-align: center;">@{{ paid.debt_date | thdate }}</td>
                                            <td style="text-align: center;">@{{ paid.deliver_no }}</td>
                                            <td style="text-align: center;">@{{ paid.deliver_date | thdate }}</td>
                                            <!-- <td style="text-align: left;">@{{ paid.supplier_name }}</td> -->
                                            <td style="text-align: left;">@{{ paid.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ paid.debt_amount | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ paid.debt_vat | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ paid.debt_total | number: 2 }}</td>
                                            <td style="text-align: center;">
                                                <span class="label label-warning" ng-show="paid.debt_status==4">
                                                    @{{ (paid.debt_status==4) ? 'ลดหนี้ศูนย์' : '' }}
                                                </span>

                                                <span class="label label-success" ng-show="paid.debt_status!=4">
                                                    @{{ 
                                                        (paid.debt_status==0) ? 'รอดำเนินการ' :
                                                        (paid.debt_status==1) ? 'ขออนุมัติ' : 
                                                        (paid.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                        (paid.debt_status==3) ? 'ยกเลิก' : 'ลดหนี้ศูนย์'
                                                    }}
                                                </span>
                                            </td>      
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li ng-if="paidPager.current_page !== 1">
                                        <a href="#" ng-click="getPaidWithURL(paidPager.first_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (paidPager.current_page==1)}">
                                        <a href="#" ng-click="getPaidWithURL(paidPager.prev_page_url)" aria-label="Prev">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>
                                   
                                   <li ng-repeat="i in paidPages" ng-class="{'active': paidPager.current_page==i}">
                                        <a href="#" ng-click="getPaidWithURL(paidPager.path + '?page=' +i)">
                                            @{{ i }}
                                        </a>
                                    </li>

                                    <!-- <li ng-if="paidPager.current_page < paidPager.last_page && (paidPager.last_page - paidPager.current_page) > 10">
                                        <a href="@{{ paidPager.url(paidPager.current_page + 10) }}">
                                            ...
                                        </a>
                                    </li> -->
                                
                                    <li ng-class="{'disabled': (paidPager.current_page==paidPager.last_page)}">
                                        <a href="#" ng-click="getPaidWithURL(paidPager.next_page_url)" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>

                                    <li ng-if="paidPager.current_page !== paidPager.last_page">
                                        <a href="#" ng-click="getPaidWithURL(paidPager.last_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- รายการลดหนี้ศูนย์ -->
                            <div class="tab-pane" id="4a" style="padding: 10px;">
                                <table class="table table-bordered table-striped" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%; text-align: center;">#</th>
                                            <th style="width: 6%; text-align: center;">รหัสรายการ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                                            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
                                            <th style="width: 7%; text-align: center;">วันที่ใบส่งของ</th>
                                            <!-- <th style="text-align: left;">เจ้าหนี้</th> -->
                                            <th style="text-align: left;">ประเภทหนี้</th>
                                            <th style="width: 7%; text-align: center;">ยอดหนี้</th>
                                            <th style="width: 7%; text-align: center;">ภาษี</th>
                                            <th style="width: 7%; text-align: center;">สุทธิ</th>
                                            <th style="width: 6%; text-align: center;">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="(index, setzero) in setzeros">
                                            <td style="text-align: center;">@{{ index+setzeroPager.from }}</td>
                                            <td style="text-align: center;">@{{ setzero.debt_id }}</td>
                                            <td style="text-align: center;">@{{ setzero.debt_date | thdate }}</td>
                                            <td style="text-align: center;">@{{ setzero.deliver_no }}</td>
                                            <td style="text-align: center;">@{{ setzero.deliver_date | thdate }}</td>
                                            <!-- <td style="text-align: left;">@{{ setzero.supplier_name }}</td> -->
                                            <td style="text-align: left;">@{{ setzero.debttype.debt_type_name }}</td>
                                            <td style="text-align: right;">@{{ setzero.debt_amount | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ setzero.debt_vat | number: 2 }}</td>
                                            <td style="text-align: right;">@{{ setzero.debt_total | number: 2 }}</td>
                                            <td style="text-align: center;">
                                                <span class="label label-warning" ng-show="setzero.debt_status==4">
                                                    @{{ (setzero.debt_status==4) ? 'ลดหนี้ศูนย์' : '' }}
                                                </span>

                                                <span class="label label-success" ng-show="setzero.debt_status!=4">
                                                    @{{ 
                                                        (setzero.debt_status==0) ? 'รอดำเนินการ' :
                                                        (setzero.debt_status==1) ? 'ขออนุมัติ' : 
                                                        (setzero.debt_status==2) ? 'ชำระเงินแล้ว' : 
                                                        (setzero.debt_status==3) ? 'ยกเลิก' : 'ลดหนี้ศูนย์'
                                                    }}
                                                </span>
                                            </td>      
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li ng-if="setzeroPager.current_page !== 1">
                                        <a href="#" ng-click="getSetzeroWithURL(setzeroPager.first_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                
                                    <li ng-class="{'disabled': (setzeroPager.current_page==1)}">
                                        <a href="#" ng-click="getPaidWithURL(setzeroPager.prev_page_url)" aria-label="Prev">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>

                                    <li ng-repeat="i in setzeroPages" ng-class="{'active': setzeroPager.current_page==i}">
                                        <a href="#" ng-click="getDataWithURL(setzeroPager.path + '?page=' +i)">
                                            @{{ i }}
                                        </a>
                                    </li>
                                   
                                    <!-- <li ng-if="setzeroPager.current_page < setzeroPager.last_page && (setzeroPager.last_page - setzeroPager.current_page) > 10">
                                        <a href="@{{ setzeroPager.url(setzeroPager.current_page + 10) }}">
                                            ...
                                        </a>
                                    </li> -->
                                
                                    <li ng-class="{'disabled': (setzeroPager.current_page==setzeroPager.last_page)}">
                                        <a href="#" ng-click="getPaidWithURL(setzeroPager.next_page_url)" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>

                                    <li ng-if="setzeroPager.current_page !== setzeroPager.last_page">
                                        <a href="#" ng-click="getPaidWithURL(setzeroPager.last_page_url)" aria-label="Previous">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
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
            }, function(e) {
                console.log(e);
            });
        });
    </script>

@endsection