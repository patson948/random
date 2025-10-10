<!-- Authentication Modals Component -->
<div x-data="{ 
    showAuthModal: false, 
    authMode: 'login',
    showPassword: false,
    showConfirmPassword: false,
    formData: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        remember: false
    },
    openLogin() {
        this.authMode = 'login';
        this.showAuthModal = true;
    },
    openRegister() {
        this.authMode = 'register';
        this.showAuthModal = true;
    },
    switchMode(mode) {
        this.authMode = mode;
        this.formData = {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            remember: false
        };
    },
    closeModal() {
        this.showAuthModal = false;
        setTimeout(() => {
            this.formData = {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                remember: false
            };
        }, 300);
    }
}" 
@keydown.escape.window="closeModal()"
@open-login.window="openLogin()"
@open-register.window="openRegister()"
>

    <!-- Modal Overlay -->
    <div 
        x-show="showAuthModal" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
        @click.self="closeModal()"
    >
        <!-- Modal Content -->
        <div 
            x-show="showAuthModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto"
        >
            <!-- Close Button -->
            <button 
                @click="closeModal()" 
                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition z-10"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="p-8 pb-6">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold mb-2" x-text="authMode === 'login' ? 'Welcome Back' : 'Create Account'"></h2>
                    <p class="text-gray-600" x-text="authMode === 'login' ? 'Sign in to continue shopping' : 'Join us and start shopping today'"></p>
                </div>

                <!-- Mode Tabs -->
                <div class="flex gap-2 p-1 bg-gray-100 rounded-full mb-6">
                    <button 
                        @click="switchMode('login')"
                        class="flex-1 py-2 px-4 rounded-full text-sm font-medium transition"
                        :class="authMode === 'login' ? 'bg-black text-white' : 'text-gray-600 hover:text-black'"
                    >
                        Sign In
                    </button>
                    <button 
                        @click="switchMode('register')"
                        class="flex-1 py-2 px-4 rounded-full text-sm font-medium transition"
                        :class="authMode === 'register' ? 'bg-black text-white' : 'text-gray-600 hover:text-black'"
                    >
                        Sign Up
                    </button>
                </div>

                <!-- Login Form -->
                <form x-show="authMode === 'login'" class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-2">Email Address</label>
                        <input 
                            type="email" 
                            name="email"
                            x-model="formData.email"
                            placeholder="Enter your email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                x-model="formData.password"
                                placeholder="Enter your password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                                required
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" x-model="formData.remember" class="w-4 h-4 rounded border-gray-300">
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-black hover:underline">Forgot Password?</a>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-3 rounded-full font-semibold hover:bg-gray-800 transition">
                        Sign In
                    </button>

                    <!-- Social Login -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-sm font-medium">Google</span>
                        </button>
                        <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="text-sm font-medium">Facebook</span>
                        </button>
                    </div>
                </form>

                <!-- Register Form -->
                <form x-show="authMode === 'register'" class="space-y-4" method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" value="customer">
                    <div>
                        <label class="block text-sm font-medium mb-2">Full Name</label>
                        <input 
                            type="text" 
                            name="name"
                            x-model="formData.name"
                            placeholder="Enter your full name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Email Address</label>
                        <input 
                            type="email" 
                            name="email"
                            x-model="formData.email"
                            placeholder="Enter your email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                x-model="formData.password"
                                placeholder="Create a password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                                required
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Confirm Password</label>
                        <div class="relative">
                            <input 
                                :type="showConfirmPassword ? 'text' : 'password'"
                                name="password_confirmation"
                                x-model="formData.password_confirmation"
                                placeholder="Confirm your password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                                required
                            >
                            <button 
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 mt-0.5 rounded border-gray-300" required>
                        <span class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-black hover:underline">Terms of Service</a> and <a href="#" class="text-black hover:underline">Privacy Policy</a>
                        </span>
                    </label>

                    <button type="submit" class="w-full bg-black text-white py-3 rounded-full font-semibold hover:bg-gray-800 transition">
                        Create Account
                    </button>

                    <!-- Social Login -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">Or sign up with</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-sm font-medium">Google</span>
                        </button>
                        <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="text-sm font-medium">Facebook</span>
                        </button>
                    </div>
                </form>

                <!-- Bottom Text -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    <template x-if="authMode === 'login'">
                        <span>Don't have an account? <button @click="switchMode('register')" class="text-black font-medium hover:underline">Sign up</button></span>
                    </template>
                    <template x-if="authMode === 'register'">
                        <span>Already have an account? <button @click="switchMode('login')" class="text-black font-medium hover:underline">Sign in</button></span>
                    </template>
                </p>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>

