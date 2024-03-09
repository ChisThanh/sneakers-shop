
class Product:
    def __init__(self, id, name, category_id, supplier_id, price, discount, image, stock, created_at, updated_at):
        self.id = id
        self.name = name
        self.category_id = category_id
        self.supplier_id = supplier_id
        self.price = price
        self.discount = discount
        self.image = image
        self.stock = stock
        self.created_at = created_at
        self.updated_at = updated_at

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
