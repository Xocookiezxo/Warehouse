import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/models/branch.dart';
import 'package:product/models/product.dart';
import 'package:product/models/state.dart';
import 'package:provider/provider.dart';

class MenuPage extends StatelessWidget with Api {
  const MenuPage({super.key});

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();
    var gg = fetch<List<ProductModel>>(
      '/admin/products',
      decoder: (data) => data == null
          ? []
          : (data as List).map((v) => ProductModel.fromJson(v)).toList(),
    );
    return Scaffold(
      appBar: AppBar(
        title: const Text('Ерөнхий цэс'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: FutureBuilder(
          future: Future.wait([
            fetch<List<ProductModel>>(
              '/admin/products',
              decoder: (data) => data == null
                  ? []
                  : (data as List)
                      .map((v) => ProductModel.fromJson(v))
                      .toList(),
            ),
            fetch(
              '/admin/branches',
              decoder: (data) => data == null
                  ? []
                  : (data as List)
                      .map<BranchModel>((v) => BranchModel.fromJson(v))
                      .toList(),
            )
          ]),
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
            state.addProductAll(sn.data![0] as List<ProductModel>);
            return Column(
              children: [
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () => context.go('/counter'),
                      child: const Text('ТООЛЛОГО ХИЙХ')),
                ),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () => context.go('/products'),
                      child: const Text('Барааны мэдээлэл')),
                ),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () {},
                      child: const Text('Агуулахын үлдэгдэл')),
                )
              ],
            );
          },
        ),
      ),
    );
  }
}
