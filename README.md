# StreamTelecom

Данный пакет разработан на основе API stream-telecom.ru (https://stream-telecom.ru/solutions/integrations/). 

В данном пакете реализованы следующие методы:
1. Просмотр баланса;
2. Выгрузка тарифов;
3. Выгрузка статистики;
4. HLR-запросы;
5. Отправка СМС;
6. Отправка сообщений в Viber;
7. Отправка уведомлений в VK;
8. Отправка Email;

## Установка
```bash
composer require manzadey/stream-telecom
```

## Начало работы
```php
use Manzadey\StreamTelecom\StreamTelecom;

$st = new StreamTelecom('name', 'login', 'password', 'password_from_personal_account');
```

## Просмотр баланса
```php
echo $st->balance();
```

## Выгрузка тарифов
```php
echo $st->tariffs();
```

## Выгрузка статистики
```php
$st->statistic()->start('02.02.2020 10:00')->end('03.03.2020 10:00')->get();
```
Для выгрузки детальной статистики необходимо указать метод `detail()`;

```php
$st->statistic()->start('02.02.2020 10:00')->end('03.03.2020 10:00')->detail()->get();
```

В ответ придёт ID отчёта.

**Необязательные методы для детальной статистики:**

`state()` - Формирование статистики по определенному статусу сообщений.  Допустимые значения deliver, not_deliver, expired, sent  (доставлено, не доставлено, просрочено, в процессе).

`phone()` - Формирование статистики по определенному номеру абонента.

`cBase()` - Указывает на необходимость выгрузки данных с привязкой к базе адресатов.

`subStat()` - Указывает на необходимость выгрузки данных с подлогинов.

`typeLoad()` - Выбор формата отчета. Допустимые значения: 0, 1 (0 -csv по умолчанию, 1 -xls)

```php
$st->statistic()
->start('02.02.2020 10:00')
->end('03.03.2020 10:00')
->detail()
->state('not_deliver')
->phone(79111234567)
->cBase()
->subStat()
->typeLoad(1)
->get();
```

## HLR
Отправка HLR-запроса
```php
$st->hlr()->phone(7912345678)->get()
```
В ответ придёт идентификатор сообщения.

Получение статуса HLR-запроса
```php
$st->hlr()->status(123456789101213);
```

## СМС
Отправка СМС-сообщения 
```php
$st->sms()->send()->text('text message')->to(['+79123456789', 79123456789, '+7(912)-345-67-89'])->get();
```
Отправка сообщений нескольким адресатам с разным текстом.
```php
$phones_array  = [
    '+79123456789',
    79123456789,
    '+7(912)-345-67-89',
];

$phones_array2 = [79987654321];

$st->sms()->send()
    ->package(static function ($s) use ($phones_array) {
        $s->text('test')->to($phones_array);
    })
    ->package(static function ($s) use ($phones_array2) {
        $s->text('test2')->to($phones_array2);
    })
    ->get();
```
Получение статуса СМС сообщения
```php
$st->sms()->status(14561456165332);
```
Получение входящих СМС сообщений
```php
$st->sms()->incoming()->start('29.01.2020 13:00')->end('30.01.2020 13:00')->get();
```

## Email
### Работа с базами
Получение списка баз
```php
$st->email()->list()->method('get')->listId(123)->get();
```
Добавление адресной базы
```php
$st->email()->list()->method('add')->name('TestBase')->abuseEmail('usermail@mail.com')->abuseName('OwnerName')->company('CompanyName')->address('MyAddress')->city('Spb')->zip(190000)->county('Russia')->url('mysite.com')->phone(79999999999)->get();
```
Обновление контактной информации адресной базы
```php
$st->email()->list()->method('update')->listId(123)->name('TestBase')->abuseEmail('usermail@mail.com')->abuseName('OwnerName')->company('CompanyName')->address('MyAddress')->city('Spb')->zip(190000)->county('Russia')->url('mysite.com')->phone(79999999999)->get();
```
Удаление адресной базы
```php
$st->email()->list()->method('delete')->listId(123)->get();
```
Получение списка подписчиков с возможностью фильтрации и регулировки выдачи
```php
$st->email()->list()->method('get_members')->listId(123)->state('active')->limit(1)->get();
```
Импортирование подписчиков из файла
```php
$st->email()->list()->method('upload')->listId(123)->file('http://www.mysite.ru/files/file.csv')->type('csv')->get();
```
Добавление одного подписчика в базу
```php
$st->email()->list()->method('add_member')->listId(123)->email('testuser@mail.com')->merge(1, 'Иван')->merge(2, 'Иванов')->merge(3, '1985-11-23')->gender('m')->get();
```
Редактирование данных подписчика
```php
$st->email()->list()->method('update_member')->memberId(123)->merge(1, 'Иван')->merge(2, 'Иванов')->merge(3, '1985-11-23')->gender('m')->get();
```
Удаление подписчика из базы
```php
$st->email()->list()->method('delete_member')->memberId(123)->get();
```
Отписка подписчика из базы
```php
$st->email()->list()->method('unsubscribe_member')->memberId(123)->listId(123)->email('testuser@mail.com')->reason('Отписка по заявке')->get();
```
## Viber
## VK