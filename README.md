# Тестовое задание

<!-- TOC -->
* [Тестовое задание](#тестовое-задание)
  * [Описание задания](#описание-задания)
  * [Описание решения](#описание-решения)
    * [Маршруты:](#маршруты)
<!-- TOC -->

## Описание задания

1. Написать собственную команду artisan, которая очищает записи одной таблицы, добавленные более недели назад и без
   записей в сводной таблице. Команда должна автоматически запускаться каждый день в 12:00 с использованием планировщика
   задач (Scheduler). Дополнительно команда регистрирует в лог информацию о времени начала и окончания выполнения.
2. Добавить слушателя для модели. При создании или обновлении объекта его свойство `active` устанавливается в `false`. В
   случае если у пользователя недостаточно прав для создания объекта, генерируется и выбрасывается собственное
   исключение.
3. Создать и зарегистрировать собственного ServiceProvider.
4. Разработка системы авторизации с использованием файла `json` для хранения и проверки учетных данных пользователей.

## Описание решения

Задание реализовано на примере сущностей «Объявление» ([Advertisement](app/Models/Advertisement.php)) и
«Ставка» ([Bid](app/Models/Bid.php)). Сущности связаны отношением «Один ко многим» («Объявление» может иметь много
«Ставок»).

Вся логика работы с сущностями размещается в сервисах (App\Services), которые обёрнуты фасадами (для возможности
макапов).

1. Реализована команда `advertisements:delete-old`, которая удаляет объявления, созданные более недели назад и не
   имеющие ставок.
   [\[Код команды\]](app/Console/Commands/AdvertisementsDeleteOldCommand.php), [\[код сервиса\]](app/Services/AdvertisementCleanerService.php).
2. Реализован слушатель
   событий [\[UnPublishAdvertisementOnModificationListener\]](app/Listeners/UnPublishAdvertisementOnModificationListener.php),
   который при создании или обновлении объявления устанавливает его свойство `active` в `false`.
   Слушатель подписан на
   событие [\[AdvertisementCreatingOrUpdatingEvent\]](app/Events/AdvertisementCreatingOrUpdatingEvent.php), которое
   вызывается при изменении объекта сущности с помощью
   наблюдателя [\[AdvertisementObserver\]](app/Observers/AdvertisementObserver.php).
   Реализована логика, при которой запрещено создавать ставку на неактивное объявление. Для этого в
   сервисе [\[BidService\]](app/Services/BidService.php) реализована проверка активности объявления.
3. Реализован собственный [\[DomainServiceProvider\]](app/Providers/DomainServiceProvider.php), который регистрирует
   фасады для сервисов.
4. Пользователи хранятся статично в файле [\[users.json\]](users.json). Для поиска по пользователям
   реализован [\[UserRepository\]](app/Repositories/UserRepository.php).
   Для авторизации пользователей реализован [\[AuthService\]](app/Services/AuthService.php). Для проверки Bearer токена
   реализован [\[AuthenticationMiddleware\]](app/Http/Middleware/AuthenticationMiddleware.php).

### Маршруты:

Сгенерированы схемы для тестирования API в
[\[Postman\]](api.postman.json) / [\[RapidAPI\]](api.paw) / [\[Swagger 2\]](api.swagger2.json).

| Метод  | URI                               | Описание                                                      |
|--------|-----------------------------------|---------------------------------------------------------------|
|        | **Авторизация**                   |                                                               |
| POST   | /api/login                        | Авторизация                                                   |
|        | **Объявления**                    |                                                               |
| GET    | /api/advertisements               | Получить список объявлений                                    |
| POST   | /api/advertisements               | Создать объявление                                            |
| GET    | /api/advertisements/{id}          | Получить объявление (доступно только для активных объявлений) |
| GET    | /api/advertisements/{id}/activate | Активировать объявление (для тестирования)                    |
| PUT    | /api/advertisements/{id}          | Обновить объявление                                           |
| DELETE | /api/advertisements/{id}          | Удалить объявление                                            |
|        | **Ставки**                        |                                                               |
| GET    | /api/bids                         | Получить список ставок                                        |
| POST   | /api/bids                         | Создать ставку                                                |
| GET    | /api/bids/{id}                    | Получить свою ставку                                          |
