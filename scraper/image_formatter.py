import urllib.request
import string
import random
from os import path
from PIL import Image

class ImageFormatter():

    def random_code(self) -> str:
        return ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(8))

    def format(self, url, save_dir):
        name = self.random_code() + '.jpg'
        tmp_path = save_dir + name
        urllib.request.urlretrieve(url, tmp_path)
        im = Image.open(tmp_path)
        if not im.mode == 'RGB':
            im = im.convert('RGB')
        im.save(tmp_path, quality=95)
        image = Image.open(tmp_path)
        width = image.size[0]
        height = image.size[1]

        aspect = width / float(height)

        ideal_width = 250
        ideal_height = 170

        ideal_aspect = ideal_width / float(ideal_height)

        if aspect > ideal_aspect:
            # Then crop the left and right edges:
            new_width = int(ideal_aspect * height)
            offset = (width - new_width) / 2
            resize = (offset, 0, width - offset, height)
        else:
            # ... crop the top and bottom:
            new_height = int(width / ideal_aspect)
            offset = (height - new_height) / 2
            resize = (0, offset, width, height - offset)

        #thumb = image.crop(resize).resize((ideal_width, ideal_height), Image.ANTIALIAS)
        thumb.save(tmp_path, quality=95)
        return name