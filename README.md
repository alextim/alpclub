## Содержание
1. [Введение](#to-introduction)
2. [Редактору](#to-editor)
   - [Необходимые навыки](#to-editor-skills)
   - [Заполнение Новостей (Постов)](#to-posts)
   - [Видео](#to-video)
   - [Картинки](#to-images)
   - [Шоткоды](#to-shortcodes)
   - [Форма "Контакты"](#to-contact-form-e)
   - [Home (Домой — Главная страница)](#to-home-page)
3. [Администратору](#to-admin)
   - [**![#f03c15](https://placehold.it/15/f03c15/000000?text=+) Важное!!!**](#to-important)
   - [Режим обслуживания, Maintenance Mode](#to-maintenance)
   - [Копирайт в футере](#to-copyright)
   - [Настройка контактных данных](#to-contact-data)
   - [Форма "Контакты"](#to-contact-form-a)
4. [Программисту](#to-programmer)
   - Настройки хостинга
   - Wordpress
   - Parent Theme
     - Замечания
     - Список изменений
   - Child Theme
5. [TO-DO](#to-do)   

## <a name="to-introduction"></a>Введение
На сайте есть два основных типа публикаций
- Записи
- Мероприятия

### Записи
предназначены для таких публикаций, как посты, новости, события, отчеты о поездках, поздравления, повестки собрания, результаты соревнований, объявления, описания.

_Запись_ состоит из главной картинки и текста. В текст можно вставлять картинки, видео, ссылки.

### Мероприятия (выезды, сборы)
Публикация вида _Мероприятие_ состоит из главной картинки и нескольких вкладок с текстом: описание, программа по дням, стоимость (что включено и что нет), снаряжение и др.

Мероприятие имеет разнообразные атрибуты: дата начала и окончания, продолжительнось, высшая точка, техническая сложность, размер группы, цена, валюта, цена распродажи и др.
На мероприятие можно зарегистрироваться (ссылка на регистрационную форму, дата окончания регистрации).

:bulb: <i>Примеры какие материалы отнести к записям, а какие к мероприятиям.
- Поздравление с Новым Годом - запись
- Сборы в Карпатах 2019 (с описанием, планом по дням, снаряжением) - мероприятие
- Объявляем набор в школу альпинизма - запись
- Скоро сборы в Карпатах - запись
- Лекция о зимнем альпинизме - запись
- Сбор в Карпатах состоялся - запись
- Напоминание об оплате членских взносов - запись
- Сборы в Шамони - мероприятие
- День Альпиниста 2019 - запись</i>




## <a name="to-editor"></a>Редактору
### <a name="to-editor-skills"></a>Необходимые навыки
- Знание HTML5 и CSS3
- Уметь пользоваться каким-либо текстовым редактором
- Уметь работать с графическими программами такими, как Adobe Photoshop, Corel PhotoPaint или подобными
- Базовые знания по работе и организации Wordpress
- Понимание SEO
- Минимальный английский

### <a name="to-posts"></a>Заполнение Новостей (Постов)
В Admin панели пункт меню "Записи" -> "Добавить новую".

Шесть элементов, которые нужно заполнить для полноценного оформления поста.

1. Заголовок
2. Текст
- Заполнять в редакторе в режиме "Текст"
- Для оформления текстов не применять in-line стили. Можно только HTML-тэги и классы.

  Пример c использования тэга HTML `<h4>` подзаголовка 4-го уровня:
  ```html
  <h4>Мой подзаголовок 4-го уровня</h4>
  ```
  
  Пример применения классов CSS для оформления параграфа:
  ```html
  <p class="my-special-class">Мой текст</p>
  ```
  
   :bulb: Класс `my-special-class` должен быть предварительно создан в  файле стилей темы -`style.css`.
- Для списков пользуйтесь тэгами `ul`, `ol` и `li`.

  :bulb: _Не создавайте неуправляемые ламерские списки с помощью тире или цифр._
- Текст оптимизированный для SEO
  - более 300 слов
  - оригинальный, __NO COPY PASTE__
  - структурированный - в теле текста обязательно тэги подзаголовков `h2`, `h3`, `h4`
  - для SEO слова из Заголовка (пункт 1) должны присутствовать в теле текста 

__Ссылки внутри вводимого текста__

Есть два вида ссылок.

**_Внутренние ссылки_** - для картинок, документов и прочего контента внутри нашего сайта.

Создавайте ссылки относительно корня сайта `/`, не используйте полный путь `https://alp.od.ua/`.

Неправильно:
```html
<a href="https://alp.od.ua/persons/klebanskij-vladimir">Вова</a>
```
    
Правильно:
```html
<a href="/persons/klebanskij-vladimir">Вова</a>
```
:bulb: _При использовании полного пути после смены протокола `https` на `http` или переходе на новый домен ссылка будет утеряна и Вам придется ее заново редактировать._
   
**_Внешние ссылки_** - на чужие сайты и ресурсы.

Обязательно добавлять 2 тэга в код ссылки:
- `target="_blank"` Открывает ссылку в новой вкладке и не уводит посетителя с нашего сайта
- `rel="noopener nofollow"` Безопасность и для SEO - робот-поисковик не уходит на чужой сайт

Неправильно:
```html
<a href="http:\\example.com">Example</a>
```     

Пример правильного оформления внешней ссылки:
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
### <a name="to-video"></a>Видео
Видео размещайте только на внешних специализированных ресурсах: youtube.com, vimeo.com и тд.

Для вставки видео в тело поста используйте тэг `iframe`.
```html
<iframe src="https://www.youtube.com/embed/Ef7f-K97xuA" width="560" height="315" frameborder="0" allowfullscreen></iframe>
```

### <a name="to-images"></a>Картинки
Все доступные картинки сайта можно просмотреть пункт меню "Медиафайлы" -> "Библиотека".

#### Четыре основных способа загрузки картинок на сайт
1. Через Admin панель меню "Медиафайлы" - "Добавить новый" -> "Загрузить новый медиафайл"
1. В Записях и Страницах "Установить изображение записи"
1. В Записях и Страницах в текстовом редакторе кнопка "Добавить медиафайл"
1. Envira Gallery

:bulb: _Размер файла картинки очень влияет на производительность сайта. Будьте внимательны, следите за размером. 
Сжимайте!_


#### Требования к картинкам
- Этап подготовки
  - Редактировать в Adobe Photoshop или Corel PhotoPaint.
  - Формат JPG.
  - Разрешение 72-96 dpi. 
  - Глубина цвета 24 Bit
  - Сохранять с оптимизацией для Web.
  - Имя файла на латиннице без пробелов, слова разделены тире `-`. Имя должно отражать предназначение и содержание картинки. Можно еще для SEO вписать в имя ключевое слово или два.
- Загрузка на сайт  
  - Заполнить тэги `title` и `alt`. В эти тэги для SEO полезно дописать ключевые слова.

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
tax-activity-alp-vid-na-monblan.jpg
post-poezdka-v-bolgariju-nachalas.jpg
trip-uts-v-bolgarii.jpg
person-klebanskij-vladimir.jpg
```

Картинки в текстах постов, страниц и мероприятий - любое осмысленное имя.

### <a name="to-shortcodes"></a>Шоткоды
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

[Редактирование](#to-contact-data) контактных данных доступно администратору.

### <a name="to-contact-form-e"></a>Форма "Контакты"
Все отправленное через контактную форму посетителями сайта можно просмотреть через адмиин-панель пункт меню "AT Contact Form".

- "Messages" - список посланных сообщений в хронологическом порядке.
- "Addrees Book" - записная книжка с e-mail и именем посетителя. Так же хранится время последней посыли  и IP-адрес, откуда отправлялась последняя форма.

Дополнительно результаты могут дублироваться на почту (см. раздел для Администратора)

### <a name="to-home-page"></a>Home (Домой — Главная страница)
Для редактирования "Главной страницы" зайдите в Admin панели в пункт меню "Страницы" -> ссылка "Изменить" в странице "Домой — Главная страница"

Главная страница состоит из 5 строк
1. Строка с баннером - "SiteOrigin Hero".
2. Строка со специальным постом - "ACO: Special post". Предполагается использование этой строки для самой важной новости (поста). Например информация о среде, поздравление, напоминание о взносах и т.п.
3. Строка с последними новостями - "ACO: Latest news". Три последние новости (поста).
4. Строка с предложением к действию - "ACO: СTA" (call to action). На нашем сайте это предложение вступить в клуб.
5. Строка с мероприятиями. Содержит в себе две ячейки.
 - Ячейка последние мероприятия - "ACO: Latest Trips". Два последних мероприятия горизонтально - средние по размеру картинки, расширенная информация о мероприятии.
 - Ячейка свежие мероприятия - "ACO: Recent Trips". Шесть последних мероприятий вертикально - картинки в виде иконок, краткая информация о мероприятии.

:bulb: _Чтобы пост, выбранный в элементе "ACO: Special post" не дублировался в элементе "ACO: Latest news" перейдите в последнем по ссылке "Редактировать". Затем в комбобоксе "Exclude Post:" выберите пост, который хотите исключить.
Для сохранения изменений нажмитек кнопку "Выполнено"._


## <a name="to-admin"></a>Администратору
### <a name="to-important"></a>**![#f03c15](https://placehold.it/15/f03c15/000000?text=+) Важное!!!**
- Не забывайте регулярно делать бекап файлов сайта и самой базы данных. Имейте несколько бэкапов, сохраняйте бэкапы по датам.

Не будьте наивны - рано или поздно катастрофа произойдет.
```diff
- Бекап - это единственное, что может помочь Вам восстановить сайт.
```
- Обновляйте плагины и ядро Вордпреса.
- Вордпрес популярен и, увы, уязвим. Следите за безопасностью, просматривайте логи.
- Минимизируйте права пользователей, избегайте предоставления пользователям прав администратора, создавайте отдельных пользователей для разных людей
- Оптимизируйте базу данных - удаляйте драфты, подвешенные записи и т.д. в WP-Optimize.
- После обновлений, редактирования Home page очищайте кэш - "Clear Cache"
### <a name="to-maintenance"></a>Режим обслуживания Maintenance Mode 
1. В админ-панели пункт зайти в меню "Appearance", подпункт "Customize"
2. Выбрать раздел "Maintenance"
3. Отметить чек-бокс "Maintenance mode"
4. Сохранить изменения - нажать кнопку "Publish"

### <a name="to-copyright"></a>Копирайт в футере
Через FTP отредактировать файл:

`/themes/alpclub-odessa/template-parts/footer/copyright.php`

### <a name="to-contact-data"></a>Настройка контактных данных
Адрес, телефоны, почта, рабочее время и прочее.
Через FTP отредактировать файл:

`/themes/alpclub-odessa/include/customizer/defaults.php`

### <a name="to-contact-form-a"></a>Форма "Контакты"
Пункт меню Settings -> AT Contact Form.

Результаты submit могут
- сохраняться в базе данных
- отсылаться на почту
- дублироваться на почту администратора сайта.

:bulb: _Если ни один чек-бокс не выбран, то форма "Контакты" не показывается._

Отдельно настраивается reCaptcha. Подробнее на [Google](https://www.google.com/recaptcha/intro/android.html)

## <a name="to-programmer"></a>Программисту

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
## <a name="to-do"></a>TO-DO
- [ ] Отказаться от Google Forms
  - Достоинство форм
    - Уже работает и Easy
  - Недостатки
    - Невозможно автоматически собрать все в один файл
    - Не будет автоматом ни рассылки  ни подписки
    - Не будет согласования Membership
- [ ] Подписка и рассылка
- [ ] Membership
- [ ] Переделать Logo и favicon. Лучшее качество и меньший размер. Уже есть исходник в векторном формате.
- [ ] Архив постов
- [ ] Архив мероприятий
- [ ] Как правильно оформить коммерческие программы? Вынести в отдельный сайт?
- [ ] Что делать с непрофильными видами активности - треккинг, лыжи и т.д.




