<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    @include('components.shop-navigation')

    <!-- Checkout Progress -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-center space-x-8">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Cart</span>
                </div>
                <div class="w-16 h-0.5 bg-green-500"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-white">2</span>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Checkout</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-gray-500">3</span>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Payment</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="checkoutData()">
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Address Section -->
            <div class="space-y-6">
                <form id="checkout-form">
                    @csrf
                    
                    <!-- Saved Addresses (if any) -->
                    @if($savedAddresses->count() > 0)
                    <div class="bg-white rounded-2xl p-8">
                        <h2 class="text-2xl font-bold mb-6">Select Address</h2>
                        <div class="space-y-4">
                            @foreach($savedAddresses as $address)
                            <label class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-gray-300 transition" 
                                   @click="selectAddress({{ $address->id }})">
                                <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1" 
                                       @if($address->is_default) checked @endif>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-semibold">{{ $address->name }}</span>
                                        @if($address->is_default)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Default</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $address->address }}</p>
                                    <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                    <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                                </div>
                            </label>
                            @endforeach
                            
                            <label class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-gray-300 transition" 
                                   @click="selectNewAddress()">
                                <input type="radio" name="address_id" value="new" class="mt-1">
                                <div class="flex-1">
                                    <span class="font-semibold">Add New Address</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    @endif

                    <!-- New Address Form -->
                    <div class="bg-white rounded-2xl p-8" @if($savedAddresses->count() > 0) x-show="showNewAddress" @endif>
                        <h2 class="text-2xl font-bold mb-6">Shipping Address</h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" name="shipping_phone" value="{{ old('shipping_phone') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea name="shipping_address" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>{{ old('shipping_address') }}</textarea>
                        </div>

                        <div class="grid md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <input type="text" name="shipping_country" value="{{ old('shipping_country', 'Zambia') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                            <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        </div>

                        @if(auth()->check())
                        <div class="mt-6">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="save_address" value="1" id="save_address" class="rounded">
                                <label for="save_address" class="text-sm text-gray-700">Save this address for future orders</label>
                            </div>
                            
                            <div x-show="document.getElementById('save_address').checked" class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address Label</label>
                                <input type="text" name="address_label" value="{{ old('address_label', 'Home') }}" 
                                       placeholder="Home, Office, etc." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-8">
                        <a href="{{ route('cart.index') }}" class="flex-1 border-2 border-gray-300 text-gray-700 py-4 rounded-full font-medium hover:bg-gray-50 transition text-center">
                            ← Back to Cart
                        </a>
                        
                        <!-- Continue button for saved addresses -->
                        <button type="button" 
                                @click="continueWithSavedAddress()" 
                                x-show="selectedAddressId && selectedAddressId !== 'new'"
                                class="flex-1 bg-black text-white py-4 rounded-full font-medium hover:bg-green-700 transition">
                            Continue →
                        </button>
                        
                        <!-- Save & Continue button for new addresses -->
                        <button type="button" 
                                @click="saveAddress()" 
                                x-show="!selectedAddressId || selectedAddressId === 'new'"
                                class="flex-1 bg-black text-white py-4 rounded-full font-medium hover:bg-gray-800 transition">
                            Save Address & Continue →
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:sticky lg:top-8">
                <div class="bg-white rounded-2xl p-8">
                    <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product->main_image ?? 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=200&q=80' }}" 
                                     alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-sm truncate">{{ $item->product->name }}</h4>
                                <p class="text-xs text-gray-600">{{ $item->product->vendor->store_name ?? 'Vendor' }}</p>
                                <p class="text-sm font-semibold mt-1">ZMW {{ number_format($item->product->price, 0) }}</p>
                            </div>
                            <span class="text-sm text-gray-600">×{{ $item->quantity }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-b py-4 space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-black">ZMW {{ number_format($subtotal, 0) }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between mb-8">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="font-bold text-2xl">ZMW {{ number_format($total, 0) }}</span>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                        Review your order details above
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkoutData() {
            return {
                showNewAddress: false,
                selectedAddressId: null,
                
                init() {
                    // Check if there's a default address selected
                    const defaultAddress = document.querySelector('input[name="address_id"]:checked');
                    if (defaultAddress) {
                        this.selectedAddressId = defaultAddress.value;
                        if (defaultAddress.value === 'new') {
                            this.showNewAddress = true;
                        }
                    }
                },
                
                selectAddress(addressId) {
                    this.showNewAddress = false;
                    this.selectedAddressId = addressId;
                    // Check the radio button for the selected address
                    const radioButton = document.querySelector(`input[name="address_id"][value="${addressId}"]`);
                    if (radioButton) {
                        radioButton.checked = true;
                    }
                    // Uncheck the save address checkbox when using saved address
                    const saveAddressCheckbox = document.getElementById('save_address');
                    if (saveAddressCheckbox) {
                        saveAddressCheckbox.checked = false;
                    }
                },
                
                selectNewAddress() {
                    this.showNewAddress = true;
                    this.selectedAddressId = 'new';
                    // Check the "new" radio button
                    const newRadioButton = document.querySelector('input[name="address_id"][value="new"]');
                    if (newRadioButton) {
                        newRadioButton.checked = true;
                    }
                },
                
                continueWithSavedAddress() {
                    // Direct redirect to payment page with saved address data
                    const selectedAddress = document.querySelector('input[name="address_id"]:checked');
                    if (!selectedAddress) {
                        alert('Please select an address.');
                        return;
                    }
                    
                    // Create form data with only the address_id
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    formData.append('address_id', selectedAddress.value);
                    
                    console.log('Sending saved address request:', selectedAddress.value);
                    
                    // Store the selected address ID in session and redirect
                    fetch('{{ route("checkout.save-address") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            window.location.href = '{{ route("payment.index") }}';
                        } else {
                            alert(data.message || 'Error processing address. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error processing address. Please try again.');
                    });
                },
                
                saveAddress() {
                    // Check if a saved address is selected
                    const selectedAddress = document.querySelector('input[name="address_id"]:checked');
                    const isNewAddress = selectedAddress && selectedAddress.value === 'new';
                    const hasAddressOptions = document.querySelector('input[name="address_id"]');
                    
                    console.log('Selected address:', selectedAddress);
                    console.log('Is new address:', isNewAddress);
                    console.log('Has address options:', hasAddressOptions);
                    
                    // If there are saved addresses but none selected, show error
                    if (hasAddressOptions && !selectedAddress) {
                        alert('Please select an address or add a new one.');
                        return;
                    }
                    
                    // Only validate new address fields if new address is selected or no saved addresses exist
                    if (isNewAddress || !hasAddressOptions) {
                        const requiredFields = ['shipping_name', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_state'];
                        for (let field of requiredFields) {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (!input.value.trim()) {
                                alert(`Please fill in ${field.replace('shipping_', '').replace('_', ' ')}.`);
                                input.focus();
                                return;
                            }
                        }
                    }
                    
                    // Get form data
                    const form = document.querySelector('form');
                    const formData = new FormData(form);
                    
                    // Handle save_address checkbox based on address type
                    const saveAddressCheckbox = document.getElementById('save_address');
                    if (isNewAddress) {
                        // For new addresses, include the checkbox value
                        if (saveAddressCheckbox && !saveAddressCheckbox.checked) {
                            formData.set('save_address', '0');
                        }
                    } else {
                        // For saved addresses, don't include save_address field at all
                        formData.delete('save_address');
                    }
                    
                    console.log('Sending request to:', '{{ route("checkout.save-address") }}');
                    console.log('Form data:', Object.fromEntries(formData));
                    
                    fetch('{{ route("checkout.save-address") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            window.location.href = '{{ route("payment.index") }}';
                        } else {
                            alert(data.message || 'Error saving address. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error saving address. Please try again.');
                    });
                }
            }
        }
    </script>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>