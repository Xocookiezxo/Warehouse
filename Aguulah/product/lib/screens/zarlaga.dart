import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/common/future_alert_dialog.dart';
import 'package:product/models/branch_have_product.dart';
import 'package:product/models/product.dart';
import 'package:product/models/state.dart';
import 'package:provider/provider.dart';
import 'package:simple_barcode_scanner/simple_barcode_scanner.dart';

class ZarlagaPage extends StatefulWidget {
  const ZarlagaPage({super.key});

  @override
  State<ZarlagaPage> createState() => _ZarlagaPageState();
}

class _ZarlagaPageState extends State<ZarlagaPage> with Api {
  ProductModel? product;
  var barController = TextEditingController();
  int count = 1;

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();

    return Scaffold(
      appBar: AppBar(
        title: const Text("Зарлага"),
      ),
      body: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text(
              count.toString(),
              style: const TextStyle(fontSize: 40, color: Colors.green),
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text("Бар код: ",
                      style:
                          TextStyle(fontSize: 12, fontWeight: FontWeight.w800)),
                  Text(product?.barcode ?? "",
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
                  Text(product?.name ?? "",
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
                  Text(product?.price?.toString() ?? "",
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
                      var p = state.products
                          .where((element) => element.barcode == res);
                      if (p.isEmpty) {
                        var snackBar = const SnackBar(
                            content: Text("Бүртгэлгүй бар код байна"));
                        ScaffoldMessenger.of(context).showSnackBar(snackBar);
                      } else {
                        product = p.first;
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
                  var p = state.products
                      .where((element) => element.barcode == value);
                  if (p.isEmpty) {
                    return 'Баркод буруу';
                  }
                  return null;
                },
                onChanged: (value) {
                  setState(() {
                    barController.text = value;
                    var p = state.products
                        .where((element) => element.barcode == value);
                    if (p.isNotEmpty) {
                      product = p.first;
                    }
                  });
                },
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: TextFormField(
                initialValue: count.toString(),
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
                    count = int.tryParse(value) ?? 0;
                  });
                },
              ),
            ),
            ElevatedButton(
              onPressed: () async {
                if (product == null) {
                  var snackBar = const SnackBar(
                      content: Text("Бүртээгдэхүүн согноогүй байна"));
                  ScaffoldMessenger.of(context).showSnackBar(snackBar);
                  return;
                }
                if (0 - count >= 0) {
                  var snackBar = const SnackBar(
                      content: Text("Бүтээндэхүүн ны тоо 0 ээс их байна"));
                  ScaffoldMessenger.of(context).showSnackBar(snackBar);
                  return;
                }
                var res = await futureAlertDialog(
                  context: context,
                  autoCloseSec: 0,
                  futureStream: fetch(
                    '/admin/branch_have_products',
                    method: 'POST',
                    decoder: (data) => BranchHaveProduct.fromJson(data),
                    body: BranchHaveProduct(
                      userId: state.user!.id,
                      branchId: state.currentBranch!.id,
                      pcount: 0 - count,
                      productId: product!.id,
                      regType: "Зарлага",
                    ).toJson(),
                  ),
                );
                if (res != null) {
                  setState(() {
                    barController.text = "";
                    count = 1;
                  });
                  context.pop();
                }
              },
              child: const Text('Зарлага бүртгэх'),
            ),
          ],
        ),
      ),
    );
  }
}
