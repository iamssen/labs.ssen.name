---
primary: cfcdaa5f87
date: '2014-06-26 15:22:26'
tags:
- 'Showcase'

---

Spark Data Grid Custom (_<https://bitbucket.org/ssen/grid.custom.spark>_)
==============================================

기본 Data Grid가 하도 개똥 같아서 `Skin`들을 수정하고, 여러 내부 기능들을 확장...



### Edit 기능 넣기

<embed src="http://files.ssen.name/showcase/grid.custom.spark/EditableDataGrid.swf" width="1000" height="700"/>

1. `DataGrid`에서 사용 할 `ItemEditor`용 `Skin`들을 모두 새로 작업
1. Excel처럼 방향키로 Cell Focus 이동 기능을 넣음 (_`Ctrl + Alt + Arrow Key` 단축키_)

Excel처럼 만들려 했지만, 단축키 설정이 다른 기본 단축키들과 충돌이 있어서 좀 애매... 일단은 `Ctrl + Alt + Arrow Key`로 설정.


### Footer 기능 넣기

<embed src="http://files.ssen.name/showcase/grid.custom.spark/FooterElementDataGrid.swf" width="1000" height="700"/>

1. Footer 기능을 넣음
1. 합계 등의 기능 추가

Edit 시에 Sort가 다시 되도록 수정해야 할듯...

분명... 프로젝트에 가면 Grid 공간과 Footer 공간의 조절을 해달라고 하겠지...


### Footer에 Graph 넣기

<embed src="http://files.ssen.name/showcase/grid.custom.spark/FooterGraphDataGrid.swf" width="1000" height="700"/>

1. Footer에 Graph 기능을 넣음 (_Flex Chart를 넣는 것은 너무 무거워서 비추천_)


### Tree 기능 넣기

<embed src="http://files.ssen.name/showcase/grid.custom.spark/HierarchicalDataGrid.swf" width="1000" height="700"/>

1. 모양을 깔끔하게 정리... (_아 Skin 만들기 빡세... 졸라 만들거 많아..._)


### 틀 고정

<embed src="http://files.ssen.name/showcase/grid.custom.spark/LockedDataGrid.swf" width="1000" height="700"/>

1. 기본 틀고정...