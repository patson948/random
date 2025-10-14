import 'package:flutter/material.dart';
import 'package:shopapp_mobile/models/cart_item.dart';
import 'package:shopapp_mobile/services/api_service.dart';

class CartProvider with ChangeNotifier {
  List<CartItem> _items = [];
  bool _isLoading = false;
  String? _error;

  List<CartItem> get items => _items;
  bool get isLoading => _isLoading;
  String? get error => _error;
  int get itemCount => _items.fold(0, (sum, item) => sum + item.quantity);
  double get totalAmount => _items.fold(0.0, (sum, item) => sum + (item.product.price * item.quantity));

  Future<void> fetchCartItems() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await ApiService.dio.get('/cart');
      
      if (response.statusCode == 200) {
        final data = response.data;
        _items = (data['items'] as List?)
            ?.map((json) => CartItem.fromJson(json))
            .toList() ?? [];
      }
    } catch (e) {
      _error = e.toString();
      debugPrint('Error fetching cart items: $e');
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> addToCart(int productId, int quantity) async {
    try {
      final response = await ApiService.dio.post('/cart', data: {
        'product_id': productId,
        'quantity': quantity,
      });

      if (response.statusCode == 201) {
        await fetchCartItems(); // Refresh cart
        return true;
      }
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      debugPrint('Error adding to cart: $e');
    }
    
    return false;
  }

  Future<bool> updateCartItem(int cartId, int quantity) async {
    try {
      final response = await ApiService.dio.put('/cart/$cartId', data: {
        'quantity': quantity,
      });

      if (response.statusCode == 200) {
        await fetchCartItems(); // Refresh cart
        return true;
      }
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      debugPrint('Error updating cart item: $e');
    }
    
    return false;
  }

  Future<bool> removeFromCart(int cartId) async {
    try {
      final response = await ApiService.dio.delete('/cart/$cartId');

      if (response.statusCode == 200) {
        await fetchCartItems(); // Refresh cart
        return true;
      }
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      debugPrint('Error removing from cart: $e');
    }
    
    return false;
  }

  Future<bool> clearCart() async {
    try {
      final response = await ApiService.dio.delete('/cart');

      if (response.statusCode == 200) {
        _items.clear();
        notifyListeners();
        return true;
      }
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      debugPrint('Error clearing cart: $e');
    }
    
    return false;
  }

  void clearError() {
    _error = null;
    notifyListeners();
  }
}

