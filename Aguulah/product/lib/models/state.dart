import 'package:flutter/material.dart';
import 'package:product/models/product.dart';

class StateModel extends ChangeNotifier {
  List<ProductModel> products = [];

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
