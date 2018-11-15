@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Simple Tables
            <small>preview of simple tables</small>
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการรับหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">

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
                                    <th style="width: 5%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($debts as $debt)

                                    <tr>
                                        <td style="text-align: center;">{{ $debt->debt_id }}</td>
                                        <td style="text-align: left;">{{ $debt->debt_date }}</td>
                                        <td style="text-align: center;">{{ $debt->deliver_no }}</td>
                                        <td style="text-align: center;">{{ $debt->deliver_date }}</td>
                                        <td style="text-align: left;">{{ $debt->supplier_name }}</td>
                                        <td style="text-align: left;">{{ $debt->debttype->debt_type_name }}</td>
                                        <td style="text-align: center;">{{ number_format($debt->debt_amount,2) }}</td>
                                        <td style="text-align: center;">{{ number_format($debt->debt_vat,2) }}</td>
                                        <td style="text-align: center;">{{ number_format($debt->debt_total,2) }}</td>
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

                            @if($debts->currentPage() !== 1)
                                <li>
                                    <a href="{{ $debts->url($debts->url(1)) }}" aria-label="Previous">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            @endif
                        
                            @for($i=$debts->currentPage(); $i < $debts->currentPage() + 10; $i++)
                                @if ($debts->currentPage() <= $debts->lastPage() && ($debts->lastPage() - $debts->currentPage()) > 10)
                                    <li class="{{ ($debts->currentPage() === $i) ? 'active' : '' }}">
                                        <a href="{{ $debts->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li> 
                                @else
                                    @if ($i <= $debts->lastPage())
                                        <li class="{{ ($debts->currentPage() === $i) ? 'active' : '' }}">
                                            <a href="{{ $debts->url($i) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endfor

                            @if($debts->currentPage() !== $debts->lastPage())
                                <li>
                                    <a href="{{ $debts->url($debts->lastPage()) }}" aria-label="Previous">
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