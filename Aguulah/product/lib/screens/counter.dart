import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/common/future_alert_dialog.dart';
import 'package:product/models/branch_have_product.dart';
import 'package:product/models/product.dart';
import 'package:product/models/state.dart';
import 'package:product/models/supply.dart';
import 'package:provider/provider.dart';
import 'package:simple_barcode_scanner/simple_barcode_scanner.dart';

class CounterPage extends StatefulWidget {
  final Supply sup;
  const CounterPage({super.key, required this.sup});

  @override
  State<CounterPage> createState() => _CounterPageState();
}

class _CounterPageState extends State<CounterPage> with Api {
  SupplyProducts? supplyProducts;
  var barController = TextEditingController();
  late Iterable<ProductModel> products;

  @override
  void initState() {
    products = widget.sup.supplyProducts!.map((e) => e.product!);
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();

    return Scaffold(
      appBar: AppBar(
        title: const Text("Тоололго"),
      ),
      body: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text(
              widget.sup.name ?? '',
              style: const TextStyle(fontSize: 14),
            ),
            SizedBox(height: 8),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                const Text("Aвах ", style: TextStyle(fontSize: 16)),
                Text(
                  "${supplyProducts?.expectedCount?.toString() ?? '0'} / ${supplyProducts?.pcount ?? 0}",
                  style: const TextStyle(fontSize: 20, color: Colors.green),
                ),
                const Text(" Aвсан", style: TextStyle(fontSize: 16)),
              ],
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text("Бар код: ",
                      style:
                          TextStyle(fontSize: 12, fontWeight: FontWeight.w800)),
                  Text(supplyProducts?.product?.barcode ?? "",
                      style: const TextStyle(fontSize: 12)),
                ],
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text("Нэр: ",
                      style:
                          TextStyle(fontSize: 12, fontWeight: FontWeight.w800)),
                  Text(supplyProducts?.product?.name ?? "",
                      style: const TextStyle(fontSize: 12)),
                ],
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text("Үнэ: ",
                      style:
                          TextStyle(fontSize: 12, fontWeight: FontWeight.w800)),
                  Text(supplyProducts?.product?.price?.toString() ?? "",
                      style: const TextStyle(fontSize: 12)),
                ],
              ),
            ),
            ElevatedButton(
              onPressed: () async {
                var res = await Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => const SimpleBarcodeScannerPage(),
                    ));
                setState(() {
                  if (res is String) {
                    barController.text = res;
                    if (res != '-1') {
                      var p =
                          products.where((element) => element.barcode == res);
                      if (p.isEmpty) {
                        supplyProducts = null;
                        var snackBar = const SnackBar(
                            content: Text("Бүртгэлгүй бар код байна"));
                        ScaffoldMessenger.of(context).showSnackBar(snackBar);
                      } else {
                        supplyProducts = supplyProducts =
                            widget.sup.supplyProducts?.firstWhere(
                                (element) => element.productId == p.first.id);
                      }
                    }
                  }
                });
              },
              child: const Text('Open Scanner'),
            ),
            Text('Barcode : ${barController.text}'),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: TextFormField(
                controller: barController,
                decoration: const InputDecoration(
                    hintText: 'Barcode', labelText: "Barcode"),
                autovalidateMode: AutovalidateMode.always,
                keyboardType: TextInputType.number,
                validator: (value) {
                  var p = products.where((element) => element.barcode == value);
                  if (p.isEmpty) {
                    return 'Нийлүүлэлтэд бүртгэлгүй баркоп';
                  }
                  return null;
                },
                onChanged: (value) {
                  setState(() {
                    barController.text = value;
                    var p =
                        products.where((element) => element.barcode == value);
                    if (p.isNotEmpty) {
                      supplyProducts = widget.sup.supplyProducts?.firstWhere(
                          (element) => element.productId == p.first.id);
                    } else {
                      supplyProducts = null;
                    }
                  });
                },
              ),
            ),
            if (supplyProducts != null)
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: TextFormField(
                  initialValue: (supplyProducts?.pcount ?? 0).toString(),
                  autovalidateMode: AutovalidateMode.always,
                  keyboardType: TextInputType.number,
                  validator: (value) {
                    if (int.tryParse(value ?? '') == null) {
                      return 'тоо оруулна уу';
                    }
                    return null;
                  },
                  decoration: const InputDecoration(
                    hintText: 'Тоо',
                    labelText: "Тоо ширхэг",
                  ),
                  onChanged: (value) {
                    setState(() {
                      supplyProducts?.pcount = int.tryParse(value) ?? 0;
                    });
                  },
                ),
              ),
            ElevatedButton(
              onPressed: () async {
                if (supplyProducts == null) {
                  var snackBar = const SnackBar(
                      content: Text("Бүртээгдэхүүн согноогүй байна"));
                  ScaffoldMessenger.of(context).showSnackBar(snackBar);
                  return;
                }
                if ((supplyProducts?.pcount ?? 0) < 1) {
                  var snackBar = const SnackBar(
                      content: Text("Бүтээндэхүүн ны тоо 0 ээс их байна"));
                  ScaffoldMessenger.of(context).showSnackBar(snackBar);
                  return;
                }
                var res = await futureAlertDialog(
                  context: context,
                  autoCloseSec: 0,
                  futureStream: fetch(
                    '/admin/supply_products/${supplyProducts!.id}',
                    method: 'Put',
                    decoder: (data) => SupplyProducts.fromJson(data),
                    body: supplyProducts!.toJson(),
                  ),
                );
                if (res != null) {
                  setState(() {
                    supplyProducts = null;
                  });
                  context.pop();
                }
              },
              child: const Text('Тоолого бүртгэх'),
            ),
          ],
        ),
      ),
    );
  }
}
