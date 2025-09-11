<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasar Santri Marketplace Shipping Label</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0 5mm;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            page-break-after: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        .logo {
            text-align: left;
            margin-bottom: 10px;
        }

        .barcode {
            text-align: right;
        }

        .non-tunai {
            text-align: right;
            font-weight: bold;
        }

        .courier-info {
            display: flex;
            align-items: center;
        }

        .courier-logo {
            margin-right: 10px;
        }

        .courier-details {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    @foreach ($pages as $index => $page)
        <div class="container">
            <table>
                <tr>
                    <td class="logo">
                        <img src="https://beta-marketplace.bitlion.io/assets/imgs/theme/logo.png" width="180"
                            alt="Pasar Santri Marketplace Logo" />
                    </td>
                    <td style="text-align: right; padding-top: 30px;"><b style="font-size: 20px; color: #0e4e1d;">{{ $page['invoice'] }}</b></td>
                </tr>
            </table>

            <table>
                <tr>
                    <td></td>
                    <td class="barcode" rowspan="3">
                        <img src="{{ $page['barcodeImage'] }}" alt="barcode" style="height:55px;" /><br>
                        <div style="font-size:13px; font-weight:bold;">{{ $page['airwaybill'] }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="courier-info">
                            <img src="{{ $page['courierLogo'] }}" width="80" alt="courier-logo"
                                class="courier-logo" />
                            <div class="courier-details">
                                <span>{{ $page['courierCompany'] }}</span>
                                <span>{{ $page['courierServiceName'] }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Berat:</b> {{ $page['totalWeight'] }} Kg<br>
                        <b>Ongkir:</b> {{ $page['shippingFee'] }}
                    </td>
                </tr>
            </table>

            <table border="1">
                <tr>
                    <td colspan="2" align="center">
                        <i>Penjual tidak perlu bayar apapun ke kurir, sudah dibayarkan otomatis</i>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <strong>Kepada:</strong><br>
                        {{ $page['buyerName'] }}<br>
                        {{ $page['buyerAddress'] }}<br>
                        {{ $page['buyerPhone'] }}
                        @if (!empty($page['buyerAddressDetail']))
                            <br>Address Detail: {{ $page['buyerAddressDetail'] }}
                        @endif
                        @if (!empty($page['orderNotes']))
                            <br>Order Notes: {{ $page['orderNotes'] }}
                        @endif
                    </td>
                    <td width="50%">
                        <strong>Dari:</strong><br>
                        {{ $page['shopName'] }}<br>
                        {{ $page['shopPhone'] }}
                    </td>
                </tr>
            </table>

            <table border="1">
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                </tr>
                @foreach ($page['items'] as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['qty'] }} pcs</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</body>

</html>
