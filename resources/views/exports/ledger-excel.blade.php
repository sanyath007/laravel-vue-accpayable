<h3>บัญชีแยกประเภทเจ้าหนี้</h3>

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