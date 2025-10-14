import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:shopapp_mobile/models/user.dart';
import 'package:shopapp_mobile/services/api_service.dart';

class AuthProvider with ChangeNotifier {
  User? _user;
  bool _isLoading = false;
  String? _error;

  User? get user => _user;
  bool get isLoading => _isLoading;
  String? get error => _error;
  bool get isAuthenticated => _user != null;

  AuthProvider() {
    _loadUserFromStorage();
  }

  Future<void> _loadUserFromStorage() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('auth_token');
      final userData = prefs.getString('user_data');
      
      if (token != null && userData != null) {
        _user = User.fromJson(userData);
        notifyListeners();
      }
    } catch (e) {
      debugPrint('Error loading user from storage: $e');
    }
  }

  Future<bool> login(String email, String password) async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await ApiService.dio.post('/login', data: {
        'email': email,
        'password': password,
      });

      if (response.statusCode == 200) {
        final data = response.data;
        final token = data['token'];
        final userData = data['user'];
        
        _user = User.fromJson(userData);
        
        // Save to storage
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('auth_token', token);
        await prefs.setString('user_data', userData.toString());
        
        _isLoading = false;
        notifyListeners();
        return true;
      }
    } catch (e) {
      _error = e.toString();
      _isLoading = false;
      notifyListeners();
    }
    
    return false;
  }

  Future<bool> register(String name, String email, String password) async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await ApiService.dio.post('/register', data: {
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': password,
      });

      if (response.statusCode == 201) {
        final data = response.data;
        final token = data['token'];
        final userData = data['user'];
        
        _user = User.fromJson(userData);
        
        // Save to storage
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('auth_token', token);
        await prefs.setString('user_data', userData.toString());
        
        _isLoading = false;
        notifyListeners();
        return true;
      }
    } catch (e) {
      _error = e.toString();
      _isLoading = false;
      notifyListeners();
    }
    
    return false;
  }

  Future<void> logout() async {
    try {
      await ApiService.dio.post('/logout');
    } catch (e) {
      debugPrint('Logout error: $e');
    } finally {
      _user = null;
      final prefs = await SharedPreferences.getInstance();
      await prefs.remove('auth_token');
      await prefs.remove('user_data');
      notifyListeners();
    }
  }

  void clearError() {
    _error = null;
    notifyListeners();
  }
}



