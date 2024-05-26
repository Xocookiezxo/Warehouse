export const AdminMenu = [
    { text: "Нүүр хуудас", href: "/", icon: "ti-home", roles:['admin','manager','staff'] },
    { text: "Ажилтан", href: "/admin/user_models", icon: "ti-receipt" , roles:['admin'] },
    { text:'Барааны лавлах төрөл',href:'/admin/product_categories',icon: 'ti-receipt', roles:['admin','manager'] },
    { text:'Салбар',href:'/admin/branches',icon: 'ti-receipt', roles:['admin'] },
    { text:'Барааны лавлахын бүртгэл',href:'/admin/products',icon: 'ti-receipt', roles:['admin','manager'] },
    { text:'Нийлүүлэгч',href:'/admin/providers',icon: 'ti-receipt', roles:['admin','manager'] },
    { text:'Агуулах дансны түүх',href:'/admin/branch_have_products',icon: 'ti-receipt', roles:['admin','manager'] },
    { text:'Тайлан',href:'/admin/report',icon: 'ti-receipt', roles:['admin','manager','staff'] },
    { text:'Нийлүүлэлт бүртгэх',href:'/admin/supplies',icon: 'ti-receipt', roles:['manager'] },
    { text:'Нийлүүлэлт тооллогийн бүртгэл',href:'/admin/supply_products',icon: 'ti-receipt', roles:['manager'] },
    // admin_menu
];

export default AdminMenu;
