<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaction Details - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    @include('admin.layouts.header')

    <div class="flex">
        @include('admin.layouts.sidebar')

        <main class="flex-1 p-8 ml-64">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Transactions
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Page Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Transaction Details</h1>
                    <p class="text-gray-600 mt-2">{{ $transaction->transaction_id }}</p>
                </div>
                
                <!-- Status Badge -->
                <div>
                    @if($transaction->status == 'successful')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Successful
                        </span>
                    @elseif($transaction->status == 'pending')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Pending
                        </span>
                    @elseif($transaction->status == 'failed')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Failed
                        </span>
                    @elseif($transaction->status == 'timeout')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Timeout
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Transaction Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Payment Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Payment Information
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Transaction ID</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->transaction_id }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Reference</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->reference }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Amount</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $transaction->currency }} {{ number_format($transaction->amount, 0) }}</p>
                                @if($transaction->fee)
                                    <p class="text-sm text-gray-500">Fee: {{ $transaction->currency }} {{ number_format($transaction->fee, 2) }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                                <p class="text-base font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Fee Bearer</p>
                                <p class="text-base font-semibold text-gray-900">{{ ucfirst($transaction->bearer ?? 'customer') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Source</p>
                                <p class="text-base font-semibold text-gray-900">{{ ucfirst($transaction->source ?? 'api') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Provider</p>
                                <p class="text-base font-semibold text-gray-900">{{ ucfirst($transaction->provider) }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Provider Reference</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->provider_reference ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Operator</p>
                                @if($transaction->operator)
                                    <p class="text-base font-semibold text-gray-900">{{ strtoupper($transaction->operator) }}</p>
                                @else
                                    <p class="text-base text-gray-500">-</p>
                                @endif
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Phone Number</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->phone ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Account Name</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->account_name ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Operator Transaction ID</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->operator_transaction_id ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Country</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->country ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Provider Status</p>
                                <p class="text-base font-semibold text-gray-900">{{ $transaction->provider_status ?? '-' }}</p>
                            </div>
                        </div>

                        @if($transaction->failure_reason)
                            <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-100">
                                <p class="text-sm text-red-600 font-medium mb-1">Failure Reason:</p>
                                <p class="text-sm text-red-700">{{ $transaction->failure_reason }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Customer Information
                        </h2>
                        
                        @if($transaction->user)
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Name</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $transaction->user->name }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Email</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $transaction->user->email }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">User ID</p>
                                    <p class="text-base font-semibold text-gray-900">#{{ $transaction->user->id }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">Guest Customer</p>
                        @endif
                    </div>

                    <!-- Provider Data -->
                    @if($transaction->provider_data)
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Provider Response Data
                            </h2>
                            
                            <div class="bg-gray-50 rounded-lg p-4 overflow-auto">
                                <pre class="text-xs text-gray-700">{{ json_encode($transaction->provider_data, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Timeline -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Timeline</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">Created</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>

                            @if($transaction->initiated_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Initiated</p>
                                        <p class="text-xs text-gray-500">{{ $transaction->initiated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($transaction->processed_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Processed</p>
                                        <p class="text-xs text-gray-500">{{ $transaction->processed_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($transaction->completed_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Completed</p>
                                        <p class="text-xs text-gray-500">{{ $transaction->completed_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Update Status</h2>
                        
                        <form method="POST" action="{{ route('admin.transactions.update-status', $transaction) }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="successful" {{ $transaction->status == 'successful' ? 'selected' : '' }}>Successful</option>
                                    <option value="failed" {{ $transaction->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="timeout" {{ $transaction->status == 'timeout' ? 'selected' : '' }}>Timeout</option>
                                    <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                        
                        <div class="space-y-3">
                            @if($transaction->user)
                                <a href="{{ route('admin.users.show', $transaction->user) }}" 
                                   class="block text-center bg-blue-50 text-blue-700 py-2 rounded-lg hover:bg-blue-100 transition">
                                    View Customer
                                </a>
                            @endif
                            
                            <button onclick="window.print()" 
                                    class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition">
                                Print Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

