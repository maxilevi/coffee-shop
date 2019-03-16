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
            query = f"INSERT INTO Products (name, description, thumbnail, price, brand, images, cuts) VALUES ('{entry['name']}', '{entry['description']}', '{entry['thumbnail']}', {entry['price']}, '{entry['brand']}', '{images}', '{cuts}');"
            self.execute_query(query)

    def truncate(self):
        self.execute_query('TRUNCATE TABLE Products;')

    def execute_query(self, query):
        with self.connection.cursor() as cursor:
            print(f'Executing query "{query}"...')
            sys.stdout.flush()
            cursor.execute(query)
        self.connection.commit()

    def assert_config(self):
        if 'db_host' not in self.config or 'db_host' not in self.config or 'db_port' not in self.config or 'db_database' not in self.config or 'db_username' not in self.config or 'db_password' not in self.config:
            raise ValueError('Invalid config')

    def close(self):
        self.connection.close()
