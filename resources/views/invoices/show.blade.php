<table border="1" width="100%">
    <caption>{{ __('Detailed Invoice of Client services') }}</caption>
    <thead>
    <tr>
        <th>{{ __('Customer:') }}</th>
        <th>{{ __('CPF/CNPJ:') }}</th>
        <th>{{ __('Invoice:') }}</th>
        <th>{{ __('Data:') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>XXXX</td>
        <td>XXXX</td>
        <td>{{ $invoice->id }}</td>
        <td>{{ $invoice->date }}</td>
    </tr>
    </tbody>
</table>

<table border="1" width="100%">
    <caption>{{ __('Invoice Details') }}</caption>
    <thead>
    <tr>
        <th>{{ __('Description:') }}</th>
        <th>{{ __('Amount:') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($itens as $item)
        <tr>
            <td>{{ $item->description }}</td>
            <td>{{ $item->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
Sub Total: {{ $subTotal = $itens->reduce(function ($carry, $item){ return $item->amount +  $carry; } ) }}
<br>
Credit: {{ $invoice->credit }}
<br>
Total: {{ $subTotal - $invoice->credit }}


<table border="1" width="100%">
    <caption>{{ __('Details of invoice calls') }}</caption>
    <thead>
    <tr>
        <th>{{ __('Product') }}</th>
        <th>{{ __('Total duration') }}</th>
        <th>{{ __('Total excedent') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($itens as $item)
        <tr>
            <td>{{ $item->description }}</td>
            <td>{{ $item->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
