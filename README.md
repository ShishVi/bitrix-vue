
# Компонент Битрикс для вывода новостей через AJAX и VUE.js

Этот проект включает в себя разработку пользовательского компонента Битрикс, который предназначен для вывода новостей с использованием AJAX-запросов, инициированных компонентом VUE.js.

## Начало работы

Чтобы начать работу с этим компонентом, вам необходимо иметь установленный Битрикс и базовые знания работы с VUE.js.

### Установка

Для установки компонента следуйте следующим шагам:
Склонируйте репозиторий в папку `/local/components/` вашего сайта на Битриксе.

### Как это работает

Компонент использует VUE.js для создания динамического интерфейса пользователя, через который отправляются AJAX-запросы к серверу Битрикс для получения новостей. Вся логика обработки запросов и возвращения данных для новостей реализована внутри компонента Битрикс.

### По заданию

1. <?php
2.    include('includes/db.php');
3.    $login = $_POST['login'];
4.    $password = $_POST['password'];
5.    $count = mysqli_query($connection, "SEL ECT * FR OM users WHERE login = '$login' AND `password`= '$password'");
6.    if (mysqli_num_rows($count) == 0 )
7.    {
8.        header("Location: /user_mode.php", 3000);
9.    } else
10.   {
11.       header("Location: /user.php", 3000);
12    }
13 ?>


# Проблемы и ошибки в PHP-коде

В приведённом PHP-коде были обнаружены следующие ошибки и проблемы:

## 1. Небезопасное включение файла

Использование `include('includes/db.php');` (строка 2) без предварительной проверки на наличие файла или без использования абсолютного пути может привести к ошибкам. Лучше использовать `require_once` с абсолютными путями.

## 2. Уязвимость для SQL-инъекций

Прямая передача переменных `$login` и `$password` в SQL-запрос (строка 5) без предварительной очистки или использования подготовленных выражений уязвима для SQL-инъекций.

## 3. Ошибки в синтаксисе SQL-запроса

В запросе `SEL ECT * FR OM users` (строка 5) присутствуют лишние пробелы, что делает запрос невалидным. Правильно: `SELECT * FROM`.

## 4. Небезопасное хранение паролей

Сравнение паролей в исходном виде (строка 5) не является безопасной практикой. Рекомендуется использование хэширования.

## 5. Проблемы с обработкой ошибок

Отсутствует явная обработка ошибок для `mysqli_query` (строка 5).

## 6. Некорректное использование функции header

Использование `header("Location: /user_mode.php", 3000);` (строка 8) и `header("Location: /user.php", 3000);` (строка 11) с неверным кодом ответа верный редирект header("Location: /user_mode.php").

## 7. Отсутствует фильтрация ввода

Переменные из `$_POST` используются без валидации (строки 3 и 4).

## 8. Отсутствует проверка на существование `$_POST` переменных

Необходима проверка перед использованием переменных из `$_POST` (строки 3 и 4).


