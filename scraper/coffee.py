import glob
from bs4 import BeautifulSoup
import requests
import json
import re
import subprocess
import sys
import db
import image_formatter
import os
import random
import bonafide
import martinez
import valdez

def get_save_path():
        return (os.path.dirname(__file__) + '/../webapp/public/temp/').replace('\\', '/')

def get(url):
    r = requests.get(url)
    if r.status_code is not 200:
        print(f'Failed to request {url}')
        return None
    return r.content

def clean():
    files = glob.glob(get_save_path() + '*')
    for f in files:
        os.remove(f)

def get_soup(item):
    print(f'Parsing "{item}" ...')
    sys.stdout.flush()
    return BeautifulSoup(get(item), 'html.parser')

clean()

bonafide_items = [
    'http://bonafideonline.com.ar/26-cafe-cinta-azul.html',
    'http://bonafideonline.com.ar/24-cafe-descafeinado.html',
    'http://bonafideonline.com.ar/25-cafe-franja-blanca.html',
    'http://bonafideonline.com.ar/28-cafe-fluminense.html',
    'http://bonafideonline.com.ar/27-cafe-noir.html',
    'http://bonafideonline.com.ar/23-cafe-express.html',
    'http://bonafideonline.com.ar/22-cafe-seleccion.html'
]
#    'https://articulo.mercadolibre.com.ar/MLA-744350871-cafe-en-grano-tost-bonafide-expresso-1-kg-sellado-en-origen-_JM'

martinez_items = [
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-intenso',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-moka',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-selecto',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-suave',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-tipo-italiano',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-brasil',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-colombia'
]

valdez_items = [
    [
        'https://articulo.mercadolibre.com.ar/MLA-723576365-cafe-juan-valdez-molido-expreso-colina-250g-colombia-_JM',
        {
            'name': 'Café Colina',
            'description': 'Un café balanceado, con una textura mediana, aroma suave y notas de nueces tostadas.',
            'thumbnail': 'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/b6112569cb7c5ef9600f69096a487edc/c/o/colina_500gr.png',
            'images': [
                'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/b6112569cb7c5ef9600f69096a487edc/c/o/colina_500gr.png',
                'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/1800x/5869e45d9f0a1b08c3132be6b2863310/c/o/colina_500gr_s.png'
            ]
        }#https://www.juanvaldezcafestore.com/en/coffee/balanced/whole-bean/colina-coffee-whole-bean-500-g-17-oz
    ],
    [
        'https://articulo.mercadolibre.com.ar/MLA-723699373-cafe-juan-valdez-x250g-volcan-molido-spresso-colombia-_JM',
        {
            'name': 'Café Volcan',
            'description': 'Ideal para los amantes del café negro y tostado. Este blend único es reconocido por su fuerte aroma, tintes ácidos y notas de caramelo dulce.',
            'thumbnail': 'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/1800x/5869e45d9f0a1b08c3132be6b2863310/v/o/volcan_250gr.png',
            'images': [
                'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/1800x/5869e45d9f0a1b08c3132be6b2863310/v/o/volcan_250gr.png',
                'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/1800x/5869e45d9f0a1b08c3132be6b2863310/v/o/volcan_250gr_s.png'
            ]
        }#https://www.juanvaldezcafestore.com/en/volcan-coffee-ground-250-g/8-8-oz
    ],
    [
        'https://articulo.mercadolibre.com.ar/MLA-723575146-cafe-juan-valdez-x250g-cumbre-molido-spresso-fuerte-colombia-_JM',
        {
            'name': 'Café Cumbre',
            'description': 'Una exquisita combinación de café colombiano hecho para estimular tus sentidos con intensos sabores y notas de fruta seca.',
            'thumbnail': 'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/b6112569cb7c5ef9600f69096a487edc/c/u/cumbre_500gr.png',
            'images': [
                'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/b6112569cb7c5ef9600f69096a487edc/c/u/cumbre_500gr.png',
                'https://www.juanvaldezcafestore.com/media/catalog/product/cache/1/image/1800x/5869e45d9f0a1b08c3132be6b2863310/c/u/cumbre_500gr_s.png'
            ]
        }#https://www.juanvaldezcafestore.com/en/coffee/bold/whole-bean/cumbre-coffee-whole-bean-500-g-17-oz
    ]
]#https://articulo.mercadolibre.com.ar/MLA-742948224-cafe-juan-valdez-colombia-molido-x-750g-_JM

parsed_items = []

for item in valdez_items:
    parsed_items.append(valdez.scrape(get_save_path(), get_soup(item[0]), item[1]))

for item in bonafide_items:
    parsed_items.append(bonafide.scrape(get_save_path(), get_soup(item)))

for item in martinez_items:
    parsed_items.append(martinez.scrape(get_save_path(), get_soup(item)))

database = db.DB()
database.populate(parsed_items)
database.close()