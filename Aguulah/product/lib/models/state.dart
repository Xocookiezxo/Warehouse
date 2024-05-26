import 'package:flutter/material.dart';
import 'package:get_storage/get_storage.dart';
import 'package:product/main.dart';
import 'package:product/models/branch.dart';
import 'package:product/models/product.dart';
import 'package:product/models/user.dart';

class StateModel extends ChangeNotifier {
  List<ProductModel> products = [];
  List<BranchModel> branches = [];
  UserModel? _user;

  StateModel(Settings setting) {
    _user = setting.user;
  }

  UserModel? get user => _user;
  set user(v) => _user = v;
  BranchModel? _currentBranch;
  BranchModel? get currentBranch => _currentBranch;
  set currentBranch(v) => _currentBranch = v;

  void setCurrentBranch(BranchModel branch) {
    _currentBranch = branch;
    GetStorage().write('current_branch', branch.toJson());
    notifyListeners();
  }

  double get totalPrice =>
      products.fold(0, (total, current) => total + (current.price ?? 0));

  void addProduct(ProductModel product, {notify = false}) {
    products.add(product);

    if (notify) notifyListeners();
  }

  void addProductAll(List<ProductModel> item, {notify = false}) {
    products.addAll(item);
    if (notify) notifyListeners();
  }

  void removeProduct(ProductModel item, {notify = false}) {
    products.remove(item);
    if (notify) notifyListeners();
  }
}
