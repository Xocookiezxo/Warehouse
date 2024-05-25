class BranchModel {
  int? id;
  String? name;
  String? address;
  String? description;
  DateTime? createdat;
  DateTime? updatedat;

  BranchModel({
    this.id,
    this.name,
    this.address,
    this.description,
    this.createdat,
    this.updatedat,
  });

  BranchModel.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
    address = json['address'];
    description = json['description'];
    createdat = (json["created_at"] is DateTime?)
        ? json["created_at"]
        : DateTime.tryParse(json["created_at"]);
    updatedat = (json["updated_at"] is DateTime?)
        ? json["updated_at"]
        : DateTime.tryParse(json["updated_at"]);
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = Map<String, dynamic>();
    data['id'] = id;
    data['name'] = name;
    data['address'] = address;
    data['description'] = description;
    data['created_at'] = createdat?.toIso8601String();
    data['updated_at'] = updatedat?.toIso8601String();
    return data;
  }
}
