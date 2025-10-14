import 'package:flutter/material.dart';
import 'package:shopapp_mobile/models/product.dart';
import 'package:shopapp_mobile/services/api_service.dart';

class ProductProvider with ChangeNotifier {
  List<Product> _products = [];
  List<Product> _featuredProducts = [];
  List<Product> _deals = [];
  List<Product> _newArrivals = [];
  bool _isLoading = false;
  String? _error;

  List<Product> get products => _products;
  List<Product> get featuredProducts => _featuredProducts;
  List<Product> get deals => _deals;
  List<Product> get newArrivals => _newArrivals;
  bool get isLoading => _isLoading;
  String? get error => _error;

  Future<void> fetchHomeData() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await ApiService.dio.get('/home');
      
      if (response.statusCode == 200) {
        final data = response.data;
        _featuredProducts = (data['featured'] as List?)
            ?.map((json) => Product.fromJson(json))
            .toList() ?? [];
        _deals = (data['deals'] as List?)
            ?.map((json) => Product.fromJson(json))
            .toList() ?? [];
        _newArrivals = (data['newArrivals'] as List?)
            ?.map((json) => Product.fromJson(json))
            .toList() ?? [];
      }
    } catch (e) {
      _error = e.toString();
      debugPrint('Error fetching home data: $e');
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> fetchProducts({String? search, int page = 1}) async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final queryParams = <String, dynamic>{
        'page': page,
        'per_page': 20,
      };
      
      if (search != null && search.isNotEmpty) {
        queryParams['search'] = search;
      }

      final response = await ApiService.dio.get('/products', queryParameters: queryParams);
      
      if (response.statusCode == 200) {
        final data = response.data;
        if (page == 1) {
          _products = (data['data'] as List?)
              ?.map((json) => Product.fromJson(json))
              .toList() ?? [];
        } else {
          _products.addAll((data['data'] as List?)
              ?.map((json) => Product.fromJson(json))
              .toList() ?? []);
        }
      }
    } catch (e) {
      _error = e.toString();
      debugPrint('Error fetching products: $e');
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<Product?> fetchProductDetail(String slug) async {
    try {
      final response = await ApiService.dio.get('/products/$slug');
      
      if (response.statusCode == 200) {
        return Product.fromJson(response.data);
      }
    } catch (e) {
      debugPrint('Error fetching product detail: $e');
    }
    
    return null;
  }

  void clearError() {
    _error = null;
    notifyListeners();
  }
}



