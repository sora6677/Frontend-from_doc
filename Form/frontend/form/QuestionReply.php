<?php
require_once(dirname(__FILE__).'/../../base/FrontendSetting.php');
require_once(dirname(__FILE__).'/../../base/FrontendInclude.php');

$_sData = isset($_POST['data']) ? $_POST['data'] : '';
// $_sData = '{"ReplyData":{"A":"B"}}';
$nStatus = 200;
$aRes = array();
cWriteLogFile::SetBaseSetting(basename(__FILE__,".php"),LOG_PATH);

try
{
    # 傳入參數
    $aData = json_decode($_sData,true);
    if(!is_array($aData))
    {
        # 非 json
        throw new Exception('傳入資料異常-非 json：' . var_export($_POST,true), 1001);
    }

    $_sReply = isset($aData['ReplyData']) ? $aData['ReplyData'] : null;
    if(!is_array($_sReply))
    {
        throw new Exception('傳入資料異常-有資料為空' . $_sData, 1001);
    }

    $_sReply = json_encode($_sReply,JSON_UNESCAPED_UNICODE);    

    $sDBHost = DB_FORM_DATA['HOST'];
    $sDBUser = DB_FORM_DATA['USER'];
    $sDBPw = DB_FORM_DATA['PW'];
    $sDBName = DB_FORM_DATA['NAME'];
    $nPort = DB_FORM_DATA['PORT'];
    $sDBCharacter = DB_CHARACTER;

    $oDB = new PDO("mysql:host={$sDBHost};dbname={$sDBName};port={$nPort};charset={$sDBCharacter}", $sDBUser, $sDBPw);
    $oDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); #禁用prepared statements的模擬效果
    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); #讓資料庫顯示錯誤原因

    # 寫入回覆
    $sSQL ="INSERT INTO `questionnaire_reply` (
                `question_id`,
                `reply_data`
            ) 
            VALUES (?,?)";
    $sPre = $oDB->prepare($sSQL);
    $sPre->execute([1,$_sReply]);
    if($oDB->lastInsertId() < 1)
    {
        throw new Exception("寫入資料失敗", 1003);
    }
}
catch(PDOException $e)
{
    cWriteLogFile::LogWrite(LOG_LEVEL['Error'],'資料庫異常->' . $e->getMessage(),$e->getCode(),$e->getLine());
    $nStatus = 1002;
}
catch(Error $e)
{
    cWriteLogFile::LogWrite(LOG_LEVEL['Error'],'Error->' . $e->getMessage(),$e->getCode(),$e->getLine());
    $nStatus = 1000;
}
catch(Exception $e)
{
    cWriteLogFile::LogWrite(LOG_LEVEL['Info'],'Exception->' . $e->getMessage(),$e->getCode(),$e->getLine());
    $nStatus = $e->getCode();
}
catch(Throwable $e)
{
    cWriteLogFile::LogWrite(LOG_LEVEL['Warn'],'Throwable->' . $e->getMessage(),$e->getCode(),$e->getLine());
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
