@extends('layouts.invoice')
@section('content')
<header>
    <img src="{{ asset("img/logo.png") }}" class="logo">
    <section>
        <p>{{ env('COMPANY_SOCIAL_REASON', 'Dashboard LTDA') }}</p>
        <p>{{ env('COMPANY_CNPJ', '##.###.###/####-##') }}</p>
        <p>{{ env('COMPANY_PHONE', '(XX) XXXX-XXXX') }}</p>
    </section>
</header>
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
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->document }}</td>
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

@foreach($products as $product)
<table border="1" width="100%">
    <thead>
    <tr>
        <th>{{ __('Product') }}</th>
        <th>{{ __('Total duration') }}</th>
        <th>{{ __('Total excedent') }}</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $product->product }}</td>
            <td>{{ $product->total_duration }}</td>
            <td>{{ $product->total_excedent }}</td>
        </tr>
    </tbody>
</table>
<table border="1" width="100%">
    <thead>
    <tr>
        <th>{{ __('Date/Time') }}</th>
        <th>{{ __('Origin') }}</th>
        <th>{{ __('Destination') }}</th>
        <th>{{ __('Tax') }}</th>
        <th>{{ __('Efective duration') }}</th>
        <th>{{ __('Duration') }}</th>
        <th>{{ __('Amount charged') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($product->details as $detail)
    <tr>
        <td>{{ $detail->datahora }}</td>
        <td>{{ $detail->origem }}</td>
        <td>{{ $detail->destino }}</td>
        <td>{{ $detail->tarifa }}</td>
        <td>{{ $detail->duracao }}</td>
        <td>{{ $detail->duracao_faturado }}</td>
        <td>{{ $detail->valor_faturado }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<hr>
@endforeach
@endsection
@push('js')
    <style>
        header {
            height: 200px;
            display: flex;
            justify-content: space-between;
        }
        header img.logo{
            height: 180px;
        }
        section{
            height: 180px;
            margin-bottom: auto;
            margin-top: auto;
        }
    </style>
@endpush
