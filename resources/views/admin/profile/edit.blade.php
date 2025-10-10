<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    @include('admin.layouts.sidebar')

    <div class="lg:pl-64">
        @include('admin.layouts.header')

        <main class="p-6">
            <div class="max-w-4xl">
                <h1 class="text-3xl font-bold mb-8">Profile Settings</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Profile Information -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 mb-6">
                    <h2 class="text-lg font-bold mb-6">Profile Information</h2>
                    
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('name') border-red-500 @enderror" required>
                                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('email') border-red-500 @enderror" required>
                                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex justify-end pt-4 border-t">
                                <button type="submit" class="bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100">
                    <h2 class="text-lg font-bold mb-6">Change Password</h2>
                    
                    <form action="{{ route('admin.profile.updatePassword') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Current Password <span class="text-red-500">*</span></label>
                                <input type="password" name="current_password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('current_password') border-red-500 @enderror" required>
                                @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">New Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('password') border-red-500 @enderror" required>
                                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                <p class="text-sm text-gray-500 mt-1">Must be at least 8 characters</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Confirm New Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black" required>
                            </div>

                            <div class="flex justify-end pt-4 border-t">
                                <button type="submit" class="bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

