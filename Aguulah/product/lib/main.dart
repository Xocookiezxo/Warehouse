import 'package:flutter/material.dart';
import 'package:get_storage/get_storage.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/common/theme.dart';
import 'package:product/models/branch.dart';
import 'package:product/models/cart.dart';
import 'package:product/models/state.dart';
import 'package:product/screens/catalog.dart';
import 'package:product/screens/counter.dart';
import 'package:product/screens/login.dart';
import 'package:product/screens/menu.dart';
import 'package:product/screens/product.dart';
import 'package:provider/provider.dart';

Future<void> main() async {
  await GetStorage.init();

  runApp(const MyApp());
}

const double windowWidth = 400;
const double windowHeight = 800;

GoRouter router() {
  var initLocation = '/';

  return GoRouter(
    initialLocation: initLocation,
    routes: [
      GoRoute(
          path: '/',
          builder: (context, state) => GetStorage().read('TOKEN') == null
              ? const MyLogin()
              : const MenuPage(),
          routes: [
            GoRoute(
                path: 'products',
                builder: (context, state) => const ProductPage(),
                routes: []),
            GoRoute(
                path: 'counter',
                builder: (context, state) => const CounterPage(),
                routes: []),
          ]),
    ],
  );
}

class MyApp extends StatefulWidget {
  const MyApp({super.key});

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  late final appRoutes = router();

  @override
  Widget build(BuildContext context) {
    GetStorage().write('TOKEN', null);
    return MultiProvider(
      providers: [
        Provider(create: (context) => BranchModel()),
        ChangeNotifierProvider(create: (context) => StateModel()),
        ChangeNotifierProxyProvider<BranchModel, CartModel>(
          create: (context) => CartModel(),
          update: (context, branch, cart) {
            if (cart == null) throw ArgumentError.notNull('cart');
            cart.branch = branch;
            return cart;
          },
        ),
      ],
      child: MaterialApp.router(
        title: 'Бүтээгдэхүүн',
        theme: appTheme,
        routerConfig: appRoutes,
      ),
    );
  }
}
