import 'package:dio/dio.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  static late Dio _dio;
  
  static void init() {
    _dio = Dio(BaseOptions(
      baseUrl: dotenv.env['API_BASE_URL'] ?? 'http://localhost:8000/api',
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    ));
    
    // Add interceptors
    _dio.interceptors.add(AuthInterceptor());
    _dio.interceptors.add(LogInterceptor(requestBody: true, responseBody: true));
  }
  
  static Dio get dio => _dio;
}

class AuthInterceptor extends Interceptor {
  @override
  void onRequest(RequestOptions options, RequestInterceptorHandler handler) async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');
    
    if (token != null) {
      options.headers['Authorization'] = 'Bearer $token';
    }
    
    handler.next(options);
  }
  
  @override
  void onError(DioException err, ErrorInterceptorHandler handler) async {
    if (err.response?.statusCode == 401) {
      // Token expired or invalid
      final prefs = await SharedPreferences.getInstance();
      await prefs.remove('auth_token');
      await prefs.remove('user_data');
    }
    handler.next(err);
  }
}



