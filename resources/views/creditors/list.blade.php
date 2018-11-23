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
    <section class="content" ng-controller="creditorCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">รายการเจ้าหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">  

                        <a href="{{ url('/creditor/add') }}" class="btn btn-primary"> เพิ่มเจ้าหนี้</a>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">#</th>
                                    <th style="width: 25%; text-align: center;">ชื่อ</th>
                                    <th style="text-align: center;">ที่อยู่</th>
                                    <th style="width: 10%; text-align: center;">ผู้ติดต่อ</th>
                                    <th style="width: 15%; text-align: center;">เลขประจำตัวผู้เสียภาษี</th>
                                    <th style="width: 10%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($creditors as $creditor)

                                    <tr>
                                        <td style="text-align: center;">{{ $creditor->supplier_id }}</td>
                                        <td>{{ $creditor->supplier_name }}</td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: center;">{{ $creditor->supplier_taxid }}</td>
                                        <td style="text-align: center;">
                                            <a href=""><i class="fa fa-edit"></i></a>
                                            <a href=""><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">

                        @if($creditors->currentPage() !== 1)
                            <li>
                                <a href="{{ $creditors->url($creditors->url(1)) }}" aria-label="Previous">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>
                        @endif
                        
                        <li class="{{ ($creditors->currentPage() === 1) ? 'disabled' : '' }}">
                            <a href="{{ $creditors->url($creditors->currentPage() - 1) }}" aria-label="Prev">
                                <span aria-hidden="true">Prev</span>
                            </a>
                        </li>

                        @for($i=$creditors->currentPage(); $i < $creditors->currentPage() + 10; $i++)
                            @if ($creditors->currentPage() <= $creditors->lastPage() && ($creditors->lastPage() - $creditors->currentPage()) > 10)
                                <li class="{{ ($creditors->currentPage() === $i) ? 'active' : '' }}">
                                    <a href="{{ $creditors->url($i) }}">
                                        {{ $i }}
                                    </a>
                                </li> 
                            @else
                                @if ($i <= $creditors->lastPage())
                                    <li class="{{ ($creditors->currentPage() === $i) ? 'active' : '' }}">
                                        <a href="{{ $creditors->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endfor

                        @if ($creditors->currentPage() < $creditors->lastPage() && ($creditors->lastPage() - $creditors->currentPage()) > 10)
                            <li>
                                <a href="{{ $creditors->url($creditors->currentPage() + 10) }}">
                                    ...
                                </a>
                            </li>
                        @endif
                        
                        <li class="{{ ($creditors->currentPage() === $creditors->lastPage()) ? 'disabled' : '' }}">
                            <a href="{{ $creditors->url($creditors->currentPage() + 1) }}" aria-label="Next">
                                <span aria-hidden="true">Next</span>
                            </a>
                        </li>

                        @if($creditors->currentPage() !== $creditors->lastPage())
                            <li>
                                <a href="{{ $creditors->url($creditors->lastPage()) }}" aria-label="Previous">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        @endif

                        </ul>
                    </div><!-- /.box-footer -->

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

@endsection