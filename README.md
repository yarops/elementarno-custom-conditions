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

1. Скопируйте папку плагина в `/wp-content/plugins/`
2. Установите зависимости: `composer install --no-dev`
3. Активируйте плагин в меню "Плагины"

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

