<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0cm; }
        body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 0; color: #1e293b; line-height: 1.5; }
        .header { background: #4f46e5; color: white; padding: 40px; }
        .header-table { width: 100%; border: none; }
        .brand { font-size: 28px; font-weight: bold; margin: 0; }
        .report-title { font-size: 12px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.8; }
        .summary-container { padding: 30px 40px; background: #f8fafc; }
        .summary-grid { width: 100%; margin-bottom: 20px; }
        .card { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .label { font-size: 10px; text-transform: uppercase; color: #64748b; font-weight: bold; margin-bottom: 5px; }
        .value { font-size: 18px; font-weight: bold; }
        .content { padding: 0 40px 40px 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; font-size: 10px; text-transform: uppercase; color: #64748b; padding: 12px; border-bottom: 2px solid #e2e8f0; }
        td { padding: 15px 12px; font-size: 11px; border-bottom: 1px solid #f1f5f9; }
        .income { color: #10b981; font-weight: bold; }
        .expense { color: #ef4444; font-weight: bold; }
        .net-positive { color: #4f46e5; }
        .footer { position: fixed; bottom: 0; width: 100%; padding: 20px 40px; font-size: 9px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <h1 class="brand">AturUangmu</h1>
                    <span class="report-title">{{ __('messages.pdf_title') }}</span>
                </td>
                <td style="text-align: right;">
                    <div style="font-size: 12px;">{{ __('messages.generated_on') }}: {{ now()->format('d M Y') }}</div>
                    <div style="font-size: 10px; opacity: 0.7;">{{ __('messages.period') }}: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="summary-container">
        <table class="summary-grid">
            <tr>
                <td style="padding-right: 15px;">
                    <div class="card">
                        <div class="label">{{ __('messages.total_income') }}</div>
                        <div class="value income">{{ $symbol ?? ($currency === 'USD' ? '$' : 'Rp') }} {{ number_format($totalIncome, $currency === 'USD' ? 2 : 0) }}</div>
                    </div>
                </td>
                <td style="padding-left: 15px; padding-right: 15px;">
                    <div class="card">
                        <div class="label">{{ __('messages.total_expense') }}</div>
                        <div class="value expense">{{ $symbol ?? ($currency === 'USD' ? '$' : 'Rp') }} {{ number_format($totalExpense, $currency === 'USD' ? 2 : 0) }}</div>
                    </div>
                </td>
                <td style="padding-left: 15px;">
                    <div class="card" style="background: #eef2ff; border-color: #c7d2fe;">
                        <div class="label" style="color: #4f46e5;">{{ __('messages.net_balance') }}</div>
                        <div class="value net-positive">{{ $symbol ?? ($currency === 'USD' ? '$' : 'Rp') }} {{ number_format($totalIncome - $totalExpense, $currency === 'USD' ? 2 : 0) }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th width="15%">{{ __('messages.date') }}</th>
                    <th width="50%">{{ __('messages.description') }}</th>
                    <th width="15%">{{ __('messages.category') }}</th>
                    <th width="20%" style="text-align: right;">{{ __('messages.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                    <td><div style="font-weight: bold; font-size: 12px;">{{ $trx->description }}</div></td>
                    <td><span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 9px;">{{ $trx->category->name ?? 'Uncategorized' }}</span></td>
                    <td style="text-align: right;" class="{{ $trx->type == 'income' ? 'income' : 'expense' }}">
                        {{ $trx->type == 'income' ? '+' : '-' }} {{ $symbol ?? ($currency === 'USD' ? '$' : 'Rp') }} {{ number_format($trx->amount, $currency === 'USD' ? 2 : 0) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        {{ __('messages.footer_note') }}
    </div>
</body>
</html>