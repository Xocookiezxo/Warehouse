import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:get_storage/get_storage.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/common/theme.dart';
import 'package:product/models/branch.dart';
import 'package:product/models/cart.dart';
import 'package:product/models/state.dart';
import 'package:product/models/user.dart';
import 'package:product/screens/counter.dart';
import 'package:product/screens/login.dart';
import 'package:product/screens/menu.dart';
import 'package:product/screens/product.dart';
import 'package:product/screens/uldegdel.dart';
import 'package:product/screens/zarlaga.dart';
import 'package:provider/provider.dart';

Future<void> main() async {
  await GetStorage.init();
  final setting = Settings();
  await setting.init();
  runApp(MyApp(setting: setting));
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
            GoRoute(
                path: 'zarlaga',
                builder: (context, state) => const ZarlagaPage(),
                routes: []),
            GoRoute(
                path: 'uldegdel',
                builder: (context, state) => const UldegdelPage(),
                routes: []),
          ]),
    ],
  );
}

class Settings with Api {
  UserModel? user;
  BranchModel? branch;
  init() async {
    try {
      user = await fetch('/user',
          decoder: (data) => UserModel.fromMap(data), method: 'get');
      branch = BranchModel.fromJson(GetStorage().read('current_branch'));
      log(user.toString());
    } catch (e) {
      GetStorage().write('TOKEN', null);
      log(e.toString());
    }
  }
}

class MyApp extends StatefulWidget {
  final Settings setting;
  const MyApp({super.key, required this.setting});

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  late final appRoutes = router();

  @override
  Widget build(BuildContext context) {
    // GetStorage().write('TOKEN', null);
    return MultiProvider(
      providers: [
        Provider(create: (context) => BranchModel()),
        ChangeNotifierProvider(create: (context) => StateModel(widget.setting)),
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
