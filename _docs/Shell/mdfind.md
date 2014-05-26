# mdfind : Metadata Find

OSX 파일들의 metadata를 바탕으로 검색을 한다. 당연히 OSX 에서만 작동된다.

	$ mdfind "query"

형태로 사용이 가능하고,

	$ mdfind -onlyin ~/Documents "query"

와 같이 검색 범위를 특정 Directory 이하로 지정하는 것도 가능하다.

OSX System과 아예 결합이 되어있는지라 결과가 빠르고, 생각보다 검색할 수 있는 범위가 넓다.

다만, 문제점 중 하나는 이 쿼리문이 사람이 기억해서 쳐대기에는 좀 무리가 있다는 것... 즉, command line 으로서의 활용성은 그다지 높다고 보기엔 어렵지 않나 싶다. command line 에서의 활용이야 `find ~/Documents/**/*.pdf` 와 같은 globbing이 더 유용하다고 볼 수 있으니... api 로 필요한 뭔가를 만들때 쓰기엔 상당히 유용할 것 같다.

# 쿼리 작성에 참고할 수 있는 자료들

- [Spotlight syntax, mdfind examples, and metadata attributes]
- [File Metadata Search Programming Guide] 
- [File Metadata Attributes Reference]


[Spotlight syntax, mdfind examples, and metadata attributes]: http://osxnotes.net/spotlight.html
[File Metadata Search Programming Guide]: https://developer.apple.com/library/mac/documentation/Carbon/Conceptual/SpotlightQuery/Concepts/QueryFormat.html
[File Metadata Attributes Reference]: https://developer.apple.com/library/mac/documentation/carbon/reference/metadataattributesref/reference/commonattrs.html