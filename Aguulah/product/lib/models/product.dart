import 'dart:ffi';

class ProductModel {
  int? id;
  String? name;
  int? providerId;
  String? barcode;
  double? price;
  int? productCategoryId;
  String? description;
  String? createdAt;
  String? updatedAt;
  NameModel? productCategory;
  NameModel? provider;

  ProductModel(
      {this.id,
      this.name,
      this.providerId,
      this.barcode,
      this.price,
      this.productCategoryId,
      this.description,
      this.createdAt,
      this.updatedAt,
      this.productCategory,
      this.provider});

  ProductModel.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
    providerId = json['provider_id'];
    barcode = json['barcode'];
    price = json['price'] != null ? double.tryParse(json['price']) : 0;
    productCategoryId = json['product_category_id'];
    description = json['description'];
    createdAt = json['created_at'];
    updatedAt = json['updated_at'];
    productCategory = json['product_category'] != null
        ? NameModel.fromJson(json['product_category'])
        : null;
    provider =
        json['provider'] != null ? NameModel.fromJson(json['provider']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['id'] = id;
    data['name'] = name;
    data['provider_id'] = providerId;
    data['barcode'] = barcode;
    data['price'] = price;
    data['product_category_id'] = productCategoryId;
    data['description'] = description;
    data['created_at'] = createdAt;
    data['updated_at'] = updatedAt;
    if (productCategory != null) {
      data['product_category'] = productCategory!.toJson();
    }
    if (provider != null) {
      data['provider'] = provider!.toJson();
    }
    return data;
  }
}

class NameModel {
  int? id;
  String? name;

  NameModel({this.id, this.name});

  NameModel.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['id'] = id;
    data['name'] = name;
    return data;
  }
}
