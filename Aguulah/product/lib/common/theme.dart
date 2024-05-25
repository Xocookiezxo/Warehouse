import 'package:flutter/material.dart';

final appTheme = ThemeData(
    colorSchemeSeed: Colors.deepPurpleAccent,
    appBarTheme: const AppBarTheme(
        backgroundColor: Colors.deepPurpleAccent,
        titleTextStyle: TextStyle(
          color: Colors.white,
          fontSize: 22,
        )),
    textTheme: const TextTheme(
      displayLarge: TextStyle(
        fontFamily: 'Corben',
        fontWeight: FontWeight.w700,
        fontSize: 24,
        color: Colors.black,
      ),
    ),
    elevatedButtonTheme: ElevatedButtonThemeData(
        style: ElevatedButton.styleFrom(
      backgroundColor: Colors.deepPurpleAccent,
      foregroundColor: Colors.white,
    )));
