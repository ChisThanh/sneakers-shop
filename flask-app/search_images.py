import os
import numpy as np
from tensorflow.keras.applications.resnet50 import ResNet50, preprocess_input
from tensorflow.keras.preprocessing.image import load_img, img_to_array
from tensorflow.keras.models import Model
from sklearn.metrics.pairwise import cosine_similarity as sklearn_cosine_similarity


def load_and_preprocess_image(img_path):
    img = load_img(img_path, target_size=(224, 224))
    img = img_to_array(img)
    img = img.reshape((1, img.shape[0], img.shape[1], img.shape[2]))
    img = preprocess_input(img)
    return img


model = ResNet50(weights=None, include_top=False, input_shape=(224, 224, 3))
model.load_weights("resnet50_weights_tf_dim_ordering_tf_kernels_notop.h5")

feature_extractor = Model(inputs=model.input, outputs=model.output)


def compute_cosine_similarity(feature1, feature2):
    similarity = sklearn_cosine_similarity(feature1.reshape(1, -1), feature2.reshape(1, -1))[0][0]
    return similarity


def _feature_image(directory):
    arr_feature_image = {}
    image_paths = [os.path.join(directory, f) for f in os.listdir(directory)
                if os.path.isfile(os.path.join(directory, f)) and f.endswith(('.jpg', '.png'))]
    for image_path in image_paths:
        current_image = load_and_preprocess_image(image_path)
        feature = feature_extractor.predict(current_image)
        arr_feature_image[os.path.basename(image_path)] = feature
    return arr_feature_image

def search_img(arr_preprocess_image, input_image_path):
    similar_images = []
    input_image = load_and_preprocess_image(input_image_path)
    input_image_feature = feature_extractor.predict(input_image)
    for img_path, current_image in arr_preprocess_image.items():
        similarity = compute_cosine_similarity(current_image, input_image_feature)
        similar_images.append((img_path, similarity))
    similar_images.sort(key=lambda x: x[1], reverse=True)
    result_file_names = [os.path.basename(result[0]) for result in similar_images[:2]]
    return result_file_names





