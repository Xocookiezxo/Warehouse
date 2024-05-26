import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/common/future_alert_dialog.dart';
import 'package:product/models/branch_have_product.dart';
import 'package:product/models/state.dart';
import 'package:product/models/supply.dart';
import 'package:provider/provider.dart';
import 'package:product/common/context_extention.dart';

class SupplyPage extends StatelessWidget with Api {
  final Supply sup;

  const SupplyPage({super.key, required this.sup});

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();

    return Scaffold(
      appBar: AppBar(
        title:
            Text(sup.name ?? '', style: Theme.of(context).textTheme.bodyMedium),
      ),
      floatingActionButton: Row(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        children: [
          ElevatedButton(
            onPressed: () async {
              var res = await futureAlertDialog(
                context: context,
                autoCloseSec: 0,
                futureStream: fetch(
                  '/admin/supplies/${sup.id}/done',
                  method: 'Put',
                  decoder: (data) => Supply.fromJson(data),
                  body: sup.toJson(),
                ),
              );
              if (res != null) {
                context.pop();
              }
            },
            child: Text("Данслах"),
          ),
          ElevatedButton(
            onPressed: () => context.go('/supply/counter', extra: sup),
            child: Text("Тоолох"),
          ),
        ],
      ),
      body: ((sup.supplyProducts?.length ?? 0) == 0)
          ? Text(
              "Нийлүүлэлтэнд  бараа бүртээгдэхүүн бүртгэлгүй байна нийлүүлэлтйн бараа бүртгэж өгнө үү")
          : ListView.builder(
              itemCount: sup.supplyProducts?.length ?? 0,
              itemBuilder: (context, index) {
                return ListTile(
                  title: Text(sup.supplyProducts?[index].product?.name ?? ''),
                  subtitle: Wrap(
                    spacing: 8,
                    children: [
                      Text(
                          "Баркод: ${sup.supplyProducts?[index].product?.barcode ?? ''}",
                          style: const TextStyle(fontSize: 8)),
                      Text(
                          "Үнэ:${sup.supplyProducts?[index].product?.price?.toString() ?? ''}",
                          style: const TextStyle(fontSize: 8)),
                      Text(
                          sup.supplyProducts?[index].createdAt
                                  ?.toShortString() ??
                              '',
                          style: const TextStyle(fontSize: 8))
                    ],
                  ),
                  trailing: Row(
                      crossAxisAlignment: CrossAxisAlignment.end,
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Text(
                            '${sup.supplyProducts?[index].expectedCount?.toString() ?? '0'}/${sup.supplyProducts?[index].pcount?.toString() ?? '0'}'),
                      ]),
                );
              },
            ),
    );
  }
}
