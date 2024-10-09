<?php
require_once(dirname(__FILE__).'/../../base/FrontendSetting.php');
require_once(dirname(__FILE__).'/../../base/FrontendInclude.php');

$nStatus = 200;
$aRes = array();
cWriteLogFile::SetBaseSetting(basename(__FILE__,".php"),LOG_PATH);

try
{
    $sDBHost = DB_FORM_DATA['HOST'];
    $sDBUser = DB_FORM_DATA['USER'];
    $sDBPw = DB_FORM_DATA['PW'];
    $sDBName = DB_FORM_DATA['NAME'];
    $nPort = DB_FORM_DATA['PORT'];
    $sDBCharacter = DB_CHARACTER;

    $oDB = new PDO("mysql:host={$sDBHost};dbname={$sDBName};port={$nPort};charset={$sDBCharacter}", $sDBUser, $sDBPw);
    $oDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); #禁用prepared statements的模擬效果
    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); #讓資料庫顯示錯誤原因

    # 查詢問題
    $aQuest = array();
    $sSQL ='SELECT  `question_data`
            FROM    `questionnaire`
            WHERE   `question_id` = 1
            LIMIT   0,1';
    $sPre = $oDB->prepare($sSQL);
    $sPre->execute();
    $aRow = $sPre->fetch(PDO::FETCH_ASSOC);
    $aJsonQuest = json_decode($aRow['question_data']);
    foreach($aJsonQuest as $n => $qd)
    {
        $id = isset($qd->id) ? $qd->id : '';
        $type = isset($qd->type) ? $qd->type : 0;
        $max_answer = isset($qd->max_answer) ? $qd->max_answer : '';
        $aQuest[$id]['type'] = $type;

        if($type == 1 || $type == 2)
        {
            $aQuest[$id]['answer'] = isset($max_answer) ? array_fill(0,$max_answer,0) : '';
            $aQuest[$id]['percentage'] = isset($max_answer) ? array_fill(0,$max_answer,0) : '';
            $aQuest[$id]['fill'] = isset($max_answer) ? array_fill(1,$max_answer,array()) : '';
            $aQuest[$id]['count'] = 0;
        }
        else if($type == 3)
        {
            $aQuest[$id]['count'] = 0;
            $aQuest[$id]['fill'] = array();
        }
        else if($type == 4)
        {
            if(!empty($max_answer[0]))
            {
                foreach($max_answer[0] as $sid => $rang)
                {
                    $aQuest[$id]['item'][$sid]['answer'] = array_fill(0,$rang,0);
                    $aQuest[$id]['item'][$sid]['percentage'] = array_fill(0,$rang,0);
                    $aQuest[$id]['item'][$sid]['fill'] = array_fill(1,$rang,array());
                    $aQuest[$id]['count'] = 0;
                }
            }
        }
    }

    # 查詢回覆
    $aData = array();
    $sSQL ='SELECT  `reply_id`,
                    `reply_data`
            FROM    `questionnaire_reply`
            WHERE   `question_id` = 1';
    $sPre = $oDB->prepare($sSQL);
    $sPre->execute();
    while($aRow = $sPre->fetch(PDO::FETCH_ASSOC))
    {
        $aJson = json_decode($aRow['reply_data']);

        # 累加回覆
        foreach($aJson as $n => $d)
        {
            $id = $d->id;
            $type = $d->type;
            $select = isset($d->answer->select) ? $d->answer->select : '';
            $fill = isset($d->answer->fill) ? $d->answer->fill : '';
            if(!isset($aQuest[$id])) continue;
            $aQuest[$id]['count']++;

            if($type == 1)
            {
                # 單選
                $select--;
                isset($aQuest[$id]['answer'][$select]) ? $aQuest[$id]['answer'][$select]++ : '';
                ($fill != '' && !empty($fill)) ? $aQuest[$id]['fill'][($select + 1)][] = $fill : '';
            }
            else if($type == 2)
            {
                # 複選
                foreach($select as $nn => $number)
                {
                    $number--;
                    isset($aQuest[$id]['answer'][$number]) ? $aQuest[$id]['answer'][$number]++ : '';
                }

                if($fill != '' && !empty($fill))
                {
                    foreach($fill as $number => $v)
                    {
                        $aQuest[$id]['fill'][$number][] = $v;
                    }
                }
            }
            else if($type == 3)
            {
                # 填寫
                ($fill != '' && !empty($fill)) ? $aQuest[$id]['fill'][] = $fill : '';
            }
            else if($type == 4)
            {
                # 多題單選
                foreach($select[0] as $sid => $number)
                {
                    $number--;
                    isset($aQuest[$id]['item'][$sid]['answer'][$number]) ? $aQuest[$id]['item'][$sid]['answer'][$number]++ : '';
                }
            }
        }
    }

    if(!empty($aQuest))
    {
        # 整理成回傳格式
        foreach($aQuest as $id => $data)
        {
            $aTmp = array();
            $type = $data['type'];
            $aTmp['id'] = $id;
            $aTmp['type'] = $type;
            $aTmp['count'] = $data['count'];
            
            if($type == 1 || $type == 2)
            {
                $aTmp['answer_count'] = $data['answer'];
                $aTmp['fill'] = array();
                foreach($data['fill'] as $number => $fill)
                {
                    $aFill = array();
                    if($fill != '' && !empty($fill))
                    {
                        $aFill[$number] = $fill;
                        $aTmp['fill'][] = $aFill;
                    };
                }
                !isset($aTmp['fill']) ? $aTmp['fill'] = array() : '';
            }
            else if($type == 3)
            {
                $aTmp['fill'] = $data['fill'];
            }
            else if($type == 4)
            {
                foreach($data['item'] as $sid => $sdata)
                {
                    $aTmp['answer_count'][$sid] = $sdata['answer'];
                }
            }

            $ts = json_encode($aTmp,JSON_UNESCAPED_UNICODE);
            $aRes['statistics'][] = $aTmp;
        }
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
