# Reporting в google analytics

Для целей оптимизации закупок и анализа эффективности система поддерживает репортинг статистики в Google Analytics. Откуда партнер посредством PostBack (средство GA) может осуществить выгрузку в любую другую систему.

## Описание

Система поддерживает следующие utm-теги : 
- utm_medium
- utm_source
- utm_campaign
- utm_content
- utm_term

Пометка пользователя осуществляется на уровне подписки. Тот же пользователь при следующей подписке = новый пользователь.
Ребиллы и последующие события ассоциированные с подпиской записываются на пользователя-подписку.
Анализ собыитй по каждой подписке можно просмотреть Audience/User Explorer в GA

Информация отправляемая о пользователях : 

- идентификатор клиента. Имеет следующий формат : $subscription_id.$tracking_id, Где subscription_id - идентификатор подписки платформы.  tracking_id - идентификатор трекинга клиента.
- User-agent
- User language (первый в списке)
- User IP



Система группирует статистику посредством Custom Dimensions для продукта, лендинга, оператора и партнера. Для корректной работы необходимо настроить Custom Dimensions в трекере (см скриншоты настройки)

Товар в рамках Enhanced ECommerce  GA обозначает лендинг. Просмотр товара - визит лендинга. Покупка - подписка на лендинге.


Именование операторов : beeline, megafon, tele2, mts, unkown_op 

Именование товара : 
-- Код товара (SKU) : Subs/operator/product_id/landing_id
-- Имя товара : Subs/operator/ProductName/LandingName

Транзакции : 
Все подписки и ребиллы отправляются в виде транзакций в GA. 
Transaction revenue отправляется как _фактическая_ сумма списаинй, а не доход партнера либо системы. Данное правило может быть изменено в будущем.
Transaction Id : 
S.$subscription_id.$bill_id для подписки.
R.$subscription_id.$bill_id для ребилла.
subscription_id - идентификатор подписки в платформе.
bill_id - идентификатор списания в платформе.



## События

### In  

Формируется при переходе пользователя на in-url системы. Это событие подразумевает корректную работу лендинга и апстрима. В рамках этого события формируется следующие события в GA : 
- Событие operations/in
- Просмотр товара со следующими характеристиками : 
-- Заголовок страницы : Subs/operator/ProductName/LandingName - для удобной идентификации в отчетах
-- URL страницы : /in/operator/landing_id
События "просмотр продукта" используются для формирования показателя "коэффициент конверсии продукта" в отчетах.

### Subscription

Формируется при подтверждении подписки (событие OnSubscribeActivate)
- Событие operations/subscribe
- действие "paymenet" для продукта (см. In) 

### Cancel

Формируется при отказе пользователя от подписки. 
- Событие operations/cancel

### Rebill 
Учет не реализован

### Suspend

Формируется при невозможности списания с пользователя.
- Событие operations/suspend


## Настройка

### Step1
![Step1](https://raw.githubusercontent.com/paymobpro/api/master/img/step1.png "Step 1")

### Step2
![Step2](https://raw.githubusercontent.com/paymobpro/api/master/img/step2.png "Step 2")

### Step3
![Step3](https://raw.githubusercontent.com/paymobpro/api/master/img/step3.png "Step 3")

### Step4
![Step4](https://raw.githubusercontent.com/paymobpro/api/master/img/step4.png "Step 4")

### Step5
![Step5](https://raw.githubusercontent.com/paymobpro/api/master/img/step5.png "Step 5")

### Step6
![Step6](https://raw.githubusercontent.com/paymobpro/api/master/img/step6.png "Step 6")

### Step7
- Заполнить в настройках продукта Tracker-id
- Заполнить в настройках продукта идентификаторы custom dimensions для продукта, оператора и т.д. Обратите внимание, что после создания Google не рекомендует их менять.
