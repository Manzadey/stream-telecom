<?php

namespace Manzadey\StreamTelecom;

class Constants
{
    public const SERVER_REST = 'https://gateway.api.sc/rest/';
    public const SERVER_EMAIL = 'http://api.streamemail.ru/';
    public const SERVER_VK = 'https://gateway.api.sc/rest/Send/SendIM/VKNotify/';

    public const URI_STATUS_MESSAGE = 'State/state.php';
    public const URI_SEND_HLR = 'Send/SendHLR/';
    public const URI_STATE_HLR = 'State/HLR/';
    public const URI_STATISTIC = 'Statistic';
    public const URI_STATISTIC_DETAIL = 'Statistic/all_stat.php';
    public const URI_BALANCE = 'Balance/balance.php';
    public const URI_TARIFFS = 'Balance/price_list.php';
    public const URI_SMS_INCOMING = 'Incoming';
    public const URI_VIBER_SEND = 'Send/SendIM/ViberOne/';
    public const UTI_VIBER_STATUS = 'State/Viber/';

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
}
