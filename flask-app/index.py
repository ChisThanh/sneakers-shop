from flask_cors import CORS
from flask import Flask, Blueprint, jsonify, request, redirect
from search_images import search_images
from product import Product
import os
import mysql.connector

app = Flask(__name__)
CORS(app)


connection = mysql.connector.connect(
    host="127.0.0.1",
    user="user",
    password="user",
    database="laravel_docker"
)

api_app = Blueprint('api', __name__, url_prefix='/api/')

def get_data(images):
    cursor = connection.cursor()
    where_condition = " OR ".join([f"image LIKE '%{img}%'" for img in images])
    cursor.execute(f"SELECT * FROM products WHERE {where_condition}")
    data = cursor.fetchall()
    cursor.close()

    products = []
    for row in data:
        product = Product(*row)
        products.append(product.product_to_dict())

    return jsonify(products)


@app.route('/')
def redirect_to_api():
    return redirect("/api/search-image")

@api_app.route('/search-image', methods=['GET'])
def api_route():
    return jsonify({'error': 'GET method is not supported'}), 400

@api_app.route('/search-image', methods=['POST'])
@api_app.route('/search-image', methods=['POST'])
def upload_file():
    if 'image' not in request.files:
        return jsonify({'error': 'No file uploaded'}), 400

    image_file = request.files['image']
    _, extension = os.path.splitext(image_file.filename.lower())

    supported_extensions = (".jpg", ".jpeg", ".png", ".gif")
    if extension not in supported_extensions:
        return jsonify({'error': 'Invalid image format. Please upload a JPG, JPEG, PNG, or GIF image.'}), 400

    file_path = f'tmp/{image_file.filename}'
    image_file.save(file_path)

    data = search_images(file_path)

    return get_data(data)


app.register_blueprint(api_app)

if __name__ == "__main__":
    app.run(port=5000, debug=True)




