<?php
require_once(dirname(__FILE__).'/../base/ApiSetting.php');
require_once(dirname(__FILE__).'/../base/ApiInclude.php');

$nStatus = 200;
$aRes = array();
cWriteLogFile::SetBaseSetting(basename(__FILE__,".php"),LOG_PATH);

try
{
    $sDBHost = DB_DATA['HOST'];
    $sDBUser = DB_DATA['USER'];
    $sDBPw = DB_DATA['PW'];
    $sDBName = DB_DATA['NAME'];
    $nPort = DB_DATA['PORT'];
    $sDBCharacter = DB_CHARACTER;

    $oDB = new PDO("mysql:host={$sDBHost};dbname={$sDBName};port={$nPort};charset={$sDBCharacter}", $sDBUser, $sDBPw);
    $oDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); #禁用prepared statements的模擬效果
    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); #讓資料庫顯示錯誤原因

    # 此帳號是否已註冊
    $sDate = Date('Y-m-d H:i:s');
    $sSQL ="SELECT  `question_id` AS QuestionId,
                    `question_data` AS QuestData,
                    `start_time` AS StartTime,
                    `end_time` AS EndTime
            FROM    `questionnaire` 
            WHERE   `start_time` < ?
            AND     `end_time` > ?";
    $sPre = $oDB->prepare($sSQL);
    $sPre->execute([$sDate,$sDate]);
    while($aRow = $sPre->fetch(PDO::FETCH_ASSOC))
    {
        $aRow['QuestData'] = json_decode($aRow['QuestData']);
        array_push($aRes,$aRow);
    }
}
catch(PDOException $e)
{
    cWriteLogFile::LogWrite(LOG_LEVEL['Error'],'資料庫異常->' . $e->getMessage(),$e->getCode());
    $nStatus = 1002;
}
catch(Exception $e)
{
    cWriteLogFile::LogWrite(LOG_LEVEL['Info'],$e->getMessage(),$e->getCode());
    $nStatus = $e->getCode();
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
