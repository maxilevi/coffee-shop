import re
import image_formatter

def parse_price(text):
    return float(text.replace('$', '').replace(',', '').strip())

def parse_name(text):
    p = re.compile('\|.*\|(.*)$')
    return p.search(text).group(1).strip()

def scrape(save_path, soup):
    data = {}
    formatter = image_formatter.ImageFormatter()
    data['name'] = parse_name(soup.find('div', class_='breadcrumb clearfix').text)
    data['description'] = soup.find('div', {"id": 'short_description_content'}).find('p').text
    data['price'] = parse_price(soup.find('span', {"id": "unit_price_display"}).text)
    data['cuts'] = [i.text for i in soup.find('select', attrs = {'name': 'group_4'}).findAll('option')]
    thumbnail_url = soup.find('div', {"id": "image-block"}).find('img')['src']
    data['thumbnail'] = '/temp/' + formatter.format(thumbnail_url, save_path)
    data['images'] = [thumbnail_url]
    data['brand'] = 'Bonafide'
    return data
