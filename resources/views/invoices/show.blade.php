@extends('layouts.invoice')
@section('content')
    <div class="container">
<header>
    <img src="{{ asset("img/logo.png") }}" class="logo">
    <section>
        <p>{{ env('COMPANY_SOCIAL_REASON', 'Dashboard LTDA') }}</p>
        <p>{{ env('COMPANY_CNPJ', '##.###.###/####-##') }}</p>
        <p>{{ env('COMPANY_PHONE', '(XX) XXXX-XXXX') }}</p>
    </section>
</header>

<h1>{{ __('Detailed Invoice') }}</h1>
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
            <td>{!! nl2br($item->description) !!}</td>
            <td>@money($item->amount)</td>
        </tr>
    @endforeach
    </tbody>
</table>
Sub Total: @money($subTotal = $itens->reduce(function ($carry, $item){ return $item->amount +  $carry; } ))
<br>
Credit: @money($invoice->credit)
<br>
Total: @money($subTotal - $invoice->credit)

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
            <td>@totalduration($product->total_duration)</td>
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
        <td>@money($detail->valor_faturado)</td>
    </tr>
    @endforeach
    </tbody>
</table>
<hr>
@endforeach
    </div>
@endsection
@push('js')
    <script>
        var urlParams = new URLSearchParams(window.location.search);
        var isPrint = urlParams.get('print');

        if(isPrint) {
            window.addEventListener("afterprint", function(event) { self.close(); });
            window.print();
        }
    </script>
    <style>
        :root {
            --app-background-color: {{ env('APP_BACKGROUND_COLOR', '#f15a22') }};
            --app-background-color-light: {{ env('APP_BACKGROUND_COLOR_LIGHT', '#f17959') }};
        }
        header {
            height: 200px;
            display: flex;
            justify-content: space-between;
        }
        table {
            border: 3px solid var(--app-background-color);
            margin: 30px auto;

        }

        table thead tr th ,
        table tbody tr td {
            padding: 12px 8px;
            vertical-align: middle;
        }
        table thead tr th {
            background-color: var(--app-background-color);
            color: #fff;
            height: 60px;
        }

        tr:nth-child(2n) {
            background-color: #fce4d6;
        }

        td {
            border: 3px solid var(--app-background-color);
        }

        h1{
            margin-top: 20px;
            font-weight: 700;
            font-size: 14pt;
            background-color: var(--app-background-color);
            text-align: center;
            color: #fff;
            padding: 8px;
        }
        header img.logo{
            height: 180px;
        }
        section{
            margin-bottom: auto;
            margin-top: auto;
            line-height: 1.5;
            font-weight: 900;
            font-size: 17px;
        }
    </style>
@endpush
