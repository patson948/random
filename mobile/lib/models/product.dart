class Product {
  final int id;
  final String name;
  final String slug;
  final String description;
  final String? shortDescription;
  final double price;
  final double? comparePrice;
  final int quantity;
  final String? sku;
  final bool isActive;
  final bool isFeatured;
  final Category? category;
  final Vendor? vendor;
  final List<Review> reviews;

  Product({
    required this.id,
    required this.name,
    required this.slug,
    required this.description,
    this.shortDescription,
    required this.price,
    this.comparePrice,
    required this.quantity,
    this.sku,
    required this.isActive,
    required this.isFeatured,
    this.category,
    this.vendor,
    this.reviews = const [],
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      description: json['description'] ?? '',
      shortDescription: json['short_description'],
      price: (json['price'] ?? 0).toDouble(),
      comparePrice: json['compare_price']?.toDouble(),
      quantity: json['quantity'] ?? 0,
      sku: json['sku'],
      isActive: json['is_active'] ?? true,
      isFeatured: json['is_featured'] ?? false,
      category: json['category'] != null ? Category.fromJson(json['category']) : null,
      vendor: json['vendor'] != null ? Vendor.fromJson(json['vendor']) : null,
      reviews: (json['reviews'] as List?)
          ?.map((reviewJson) => Review.fromJson(reviewJson))
          .toList() ?? [],
    );
  }

  double get discountPercentage {
    if (comparePrice != null && comparePrice! > price) {
      return ((comparePrice! - price) / comparePrice! * 100).roundToDouble();
    }
    return 0;
  }

  bool get isOnSale => discountPercentage > 0;
}

class Category {
  final int id;
  final String name;
  final String slug;
  final String? description;

  Category({
    required this.id,
    required this.name,
    required this.slug,
    this.description,
  });

  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      description: json['description'],
    );
  }
}

class Vendor {
  final int id;
  final String businessName;

  Vendor({
    required this.id,
    required this.businessName,
  });

  factory Vendor.fromJson(Map<String, dynamic> json) {
    return Vendor(
      id: json['id'] ?? 0,
      businessName: json['business_name'] ?? '',
    );
  }
}

class Review {
  final int id;
  final int rating;
  final String? comment;
  final User? user;

  Review({
    required this.id,
    required this.rating,
    this.comment,
    this.user,
  });

  factory Review.fromJson(Map<String, dynamic> json) {
    return Review(
      id: json['id'] ?? 0,
      rating: json['rating'] ?? 0,
      comment: json['comment'],
      user: json['user'] != null ? User.fromJson(json['user']) : null,
    );
  }
}

