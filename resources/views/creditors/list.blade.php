@extends('layouts.main')

@section('content')

<div class="container-fluid">
      
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายการเจ้าหนี้</li>
    </ol>

    <div class="row">
        <div class="col-md-12">

            <div class="table-responsive">               
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
            </div>

            <ul class="pagination">

                @if($creditors->currentPage() !== 1)
                    <li>
                        <a href="{{ $creditors->url($creditors->url(1)) }}" aria-label="Previous">
                            <span aria-hidden="true">First</span>
                        </a>
                    </li>
                @endif
            
                @for($i=1; $i<=$creditors->lastPage(); $i++)
                    <li class="{{ ($creditors->currentPage() === $i) ? 'active' : '' }}">
                        <a href="{{ $creditors->url($i) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                @if($creditors->currentPage() !== $creditors->lastPage())
                    <li>
                        <a href="{{ $creditors->url($creditors->lastPage()) }}" aria-label="Previous">
                            <span aria-hidden="true">Last</span>
                        </a>
                    </li>
                @endif

            </ul>

        </div>
    </div>
</div>

@endsection