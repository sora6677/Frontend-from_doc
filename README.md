# Frontend-from_doc 問卷表單

## 共用錯誤代碼
|代碼|說明|
|---|-----|
|1001|xxxxxxxxxxxx|

```
```

## QuestionReply - 問卷回覆
```
MetHod：POST
傳入參數：
  data：JSON
傳入JSON：
  ReplyData(json)：回覆內容
傳入範例：
  data={"ReplyData":[{"1":"A"},{"2":"B"}]}
```

```
回傳參數：
  status(int)：代碼
  msg(string)：訊息
  data(object)：
回傳方式：JSON
```

```
成功範例：
  {"status":200,"msg":"成功","data":{}}
失敗範例：
  {"status":1001,"msg":"傳入資料異常","data":{}}
```
