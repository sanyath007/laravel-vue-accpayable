<h3>ยอดหนี้รายประเภทหนี้</h3>
<table>
    <thead>
        <tr>
            <th style="width: 3%; text-align: center;">#</th>
            <th style="width: 5%; text-align: center;">รหัสรายการ</th>
            <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
            <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
            <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
            <th style="text-align: left;">เจ้าหนี้</th>
            <th style="width: 8%; text-align: center;">ยอดหนี้</th>
            <th style="width: 8%; text-align: center;">ภาษี</th>
            <th style="width: 8%; text-align: center;">สุทธิ</th>
            <th style="width: 8%; text-align: center;">สถานะ</th>
        </tr>
    </thead>
    <tbody>

        <?php $cx = 0; ?>
        @foreach($debts as $debt)

            <tr>
                <td style="text-align: center;">{{ ++$cx }}</td>
                <td style="text-align: center;">{{ $debt->debt_id }}</td>
                <td style="text-align: left;">{{ convThDateFromDb($debt->debt_date) }}</td>
                <td style="text-align: center;">{{ $debt->deliver_no }}</td>
                <td style="text-align: left;">{{ $debt->debt_type_name }}</td>
                <td style="text-align: left;">{{ $debt->supplier_name }}</td>
                <td style="text-align: center;">{{ number_format($debt->debt_amount, 2) }}</td>
                <td style="text-align: center;">{{ number_format($debt->debt_vat, 2) }}</td>
                <td style="text-align: center;">{{ number_format($debt->debt_total, 2) }}</td>   
                <td style="text-align: center;">
                    <?php if($debt->debt_status==1) {
                        echo 'ขออนุมัติ';
                    } else if($debt->debt_status==2) {
                        echo 'ชำระเงินแล้ว';
                    } else if($debt->debt_status==3) {
                        echo 'ยกเลิก';
                    } else {
                        echo 'รอดำเนินการ';
                    }   
                    ?>
                </td>       
            </tr>

        @endforeach

    </tbody>
</table>