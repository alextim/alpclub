## Содержание
1. [Редактору](#to-editor)
   - Заполнение Новостей
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
     - Список изменений Файл: \wp-content\themes\surya-chandra-lite\inc\init.php
   - Child Theme

## 1. Редактору<a name="to-editor"></a>
### Заполнение Новостей
В Admin панели пункт меню "Записи" -> "Добавить новую".

Что нужно вводить.

1. Заголовок
2. Текст
   - Заполнять в редакторе в режиме "Текст"
   - Для оформления текстов не пользоваться стилями. Можно только тэги и классы.
   - Текст по длине для SEO не короче, чем 301 слово
   - Только самописанные тексты, __NO COPY PASTE__
   - В тексте документа обязательно тэги подзаголовков `h2`, `h3`, `h4`
   - #### Ссылки
     - __внутренние ссылки__:  относительные от корня сайта `/`, без префикса `https://alp.od.ua`. 
> Неправильно 
> `<a href="https://alp.od.ua/persons/klebanskij-vladimir">Вова</a>`

> Правильно 
> `<a href="/persons/klebanskij-vladimir">Вова</a>`
     - __внешние ссылки__
> Обязательно добавлять в ссылки на внешние сайты 2 тэга:
> 1. `target="_blank"` Открывает в новой вкладке и не уводит посетителя с нашего сайта
> 1. `rel="noopener nofollow"` Безопасность и для SEO - робот-поисковик не уходит на чужой сайт

> Пример правильного оформления:
>`<a target="_blank" rel="noopener nofollow" href="http:\\example.com">Example</a>`

3. Выбрать рубрику, одну или несколько
4. Установить изображение записи
   ! При вставке картинки не забывайте заполнить очень нужные для SEO аттрибуты `ALT` и `TITLE`.
5. Заполнить SEO поля
   - Заголовок
   - Описание
   - Ключевые слова
6. Отрывок (необязательно)

После заполнения всех необходимых полей сохранить -нажать копку "Опубликовать".

Продублировать в пост на странице клуба в  facebook: написать пару слов и подробнее читайте на нашем сайте с ссылкой на созданный документ. 

### Картинки
Все доступные картинки сайта можно просмотреть пункт меню "Медиафайлы" -> "Библиотека"
Четыре основных способа загрузки картинок на сайт 
1. Через Admin панель меню "Медиафайлы" - "Добавить новый" -> "Загрузить новый медиафайл"
1. В Записях и Страницах "Установить изображение записи"
1. В Записях и Страницах в текстовом редакторе кнопка "Добавить медиафайл"
1. Envira Gallery

Размер файла картинки очень влияет на производительность сайта. Будьте внимательны, следите за размером. Сжимайте!
Подготовка картинки
- Редактировать в Adobe Photoshop или Corel PhotoPaint.
- Формат JPG.
- Разрешение 72-96 dpi. 
- 24 Bit
- Сохранять с оптимизацией для Web.
- Имя файла должно отражвть предназначение и содержание картинки.
Загрузка на сайт
- Заполнить аттрибуты TITLE, ALT

| Где | Шаблон имени | Dimensions, px | File size, kB |
| --- | --- | --- | --- |
| Баннер по умолчанию | | 1920 x 500 | 50-80 |
| Страницы    | page-{slug}-??????.jpg |   1920 x 500 | 50-80 |
| Таксономии  | tax-{taxonomy name}-{slug}-??????.jpg  | 1920 x 500 | 50-80 |
| Слайдер     | slider-??????.jpg       | 1920 x 850 | 90-120 |
| Посты       | post-{slug}.jpg     | 800 x 500 |  |
| Мероприятия | trip-{slug}.jpg       | 800 x 500 |  |
| Люди        | person-{slug}.jpg |  |  |

{slug} = Ярлык

> Пример
> page-poezdka-v-bolgariju.jpg

Картинки в теле постов, страниц и мероприятий любое осмысленное имя

### Шоткоды.
Можно использовать в тексте постов и мероприятий

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
/themes/alpclub-odessa/template-parts/footer/copyright.php

### Настройка контактных данных
Адрес, телефоны, почта, рабочее время и прочее.
Через FTP отредактировать файл:
/plugins/at-contact-info/inc/defaults.php


## Программисту<a name="to-programmer"></a>

###  Настройки хостинга
- Код дочерней темы работает по PHP 7.2
- Бесплатный сертификат Let's Encrypt - срок действия при месяца. Необходимо заказывать за 1 месяц до окончания спрока действия.
- Редирект HTTP на HTTPS
###  Wordpress
Изменены файлы .htacess и wp-config.php. Из соображений безопасности смотри отдельный документ.
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
Меню создается и через 2-3 секунды самороизвольно исчезает из-за проблемы в реализации функции is_admin().
Заменил is_admin() на is_customize_preview().

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
