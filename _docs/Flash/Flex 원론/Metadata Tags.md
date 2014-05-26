# 참고

- [Flex Metadata Tags](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf680e1-7ffe.html)

# property 에 추가 가능한 metadata tags

- Flash Builder 에서 코드 편집시에 도움
    - `[Deprecated]` 더 이상 사용되지 않는 (삭제 예정인) api 에 표시
    - `[Inspectable]` 속성을 정의 한다 (Array 의 구성 요소를 정의 한다던가 하는...)
    - `[SkinPart]` Skin 에 어떤 요소들이 포함되어져야 하는지 정의한다.
- Compile Time
    - `[Embed]`
        - [사용 가능한 mime type](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf60546-7ffb.html#WS2db454920e96a9e51e63e3d11c0bf69084-7f96)
            - `application/octet-stream`
            - `application/x-font`
            - `application/x-font-truetype`
            - `application/x-shockwave-flash`
            - `audio/mpeg`
            - `image/gif`
            - `image/jpeg`
            - `image/png`
            - `image/svg`
            - `image/svg-xml`
- `[Bindable(event="propertyChanged")]`
- `[NonCommittingChangeEvent]`
- `[Transient]`

# class 에 선언 가능한 녀석들

- Flash Builder 에서 코드 편집시에 도움
    - `[Deprecated]` 더 이상 사용되지 않는 (삭제 예정인) api 에 표시
- Mxml 편의
    - `[DefaultProperty]` mxml element 하부에 바로 쓸 수 있는 속성을 정한다. (ex: Group 의 children 같은 경우)
    - `[SkinState]` Skin 에 어떤 state 들이 포함되어져야 하는지 정의
    - `[Style]` Style 요소를 정의. IStyleClient 를 구현해줘야 함
    - `[Event]` 현재 Class 에서 dispatch 되는 event 정의
- `[Exclude]` 상속 구현 의해 사용되지 않는 mxml 속성 정의
- `[AccessibilityClass]`
- `[Alternative]`
- `[Bindable]`
- `[ExcludeClass]` @private 과 유사한 효과
- `[IconFile]` component icon file. builder 4.7 이후로 gui 편집기가 사라졌으므로 별 쓸모 없음
- `[Managed]`
- `[RemoteClass]` 직렬화를 위해 사용
- `[ResourceBundle]`

# interface 에 선언 가능한 녀석들

- `[ArrayElementType]`
- `[Bindable]`
- `[Deprecated]`
- `[Embed]`
- `[Inspectable]`
- `[NonCommittingChangeEvent]`
- `[PercentProxy]`
- `[RichTextContent]`
- `[SkinPart]`
- `[Transient]`
