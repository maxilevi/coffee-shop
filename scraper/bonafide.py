from bs4 import BeautifulSoup
import requests
import json
import re
import subprocess
import sys
import db
import image_formatter
import os
import glob
import random

def get(url):
    r = requests.get(url)
    if r.status_code is not 200:
        print(f'Failed to request {url}')
        return None
    return r.content

def parse_price(text):
        return float(text.replace('$', '').replace(',', '').strip())

def get_save_path():
        return (os.path.dirname(__file__) + '/../webapp/public/temp/').replace('\\', '/')

def parse_name(text):
    p = re.compile('\|.*\|(.*)$')
    return p.search(text).group(1).strip()

def clean():
    files = glob.glob(get_save_path() + '*')
    for f in files:
        os.remove(f)
clean()
items = [
    'http://bonafideonline.com.ar/26-cafe-cinta-azul.html',
    'http://bonafideonline.com.ar/24-cafe-descafeinado.html',
    'http://bonafideonline.com.ar/25-cafe-franja-blanca.html',
    'http://bonafideonline.com.ar/28-cafe-fluminense.html',
    'http://bonafideonline.com.ar/27-cafe-noir.html',
    'http://bonafideonline.com.ar/23-cafe-express.html',
    'http://bonafideonline.com.ar/22-cafe-seleccion.html'
]

parsed_items = []
for item in items:
    print(f'Parsing "{item}" ...')
    sys.stdout.flush()
    soup = BeautifulSoup(get(item), 'html.parser')
    data = {}
    formatter = image_formatter.ImageFormatter()
    data['name'] = parse_name(soup.find('div', class_='breadcrumb clearfix').text)
    data['description'] = soup.find('div', {"id": 'short_description_content'}).find('p').text
    data['price'] = parse_price(soup.find('span', {"id": "unit_price_display"}).text)
    data['cuts'] = [i.text for i in soup.find('select', attrs = {'name': 'group_4'}).findAll('option')]
    thumbnail_url = soup.find('div', {"id": "image-block"}).find('img')['src']
    data['thumbnail'] = '/temp/' + formatter.format(thumbnail_url, get_save_path())
    data['images'] = [thumbnail_url]
    data['brand'] = 'Bonafide'
    parsed_items.append(data)

database = db.DB()
database.populate(parsed_items)
database.close()