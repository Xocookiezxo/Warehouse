import 'package:flutter/material.dart';
import 'package:get_storage/get_storage.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
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
          future: fetch<List<ProductModel>>(
            '/admin/products',
            decoder: (data) => data == null
                ? []
                : (data as List).map((v) => ProductModel.fromJson(v)).toList(),
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
            state.addProductAll(sn.data as List<ProductModel>);
            return Column(
              children: [
                Text(state.currentBranch?.name ?? ''),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () => context.go('/uldegdel'),
                      child: const Text('Барааны үлдэгдэл')),
                ),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () => context.go('/counter'),
                      child: const Text('Орлого хийх')),
                ),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () => context.go('/zarlaga'),
                      child: const Text('Зарлага хийх')),
                ),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () => context.go('/products'),
                      child: const Text('Орлого&Зарлага түүх')),
                ),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                      onPressed: () async {
                        await GetStorage().write('TOKEN', null);
                        GetStorage().save();
                        context.pushReplacement('/');
                      },
                      child: const Text('Системээс гарах')),
                )
              ],
            );
          },
        ),
      ),
    );
  }
}
