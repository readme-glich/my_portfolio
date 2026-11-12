<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wp_forum' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'M{&[Y@=e@_$1^}me*Iw/jpYtFi/>Bp%@(}ecYq5/,6r=L mb:QVXW^q^7.0<8@@C' );
define( 'SECURE_AUTH_KEY',  '{Pqa>l9~Pq~*`C~/tWQYaF<EMtJ|s<x._${CQy7JnS[R;(7h$+M:50nMI0I_Me?{' );
define( 'LOGGED_IN_KEY',    '$E;RZJbsxYq<QdYM9NM4|~G3$4O-aM#]byN 8xv^lXqt5W<uV#!gQL.mO7DS/@;_' );
define( 'NONCE_KEY',        'q _Zk~]yZ5?nYfI3`It=*68?t/yzT[#stw*!AihF>`_gQ7oqXqtSx/TQKE8:rNZl' );
define( 'AUTH_SALT',        'aQG&mhxX- @mszyL3`aNT#]ehE*qz$NL]CMyv3H~]%m| s}`o/E/4T10_p^R)UnJ' );
define( 'SECURE_AUTH_SALT', ')1p4[KJ/nmgtLsmr`aQXU_CzS>-0ZkU0_(^qKgtI ^p^&{]P&VYik69,]LJk=KTP' );
define( 'LOGGED_IN_SALT',   '[#aXQjL_=*;/yWFRq11flE8H2VHv>]Ia_U1YdXQ9=]1@3KgvhLiri2Iv?5C1RnVC' );
define( 'NONCE_SALT',       'R~>I33S}6BBB`wy-`;HIn_SqKh)%ma`.xCM`_M]VpwCiZi&G%IQQ*sOQBm,wLH=a' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 *
 * В процессе установки указанный префикс добавляется к именам таблиц базы данных.
 * Если изменить это значение после установки WordPress, то сайт снова перейдёт
 * в режим установки.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
