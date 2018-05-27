## Thai Text Visualization

Web Service สำหรับการตัดคำและทัศนภาพข้อความภาษาไทย

## REST API

This topic will show you how to run our API, where REST API is an easy way to execute tasks. Because of this call. POSTMAN can be run directly.

## Sent Value

Method : POST

URI : http://206.189.80.141/api

| KEY | Value | Type |
|----------|----------|----------|
| apikey      | Key      | String      |
| textword[]      | Text Files      | File Array      |
| dictdoc      | Text Files      | File      |

## Return value

JSON Format

Example :

[{

"Filename" : "doc_1.txt",

"Wordsegment" : ["กฎหมาย","ค้าขาย","เป็นธรรม"],

"Process_time" : "0.01 ms"

}]



