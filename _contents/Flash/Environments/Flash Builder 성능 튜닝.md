---
primary: 68766333b5
date: '2013-08-31 12:58:46'

---

# JVM memory 할당

#### eclipse

- edit `Flash Builder.app/Contents/MacOS/Adobe Flash Builder 4.7.ini`
- `-Xms`, `-Xmx`, `-XX:MaxPermSize`... 등 메모리 관련 설정을 적당히 올려줌

#### mxmlc, compc

- edit `SDK/build.properties`
- `jvm.args = ...` 라인에 있는 `-Xms`, `-Xmx` 등을 적당히 올려줌