import 'package:shopapp_mobile/models/product.dart';

class CartItem {
  final int id;
  final int productId;
  final int quantity;
  final Product product;

  CartItem({
    required this.id,
    required this.productId,
    required this.quantity,
    required this.product,
  });

  factory CartItem.fromJson(Map<String, dynamic> json) {
    return CartItem(
      id: json['id'] ?? 0,
      productId: json['product_id'] ?? 0,
      quantity: json['quantity'] ?? 0,
      product: Product.fromJson(json['product'] ?? {}),
    );
  }

  double get subtotal => product.price * quantity;
}

