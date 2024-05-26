import 'package:flutter/material.dart';
import 'package:get_storage/get_storage.dart';
import 'package:go_router/go_router.dart';
import 'package:product/api.dart';
import 'package:product/common/future_alert_dialog.dart';
import 'package:product/models/branch.dart';
import 'package:product/models/state.dart';
import 'package:product/models/user.dart';
import 'package:provider/provider.dart';

class FormData {
  String? username;
  String? password;
  FormData({
    this.username,
    this.password,
  });
  Map<String, dynamic> toMap() => {
        'username': username,
        'password': password,
      };
}

class MyLogin extends StatefulWidget {
  const MyLogin({super.key});

  @override
  State<MyLogin> createState() => _MyLoginState();
}

class _MyLoginState extends State<MyLogin> with Api {
  FormData formData = FormData();

  @override
  Widget build(BuildContext context) {
    var state = context.read<StateModel>();
    return Scaffold(
      body: Center(
        child: Container(
          padding: const EdgeInsets.all(80.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                'Нэвтрэх',
                style: Theme.of(context).textTheme.displayLarge,
              ),
              TextFormField(
                decoration: const InputDecoration(
                  hintText: 'Нэвтрэх нэр',
                ),
                onChanged: (value) {
                  formData.username = value;
                },
              ),
              TextFormField(
                decoration: const InputDecoration(
                  hintText: 'Нууц үг',
                ),
                obscureText: true,
                onChanged: (value) {
                  formData.password = value;
                },
              ),
              const SizedBox(
                height: 24,
              ),
              // DropdownButtonFormField(
              //   items: [
              //     ...branchs.map(
              //       (element) => DropdownMenuItem(
              //         value: element,
              //         child: Text(element.name?.toString() ?? ''),
              //       ),
              //     )
              //   ],
              //   onChanged: (value) {
              //     state.setCurrentBranch(value!);
              //   },
              // ),
              ElevatedButton(
                onPressed: () async {
                  // if (state.currentBranch == null) {
                  //   ScaffoldMessenger.of(context).showSnackBar(
                  //       const SnackBar(
                  //           content: Text("Салбар сонгоогүй байна")));
                  //   return;
                  // }

                  var user = await futureAlertDialog(
                    context: context,
                    autoCloseSec: 0,
                    futureStream: fetch(
                      '/login',
                      decoder: (data) => UserModel.fromMap(data),
                      method: 'POST',
                      body: formData.toMap(),
                    ),
                  );
                  if (user != null) {
                    await GetStorage().write('TOKEN', user.token);

                    state.user = user;
                    context.pushReplacement('/');
                    GetStorage().save();
                  }
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.deepPurpleAccent,
                  foregroundColor: Colors.white,
                ),
                child: const Text('Нэвтрэх'),
              )
            ],
          ),
        ),
      ),
    );
  }
}
