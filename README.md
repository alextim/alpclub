## Содержание
1. Редактору
   - Картинки
   - Шоткоды.
   - Оформление внешних ссылок
2. Администратору
   - Режим обслуживания, Maintenance Mode 
   - Копирайт в футере.
   - Настройка контактных данных: адрес, телефоны, почта и т.д.
3. Программисту
   - Хостинг
   - Parent Theme
     - Замечания
     - Список изменений Файл: \wp-content\themes\surya-chandra-lite\inc\init.php
       - Запрет автолоадера рекомендованных плагинов
       - Запрет поддержки экспорта.
       - Запрет на вывод Info.
       - solved BUG: Загрузка Customizer только в Admin не работала
   - Child Theme

## 1. Редактору

### Картинки
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
 
### Шоткоды.
- [at_contact_phone_1]
- [at_contact_email_1]
- [at_contact_opening_time]
- [at_contact_vcard all]
- [at_contact_vcard addr]
- [at_contact_vcard comm]

### Оформление внешних ссылок
Обязательно добавлять в ссылки на внешние сайты 2 тэга:
1. `target="_blank"` Открывает в новой вкладке и не уводит посетителя с нашего сайта
2. `rel="noopener nofollow"` Безопасность и для SEO - робот-поисковик не уходит на чужой сайт

Пример правильного оформления:
`<a target="_blank" rel="noopener nofollow" href="http:\\example.com">Example</a>`


## 2. Администратору

### Режим обслуживания Maintenance Mode (только для Администратора)
1. В админ-панели пункт зайти в меню "Appearance", подпункт "Customize"
2. Выбрать раздел "Maintenance"
3. Отметить чек-бокс "Maintenance mode"
4. Сохранить изменения - нажать кнопку "Publish"

### Копирайт в футере.
Через FTP отредактировать файл:
/themes/alpclub-odessa/template-parts/footer/copyright.php

### Настройка контактных данных: адрес, телефоны, почта и т.д.
Через FTP отредактировать файл:
/plugins/at-contact-info/inc/defaults.php


## Программисту

###  Хостинг
- PHP 7.2
- Бесплатный сертификат Let's Encrypt - срок действия при месяца. Необходимо заказывать за 1 месяц до окончания спрока действия.
- Редирект HTTP на HTTPS

### Parent Theme
#### Замечания
Для улучшения производительности модифицированы файлы родительской темы.
Все изменения отмечены комментарием:
`// ATPTM`

После обновления родительской темы эти модификации теряются. Надо восстановливать вручную.
Модифицировання версия файла находится в  `\wp-content\themes\alpclub-odessa\surya-chandra-lite\init.php`
Действия 
1. зайти по FTP
2. загрузить оба файла в текстовый редактор
3. если отличия только те, что перечислены ниже в 3.2, то перезаписать файл родительской темы `\wp-content\themes\surya-chandra-lite\inc\init.php` модифицированным файлом из дочерней `\wp-content\themes\alpclub-odessa\surya-chandra-lite\init.php`
4. если есть еще какие-то отличия, то подправить код

#### Список изменений Файл: \wp-content\themes\surya-chandra-lite\inc\init.php

##### Запрет автолоадера рекомендованных плагинов.
Строка 27
```
// ATPTM require_once trailingslashit( get_template_directory() ) . 'lib/tgm/class-tgm-plugin-activation.php';
```
Строка 34
```
// ATPTM require_once trailingslashit( get_template_directory() ) . 'inc/hook/tgm.php';
```
##### Запрет поддержки экспорта.
Строка 59
```
// ATPTM require_once trailingslashit( get_template_directory() ) . 'inc/supports/ocdi.php';
```

##### Запрет на вывод Info.
Строки 64-67
```
// ATPTM if ( is_admin() ) {
// ATPTM 	require_once trailingslashit( get_template_directory() ) . 'lib/info/class.info.php';
// ATPTM 	require_once trailingslashit( get_template_directory() ) . 'lib/info/info.php';
// ATPTM }
```
##### solved BUG: Загрузка Customizer только в Admin не работала
Меню создается и через 2-3 секунды самороизвольно исчезает
Из-за проблемы в реализации функции is_admin()
Заменил is_admin() на is_customize_preview()

Строки 48-49
```
 */ // ATPTM
if (is_customize_preview()) { require_once trailingslashit( get_template_directory() ) . 'inc/customizer.php'; }
```
### Child Theme
Запрет ревизий постов
Файл \wp-content\themes\alpclub-odessa\functions.php
```
		// ATPTM
		// Ограничение количества ревизий постов в базе данных: 0
		add_filter( 'wp_revisions_to_keep', function ( $num, $post ) : int { return 0; }, 10, 2 );
```  
