@extends('layouts.vendor')

@section('title', 'Edit Profile')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600 mt-1">Update your vendor account information</p>
        </div>
        
        <!-- Status Badge -->
        <div>
            @if($vendor->is_approved)
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Approved
                </span>
            @else
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Pending Approval
                </span>
            @endif
        </div>
    </div>

    <!-- Profile Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form method="POST" action="{{ route('vendor.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Shop Information -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Shop Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Shop Name -->
                        <div class="md:col-span-2">
                            <label for="shop_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                Shop Name *
                            </label>
                            <input 
                                type="text" 
                                id="shop_name" 
                                name="shop_name" 
                                value="{{ old('shop_name', $vendor->shop_name) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                                placeholder="Enter your shop name"
                            >
                            @error('shop_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                                Phone Number *
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $vendor->phone) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                                placeholder="Enter your phone number"
                            >
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-900 mb-2">
                                Address *
                            </label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                value="{{ old('address', $vendor->address) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                                placeholder="Enter your business address"
                            >
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                                Shop Description
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition resize-none"
                                placeholder="Describe your shop and what you sell..."
                            >{{ old('description', $vendor->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Account Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Account Name
                            </label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                                {{ auth()->user()->name }}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">This is your user account name</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Email Address
                            </label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                                {{ auth()->user()->email }}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">This is your login email</p>
                        </div>

                        <!-- Shop Slug -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Shop URL
                            </label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                                {{ url('/vendor/' . $vendor->slug) }}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Your shop's unique URL</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-400 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-700 mb-1">Profile Update Information</h3>
                        <p class="text-sm text-blue-700">
                            Changes to your shop name, description, phone, or address will be reviewed by our team. 
                            Your account information (name and email) cannot be changed from this page.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="flex-1 bg-black text-white px-6 py-4 rounded-full hover:bg-gray-800 transition font-semibold text-lg"
                >
                    Update Profile
                </button>
                
                <a 
                    href="{{ route('vendor.dashboard') }}"
                    class="flex-1 bg-gray-100 text-gray-900 px-6 py-4 rounded-full hover:bg-gray-200 transition font-semibold text-lg text-center"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Additional Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Shop Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Shop Statistics</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Products</span>
                    <span class="font-semibold text-gray-900">{{ $vendor->products()->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Orders</span>
                    <span class="font-semibold text-gray-900">{{ $vendor->orderItems()->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Account Created</span>
                    <span class="font-semibold text-gray-900">{{ $vendor->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a 
                    href="{{ route('vendor.products.index') }}"
                    class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="font-medium text-gray-900">Manage Products</span>
                </a>
                
                <a 
                    href="{{ route('vendor.orders.index') }}"
                    class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium text-gray-900">View Orders</span>
                </a>
                
                <a 
                    href="{{ route('vendor.dashboard') }}"
                    class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    </svg>
                    <span class="font-medium text-gray-900">Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
