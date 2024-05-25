class UserModel {
  int id;
  String? name;
  String? phone;
  String? username;
  String? password;
  String? roles;
  DateTime? createdAt;
  String? token;
  UserModel({
    required this.id,
    this.name,
    this.phone,
    this.username,
    this.password,
    this.roles,
    this.createdAt,
    this.token,
  });

  factory UserModel.fromMap(Map<String, dynamic> json) {
    return UserModel(
      id: json['id'],
      name: json['name'],
      phone: json['phone'],
      username: json['username'],
      password: json['password'],
      roles: json['roles'],
      createdAt: (json["created_at"] is DateTime?)
          ? json["created_at"]
          : DateTime.tryParse(json["created_at"]),
      token: json['token'],
    );
  }

  Map<String, dynamic> toMap() => {
        'id': id,
        'name': name,
        'phone': phone,
        'username': username,
        'password': password,
        'roles': roles,
        'created_at': createdAt?.toIso8601String(),
        'token': token,
      };
}
