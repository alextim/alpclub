## Содержание
1. [Редактору](#to-editor)
   - Заполнение Новостей (Постов)
   - Картинки
   - Шоткоды.
2. [Администратору](#to-admin)
   - Режим обслуживания, Maintenance Mode 
   - Копирайт в футере.
   - Настройка контактных данных
3. [Программисту](#to-programmer)
   - Настройки хостинга
   - Wordpress
   - Parent Theme
     - Замечания
     - Список изменений
   - Child Theme

## 1. Редактору<a name="to-editor"></a>
### Заполнение Новостей (Постов)
В Admin панели пункт меню "Записи" -> "Добавить новую".

Шесть элементов, которые нужно заполнить для полноценного оформления поста.

1. Заголовок
2. Текст
- Заполнять в редакторе в режиме "Текст"
- Для оформления текстов не применять in-line стили. Можно только HTML тэги и классы.

  Пример тэгов:   `<h4>Мой подзаголовок 4-го уровня<h4>`.  
  
  Пример классов: `<p class="my-special-class">Мой текст</p>`.
  
  `my-special-class` должен быть предварительно создан в  файле стилей темы -`style.css`.
- Для списков пользуйтесь тэгами `ul`, `ol` и `li`.

  Не создавайте неуправляемые ламерские списки с помощью тире или цифр.
- Текст оптимизированный для SEO
  - более 300 слов
  - оригинальный, __NO COPY PASTE__
  - структурированный - в теле текста обязательно тэги подзаголовков `h2`, `h3`, `h4`
  - для SEO слова из Заголовка (пункт 1) должны присутствовать в теле текста 

__Ссылки внутри вводимого текста__

Есть два вида ссылок.

**_Внутренние_** - для картинок, документов и прочего контента внутри нашего сайта.

Создавайте ссылки относительно корня сайта `/`, не используйте полный путь `https://alp.od.ua/`. 
     
Неправильно:
```html
<a href="https://alp.od.ua/persons/klebanskij-vladimir">Вова</a>
```
	    
Правильно:
```html
<a href="/persons/klebanskij-vladimir">Вова</a>
```
       
**_Внешние_** ссылки на чужие сайты и ресурсы.

Обязательно добавлять 2 тэга:
- `target="_blank"` Открывает в новой вкладке и не уводит посетителя с нашего сайта
- `rel="noopener nofollow"` Безопасность и для SEO - робот-поисковик не уходит на чужой сайт
       
Пример правильного оформления:
```html
<a target="_blank" rel="noopener nofollow" href="http:\\example.com">Example</a>
```
3. Выбрать рубрику, одну или несколько.
4. Установить изображение записи.
   При вставке картинки не забывайте заполнить очень нужные для SEO тэги `title` и `alt`.
5. Заполнить SEO мета-поля из раздела "All in One SEO Pack"
   - Заголовок.
   - Описание.
   - Ключевые слова.
6. Отрывок. Необязательно, но крайне желательно.

После заполнения всех необходимых полей сохранить пост- нажать копку "Опубликовать".

Продублировать пост на странице клуба в facebook: написать пару слов и что-то вроде "подробнее читайте на нашем сайте" с ссылкой на созданный документ. 

### Картинки
Все доступные картинки сайта можно просмотреть пункт меню "Медиафайлы" -> "Библиотека".

#### Четыре основных способа загрузки картинок на сайт
1. Через Admin панель меню "Медиафайлы" - "Добавить новый" -> "Загрузить новый медиафайл"
1. В Записях и Страницах "Установить изображение записи"
1. В Записях и Страницах в текстовом редакторе кнопка "Добавить медиафайл"
1. Envira Gallery

Размер файла картинки очень влияет на производительность сайта. Будьте внимательны, следите за размером. 
Сжимайте!


#### Требования к картинкам
- Этап подготовки
  - Редактировать в Adobe Photoshop или Corel PhotoPaint.
  - Формат JPG.
  - Разрешение 72-96 dpi. 
  - Глубина цвета 24 Bit
  - Сохранять с оптимизацией для Web.
  - Имя файла на латиннице без пробелов, слова разделены тире `-`. Имя должно отражать предназначение и содержание картинки. Можно еще для SEO вписать в имя ключевое слово или два.
- Загрузка на сайт  
  - Заполнить тэги `title` и `alt`. В тэги для SEO полезно дописать ключевые слова.

Таблица назначений, имен и размера картинок

| Назначение | Шаблон имени | Dimensions, px | File size, kB |
| --- | --- | ---: | --- |
| Баннер по умолчанию | | 1920 x 500 | 50-80 |
| Страницы    | page-{slug}-??????.jpg |   1920 x 500 | 50-80 |
| Таксономии  | tax-{taxonomy name}-{slug}-??????.jpg  | 1920 x 500 | 50-80 |
| Слайдер     | slider-??????.jpg       | 1920 x 850 | 90-120 |
| Посты       | post-{slug}.jpg     | 800 x 500 |  |
| Мероприятия | trip-{slug}.jpg       | 800 x 500 |  |
| Люди        | person-{slug}.jpg | 300 x 300 |  |

{slug} = Ярлык

Пример:
```
tax-activity-alp-vid-vid-na-monbla.jpg
post-poezdka-v-bolgariju-nachalas.jpg
trip-uts-v-bolgarii.jpg
person-klebanskij-vladimir.jpg
```

Картинки в текстах постов, страниц и мероприятий - любое осмысленное имя.

### Шоткоды.
Для использования в тексте постов и мероприятий.

Единые для сайта номер телефона, e-mail и прочие атрибуты адреса и контактных данных.

```
[at_contact_phone_1]
[at_contact_email_1]
[at_contact_opening_time]
[at_contact_vcard all]
[at_contact_vcard addr]
[at_contact_vcard comm]
```

## 2. Администратору<a name="to-admin"></a>
### Режим обслуживания Maintenance Mode 
1. В админ-панели пункт зайти в меню "Appearance", подпункт "Customize"
2. Выбрать раздел "Maintenance"
3. Отметить чек-бокс "Maintenance mode"
4. Сохранить изменения - нажать кнопку "Publish"

### Копирайт в футере.
Через FTP отредактировать файл:

`/themes/alpclub-odessa/template-parts/footer/copyright.php`

### Настройка контактных данных
Адрес, телефоны, почта, рабочее время и прочее.
Через FTP отредактировать файл:

`/themes/alpclub-odessa/include/customizer/defaults.php`


## Программисту<a name="to-programmer"></a>

###  Настройки хостинга
- Код дочерней темы работает по PHP 7.2
- Бесплатный сертификат Let's Encrypt - срок действия при месяца. Необходимо заказывать за 1 месяц до окончания спрока действия.
- Редирект HTTP на HTTPS
###  Wordpress
Изменены файлы `.htacess` и `wp-config.php`. Из соображений безопасности не опубликованы.
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

#### Список изменений
Файл:
`\wp-content\themes\surya-chandra-lite\inc\init.php`

##### Запрет автолоадера рекомендованных плагинов.
Строка 27
```php
// ATPTM require_once trailingslashit( get_template_directory() ) . 'lib/tgm/class-tgm-plugin-activation.php';
```
Строка 34
```php
// ATPTM require_once trailingslashit( get_template_directory() ) . 'inc/hook/tgm.php';
```
##### Запрет поддержки экспорта.
Строка 59
```php
// ATPTM require_once trailingslashit( get_template_directory() ) . 'inc/supports/ocdi.php';
```

##### Запрет на вывод Info.
Строки 64-67
```php
// ATPTM if ( is_admin() ) {
// ATPTM 	require_once trailingslashit( get_template_directory() ) . 'lib/info/class.info.php';
// ATPTM 	require_once trailingslashit( get_template_directory() ) . 'lib/info/info.php';
// ATPTM }
```
##### solved BUG: Загрузка Customizer только в Admin не работала
Меню создается и через 2-3 секунды самороизвольно исчезает из-за проблемы в реализации функции `is_admin()`.
Заменил `is_admin()` на `is_customize_preview()`.

Строки 48-49
```php
 */ // ATPTM
if (is_customize_preview()) { require_once trailingslashit( get_template_directory() ) . 'inc/customizer.php'; }
```
### Child Theme
Запрет ревизий постов.
Файл
`\wp-content\themes\alpclub-odessa\functions.php`
```php
		// ATPTM
		// Ограничение количества ревизий постов в базе данных: 0
		add_filter( 'wp_revisions_to_keep', function ( $num, $post ) : int { return 0; }, 10, 2 );
```  
