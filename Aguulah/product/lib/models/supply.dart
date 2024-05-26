import 'package:product/models/product.dart';

class Supply {
  int? id;
  String? name;
  String? status;
  String? description;
  DateTime? createdAt;
  DateTime? updatedAt;
  List<SupplyProducts>? supplyProducts;

  Supply(
      {this.id,
      this.name,
      this.status,
      this.description,
      this.createdAt,
      this.updatedAt,
      this.supplyProducts});

  Supply.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
    status = json['status'];
    description = json['description'];
    createdAt = (json["created_at"] is DateTime?)
        ? json["created_at"]
        : DateTime.tryParse(json["created_at"]);
    updatedAt = (json["updated_at"] is DateTime?)
        ? json["updated_at"]
        : DateTime.tryParse(json["updated_at"]);
    if (json['supply_products'] != null) {
      supplyProducts = <SupplyProducts>[];
      json['supply_products'].forEach((v) {
        supplyProducts!.add(SupplyProducts.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = Map<String, dynamic>();
    data['id'] = id;
    data['name'] = name;
    data['status'] = status;
    data['description'] = description;
    data['created_at'] = createdAt?.toIso8601String();
    data['updated_at'] = createdAt?.toIso8601String();
    if (supplyProducts != null) {
      data['supply_products'] = supplyProducts!.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class SupplyProducts {
  int? id;
  int? supplyId;
  int? productId;
  int? expectedCount;
  int? pcount;
  String? description;
  DateTime? createdAt;
  DateTime? updatedAt;
  ProductModel? product;

  SupplyProducts(
      {this.id,
      this.supplyId,
      this.productId,
      this.expectedCount,
      this.pcount,
      this.description,
      this.createdAt,
      this.updatedAt,
      this.product});

  SupplyProducts.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    supplyId = json['supply_id'];
    productId = json['product_id'];
    expectedCount = json['expected_count'];
    pcount = json['pcount'];
    description = json['description'];
    createdAt = (json["created_at"] is DateTime?)
        ? json["created_at"]
        : DateTime.tryParse(json["created_at"]);
    updatedAt = (json["updated_at"] is DateTime?)
        ? json["updated_at"]
        : DateTime.tryParse(json["updated_at"]);
    product =
        json['product'] != null ? ProductModel.fromJson(json['product']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = Map<String, dynamic>();
    data['id'] = id;
    data['supply_id'] = supplyId;
    data['product_id'] = productId;
    data['expected_count'] = expectedCount;
    data['pcount'] = pcount;
    data['description'] = description;
    data['created_at'] = createdAt?.toIso8601String();
    data['updated_at'] = createdAt?.toIso8601String();
    if (product != null) {
      data['product'] = product!.toJson();
    }
    return data;
  }
}
