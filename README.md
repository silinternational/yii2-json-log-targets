# Yii2 JSON Log Targets
A collection of Yii2 log targets that format the log message as a JSON string.

## Tips

### Have the log prefix (if used) return JSON

Example (to be placed into your Yii2 config file's 
```['components']['log']['targets']``` array):

    [
        'class' => 'Sil\JsonLog\target\JsonFileTarget',
        'levels' => ['error', 'warning'],
        'except' => [
            'yii\web\HttpException:401',
            'yii\web\HttpException:404',
        ],
        'logVars' => [], // Disable logging of _SERVER, _POST, etc.
        'prefix' => function($message) use ($appEnv) {
            $prefixData = [
                'env' => $appEnv,
            ];
            if ( ! \Yii::$app->user->isGuest) {
                $prefixData['user'] = \Yii::$app->user->identity->email;
            }
            return \yii\helpers\Json::encode($prefixData);
        },
    ],

### If using syslog to send to Logentries, only send the JSON content
Make sure that the template you define for Logentries in your rsyslog.conf file 
does not add other content before the ```%msg%``` data (aside from your 
Logentries key). For example, do something like this...

    $template Logentries,"LOGENTRIESKEY %msg%\n"

... NOT like this...

    $template Logentries,"LOGENTRIESKEY %HOSTNAME% %syslogtag%%msg%\n"

## License

This is released under the MIT license (see LICENSE file).
