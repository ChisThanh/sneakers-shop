import numpy as np
import os
import glob
import cv2
import sys

from tensorflow.keras.applications import ResNet50
from tensorflow.keras.preprocessing import image
from tensorflow.keras.applications.resnet50 import preprocess_input
from scipy.spatial.distance import cosine

weights_path = "resnet50_weights_tf_dim_ordering_tf_kernels_notop.h5"
model = ResNet50(weights=None, include_top=False, pooling='avg')
model.load_weights(weights_path)

def extract_color_histogram(image):
    img_lab = cv2.cvtColor(image, cv2.COLOR_BGR2Lab)
    hist = cv2.calcHist([img_lab], [0, 1, 2], None, [8, 8, 8], [0, 256, 0, 256, 0, 256])
    hist = cv2.normalize(hist, hist).flatten()
    return hist
def compare_color_histograms(hist1, hist2):
    return cv2.compareHist(hist1, hist2, cv2.HISTCMP_CHISQR)

def extract_features(image_path):
    img = image.load_img(image_path, target_size=(224, 224))
    img_array = image.img_to_array(img)
    img_array = preprocess_input(img_array)
    img_array = np.expand_dims(img_array, axis=0)
    features = model.predict(img_array)
    return features.flatten()

def compare_features(feature1, feature2):
    return cosine(feature1, feature2)

def search_similar_images(query_feature, dataset_features, dataset_paths, n):
    similarities = [compare_features(query_feature, feat) for feat in dataset_features]
    most_similar_indices = sorted(range(len(similarities)), key=lambda k: similarities[k])[:n]
    return [dataset_paths[idx] for idx in most_similar_indices]

def get_dataset_paths(dataset_folder):
    image_extensions = ["jpg", "jpeg", "png", "gif"]
    return [img for ext in image_extensions for img in glob.glob(os.path.join(dataset_folder, f"*.{ext}"))]

def get_dataset_features_and_histograms(dataset_paths):
    dataset_features = []
    dataset_histograms = []
    for img_path in dataset_paths:
        img = cv2.imread(img_path)
        dataset_features.append(extract_features(img_path))
        dataset_histograms.append(extract_color_histogram(img))
    return dataset_features, dataset_histograms

def search_images(image_path, n=3):
    query_feature = extract_features(image_path)
    query_histogram = extract_color_histogram(cv2.imread(image_path))
    similarities_feature = [compare_features(query_feature, feat) for feat in dataset_features]
    similarities_histogram = [compare_color_histograms(query_histogram, hist) for hist in dataset_histograms]
    combined_scores = np.array(similarities_feature) + np.array(similarities_histogram)
    most_similar_indices = combined_scores.argsort()[:n]
    return [extract_file_name(dataset_paths[idx]) for idx in most_similar_indices]

def extract_file_name(file_path):
    file_name = file_path.split("/")[-1]
    return file_name

dataset_folder = "../public/images/products"
dataset_paths = get_dataset_paths(dataset_folder)
dataset_features, dataset_histograms = get_dataset_features_and_histograms(dataset_paths)

