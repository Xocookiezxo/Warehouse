import 'package:flutter/material.dart';
import 'package:product/api.dart';
import 'package:product/models/branch_have_product.dart';
import 'package:product/models/state.dart';
import 'package:provider/provider.dart';
import 'package:product/common/context_extention.dart';

class ProductPage extends StatelessWidget with Api {
  const ProductPage({super.key});

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();
    return Scaffold(
      appBar: AppBar(
        title: Text('Орлого зарлагын түүх',
            style: Theme.of(context).textTheme.displayLarge),
      ),
      body: FutureBuilder(
        future: fetch<List<BranchHaveProduct>>(
          '/admin/branch_have_products?branch_id=${state.currentBranch!.id}',
          decoder: (data) => data == null
              ? []
              : (data as List)
                  .map((v) => BranchHaveProduct.fromJson(v))
                  .toList(),
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
          var result = sn.data as List<BranchHaveProduct>;
          return ListView.builder(
            itemCount: result.length,
            itemBuilder: (context, index) {
              return ListTile(
                onTap: () {
                  Navigator.of(context).pushNamed('routeName');
                },
                title: Text(result[index].product?.name ?? ''),
                subtitle: Wrap(
                  spacing: 8,
                  children: [
                    Text("Баркод: ${result[index].product?.barcode ?? ''}",
                        style: const TextStyle(fontSize: 8)),
                    Text(
                        "Үнэ:${result[index].product?.price?.toString() ?? ''}",
                        style: const TextStyle(fontSize: 8)),
                    Text(result[index].createdAt?.toShortString() ?? '',
                        style: const TextStyle(fontSize: 8))
                  ],
                ),
                trailing: Row(
                    crossAxisAlignment: CrossAxisAlignment.end,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text("${result[index].regType ?? ""} ",
                          style: const TextStyle(fontSize: 8)),
                      Text(result[index].pcount?.toString() ?? ''),
                    ]),
              );
            },
          );
        },
      ),
    );
  }
}
