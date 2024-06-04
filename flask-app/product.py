class Product:
    def __init__(self, *args):
        self.id = args[0]
        self.name = args[1]
        self.category_id = args[2]
        self.supplier_id = args[3]
        self.price = args[4]
        self.discount = args[5]
        self.image = args[6]
        self.stock = args[7]
        self.created_at = args[8]
        self.updated_at = args[9]

    def product_to_dict(self):
        return {
            'id': self.id,
            'name': self.name,
            'category_id': self.category_id,
            'supplier_id': self.supplier_id,
            'price': self.price,
            'discount': self.discount,
            'image': self.image,
            'stock': self.stock,
            'created_at': self.created_at,
            'updated_at': self.updated_at
        }
