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

