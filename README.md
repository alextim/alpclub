## Содержание
1. Режим обслуживания, Maintenance Mode 
2. Картинки
3. Копирайт в футере.
4. Настройка контактных данных: адрес, телефоны, почта и т.д.
5. Шоткоды.
6. Оформление внешних ссылок

## 1. Режим обслуживания Maintenance Mode 
- В админ-панели пункт зайти меню "Appearance", подпункт "Customize"
- Выбрать раздел "Maintenance"
- Отметить чек-бокс "Maintenance mode"
- Сохранить изменения - нажать кнопку "Publish"

## 2. Картинки
Размер картинки очень влияет на производительность сайла
- Редактировать в Adobe Photosho или Corel PhotoPaint
- Разрешение 72dpi
- Сохранять с оптимизацией для Web

 Где | Разрешение | Размер файла 
 --- | --- | --- 
 Баннер по умолчанию | 1920 x 500 | 50-80kB
 Страницы            |   
 Таксономии          | 
 Слайдер             | 1920 x 850 | 90-120kB



## 3. Копирайт в футере.
Через FTP отредактировать файл:
/themes/alpclub-odessa/template-parts/footer/copyright.php


## 4. Настройка контактных данных: адрес, телефоны, почта и т.д.
Через FTP отредактировать файл:
/plugins/at-contact-info/inc/defaults.php


## 5. Шоткоды.
- [at_contact_phone_1]
- [at_contact_email_1]
- [at_contact_opening_time]
- [at_contact_vcard all]
- [at_contact_vcard addr]
- [at_contact_vcard comm]


## 6. Оформление внешних ссылок
Обязательно добавлять в ссылки на внешние сайты 2 тэга:

1. target="_blank" Открывает в новой вкладке и не уводит посетителя с нашего сайта
2. rel="noopener nofollow" Безопасность, для SEO- робот-поисковик не уходит на чужой сайт

Пример правильного оформления:
\<a target="_blank" rel="noopener nofollow" href="http:\\example.com">Example\</a>
