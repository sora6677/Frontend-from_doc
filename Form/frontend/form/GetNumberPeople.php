<?php
$nStatus = 200;
$aRes = array();

define('DB_CHARACTER','utf8mb4');
define('LOG_PATH', './logs/' . Date('Y/m/d/'));
define('LOG_LEVEL', array(
    "Debug" => "Debug",
    "Info"  => "Info",
    "Warn"  => "Warn",
    "Error" => "Error",
    "Fatal" => "Fatal",
));

cWriteLogFile::SetBaseSetting(basename(__FILE__,".php"),LOG_PATH);

try
{
    $sDBHost = "localhost";
    $sDBUser = "LiveRoad";
    $sDBPw = "asdXsd234";
    $sDBName = "liveroad";
    $nPort = "3306";
    $sDBCharacter = DB_CHARACTER;

    $oDB = new PDO("mysql:host={$sDBHost};dbname={$sDBName};port={$nPort};charset={$sDBCharacter}", $sDBUser, $sDBPw);
    $oDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); #禁用prepared statements的模擬效果
    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); #讓資料庫顯示錯誤原因

    # 查詢問題
    $aQuest = array();
    $sSQL ='SELECT  COUNT(`sno`) AS Cnt
            FROM    `questionnaire_reply`
            WHERE   1 = 1';
    $sPre = $oDB->prepare($sSQL);
    $sPre->execute();
    $aRow = $sPre->fetch(PDO::FETCH_ASSOC);
    if($aRow)
    {
        $aRes['Count'] = $aRow['Cnt'];
    }
    else
    {
        $nStatus = 99;
    }
}
catch(PDOException $e)
{
    error_log('資料庫異常: ' . $e->getMessage(),0,'./logs.log');
    $nStatus = 1002;
}
catch(Error $e)
{
    error_log($e->getMessage(),0,'./logs.log');
    $nStatus = 1000;
}
catch(Exception $e)
{
    error_log($e->getMessage(),0,'./logs.log');
    $nStatus = $e->getCode();
}
catch(Throwable $e)
{
    error_log($e->getMessage(),0,'./logs.log');
    $nStatus = 1000;
}
finally
{
    // die("無法連上資料庫：" . $e->getMessage());
    $aRes = $nStatus == 200 && !empty($aRes) ? $aRes : (object) [];
    $aResponse = array(
        "status"=> $nStatus,
        "msg"   => GetResponseMsg($nStatus),
        "data"  => $aRes
    );
    echo json_encode($aResponse,JSON_UNESCAPED_UNICODE);

    unset($oDB);
    exit;
}

function GetResponseMsg(int $_n)
{
    switch($_n)
    {
        case 200:
            $sMsg = '成功';
            break;
        case 1001:
            $sMsg = '連線異常';
            break;
        case 1101:
            $sMsg = '登入失敗';
            break;
        default:
            $sMsg = '異常錯誤';
            break;
    }
    return $sMsg;
}

class cWriteLogFile
{
    /*
        使用方式
        cWriteLogFile::SetBaseSetting(檔案名稱,檔案路徑)
        cWriteLogFile::LogWrite(檔案名稱,檔案路徑)
    */
    public static $sName = ''; # 檔案名稱
    public static $sPath = ''; # 檔案路徑  

    public static function SetBaseSetting(string $_sName,string $_sPath)
    {
        /*
            設定要寫入的檔案名稱、路徑
            $_sName = 檔案名稱
            $_sPath = 路徑
        */

        self::$sName = $_sName;
        self::$sPath = $_sPath;
    }

    private static function GetMicrotime()
    {
        /*
            取得當前時間到毫秒
        */
        list($tm,$mt) = explode('.',microtime(true));
        $mt = str_pad($mt,4,"0",STR_PAD_RIGHT);
        return Date('Y-m-d H:i:s.',$tm).$mt;
    }

    private static function CreateLogPath()
    {
        /*
            建立資料夾路徑,創建多層目錄
            $path = 目錄路徑
        */
        // $path = str_replace("\\",'/',self::$sPath);

        // if(!is_dir($path))
        // {
        //     return mkdir($path,0777,true);
        // }
        return true;
    }

    private static function WriteFile(string $_sStr)
    {
        # $_sStr => 寫入檔案

        if(self::$sName == '') return false;
        if(self::$sPath == '') return false;
        if(!self::CreateLogPath()) return false;
            
        $sPath = self::$sPath.self::$sName.'.log';
        $sStr = self::GetMicrotime() . " " . $_sStr . "\r\n";
        // error_log($sStr,3,$sPath);
        error_log($sStr);
    }

    private static function LogLevel(string $_level)
    {
        # $_level => 級別
        $level = $_level;
        switch(strtoupper($level))
        {
            case 'DEBUG':
            case 'INFO':
            case 'WARN':
            case 'ERROR':
            case 'FATAL':
                break;
            default:
                $level = 'Debug';
                break;
        }
        return $level;
    }

    public static function LogWrite(string $_l, string $_s, string $_n = '', int $_line = 0)
    {
        # $_l => Log級別
        # $_s => Log訊息
        # $_n => Log代碼

        $level = self::LogLevel($_l);
        $sLog = "{$level} msg:{$_s}, code:{$_n}, line:{$_line}";
        self::WriteFile($sLog);
    }
}