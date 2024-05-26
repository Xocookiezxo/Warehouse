import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:get_storage/get_storage.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/models/product.dart';
import 'package:product/models/state.dart';
import 'package:product/models/supply.dart';
import 'package:provider/provider.dart';

class MenuPage extends StatefulWidget {
  const MenuPage({super.key});

  @override
  State<MenuPage> createState() => _MenuPageState();
}

class _MenuPageState extends State<MenuPage> with Api {
  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();

    return Scaffold(
      appBar: AppBar(
        title: const Text('Ерөнхий цэс'),
        actions: [
          IconButton(
              onPressed: () async {
                await GetStorage().write('TOKEN', null);
                GetStorage().save();
                context.pushReplacement('/');
              },
              icon: const Text('гарах'))
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: FutureBuilder(
          future: fetch<List<Supply>>(
            '/admin/supplies',
            decoder: (data) => data == null
                ? []
                : (data as List).map((v) => Supply.fromJson(v)).toList(),
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
                      "Нийлүүлэлт бүртгэлгүй байна шинэ нийлүүлэлт үүсгэнэ үү"),
                ],
              );
            }
            var ss = sn.data as List<Supply>;
            return ListView.builder(
              itemCount: ss.length,
              itemBuilder: (context, index) => ListTile(
                onTap: () async {
                  await context.push('/supply', extra: ss[index]);
                  setState(() {});
                },
                title: Text(ss[index].name ?? ''),
              ),
            );
          },
        ),
      ),
    );
  }
}
