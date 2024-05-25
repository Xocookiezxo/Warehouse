import 'dart:convert';
import 'dart:developer';
import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:flutter/services.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;
import 'package:image_picker/image_picker.dart';

class ValidationException implements Exception {
  String message;
  Map<String, dynamic> errors;
  ValidationException(this.message, this.errors) : super();
  @override
  String toString() {
    // var varsss = "";

    // errors.forEach((key, value) => varsss += "$key:$value \n\r");
    return "$message ";
  }
}

typedef Decoder<T> = T Function(dynamic data);

typedef Progress = Function(double percent);

mixin Api {
  static String host = "http://192.168.10.247:8000";
  Future<T?> fetch<T>(
    String path, {
    String method = 'get',
    dynamic body,
    Map<String, String>? headers,
    Map<String, dynamic>? query,
    Decoder<T>? decoder,
    Progress? uploadProgress,
    void Function(String msg)? onError,
    void Function()? connectionError,
  }) async {
    var headersList = {
      'User-Agent': 'waste_mobile',
      'Accept': 'application/json',
      HttpHeaders.contentTypeHeader: 'application/json;charset=utf-8',
      'charset': 'utf-8',
      ..._hasToken(),
      ...headers ?? {}
    };
    var url = Uri.parse('${Api.host}/api$path');
    if (kDebugMode) {
      log(url.toString());
    }
    http.Response res;
    switch (method.toLowerCase()) {
      case 'post':
        res = await http.post(url,
            headers: headersList, body: body == null ? '' : jsonEncode(body));
        break;
      case 'put':
        res = await http.put(url,
            headers: headersList, body: body == null ? '' : jsonEncode(body));
        break;
      case 'patch':
        res = await http.patch(url,
            headers: headersList, body: body == null ? '' : jsonEncode(body));
        break;
      case 'head':
        res = await http.head(url, headers: headersList);
        break;
      default:
        res = await http.get(url, headers: headersList);
    }

    String text = 'Сервэртэй холбогдоход алдаа гарлаа!';
    if (res.statusCode >= 200 && res.statusCode < 300) {
      final body = jsonDecode(res.body);

      if (decoder != null) {
        return decoder(body);
      }
      return body;
    } else if (res.statusCode == 401) {
      final body = jsonDecode(res.body);

      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }
      throw ValidationException(text, body['errors']);
    } else if (res.statusCode == 422) {
      final body = jsonDecode(res.body);
      text = res.reasonPhrase ?? text;
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }
      throw ValidationException(text, body['errors'] ?? {});
    } else {
      if (kDebugMode) {
        print(res.reasonPhrase);
      }
      final body = jsonDecode(res.body);
      text = res.reasonPhrase ?? text;
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }
      if (onError != null) {
        onError(text);
      } else {
        throw PlatformException(code: res.statusCode.toString(), message: text);
      }
      return null;
    }
  }

  Future<T?> fetchMutiPart<T>(
    String path,
    String method, {
    required dynamic body,
    Map<String, String>? headers,
    Map<String, dynamic>? query,
    Decoder<T>? decoder,
    required List<List<int>> images,
    XFile? image,
    List<int>? video,
    Progress? uploadProgress,
    void Function(String msg)? onError,
    void Function()? connectionError,
  }) async {
    var headersList = {
      'User-Agent': 'waste_mobile',
      'Accept': 'application/json',
      HttpHeaders.contentTypeHeader: 'application/json',
      ..._hasToken()
    };
    var url = Uri.parse('${Api.host}/api$path');

    var req = http.MultipartRequest(method, url);
    req.headers.addAll(headersList);
    if (body is! Map) {
      body = jsonDecode(body);
    }
    body.forEach((key, val) {
      if (val != null) {
        if (val is List) {
          for (int i = 0; i < val.length; i++) {
            req.fields['$key[$i]'] = val[i].toString();
          }
        } else {
          req.fields[key] = val.toString();
        }
      }
    });
    for (int i = 0; i < images.length; i++) {
      req.files.add(http.MultipartFile.fromBytes('images[$i]', images[i],
          filename: "images$i.jpg"));
    }
    if (video != null) {
      req.files.add(
          http.MultipartFile.fromBytes('video', video, filename: 'video.mpeg'));
    }
    if (image != null) {
      req.files.add(await http.MultipartFile.fromPath('image', image.path));
    }
    var res = await req.send();
    final resBytes = await res.stream.toBytes();
    final resBody = utf8.decode(resBytes.toList(), allowMalformed: true);
    String text = 'Сервэртэй холбогдоход алдаа гарлаа!';
    if (res.statusCode >= 200 && res.statusCode < 300) {
      final body = jsonDecode(resBody);

      if (decoder != null) {
        return decoder(body);
      }
      return body;
    }
    if (res.statusCode == 401) {
      final body = jsonDecode(resBody);
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }

      throw ValidationException(text, body['errors']);
    } else {
      if (kDebugMode) {
        print(res.reasonPhrase);
      }
      final body = jsonDecode(resBody);
      text = res.reasonPhrase ?? text;
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }
      if (onError != null) {
        onError(text);
      } else {
        throw PlatformException(code: res.statusCode.toString(), message: text);
      }
      return null;
    }
  }

  Map<String, String> _hasToken() {
    final token = GetStorage().read<String>("TOKEN");
    if (token == null) {
      return {};
    }
    return {'Authorization': "Bearer $token"};
  }
}
