<table>
    <thead>
        <tr>
            <th>Nomor Faktur</th>
            <th>Cust Id</th>
            <th>Cust Name</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Send Stat</th>
            <th>Date Put</th>
            <th>Date Send</th>
            <th>Sales</th>
            <th>Pay Term</th>
            <th>Office</th>
        </tr>
    </thead>
    <tbody>
@if(isset($report))
    @foreach($report as $h)
        <tr>
            <td>{{ str_replace( ',', '', number_format($h->tr_id)) }}</td>
            <td>{{ $h->CustomerId }}</td>
            <td>{{ $h->NamaCustomer }}</td>
            <td>{{ $h->phone }}</td>
            <td>{{ $h->pesan }}</td>
            <td>{{ $h->response }}</td>
            <td>{{ $h->dt_put }}</td>
            <td>{{ $h->dt_send }}</td>
            <td>{{ $h->NamaSales }}</td>
            <td>{{ $h->pay_term }}</td>
            <td>{{ $h->office }}</td>
        </tr>
    @endforeach
@endif
    </tbody>
</table>