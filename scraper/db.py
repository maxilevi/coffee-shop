import pymysql.cursors
import json
import sys

class DB():

    def __init__(self):
        with open('./../config.json', 'r') as fp:
            self.config = json.loads(fp.read())
        self.assert_config()
        self.connection = pymysql.connect(
            host=self.config['db_host'],
            port=self.config['db_port'],
            user=self.config['db_username'],
            password=self.config['db_password'],
            db=self.config['db_database'],
            charset='utf8mb4',
            cursorclass=pymysql.cursors.DictCursor
        )

    def populate(self, entries: list):
        self.truncate()
        for entry in entries:
            images = json.dumps(entry['images'])
            cuts = json.dumps(entry['cuts'])
            short_desc = self.get_short_desc(entry['description'])
            query = f"INSERT INTO products (name, short_description, long_description, thumbnail, price, brand, images, cuts) VALUES ('{entry['name']}', '{short_desc}', '{entry['description']}', '{entry['thumbnail']}', {entry['price']}, '{entry['brand']}', '{images}', '{cuts}');"
            self.execute_query(query)

    def truncate(self):
        self.execute_query('TRUNCATE TABLE products;')

    def execute_query(self, query):
        with self.connection.cursor() as cursor:
            print(f'Executing query "{query}"...')
            sys.stdout.flush()
            cursor.execute(query)
        self.connection.commit()

    def assert_config(self):
        if 'db_host' not in self.config or 'db_host' not in self.config or 'db_port' not in self.config or 'db_database' not in self.config or 'db_username' not in self.config or 'db_password' not in self.config:
            raise ValueError('Invalid config')

    def get_short_desc(self, text):
        lines = text.split('.')
        counted = 0
        new_text = ''
        i = 0
        while counted < 100 and i < len(lines):
            new_text += lines[i]  + '.'
            counted += len(lines[i])
            i += 1
        return new_text + ('...' if counted > 100 else '')

    def close(self):
        self.connection.close()
