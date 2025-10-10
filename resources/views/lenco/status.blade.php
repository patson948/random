<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lenco Status</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
        .card { max-width: 720px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; }
        .kv { display: grid; grid-template-columns: 220px 1fr; gap: 8px; margin-bottom: 6px; }
        .key { color: #6b7280; }
        .val { font-weight: 600; }
        .actions { display: flex; gap: 8px; align-items: center; margin-top: 12px; }
        a, .button { background: #111827; color: #fff; text-decoration: none; padding: 8px 12px; border-radius: 6px; display: inline-block; }
        .link { color: #ef4444; background: transparent; padding: 0; }
        .error { color: #b91c1c; font-size: 14px; margin-bottom: 10px; }
        .info { color: #065f46; font-size: 14px; margin-bottom: 10px; }
        pre { background: #f8fafc; padding: 12px; border-radius: 6px; overflow: auto; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="margin-top:0;margin-bottom:12px;">Collection Status</h2>

        @if (session('info'))
            <div class="info">{{ session('info') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $mm = $data['mobileMoneyDetails'] ?? null;
        @endphp

        <div class="kv"><div class="key">ID</div><div class="val">{{ $data['id'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Reference</div><div class="val">{{ $data['reference'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Lenco Reference</div><div class="val">{{ $data['lencoReference'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Amount</div><div class="val">{{ $data['amount'] ?? '-' }} {{ $data['currency'] ?? '' }}</div></div>
        <div class="kv"><div class="key">Status</div><div class="val">{{ $data['status'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Settlement Status</div><div class="val">{{ $data['settlementStatus'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Reason For Failure</div><div class="val">{{ $data['reasonForFailure'] ?? '-' }}</div></div>

        <h3 style="margin-top:16px;">Mobile Money</h3>
        <div class="kv"><div class="key">Country</div><div class="val">{{ $mm['country'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Phone</div><div class="val">{{ $mm['phone'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Operator</div><div class="val">{{ $mm['operator'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Account Name</div><div class="val">{{ $mm['accountName'] ?? '-' }}</div></div>
        <div class="kv"><div class="key">Operator Txn ID</div><div class="val">{{ $mm['operatorTransactionId'] ?? '-' }}</div></div>

        <div class="actions">
            <a class="button" href="{{ route('lenco.status', ['reference' => $data['reference'] ?? '']) }}">Requery</a>
            <a class="link" href="{{ route('lenco.form') }}">New Payment</a>
            <a class="link" href="{{ url('/') }}">Home</a>
        </div>

        <h3 style="margin-top:16px;">Raw</h3>
        <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
    </div>
</body>
</html>


