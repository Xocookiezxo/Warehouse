import 'package:flutter/material.dart';
import 'package:product/models/state.dart';
import 'package:provider/provider.dart';

class ProductPage extends StatelessWidget {
  const ProductPage({super.key});

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();
    return Scaffold(
      appBar: AppBar(
        title: Text('Бүтээгдэхүүн',
            style: Theme.of(context).textTheme.displayLarge),
      ),
      body: ListView.builder(
        itemCount: state.products.length,
        itemBuilder: (context, index) {
          return ListTile(
            onTap: () {
              Navigator.of(context).pushNamed('routeName');
            },
            title: Text(state.products[index].name ?? ''),
            subtitle: Text("Баркод: ${state.products[index].barcode ?? ''}"),
            trailing: Text(state.products[index].price?.toString() ?? ''),
          );
        },
      ),
    );
  }
}
