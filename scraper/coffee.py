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

martinez_items = [
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-intenso',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-moka',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-selecto',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-suave',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-tipo-italiano',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-brasil',
    'https://www.cafemartinezonline.com.ar/producto/cafe-molido-colombia'
]

parsed_items = []
for item in bonafide_items:
    parsed_items.append(bonafide.scrape(get_save_path(), get_soup(item)))

for item in martinez_items:
    parsed_items.append(martinez.scrape(get_save_path(), get_soup(item)))

database = db.DB()
database.populate(parsed_items)
database.close()