<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lenco Mobile Money Payment</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
        .card { max-width: 520px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; }
        .row { margin-bottom: 12px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; }
        button { background: #111827; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px; cursor: pointer; }
        .error { color: #b91c1c; font-size: 14px; margin-bottom: 10px; }
        .info { color: #065f46; font-size: 14px; margin-bottom: 10px; }
        .actions { display: flex; gap: 8px; align-items: center; }
        a { color: #ef4444; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="margin-top:0;margin-bottom:12px;">Initiate Mobile Money Collection</h2>

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

        <form method="POST" action="{{ route('lenco.initiate') }}">
            @csrf
            <div class="row">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" min="1" name="amount" id="amount" value="{{ old('amount', '100') }}" required>
            </div>

            <div class="row">
                <label for="currency">Currency</label>
                <select name="currency" id="currency" required>
                    <option value="ZMW" {{ old('currency', 'ZMW') === 'ZMW' ? 'selected' : '' }}>ZMW (Zambia)</option>
                    <option value="NGN" {{ old('currency') === 'NGN' ? 'selected' : '' }}>NGN (Nigeria)</option>
                    <option value="GHS" {{ old('currency') === 'GHS' ? 'selected' : '' }}>GHS (Ghana)</option>
                    <option value="KES" {{ old('currency') === 'KES' ? 'selected' : '' }}>KES (Kenya)</option>
                    <option value="UGX" {{ old('currency') === 'UGX' ? 'selected' : '' }}>UGX (Uganda)</option>
                    <option value="RWF" {{ old('currency') === 'RWF' ? 'selected' : '' }}>RWF (Rwanda)</option>
                </select>
            </div>

            <div class="row">
                <label for="country">Country</label>
                <select name="country" id="country" required>
                    <option value="ZM" {{ old('country', 'ZM') === 'ZM' ? 'selected' : '' }}>Zambia (ZM)</option>
                    <option value="NG" {{ old('country') === 'NG' ? 'selected' : '' }}>Nigeria (NG)</option>
                    <option value="GH" {{ old('country') === 'GH' ? 'selected' : '' }}>Ghana (GH)</option>
                    <option value="KE" {{ old('country') === 'KE' ? 'selected' : '' }}>Kenya (KE)</option>
                    <option value="UG" {{ old('country') === 'UG' ? 'selected' : '' }}>Uganda (UG)</option>
                    <option value="RW" {{ old('country') === 'RW' ? 'selected' : '' }}>Rwanda (RW)</option>
                </select>
            </div>

            <div class="row">
                <label for="phone">Customer Phone</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="260971234567 or 0971234567" required>
                <small style="color:#6b7280;font-size:11px;display:block;margin-top:4px;">
                    Zambia: 260XXXXXXXXX | Nigeria: 234XXXXXXXXXX | Ghana: 233XXXXXXXXX
                </small>
            </div>

            <div class="row">
                <label for="operator">Mobile Money Operator (required)</label>
                <select name="operator" id="operator" required>
                    <option value="">Select operator</option>
                    <option value="airtel" {{ old('operator', 'airtel') === 'airtel' ? 'selected' : '' }}>Airtel</option>
                    <option value="mtn" {{ old('operator') === 'mtn' ? 'selected' : '' }}>MTN</option>
                    <option value="tnm" {{ old('operator') === 'tnm' ? 'selected' : '' }}>TNM</option>
                </select>
                <small style="color:#6b7280;font-size:11px;display:block;margin-top:4px;">
                    Zambia: airtel, mtn, tnm | Malawi: airtel, tnm
                </small>
            </div>

            <div class="row">
                <label for="bearer">Fee Bearer</label>
                <select name="bearer" id="bearer">
                    <option value="customer" {{ old('bearer') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="merchant" {{ old('bearer') === 'merchant' ? 'selected' : '' }}>Merchant</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit">Request Payment</button>
                <a href="{{ url('/') }}">Home</a>
            </div>

            <p style="font-size:12px;color:#6b7280;margin-top:12px;">Sandbox OTP is 000000.</p>
        </form>
    </div>
</body>
</html>


