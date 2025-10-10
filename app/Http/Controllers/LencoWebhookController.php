<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LencoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $sharedSecret = (string) config('services.lenco.webhook_secret');

        // Basic shared-secret validation header e.g., 'X-Lenco-Signature' or fallback to token in query/body
        $signature = (string) $request->header('X-Lenco-Signature', $request->query('signature', ''));

        if ($sharedSecret !== '' && hash_equals($sharedSecret, $signature) === false) {
            return response()->json(['message' => 'Invalid signature'], Response::HTTP_UNAUTHORIZED);
        }

        $payload = $request->all();

        // Log for visibility in development
        Log::info('Lenco webhook received', [
            'event' => $payload['event'] ?? null,
            'data' => $payload['data'] ?? null,
        ]);

        // You can upsert collection status in DB here if you store it.
        // For demo, just acknowledge.
        return response()->json(['received' => true]);
    }
}


