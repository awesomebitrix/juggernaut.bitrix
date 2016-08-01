<?php

namespace Jugger\Ui\Hermitage;

/**
 * Список CSS классов иконок
 */
abstract class Icon
{
    /*
     * Контекстное меню (публичка)
     */
    const TOOLBAR_DELETE =      'bx-context-toolbar-delete-icon';
    const TOOLBAR_SETTINGS =    'bx-context-toolbar-settings-icon';
    const TOOLBAR_CREATE =      'bx-context-toolbar-create-icon';
    const TOOLBAR_EDIT =        'bx-context-toolbar-edit-icon';
    const TOOLBAR_DRAG =        'bx-context-toolbar-drag-icon';
    const TOOLBAR_BUTTON =      'bx-context-toolbar-button-icon';
    /*
     * Верхная административная панель (публичка)
     */
    const PANEL_SEO =               'bx-panel-seo-icon';
    const PANEL_STATISTICS =        'bx-panel-statistics-icon';
    const PANEL_SHORT_URL =         'bx-panel-short-url-icon';
    const PANEL_STICKERS =          'bx-panel-stickers-icon';
    const PANEL_STIKERS_SMALL =     'bx-panel-small-stickers-icon';
    const PANEL_SITE_WIZARD =       'bx-panel-site-wizard-icon';
    const PANEL_SITE_TEMPLATE =     'bx-panel-site-template-icon';
    const PANEL_SITE_STRUCTURE =    'bx-panel-site-structure-icon';
    const PANEL_PERFORMANCE =       'bx-panel-performance-icon';
    const PANEL_COMPONENTS =        'bx-panel-components-icon';
    const PANEL_CREATE_PAGE =       'bx-panel-create-page-icon';
    const PANEL_CREATE_SECTION =    'bx-panel-create-section-icon';
    const PANEL_EDIT_PAGE =         'bx-panel-edit-page-icon';
    const PANEL_EDIT_SECTION =      'bx-panel-edit-section-icon';
    const PANEL_EDIT_SECRET_PAGE =  'bx-panel-edit-secret-page-icon';
    const PANEL_EDIT_SECRET_SECTION='bx-panel-edit-secret-section-icon';
    const PANEL_REFRESH =           'bx-panel-clear-cache-icon';
    const PANEL_INSTALL_SOLUTION =  'bx-panel-install-solution-icon';
    const PANEL_MORE_BUTTON =       'bx-panel-more-button-icon';
    const PANEL_MENU =              'bx-panel-menu-icon';
    const PANEL_TRANSLATE =         'bx-panel-translate-icon';
    const PANEL_REINDEX =           'bx-panel-reindex-icon';
    const PANEL_IBLOCK =            'bx-panel-iblock-icon';
    /*
     * Административный интерфейс
     */
    const MENU_FAV = "fav_menu_icon ";
    const MENU_FAV_YELLOW = "fav_menu_icon_yellow ";
    
    const MENU_IBLOCKS = "iblock_menu_icon_iblocks ";
    const MENU_IBLOCK_TYPES = "iblock_menu_icon_types ";
    const MENU_IBLOCK_SETTINGS = "iblock_menu_icon_settings ";
    const MENU_IBLOCK_SECTIONS = "iblock_menu_icon_sections ";
    
    const MENU_FILEMAN = "fileman_menu_icon ";
    const MENU_FILEMAN_STICKER = "fileman_sticker_icon ";
    const MENU_FILEMAN_SECTIONS = "fileman_menu_icon_sections,";
    
    const MENU_CLOUDS = "clouds_menu_icon ";
    const MENU_CLOUD_BITRIX = "bitrixcloud_menu_icon ";
    
    const MENU_SALE = "sale_menu_icon ";
    const MENU_SALE_CRM = "sale_menu_icon_crm ";
    const MENU_SALE_STORE = "sale_menu_icon_store ";
    const MENU_SALE_ORDERS = "sale_menu_icon_orders ";
    const MENU_SALE_BUYERS = "sale_menu_icon_buyers ";
    const MENU_SALE_BIGDATA = "sale_menu_icon_bigdata";
    const MENU_SALE_CATALOG = "sale_menu_icon_catalog";
    const MENU_SALE_STATISTIC = "sale_menu_icon_statistic";
    const MENU_SALE_AFFILIATE = "sale_menu_icon_buyers_affiliate";
    
    const MENU_UPDATE = "update_menu_icon ";
    const MENU_UPDATE_PARTNER = "update_menu_icon_partner ";
    const MENU_UPDATE_MARKETPLACE = "update_marketplace ";
    const MENU_UPDATE_MARKETPLACE_MODULES = "update_marketplace_modules ";
    
    const MENU_USER = "user_menu_icon ";
    const MENU_SEARCH = "search_menu_icon ";
    const MENU_CURRENCY = "currency_menu_icon ";
    const MENU_LDAP = "ldap_menu_icon ";
    const MENU_TRANSLATE = "translate_menu_icon ";
    const MENU_CLUSTER = "cluster_menu_icon ";
    const MENU_SYS = "sys_menu_icon ";
    const MENU_UTIL = "util_menu_icon ";
    const MENU_PERFMON = "perfmon_menu_icon ";
    
    const MENU_STATISTIC_ONLINE = "statistic_icon_online ";
    const MENU_STATISTIC_VISITORS = "statistic_icon_visitors ";
    const MENU_STATISTIC_SEARCHERS = "statistic_icon_searchers ";
    const MENU_STATISTIC_EVENTS = "statistic_icon_events ";
    const MENU_STATISTIC_TRAFFIC = "statistic_icon_traffic ";
    const MENU_STATISTIC_SUMMARY = "statistic_icon_summary ";
    const MENU_STATISTIC_ADVERT = "statistic_icon_advert ";
    const MENU_STATISTIC_SITES = "statistic_icon_sites ";
    
    const MENU_LEARNING = "learning_menu_icon ";
    const MENU_LEARNING_COURSES = "learning_icon_courses ";
    const MENU_LEARNING_LESSONS = "learning_icon_lessons ";
    const MENU_LEARNING_CHAPTERS = "learning_icon_chapters ";
    const MENU_LEARNING_CERTIFICATION = "learning_icon_certification ";
    const MENU_LEARNING_GRANDEBOOK = "learning_icon_gradebook ";
    const MENU_LEARNING_ATTEMPTS = "learning_icon_attempts ";
    const MENU_LEARNING_EXPORT = "learning_icon_export ";
    const MENU_LEARNING_QUESTION = "learning_icon_question ";
    const MENU_LEARNING_TESTS = "learning_icon_tests ";
    const MENU_LEARNING_GROUPS = "learning_icon_groups ";
    
    const MENU_SEO = "seo_menu_icon ";
    const MENU_SEO_ADV = "seo_adv_menu_icon ";
    
    const MENU_SENDER = "sender_menu_icon ";
    const MENU_SENDER_TRIG = "sender_trig_menu_icon ";
    
    const MENU_CONVERSION_PULSE = "conversion_pulse_menu_icon ";
    const MENU_CONVERSION_MODEL = "conversion_model_menu_icon ";
    
    const MENU_SECURITY = "security_menu_icon ";
    const MENU_SECURITY_DDOS = "security_menu_ddos_icon ";
    
    const MENU_SMILE = "smile_menu_icon";
    const MENU_DEFAULT = "default_menu_icon ";
    const MENU_RAITING = "rating_menu_icon ";
    const MENU_SUPPORT = "support_menu_icon ";
    const MENU_SONET = "sonet_menu_icon ";
    const MENU_FORUM = "forum_menu_icon ";
    const MENU_BIZPROC = "bizproc_menu_icon ";
    const MENU_BLOG = "blog_menu_icon ";
    const MENU_MAIL = "mail_menu_icon ";
    const MENU_MAIN_FOLDER = "main_menu_icon_folder,";
    const MENU_WORKFLOW = "workflow_menu_icon ";
    const MENU_HIGHLOADBLOCKS = "highloadblock_menu_icon ";
    const MENU_FORM = "form_menu_icon";
    const MENU_CONTROLLER = "controller_menu_icon ";
    const MENU_VOTE = "vote_menu_icon ";
    const MENU_SUBSCRIBE = "subscribe_menu_icon ";
    const MENU_ADVERTSTRING = "advertising_menu_icon ";
    const MENU_XDIMPORT = "xdimport_menu_icon ";
    const MENU_XMPP = "xmpp_menu_icon ";
    const MENU_EXTENSION = "extension_menu_icon ";
    const MENU_ACCT = "acct_customers_menu_icon ";
    const MENU_TRADE_CATALOG = "trade_catalog_menu_icon ";
    const MENU_SCALE = "scale_menu_icon ";
    const MENU_MOBILE = "mobile_menu_icon ";
    const MENU_ABTEST = "abtest_menu_icon ";
}