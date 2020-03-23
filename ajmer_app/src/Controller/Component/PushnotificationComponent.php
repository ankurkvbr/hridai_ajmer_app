<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Mobile Pushnotification Component
 *
 * @author        Zankat Kalpesh
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class PushnotificationComponent extends Component {

    private $DeviceConfig = [];

    /**
     * Constructor
     *
     * @param	array	$config
     * @return	void
     */
    public function initialize(array $config = array()) {
        //Load Configure File
        Configure::load('pushnotification');
        //Read DeviceConfig Configure
        $this->DeviceConfig = Configure::read('DeviceConfig');
    }

    /* Android Device */

    public function android($_devicetoken, $_msg, $options = []) {

        $_androidConfig = $this->DeviceConfig['AndroidDevice'] + $options;

        $AuthorizationKey = $_androidConfig['AuthorizationKey'];
        $_androidConfig['Headers'][] = "Authorization:key={$AuthorizationKey}";

        $pushData = array();
        $pushData['message'] = $_msg;
        $pushData['collapse_key'] = (string) time();
        if (!empty($_androidConfig['pushData'])) {
            $pushData = $_androidConfig['pushData'] + $pushData;
        }

        $pushData = array(
            'registration_ids' => [$_devicetoken],
            'data' => $pushData
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $_androidConfig['GCM_SERVER_URL']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $_androidConfig['Headers']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($pushData));
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        if (isset($response)) {
            $response = json_decode($response);
            return $response;
        } else {
            return false;
        }
    }

    /* IOS Device */

    public function ios($_devicetoken, $_msg, $options = []) {

        $_iosConfig = $this->DeviceConfig['IOSDevice'] + $options;

        $Certificate = $_iosConfig['Certificate'][$_iosConfig['ENVIRONMENT']];
        $Server = $_iosConfig['SERVER_URL'][$_iosConfig['ENVIRONMENT']];
        $Passphrase = $_iosConfig['Passphrase'];

        $_log_path = $_iosConfig['LogsPath'];

        $_log_filename = 'ios-' . date('d-m-Y') . '.log';

        $rwLogFile = fopen($_log_path . $_log_filename, "a+");

        fwrite($rwLogFile, "=============== Device " . date("Y-m-d h:i:s A") . " =============\n Device token: '" . $_devicetoken . "'\n");

        $errorCode = $errorStr = '';

        $pushData = array();
        $pushData['aps']['badge'] = 0;
        $pushData['aps']['sound'] = 'default';
        $pushData['aps']['alert'] = $_msg;
        if (!empty($_iosConfig['AppAlert'])) {
            $pushData['aps'] = $_iosConfig['AppAlert'] + $pushData['aps'];
        }
        $pushData = json_encode($pushData);
        $isError = false;
        $scc = stream_context_create();
        @stream_context_set_option($scc, 'ssl', 'local_cert', $Certificate);
        @stream_context_set_option($scc, 'ssl', 'passphrase', $Passphrase);
        $connectSSC = @stream_socket_client($Server, $errorCode, $errorStr, 2, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $scc);
        if (!$connectSSC) {
            fwrite($rwLogFile, " Failed to connect: $errorCode $errorStr \n");
            $isError = true;
        } else {
            $notificationObj = chr(0) . pack('n', 32) . pack('H*', $_devicetoken) . pack('n', strlen($pushData)) . $pushData;
            $result = fwrite($connectSSC, $notificationObj, strlen($notificationObj));
            if (!$result) {
                fwrite($rwLogFile, " Error Code: " . $errorCode . "\n Error String: " . $errorStr . "\n");
                $isError = true;
            }
        }

        if (!$isError) {
            fwrite($rwLogFile, " Notification Send Message: " . $_msg . "\n");
        }
        fwrite($rwLogFile, "=============== Device " . date("Y-m-d h:i:s A") . " =============\n");
        fclose($rwLogFile);
        if ($isError) {
            return false;
        } else {
            fclose($connectSSC);
            return true;
        }
    }

    /* Windows Device */

    public function windows($_devicetoken, $_title, $_msg, $options = []) {

        $_windowConfig = $this->DeviceConfig['WindowDevice'] + $options;

        $message = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<wp:Notification xmlns:wp=\"WPNotification\">" .
                "<wp:Toast>" .
                "<wp:Text1>" . trim($_title) . "</wp:Text1>" .
                "<wp:Text2>" . trim($_msg) . "</wp:Text2>" .
                "<wp:Param>/View/ExtendedSplashScreen.xaml?From=" . $_title . " ~ " . $_msg . "</wp:Param>" .
                "</wp:Toast> " .
                "</wp:Notification>";

        $_windowConfig['Headers'][] = 'Content-Length:' . strlen($message);
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $_devicetoken);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $_windowConfig['Headers']);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            if ($response) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }

}