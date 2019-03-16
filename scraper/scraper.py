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


class Scraper():

    def run(self):
        i = 0
        items = []
        files = glob.glob(self.get_save_path() + '*')
        for f in files:
            os.remove(f)
        while i < 1:
            print(f'Scraping page {str(i + 1)}')
            sys.stdout.flush()
            raw = self.get(self.next_page(i))
            soup = BeautifulSoup(raw, 'html.parser')
            articles = soup.find_all('article')
            for article in articles:
                art = self.parse_article(article)
                items.append(art)
                print(f"Scraped -> '{art['name']}'")
                sys.stdout.flush()
            i += 1
        print('Loading scraped items into db...')
        database = db.DB()
        database.populate(items)
        database.close()


    def parse_article(self, article):
        data = {
            'name': None,
            'thumbnail': None,
            'description': 'default',
            'price': 0.0,
            'images': [],
            'sizes': []
        }
        full_link = article.find('a', class_='link-image')['href']
        data['name'] = article.find('a', class_='link-image')['title']
        data['link'] = full_link
        img_source = article.find('img')['src']
        data['thumbnail'] = re.findall(r'(.*?)\?', img_source)[0] if '?' in img_source else img_source
        data['price'] = self.parse_price(article.find('span', class_='price').text)

        formatter = image_formatter.ImageFormatter()
        data['thumbnail'] = '/img/' + formatter.format(data['thumbnail'], self.get_save_path())

        single_product = self.get(full_link).decode('utf-8')
        if single_product is None:
            print(f'Invalid link {full_link}')
            return
        sizes = json.loads(re.search(r"var\sskuJson_0\s*=\s*({.*})", single_product).group(1))
        data['sizes'] = [size['dimensions']['Talle'] for size in sizes['skus'] if size['available'] is True]
        data['category'] = 'shoes'
        data['gender'] = 'man' if random.choice([True, False]) else 'woman'
        return data
            
    def parse_price(self, text):
        return float(text.replace('$', '').replace('.', '').replace(',', '.').strip())

    def get(self, url):
        r = requests.get(url)
        if r.status_code is not 200:
            print(f'Failed to request {url}')
            return None
        return r.content

    def get_save_path(self):
        return (os.path.dirname(__file__) + '/../webapp/public/img/').replace('\\', '/')
