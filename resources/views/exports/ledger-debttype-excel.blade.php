<h3>บัญชีแยกประเภทหนี้</h3>

<table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
        <tr>
            <th style="width: 3%; text-align: center;">#</th>
            <th style="width: 10%; text-align: center;">รหัสรายการ</th>
            <th style="text-align: left;">ประเภทหนี้</th>
            <th style="width: 10%; text-align: center;">เครดิต</th>
            <th style="width: 10%; text-align: center;">เดบิต</th>
            <th style="width: 10%; text-align: center;">ยอดคงเหลือ</th>
        </tr>
    </thead>
    <tbody>

        <?php 
            $index = 0;
            $totalDebit = 0;
            $totalCredit = 0;
        ?>

        @foreach($debts as $debt)

            <?php
                $totalDebit += $debt->debit;
                $totalCredit += $debt->credit;
            ?>

            <tr>
                <td style="text-align: center;">{{ ++$index }}</td>
                <td style="text-align: center;">{{ $debt->debt_type_id }}</td>
                <td style="text-align: left;">{{ $debt->debt_type_name }}</td>
                <td style="text-align: right;">{{ number_format($debt->debit,2) }}</td>
                <td style="text-align: right;">{{ number_format($debt->credit,2) }}</td>
                <td style="text-align: right;">
                    {{ ($debt->credit) ? number_format(($debt->debit - $debt->credit),2) : number_format($debt->debit,2) }}
                </td>
            </tr>
            
        @endforeach

    </tbody>
</table>