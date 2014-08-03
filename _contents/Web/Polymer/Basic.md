---
primary: 67015fa5ee
date: '2014-07-27 21:19:59'

---

사용 가능한 표현들
==================================

```html
<polymer-element name="name"
                 attributes="property1 property2 property3"
                 extends="parent-element"
                 constructor="Name"
                 noscript>
    <template>
    </template>

    <script src="script.js"></script>
    <script>
        var globalProperty = 'val'

        Polymer('name', {
            property : 'val',

            get property() {
            },
            set property(val) {
            },


        })
    </script>
</polymer-element>

```



property, element, attribute 항목들 다루기
==================================

## property 초기화

```js        
Polymer('name', { 
    created: function() { 
        this.property = 'a' 
    } 
})
```

```js
Polymer('name', { 
    property : 'a'
})
```

첫번째 것을 더 추천한다고 되어 있지만... 

글쎄... 보기에는 두 번째 것이 더 나아보이기도 한다.

## property를 attribute로 사용 가능하게 하기

```js
<polymer-element name="name" attributes="property1 property2">
    <script>
        Polymer('name', {
            property1: 'a',
            property2: 'b'
        })
    </script>
</polymer-element>
```

```js
Polymer('name', { 
    publish : { 
        property1 : '', 
        property2 : '' 
    } 
})
```

- [ ] 작동 확인 안했음  
    
## property 변화 감지

```js
Polymer('name', {
    get property() {
    },
    set property(val) {
    }
})
```

- [ ] getter, setter 를 attribute로 내보낼 수 있나?

```js
Polymer('name', {
    attributeChanged(attrName, oldVal, newVal) {
    }
}
```

```js
Polymer('name', {
    // propertyName + Changed
    propertyChanged : function(oldVal, newVal) {
    }
}
```

```js
Polymer('name', {
    observe: {
        property: 'validate'
    },
    validate: function(oldVal, newVal) {
    }
})
```


## element 변화 감지

```js
Polymer('name', {
    created: function() {
        this.onMutation(this, this.childrenElementsChanged)
    },
    childrenElementsChanged: function(observer, mutations) {
    }
})
```


## global

```html
<script>
    var globalProperty = 'a'
    
    Polymer('name', {
    })
</script>
```

Component 내의 global 처리는 위와 같이 할 수 있다.

```html
<polymer-element name="app-globals">
  <script>
  (function() {
    var values = {};

    Polymer('app-globals', {
       ready: function() {
         for (var i = 0; i < this.attributes.length; ++i) {
           var attr = this.attributes[i];
           values[attr.nodeName] = attr.nodeValue;
         }
       }
    });
  })();
  </script>
</polymer-element>
```

그 외, 전체 Component가 공유할 수 있는 녀석의 경우는 위와 같이 Component를 만들어서 처리하는 것을 추천하고 있다...

흐음... 좀 아리까리 하긴 한데... 이 형식을 잘 이용하면 MV* Context를 만들 수 있지 않을까 싶다.



Life cycle events
===============================================

```js
Polymer('name', {
    created: function () {
        console.log('created')
    },
    ready: function () {
        console.log('ready')
    },
    attached: function () {
        console.log('attached')
    },
    domReady: function () {
        console.log('domReady')
    },
    detached: function () {
        console.log('detached')
    }

    //------------------------------------
    // life cycle
    //
    // created test-element test-element.html:19
    // ready test-element test-element.html:22
    // attached test-element test-element.html:25
    // --- $(document).ready()
    // get getsetProperty test-element.html:9
    // getsetProperty test.html:30
    // set getsetProperty hello setter test-element.html:13
    // call method test-element.html:16
    // domReady test-element
})


```
