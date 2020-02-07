<?php

namespace Manzadey\StreamTelecom;

class Constants
{
    public const SERVER_REST = 'https://gateway.api.sc/rest/';
    public const SERVER_EMAIL = 'http://api.streamemail.ru/';

    public const VIBER_SOURCE = 'NAVIGATOR';

    public const URI_SESSION = 'Session/';
    public const URI_STATUS_MESSAGE = 'State/state.php';
    public const URI_SEND_HLR = 'Send/SendHLR/';
    public const URI_STATE_HLR = 'State/HLR/';
    public const URI_STATISTIC = 'Statistic';
    public const URI_STATISTIC_DETAIL = 'Statistic/all_stat.php';
    public const URI_BALANCE = 'Balance/balance.php';
    public const URI_TARIFFS = 'Balance/price_list.php';
    public const URI_SMS_INCOMING = 'Incoming';
    public const URI_VIBER_SEND = 'Send/SendIM/ViberOne/';
    public const URI_VIBER_STATUS = 'State/Viber/';
    public const URI_VIBER_BULK = 'Send/SendIM/ViberBulk/';
    public const URI_VK_SEND = 'Send/SendIM/VKNotify/';

    public const QUERY_SIMPLE = [
        'uri'   => 'Send/SendSms/',
        'query' => 'destinationAddress',
    ];
    public const QUERY_MULTIPLE = [
        'uri'   => 'Send/SendBulk/',
        'query' => 'destinationAddresses',
    ];
    public const QUERY_MULTIPLE_PACKET = 'Send/SendBulkPacket/';

    public const MESSAGE_ID = 'message_id';

    public const MESSAGE_STATUSES = [
        -1  => 'Отправлено (передано в мобильную сеть)',
        0   => 'Доставлено абоненту',
        42  => 'Не доставлено',
        46  => 'Просрочено (истек срок жизни сообщения)',
        255 => 'Недоступно (статус в архиве/нет доступа к статусу)',
    ];

    public const HLR_STATUSES = [
        -1 => 'Номер находится в процессе проверки',
        0  => 'Абонент доступен',
        42 => 'Абонент недоступен',
    ];

    public const HLR_ERRORS = [
        '0x030000' => 'Абонент доступен',
        '0x030100' => 'Абонент не найден',
        '0x0301FF' => 'Абонент не найден',
        '0x030B00' => 'Телекоммуникационный сервис не предоставляется',
        '0x030BFF' => 'Телекоммуникационный сервис не предоставляется',
        '0x030D00' => 'Вызов запрещен',
        '0x030DFF' => 'Вызов запрещен',
        '0x031B00' => 'Абонент не доступен',
        '0x031BFF' => 'Абонент не доступен',
        '0x03FA00' => 'Истек таймаут ожидания ответа',
        '0x03FB00' => 'Истек таймаут ожидания ответа',
        '0x03FE00' => 'Отсутствует ответ телефонной части',
        '0x03FF00' => 'Истек таймаут ожидания ответа',
        '0x03FFFB' => 'Истек таймаут ожидания ответа',
        '0x0323FF' => 'Отсутствие данных',
        '0x032400' => 'Отсутствие данных',
    ];

    public const VIBER_STATUSES = [
        'delivered'   => 'Доставлено',
        'undelivered' => 'Не доставлено',
        'sent'        => 'Отправлено',
        'read'        => 'Прочитано',
        'expired'     => 'Просрочено',
    ];

    public const VIBER_ERRORS = [
        'user-blocked'      => 'Абонент заблокирован',
        'not-viber-user'    => 'Абонент не является пользователем Viber',
        'filtered'          => 'Сообщение не соответствует ни одному зарегистрированному шаблону',
    ];

    public const EMAIL_MERGE_MAX = 10;

    public const EMAIL_METHODS = [
        'lists.add',
        'lists.update',
        'lists.get',
        'lists.delete',
        'lists.get_members',
        'lists.upload',
        'lists.add_member',
        'lists.add_member_batch',
        'lists.update_member',
        'lists.delete_member',
        'lists.unsubscribe_member',
        'lists.move_member',
        'lists.copy_member',
        'lists.add_merge',
        'lists.update_merge',
        'lists.delete_merge',
        'lists.get_import_result',
        'campaigns.get',
        'campaigns.create',
        'campaigns.update',
        'campaigns.create_auto',
        'campaigns.update_auto',
        'campaigns.delete',
        'campaigns.attach',
        'campaigns.get_attachments',
        'campaigns.delete_attachment',
        'campaigns.get_templates',
        'campaigns.add_template',
        'campaigns.delete_template',
        'campaigns.force_auto',
        'reports.sent',
        'reports.delivered',
        'reports.opened',
        'reports.unsubscribed',
        'reports.bounced',
        'reports.clickstat',
        'reports.bouncestat',
        'reports.summary',
        'reports.clients',
        'reports.geo',
    ];

    public const PRICE_RUS = [
        'РОССИЯ, Russia',
        'МТС',
        'Мегафон',
        'СМАРТС',
        'Скартелл (YOTA)',
        'ТЕЛЕ2',
        'Билайн',
    ];
}
