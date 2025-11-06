# Elementor Custom Conditions

Кастомные условия отображения для Elementor Theme Builder.

## Возможности

- **Page Template Condition** - условие для выбора Page Template темы.

## Требования

- WordPress 5.8+
- PHP 8.2+
- Elementor 3.0+
- Elementor Pro

## Установка

### Из релиза

1. Скачайте zip из [Releases](https://github.com/yarops/elementarno-custom-conditions/releases)
2. Распакуйте в `/wp-content/plugins/`
3. Активируйте плагин

### Из исходников (для разработки)

1. Клонируйте в `/wp-content/plugins/`
2. Активируйте плагин

## Использование

1. Перейдите в **Templates → Theme Builder**.
2. Создайте или отредактируйте шаблон.
3. В **Display Conditions** выберите условие **"Page Template"**.
4. Выберите нужный шаблон страницы.
5. Сохраните.

## Разработка

```bash
# Установка зависимостей.
composer install

# Проверка кода.
composer check

# Исправление ошибок.
composer fix
```

## Создание релиза

1. Создайте тег: `git tag v1.0.0`
2. Отправьте тег: `git push origin v1.0.0`
3. GitHub Actions автоматически создаст релиз с готовым zip-архивом

