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
            <li class="breadcrumb-item active">ประเภทรายการหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title">รายการประเภทรายการหนี้</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                      <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 8%; text-align: center;">#</th>
                                    <th style="text-align: center;">ชื่อ</th>
                                    <th style="width: 25%; text-align: center;">ประเภท</th>
                                    <th style="width: 10%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($debttypes as $debttype)

                                    <tr>
                                        <td style="text-align: center;">{{ $debttype->debt_type_id }}</td>
                                        <td style="text-align: left;">{{ $debttype->debt_type_name }}</td>
                                        <td style="text-align: center;">{{ $debttype->debt_cate_name }}</td>
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

                            @if($debttypes->currentPage() !== 1)
                                <li>
                                    <a href="{{ $debttypes->url($debttypes->url(1)) }}" aria-label="Previous">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            @endif
                        
                            @for($i=1; $i<=$debttypes->lastPage(); $i++)
                                <li class="{{ ($debttypes->currentPage() === $i) ? 'active' : '' }}">
                                    <a href="{{ $debttypes->url($i) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            @if($debttypes->currentPage() !== $debttypes->lastPage())
                                <li>
                                    <a href="{{ $debttypes->url($debttypes->lastPage()) }}" aria-label="Previous">
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