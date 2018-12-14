<h3>ทะเบียนเจ้าหนี้จ่ายชำระหนี้</h3>
<table>
    <thead>
        <tr>
            <th style="width: 5%; text-align: center;">#</th>
            <th style="width: 5%; text-align: center;">รหัสรายการ</th>
            <th style="width: 5%; text-align: center;">วันที่ชำระ</th>
            <th style="width: 5%; text-align: center;">เลขที่เช็ค</th>
            <th style="width: 8%; text-align: center;">เลขที่เอกสาร</th>
            <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
            <th style="width: 15%; text-align: left;">รายการ</th>
            <th style="text-align: left;">บริษัท</th>
            <th style="width: 8%; text-align: center;">ยอดหนี้สุทธิ</th>
             <th style="width: 5%; text-align: center;">ยอดหนี้</th>
            <th style="width: 8%; text-align: center;">VAT1%</th>
            <th style="width: 8%; text-align: center;">ยอดจ่ายเช็ค</th>
            <th style="width: 8%; text-align: center;">ธนาคาร</th>
        </tr>
    </thead>
    <tbody>

        <?php $cx = 0; ?>
        @foreach($payments as $payment)

            <tr>
                <td style="text-align: center;">{{ ++$cx }}</td>
                <td style="text-align: center;">{{ $payment->debt_id }}</td>
                <td style="text-align: center;">{{ convThDateFromDb($payment->paid_date) }}</td>
                <td style="text-align: center;">{{ $payment->cheque_no }}</td>
                <td style="text-align: center;">{{ $payment->deliver_no }}</td>
                <td style="text-align: left;">{{ $payment->debt_type_name }}</td>
                <td style="text-align: left;">{{ $payment->debt_type_detail }}</td>
                <td style="text-align: left;">{{ $payment->pay_to }}</td>
                <td style="text-align: right;">{{ number_format($payment->debt_total, 2) }}</td>
                <td style="text-align: right;">{{ number_format($payment->total, 2) }}</td>
                <td style="text-align: center;">{{ number_format($payment->net_amt, 2) }}</td>
                <td style="text-align: right;">{{ number_format($payment->paid_amt, 2) }}</td>
                <td style="text-align: right;">{{ $payment->bank_name. '(' .$payment->bank_acc_no. ')' }}</td>
            </tr>

        @endforeach

    </tbody>
</table>