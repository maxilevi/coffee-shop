import re
import image_formatter

def parse_price(text):
    return float(text.replace('$', '').replace(',', '').strip())

def scrape(save_path, soup):
    data = {}
    formatter = image_formatter.ImageFormatter()
    data['name'] = soup.find('h1', class_='product-sheet-description-title').text
    desc = soup.find('div', class_='spec-text').text
    data['description'] = desc.partition('.')[0] + '.' + desc.partition('.')[2] if len(desc) > 200 else desc
    data['price'] = parse_price(soup.find('span', class_='price').text) * 4 #Price per KG
    data['cuts'] = ['Molido']
    thumbnail_url = 'https://www.cafemartinezonline.com.ar/' + soup.find('a', {"id": "product-image-"}).find('img', class_='img-original')['src']
    data['thumbnail'] = '/temp/' + formatter.format(thumbnail_url, save_path)
    data['images'] = [thumbnail_url]
    data['brand'] = 'Café Martinez'
    return data
