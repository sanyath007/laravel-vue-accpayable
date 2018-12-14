<h3>รายงานหนี้ค้างจ่าย</h3>
<table>
    <thead>
        <tr>
            <th style="width: 5%; text-align: center;">#</th>
            <th style="width: 5%; text-align: center;">รหัสรายการ</th>
            <th style="width: 15%; text-align: left;">ประเภทหนี้</th>
            <th style="width: 15%; text-align: left;">รายการ</th>
            <th style="width: 8%; text-align: center;">วันที่ลงบัญชี</th>
            <th style="width: 8%; text-align: center;">วันที่ตรวจรับ</th>
            <th style="text-align: left;">บริษัท</th>
            <th style="width: 8%; text-align: center;">เลขที่เอกสาร</th>
            <th style="width: 8%; text-align: center;">ยอดหนี้สุทธิ</th>
            <th style="width: 8%; text-align: center;">วันที่รับเอกสาร (ชุดเบิก-จ่าย)</th> <!-- //ฟิลด์ app_recdoc_date ตาราง nrhosp_acc_app -->
            <th style="width: 8%; text-align: center;">สถานะ</th>
        </tr>
    </thead>
    <tbody>

        <?php $cx = 0; ?>
        @foreach($debts as $debt)

            <tr>
                <td style="text-align: center;">{{ ++$cx }}</td>
                <td style="text-align: center;">{{ $debt->debt_id }}</td>
                <td style="text-align: left;">{{ $debt->debt_type_name }}</td>
                <td style="text-align: left;">{{ $debt->debt_type_detail }}</td>
                <td style="text-align: center;">{{ convThDateFromDb($debt->debt_date) }}</td>
                <td style="text-align: center;">{{ convThDateFromDb($debt->debt_doc_recdate) }}</td>
                <td style="text-align: left;">{{ $debt->supplier_name }}</td>
                <td style="text-align: center;">{{ $debt->deliver_no }}</td>
                <td style="text-align: right;">{{ number_format($debt->debt_total, 2) }}</td>
                <td style="text-align: center;">{{ $debt->app_recdoc_date }}</td> <!-- //ฟิลด์ app_recdoc_date ตาราง nrhosp_acc_app -->
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