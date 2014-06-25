---
primary: 89d55c60a1
date: '2013-08-30 16:22:28'

---

# Category Key가 있는 Object List 를 Tree 형태로 변환

`{cate1:"a", cate2:"b", cate3:"c", value:123}` 과 같은 형태의 데이터를

```json
a : {
	b : {
		c : {
			cate1 : "a", 
			cate2 : "b", 
			cate3 : "c", 
			value : 123
		}
	}
}
```
			
와 같은 tree 형태로 만들어준다.

```as3
function multipleKeyDatasToTree(itr:Itr, categoryKeys:Vector.<String>, root:TreeNode=null, appendLastNodeWith:Function=null):TreeNode {
	if (root === null) {
		root=new TreeNode;
	}
	
	var node:TreeNode;
	var source:Object;
	var key:String;
	
	var f:int;
	var fmax:int;
	
	while (itr.hasNext()) {
		source=itr.next();
		
		f=-1;
		fmax=categoryKeys.length;
		node=root;
		
		while (++f < fmax) {
			key=source[categoryKeys[f]];
			
			if (node.find(key) === null) {
				node.appendNode(new TreeNode(key));
			}
			
			node=node.find(key) as TreeNode;
			
			if (f === fmax - 1) {
				if (appendLastNodeWith === null) {
					node.appendNode(new TreeNode(source));
				} else {
					appendLastNodeWith(node, source);
				}
			}
		}
	}
	
	return root;
}
```