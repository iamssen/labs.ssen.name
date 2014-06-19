---
primary: b3799b3d1d
date: '2014-01-31 02:37:29'

---

# Finder 검색에서 원본 질의(Raw Query) 보이기

Finder에서 기본적으로 원본 질의가 감춰져 있는 편이다. (감춰져 있다기 보다는 일반적으로 쓸 일이 없으니...)

![파인더를 연다][view-raw-query1]

![Space 한 번][view-raw-query2]

Finder의 검색 창에 **공백을 한 칸 주면 검색이 시작되게 된다.**

![검색 조건을 추가 시킨다][view-raw-query3]

검색 조건의 오른쪽 + 버튼을 눌러서 검색 조건을 하나 추가하고,

![원본 질의를 추가][view-raw-query4]

검색 타입에서 "기타..."을 선택했을 때 나오는 리스트에서 위와 같이 원본 질의를 찾을 수 있다.

![검색 조건으로 원본 질의를 선택][view-raw-query5]

이제 검색 조건을 원본 질의로 선택한다.


# 원본 질의(Raw Query) 조건식

원본 질의는 Mac 개발의 File Metadata Search를 사용하는듯 싶다. Mac 관련된 개발쪽은 자세히 모르기 때문에 패스...

그냥 일반적인 프로그래밍 언어의 조건식과 별다를바 없다. 자세한 사항들은 아래 링크에서...

- [Spotlight syntax, mdfind examples, and metadata attributes]
- [File Metadata Search Programming Guide] 
- [File Metadata Attributes Reference]


# Mavericks Tags `OR` Search

	(kMDItemUserTags == 'Inbox') || (kMDItemUserTags == 'Today') || (kMDItemUserTags == 'Priority') || (kMDItemUserTags == 'Complete')

OSX 10.9 Mavericks에 추가된 Tag는 `kMDItemUserTags`로 검색할 수 있고, `OR`는 일반적인 형태 그대로 `||` 문자를 사용해서 처리할 수 있다.




[Spotlight syntax, mdfind examples, and metadata attributes]: http://osxnotes.net/spotlight.html
[File Metadata Search Programming Guide]: https://developer.apple.com/library/mac/documentation/Carbon/Conceptual/SpotlightQuery/Concepts/QueryFormat.html
[File Metadata Attributes Reference]: https://developer.apple.com/library/mac/documentation/carbon/reference/metadataattributesref/reference/commonattrs.html

[view-raw-query1]: ../../../files/captures/20140131/001127.png
[view-raw-query2]: ../../../files/captures/20140131/001134.png
[view-raw-query3]: ../../../files/captures/20140131/001141.png
[view-raw-query4]: ../../../files/captures/20140131/001213.png
[view-raw-query5]: ../../../files/captures/20140131/001221.png