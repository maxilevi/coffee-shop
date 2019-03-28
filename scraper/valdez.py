import re
import image_formatter

def parse_price(text):
    return float(text.replace('$', '').replace(',', '').strip())

def scrape(save_path, soup, params):
    data = {}
    formatter = image_formatter.ImageFormatter()
    data['name'] = params['name']
    data['description'] = params['description']
    data['price'] = (parse_price(soup.find('span', class_='price-tag-fraction').text) + 300) * 4 # Price per KG
    data['cuts'] = ['Molido']
    thumbnail_url = params['thumbnail']
    data['thumbnail'] = '/temp/' + formatter.format(thumbnail_url, save_path)
    data['images'] = params['images']
    data['brand'] = 'Juan Valdez'
    return data
