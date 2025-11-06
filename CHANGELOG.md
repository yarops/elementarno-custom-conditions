# Changelog

Все значимые изменения в проекте будут документированы в этом файле.

Формат основан на [Keep a Changelog](https://keepachangelog.com/ru/1.0.0/),
и этот проект придерживается [Semantic Versioning](https://semver.org/lang/ru/).

## [1.0.0] - 2025-11-06

### Добавлено
- Первый релиз плагина
- Кастомное условие "Page Template" для Elementor Theme Builder
- Автоматическое определение всех Page Templates из активной темы
- Поддержка Default Template (страницы без шаблона)
- PSR-4 autoloading через Composer
- Illuminate Container для Dependency Injection
- Инструменты качества кода:
  - PHPStan 2.1 для статического анализа
  - PHP_CodeSniffer 3.13 с WordPress Coding Standards
  - PHPStan WordPress расширения
- Конфигурационные файлы:
  - `phpcs.xml.dist` для PHPCS
  - `phpstan.neon.dist` для PHPStan
  - `composer.json` с необходимыми зависимостями
- Composer скрипты для проверки кода (`check`, `phpcs`, `phpstan`, `fix`)
- Фильтр `elementarno_page_templates` для расширения списка шаблонов
- Полная документация в README.md

### Требования
- WordPress 5.8+
- PHP 8.2+
- Elementor 3.0.0+
- Elementor Pro

[1.0.0]: https://github.com/yarops/elementarno-custom-conditions/releases/tag/v1.0.0

