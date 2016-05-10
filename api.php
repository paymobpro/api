<?
/*
 * Описание интерфейса, который должен реализовать партнер для приема асинхронных уведомлений от платформы.
 * Каждый метод интерфейса должен вернуть значение request_id с целью уведомления платформы, что данные приняты и обработаны.
 * Используемый протокол : JSON-RPC . Все запросы и ответы формируюстя в соответствии со споецификацией проткола.
 *
 */
interface PayMobNotify {

    /**
     * Handle : параметр партнера. Используется для сопоставления вызовов API и идентификатора посетителя на сайте партнера, которым этот вызов относится.
     * Идентификатор передается при отправке трафика, либо при запросе информации о подписке, сохраняется на стороне платформы и в дальнейшем передается
     * во всех уведомлениях от платформы к партнеру.
     */


    /**
     * OnSubscribeStart : извещение о попытке инициации подписки
     * @param int $request_id идентификатор трансакции
     * @param int $subscribe_id идентификатор подописки
     * @param int $replace_id идентификатор заменяемой подписки
     * @param int $client телефон абонента
     * @param int $goods_id идентификатор товара
     * @param string $handle параметр партнера
     * @return int
     */
    public function OnSubscribeStart(int $request_id, int $subscribe_id, int $replace_id, int $client, int $goods_id, string $handle );

    /**
     * OnSubscribeActivate : уведомление об успешной активации подписки
     * @param int $request_id идентификатор трансакции
     * @param int $subscribe_id идентификатор подписки
     * @param string $handle параметр партнера
     * @return int
     */
    public function OnSubscribeActivate(int $request_id, int $subscribe_id, string $handle );

    /** OnSubscribeNotify : уведомление об успешном плановом списании.
     * @param int $request_id
     * @param int $subscribe_id
     * @param float $sum : сумма списания
     * @param int $pay_time : дата списания в формате unixtime/UTC
     * @param string $handle
     * @return int
     */
    public function OnSubscribeNotify(int $request_id, int $subscribe_id, float $sum, int $pay_time, string $handle);

    /**
     * OnSubscribeSuspend : уведомление о неуспешном списании
     * @param int $request_id
     * @param int $subscribe_id
     * @param int $pay_time : дата операции
     * @param int $next_pay_time : дата следующей попытки
     * @param string $handle
     * @return int
     */
    public function OnSubscribeSuspend(int $request_id, int $subscribe_id, int $pay_time, int $next_pay_time, string $handle);

    /**
     * OnSubscribeCancel : уведомление об отмене подписки
     * @param int $request_id
     * @param int $subscribe_id
     * @param int $code : код отмены
     * @param string $message : текстовая расшифровка кода отмены
     * @param string $handle
     * @return int
     */
    public function OnSubscribeCancel(int $request_id, int $subscribe_id, int $code, string $message, string $handle);

    /**
     * OnSubscribeNotice : уведомление об ошибках при выполнении операций
     * @param int $request_id
     * @param int $subscribe_id
     * @param int $transaction_id : идентификатор запроса (см API запросов)
     * @param int $code : код ошибки
     * @param string $message : текстовая расшифровка кода.
     * @return int
     *
     *
     * Данное API будет использоваться так же и для других типов подписок (SMS). Описание кодов включает и информацию
     * для других типов. Которая на данный момент может быть проигноирована.
     * 
    * Коды операций
    * 0 Операция успешна.
    * 2501 Неверное количество параметров Шаблона СМС.
    * 2502 Достигнут предел количества отправленных Абоненту СМС в промежуток времени.
    * 2503 Услуга недоступна абонентам данного Оператора.
    * 2504 Подписка не найдена.
    * 2505 Абонент уже подписан на данный Услугу.
    * 2506 Невозможно произвести действия с Подпиской по причине её закрытия.
    * 2507 Ошибка в указании периода действия Подписки.
    * 2508 Запрос на Подписку закрыт по причине акцепции Абонентом другого запроса на эту же Услугу.
    * 2509 Невозможно идентифицировать Товар ( данного Товара не существует ).
    * 2510 Подписка закрыта по причине истечения времени ожидания подтверждения Абонента.
    * 2511 Подписка закрыта по причине отказа Абонентом.
    * 2512 Подписка закрыта по инициативе Предприятия.
    * 2513 Подписка закрыта Системой.
    * 2514 Подписка закрыта Оператором.
    * 2515 Подписка закрыта путём команды от Абонентом через СМС.
    * 2516 Подписка закрыта по причине невозможности осуществить первоначальное списание.
    * 2517 Подписка закрыта по причине прекращения срока действия.
    * 2518 Подписка закрыта по причине истечения кол-ва попыток подтверждения кодом.
    * 2519 Подписка закрыта по причине отказа Абонента от услуги через форму Widget.
    * 2531 Неверный код подтверждения Подписки.
    * 2532 Повторное обращение.
    * 2533 У данного абонента нет подписок в стадии ожидания подтверждения.
*/
    public function OnSubscribeNotice(int $request_id, int $subscribe_id, int $transaction_id, int $code, string $message );

    /**
     * OnSubscribeStat : сообщает информацию о подписке. Для инциаилизации необходимо вызвать SubscribeStat
     * @param int $request_id
     * @param Array $info

    * "client_id":"79268638461" телефон абонента
    * "subscribe_id":"1234567890" идентификатор подписки
    * "goods_id":"1" идентификатор товара
    * "amount":"100" сумма последней трансакции
    * "amount_made":"100" сумма всех трансакций
    * "next_repay":"123123213" дата следующего ребилла. unixtime/UTC
    * "till":"123123213" дата окончания подписки. unixtime/UTC
    * "repay_expected":"6" ожидаемое количество ребиллов
    * "repay_made":"1" реально сделанное количество ребиллов
    * "repay_missed":"0" количество неуспешных ребиллов
    * "stage":"active" статус подписки
    * "repay_stage":"auth" статус ребилла
    * "result":"0" код операции подписки
    * "repay_result":"0" код операции ребилла
    * "closed":"f"

     * @param string $handle
     * @return int
     */
    public function OnSubscribeStat(int $request_id, Array $info, string $handle);
}


/*
 * используется партнером для вызовов методов на стороне платформы.
 * URL JSON-RPC сервера на стороне системы : https://paymob.pro/api
 */

class PayMob {


    /**
     * GetWMCProductLink : возвращает шаблон урла для отправки посетителя по протоколу WapClick Mobile Commerce (WMC)
     * @param string $auth : код авторизации клиента. Получается в админке PayMob.pro
     * @param int $product_id : идентификатор продукта.
     * @return string : "http://product_id/?handle=%HANDLE%" возвратит URL для отправки трафика. В позиции для указания
     *                  хендла посетителя будет помещена строка %HANDLE%. Ее необходимо будет заменить на реальный
     *                  идентификатор посетителя при отправке трафика.
     */
    public function GetWMCProductLink (string $auth, int $product_id)
    {
        return ""; //URL либо throw Exception в случае ошибки.
    }

    /**
     * GetSubscribeStatAsync : запрашивает информацию о подписке. Данные прийдут в OnSubscribeStat.
     * @param string $auth
     * @param int $subscribe_id : идентификатор подписки.
     * @return int : возвращает идентификатор запроса. Он будет первым параметром в OnSubscribeStat, для сопоставления
     * вызова и ответа.
     */
    public function GetSubscribeStatAsync (string $auth, int $subscribe_id)
    {
        $request_id = (int) 11111;
        return $request_id;
    }
}
