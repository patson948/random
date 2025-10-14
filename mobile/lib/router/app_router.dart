import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';
import 'package:shopapp_mobile/providers/auth_provider.dart';
import 'package:shopapp_mobile/screens/auth/login_screen.dart';
import 'package:shopapp_mobile/screens/auth/register_screen.dart';
import 'package:shopapp_mobile/screens/main/main_screen.dart';
import 'package:shopapp_mobile/screens/product/product_detail_screen.dart';
import 'package:shopapp_mobile/screens/order/orders_screen.dart';

class AppRouter {
  static final GoRouter router = GoRouter(
    initialLocation: '/',
    redirect: (context, state) {
      final authProvider = Provider.of<AuthProvider>(context, listen: false);
      
      // If user is not authenticated and trying to access protected routes
      if (!authProvider.isAuthenticated && 
          !state.matchedLocation.startsWith('/auth')) {
        return '/auth/login';
      }
      
      // If user is authenticated and on auth screens, redirect to home
      if (authProvider.isAuthenticated && 
          state.matchedLocation.startsWith('/auth')) {
        return '/';
      }
      
      return null;
    },
    routes: [
      // Auth routes
      GoRoute(
        path: '/auth/login',
        builder: (context, state) => const LoginScreen(),
      ),
      GoRoute(
        path: '/auth/register',
        builder: (context, state) => const RegisterScreen(),
      ),
      
      // Main app routes
      GoRoute(
        path: '/',
        builder: (context, state) => const MainScreen(),
        routes: [
          GoRoute(
            path: 'product/:slug',
            builder: (context, state) {
              final slug = state.pathParameters['slug']!;
              return ProductDetailScreen(slug: slug);
            },
          ),
          GoRoute(
            path: 'orders',
            builder: (context, state) => const OrdersScreen(),
          ),
        ],
      ),
    ],
  );
}
