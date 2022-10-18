# Frontend-from_doc 問卷表單

## 共用錯誤代碼
|回傳碼|說明|
|---|---|
|200|成功|
|1000|異常錯誤|
|1001|傳入資料異常|
|1002|資料庫異常|
|1003|寫入資料失敗|

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


## StatisticsReply.php - 問卷回覆統計
```
MetHod：GET
傳入參數：
傳入JSON：
傳入範例：
```

```
回傳參數：
  status(int)：代碼
  msg(string)：訊息
  data(object)：
    statistics：表單統計後 json
回傳方式：JSON
```

```
成功範例：
  {"status":200,"msg":"成功","data":{"statistics":[{"id":110000,"type":1,"count":2,"answer_count":[1,0,1],"fill":[]},{"id":120000,"type":1,"count":2,"answer_count":[1,0,0,0,0,0,1],"fill":[]},{"id":130000,"type":1,"count":2,"answer_count":[1,0,0,0,0,0,1],"fill":[]},{"id":140000,"type":1,"count":2,"answer_count":[1,0,0,0,0,0,1],"fill":{"7":["99"]}},{"id":150000,"type":2,"count":2,"answer_count":[1,0,0,0,1],"fill":{"5":["99"]}},{"id":160000,"type":3,"count":2,"fill":["123","99"]},{"id":170000,"type":1,"count":2,"answer_count":[1,0,0,0,0,0,0,1],"fill":{"8":["99"]}},{"id":180000,"type":2,"count":2,"answer_count":[1,0,0,0,0,1],"fill":{"1":["1263"],"6":["99"]}},{"id":190000,"type":4,"count":2,"answer_count":{"191000":[1,1,0,0,0],"192000":[1,1,0,0,0],"193000":[0,1,1,0,0],"194000":[0,0,1,1,0],"195000":[0,0,0,1,1],"196000":[0,0,0,1,1]}},{"id":200000,"type":1,"count":2,"answer_count":[2,0,0,0,0,0,0,0,0,0],"fill":{"1":["1","2"]}},{"id":210000,"type":1,"count":2,"answer_count":[2,0],"fill":{"1":["1","3"]}},{"id":220000,"type":1,"count":2,"answer_count":[1,0,0,0,0,0,1],"fill":{"7":["5"]}},{"id":230000,"type":1,"count":2,"answer_count":[1,1],"fill":{"2":["5"]}},{"id":240000,"type":1,"count":2,"answer_count":[1,0,0,0,1],"fill":[]},{"id":250000,"type":3,"count":2,"fill":["1","8"]},{"id":260000,"type":3,"count":2,"fill":["1","6"]}]}}
失敗範例：
  {"status":1001,"msg":"傳入資料異常","data":{}}
```
