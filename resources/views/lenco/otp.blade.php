<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lenco OTP</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
        .card { max-width: 520px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; }
        .row { margin-bottom: 12px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; }
        button { background: #111827; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px; cursor: pointer; }
        .error { color: #b91c1c; font-size: 14px; margin-bottom: 10px; }
        .info { color: #065f46; font-size: 14px; margin-bottom: 10px; }
        .actions { display: flex; gap: 8px; align-items: center; }
        a { color: #ef4444; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="margin-top:0;margin-bottom:12px;">Submit OTP</h2>

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

        <form method="POST" action="{{ route('lenco.otp.submit') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="reference" value="{{ $reference }}">

            <div class="row">
                <label for="otp">OTP</label>
                <input type="text" name="otp" id="otp" value="{{ old('otp') }}" placeholder="Enter OTP" required>
            </div>

            <div class="actions">
                <button type="submit">Submit</button>
                <a href="{{ route('lenco.status', ['reference' => $reference]) }}">Check Status</a>
                <a href="{{ route('lenco.form') }}">Start Over</a>
            </div>

            <p style="font-size:12px;color:#6b7280;margin-top:12px;">Sandbox OTP is 000000.</p>
        </form>
    </div>
</body>
</html>


