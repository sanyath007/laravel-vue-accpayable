@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการเจ้าหนี้
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการเจ้าหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="creditorCtrl" ng-init="getData()">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">ค้นหาข้อมูล</h3>
                    </div>

                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">
                            <div class="col-md-12">                                
                                <div class="form-group">
                                    <label>ค้นหาชื่อเจ้าหนี้</label>
                                    <input type="text" id="searchKey" ng-keyup="getData($event)" class="form-control">
                                </div><!-- /.form group -->
                            </div>

                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <a href="{{ url('/creditor/add') }}" class="btn btn-primary"> เพิ่มเจ้าหนี้</a>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">รายการเจ้าหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">#</th>
                                    <th style="width: 5%; text-align: center;">รหัส</th>
                                    <th style="width: 25%; text-align: center;">ชื่อ</th>
                                    <th style="text-align: center;">ที่อยู่</th>
                                    <th style="width: 10%; text-align: center;">ผู้ติดต่อ</th>
                                    <th style="width: 15%; text-align: center;">เลขประจำตัวผู้เสียภาษี</th>
                                    <th style="width: 8%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(index, creditor) in creditors">
                                    <td style="text-align: center;">@{{ index+pager.from }}</td>
                                    <td style="text-align: center;">@{{ creditor.supplier_id }}</td>
                                    <td>@{{ creditor.supplier_name }}</td>
                                    <td>
                                        @{{ ((creditor.supplier_address1) ? creditor.supplier_address1 : '')+ ' ' 
                                            +((creditor.supplier_address2) ? creditor.supplier_address2 : '')+ ' ' 
                                            +((creditor.supplier_address3) ? creditor.supplier_address3 : '') }}
                                    </td>
                                    <td style="text-align: center;">@{{ (creditor.supplier_agent_name) ? creditor.supplier_agent_name : '' }}</td>
                                    <td style="text-align: center;">@{{ (creditor.supplier_taxid) ? creditor.supplier_taxid : '' }}</td>
                                    <td style="text-align: center;">
                                        <a ng-click="edit(creditor.supplier_id)" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

                                        @if(Auth::user()->person_id == '1300200009261')

                                            <a ng-click="delete(creditor.supplier_id)" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        @endif
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">

                            <li ng-if="pager.current_page !== 1">
                                <a ng-click="getDataWithURL(pager.first_page_url)" aria-label="Previous">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>
                        
                            <li ng-class="{'disabled': (pager.current_page==1)}">
                                <a ng-click="getDataWithURL(pager.first_page_url)" aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>
                           
                            <li ng-if="pager.current_page < pager.last_page && (pager.last_page - pager.current_page) > 10">
                                <a href="@{{ pager.url(pager.current_page + 10) }}">
                                    ...
                                </a>
                            </li>
                        
                            <li ng-class="{'disabled': (pager.current_page==pager.last_page)}">
                                <a ng-click="getDataWithURL(pager.next_page_url)" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            <li ng-if="pager.current_page !== pager.last_page">
                                <a ng-click="getDataWithURL(pager.last_page_url)" aria-label="Previous">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-footer -->

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

@endsection