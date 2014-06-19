---
primary: 86671c8e9f
date: '2013-12-25 17:45:59'

---

# 소개
현재 실행중인 Bean 리스트를 확인할 수 있다.    
확인하기 힘든 AMF Message Broker 등을 확인할 때 유용하다.


# Tracking 대상이 되는 어플리케이션을 실행하기
- Tracking 할 Weblogic, Tomcat 등 Java Application을 실행시킬 때 `-Dcom.sun.management.jmxremote` 옵션을 붙여서 실행시킨다.

## 예제 : Weblogic 설정
- `$Domain/bin/setDomainEnv` 파일 열기
- `set JAVA_OPTIONS=%JAVA_OPTIONS% -Dapp.mode=local` 이 부분 뒤에 `-Dcom.sun.management.jmxremote` 옵션 붙임
- 재실행


# jvisualvm 
- `$JDK/bin/jvisualvm.exe` 실행
- `Tools/Plugins` 메뉴에서 **VisualVM-MBeans** 플러그인을 인스톨

이후 jvisualvm에서 Application을 선택하면 MBeans 리스트를 확인할 수 있다