import 'package:flutter/material.dart';
import 'package:product/api.dart';
import 'package:product/models/product.dart';
import 'package:product/models/state.dart';
import 'package:provider/provider.dart';

class ProductUldegdel {
  int? id;
  String? branchName;
  String? productName;
  String? barcode;
  String? price;
  String? cnt;

  ProductUldegdel(
      {this.id,
      this.branchName,
      this.productName,
      this.barcode,
      this.price,
      this.cnt});

  ProductUldegdel.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    branchName = json['branch_name'];
    productName = json['product_name'];
    barcode = json['barcode'];
    price = json['price'];
    cnt = json['cnt'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['id'] = this.id;
    data['branch_name'] = this.branchName;
    data['product_name'] = this.productName;
    data['barcode'] = this.barcode;
    data['price'] = this.price;
    data['cnt'] = this.cnt;
    return data;
  }
}

class UldegdelPage extends StatelessWidget with Api {
  const UldegdelPage({super.key});

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();
    return Scaffold(
      appBar: AppBar(
        title: Text('Дансны үлдэгдэл',
            style: Theme.of(context).textTheme.displayLarge),
      ),
      body: FutureBuilder(
        future: fetch<List<ProductUldegdel>>(
          '/admin/uldegdel/${state.currentBranch!.id}',
          decoder: (data) => data == null
              ? []
              : (data as List).map((v) => ProductUldegdel.fromJson(v)).toList(),
        ),
        builder: (context, sn) {
          if (sn.connectionState == ConnectionState.waiting) {
            return const Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  CircularProgressIndicator(
                      semanticsLabel: "Мэдээлэл шинэчилж байна"),
                  Text("Мэдээлэл шинэчилж байна"),
                ],
              ),
            );
          }
          if (sn.hasError) {
            return Column(
              children: [
                const Text("Ямар нэг зүйл буруул байна даа"),
                Text(sn.error.toString())
              ],
            );
          }

          if (sn.data == null || sn.data!.isEmpty) {
            return const Column(
              children: [
                Text(
                    "Бараа бүртгэлгүй байгаа тул ямар нэгэн бараа бүртгэхэл болждээ"),
              ],
            );
          }
          var result = sn.data as List<ProductUldegdel>;
          return ListView.builder(
            itemCount: result.length,
            itemBuilder: (context, index) {
              return ListTile(
                onTap: () {
                  Navigator.of(context).pushNamed('routeName');
                },
                title: Text(result[index].productName ?? ''),
                subtitle: Wrap(
                  spacing: 8,
                  children: [
                    Text("Баркод: ${result[index].barcode ?? ''}"),
                    Text("Үнэ:${result[index].price?.toString() ?? ''}"),
                  ],
                ),
                trailing: Column(
                  children: [
                    Text(result[index].cnt?.toString() ?? ''),
                  ],
                ),
              );
            },
          );
        },
      ),
    );
  }
}
