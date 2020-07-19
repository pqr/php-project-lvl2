# Вычислитель отличий

<a href="https://codeclimate.com/github/pqr/php-project-lvl2/maintainability"><img src="https://api.codeclimate.com/v1/badges/0e399c0f5027ebd3d459/maintainability" /></a>
<a href="https://codeclimate.com/github/pqr/php-project-lvl2/test_coverage"><img src="https://api.codeclimate.com/v1/badges/0e399c0f5027ebd3d459/test_coverage" /></a>
<a href="https://github.com/pqr/php-project-lvl2/actions"><img src="https://github.com/pqr/php-project-lvl2/workflows/lint/badge.svg"></a>

Учебный проект Хекслет. Консольная утилита, вычисляет и отображает различия между файлами в формате JSON или YAML.

## Установка

```
composer global require pqr/php-project-lvl2
```

## Использование

Вывести справку по возможным командам и опциям
```
gendiff --help
```

Сравнить JSON файлы:
```
gendiff 1.json 2.json
```

Сравнить YAML файлы:
```
gendiff 1.yml 2.yml
```

Сравнить JSON файлы и вывести в результат в простом текстовом виде:
```
gendiff --format=plain 1.json 2.json
```

Сравнить JSON файлы и вывести в результат в структурированном JSON (удобно для обработки сторонним приложением):
```
gendiff --format=json 1.json 2.json
```

## Пример использоваения

[![asciicast](https://asciinema.org/a/pthp3fmcRh5lD85YzAzvoTdnd.svg)](https://asciinema.org/a/pthp3fmcRh5lD85YzAzvoTdnd)
