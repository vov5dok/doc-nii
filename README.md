# mgek



## Getting started

To make it easy for you to get started with GitLab, here's a list of recommended next steps.

Already a pro? Just edit this README.md and make it your own. Want to make it easy? [Use the template at the bottom](#editing-this-readme)!

## Add your files

- [ ] [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
- [ ] [Add files using the command line](https://docs.gitlab.com/ee/gitlab-basics/add-file.html#add-a-file-using-the-command-line) or push an existing Git repository with the following command:

```
cd existing_repo
git remote add origin http://git2.niioz.ru/GoldinEA/mgek.git
git branch -M main
git push -uf origin main
```
## Использованные пакеты

- [ ] [Laravel Sail](https://laravel.com/docs/9.x/sail) для разработки локально. (необходимы также WSL и Docker)
- [ ] [MoonShine](https://moonshine.cutcode.ru/) Панель администратора (openSource проект).
- [ ] [Seotools](https://github.com/artesaos/seotools) Использована для SEO.

## Команды artisan для администрирования:
- [ ] Активация пользователя (по email):
```
php artisan user:activate {email}
```


## Разворачивание тестового стенда (для локальной разработки и тестирования)
### Внимание: для разворачивания тестового стенда (для локальной разработки) на компьютере уже должны быть установлены WSL и Docker.

1. Открыть в терминале WSL папку проекта.
2. Для удобства присваиваем alias.
```
   alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
3. Переименовываем файл .env.localdevelop в .env .
4. Запускаем процесс разворачивания процесса docker окружения.
```
    sail up -d
```
5. Устанавливаем все зависимости composer.
```
    sail composer install
```
7. Устанавливаем npm и все пакеты, производим компиляцию фронта.
   (в режиме разработки фронт не собирать - админпанель работать не будет - это известный баг их пакета)
```
    sail npm install
    sail npm run build
```
8. Применяем все миграции.
```
    sail artisan migrate
```
9. Создаем нового пользователя.
```
    php artisan moonshine:user
```

Далее стенд фактически готов к работе. 
Сайт доступен по адресу http://localhost/ .
Тестирование почтовых сообщений доступно в http://localhost:8025/ .
Xdebug также доступен сразу же из коробки.
