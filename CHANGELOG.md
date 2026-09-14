# Changelog

### V5.0.0

- support Filament v5 and Laravel 12 / 13 (the Filament v4 line continues on the `v4` branch)
- fix the `NotificationAction` table action loading templates through a test-only model class
- fix `NotificationsTemplateActions`, `NotificationsTemplateHeaderActions` and `NotificationsTemplateBulkActions::register()` rejecting `Filament\Actions\*` actions
- fix the infolist class in `config/filament-alerts.php` so it autoloads on case-sensitive file systems
- fix sending a notification by template key throwing a `TypeError`
- ship a `NotificationsTemplate` model factory
- add regression tests, install command tests and a phpstan config
