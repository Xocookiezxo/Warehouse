import 'package:product/models/branch.dart';
import 'package:product/models/product.dart';
import 'package:product/models/user.dart';

class BranchHaveProduct {
  int? id;
  int? branchId;
  int? productId;
  int? pcount;
  String? regType;
  int? userId;
  DateTime? createdAt;
  DateTime? updatedAt;
  BranchModel? branch;
  ProductModel? product;
  UserModel? user;

  BranchHaveProduct(
      {this.id,
      this.branchId,
      this.productId,
      this.pcount,
      this.regType,
      this.userId,
      this.createdAt,
      this.updatedAt,
      this.branch,
      this.product,
      this.user});

  BranchHaveProduct.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    branchId = json['branch_id'];
    productId = json['product_id'];
    pcount = json['pcount'];
    regType = json['reg_type'];
    userId = json['user_id'];
    createdAt = (json["created_at"] is DateTime?)
        ? json["created_at"]
        : DateTime.tryParse(json["created_at"]);
    updatedAt = (json["updated_at"] is DateTime?)
        ? json["updated_at"]
        : DateTime.tryParse(json["updated_at"]);
    branch =
        json['branch'] != null ? BranchModel.fromJson(json['branch']) : null;
    product =
        json['product'] != null ? ProductModel.fromJson(json['product']) : null;
    user = json['user'] != null ? UserModel.fromMap(json['user']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = Map<String, dynamic>();
    data['id'] = id;
    data['branch_id'] = branchId;
    data['product_id'] = productId;
    data['pcount'] = pcount;
    data['reg_type'] = regType;
    data['user_id'] = userId;
    data['created_at'] = createdAt?.toIso8601String();
    data['updated_at'] = createdAt?.toIso8601String();
    if (branch != null) {
      data['branch'] = branch!.toJson();
    }
    if (product != null) {
      data['product'] = product!.toJson();
    }
    if (user != null) {
      data['user'] = user!.toMap();
    }
    return data;
  }
}
