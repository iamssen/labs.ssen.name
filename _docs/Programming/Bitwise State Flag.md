# Bitwise 연산을 이용한 State Flag Modeling

1. 가벼운 데이터를 통해서 state flag 작업을 할 수 있다
2. 일반적으로 조건식이 길어지는 다중 조건을 간단하게 표현할 수 있다

# Bitwise 연산자 다루기

### State 상수의 선언

	public static const A:uint = 1 << 0; // 0
	public static const B:uint = 1 << 1; // 10
	public static const C:uint = 1 << 2; // 100
	public static const C:uint = 1 << 3; // 1000

상수는 shift 연산자를 통해서 선언해준다. 

각 상수에 해당하는 2진수 상태가 발생되게 된다. (boolean 배열과 같다고 볼 수 있다)

### 상태를 on 으로 돌리기

	flags = 0;
	flags |= D; // 2진수로 1000 이 된다
	flags |= A | B; // 2진수가 합쳐져서 1011 이 된다

연산자 `|` (Bitwise OR) 를 사용한다.

Bitwise OR 는 아래와 같이 `0 | 1 = 1` 의 특징을 가진다.

- `0 | 0 = 0`, `10 | 00 = 10`
- `1 | 0 = 1`, `10 | 01 = 11`
- `1 | 1 = 1`, `11 | 00 = 11`

### 상태를 off 로 돌리기

	// flags 가 2진수로 1011 상태라고 할 때
	flags &= ~A; // 2진수로 1010 이 된다
	flags &= ~(B | D); // 2진수로 0000 이 된다

연산자 `&` (Bitwise AND) 와 `~` (Bitwise NOT) 을 사용한다.

Bitwise AND 는 아래와 같이 `1 | 1 = 1` 의 특징을 가진다.

- `0 | 0 = 0`, `10 | 00 = 00`
- `1 | 0 = 0`, `10 | 01 = 00`
- `1 | 1 = 1`, `11 | 10 = 10`

Bitwise AND  와 NOT 이 합쳐지면 아래와 같은 특징을 가지게 된다

- `1011 & ~0011 = 1000`
- `1011 & ~0111 = 1000`
- `1011 & ~1000 = 0011`

### 상태의 or 검색 (항목들 중 하나라도 on 상태인지 확인)

	// flags 가 2진수로 1011 상태라고 할 때
	flags & (A | B) !== 0; // 2진수로 0011 이 되기 때문에, true 가 나온다
	flags & C !== 0; // 2진수로 0000 이 되기 때문에, false 가 나온다

Bitwise AND 를 사용한다. 공식은 `flags & mask !== 0` 이 된다.

- `1011 & 0001 = 0001`
- `1011 & 0100 = 0000`

과 같이 되기 때문에 `!== 0` 을 검색함 으로서 or 검색을 수행할 수 있다 

### 상태의 and 검색 (모든 항목들이 on 상태인지 확인)

	// flags 가 2진수로 1011 상태이고 
	flags & 1011 === flags; // 결과는 1011 이기 때문에 true 가 된다
	flags & 1001 === flags; // 결과는 1001 이기 때문에 false 가 된다

Bitwise AND 로 계산한 다음, flags 와 대입한다.

`flags & mask === flags` 이기 때문에 flags 가 켜져 있는 모든 상태들이 다 켜져 있어야만 대입시 true 가 된다


# Case 별 Modeling

## 지속적인 상태의 확인이 필요할 때

	class Model {
		public static const A:uint=1 << 0;
		public static const B:uint=1 << 1;
		public static const C:uint=1 << 2;
		public static const D:uint=1 << 3;

		private var flags:uint=0;

		public function remove(mask:uint):void {
			flags&=~mask;
		}

		public function clear():void {
			flags=0;
		}

		public function add(mask:uint):void {
			flags|=mask;
		}

		public function test(mask:uint):Boolean {
			return (flags & mask) !== 0;
		}
	}

invalidation 처럼 지속적인 상태의 확인이 필요한 경우 사용할 수 있다

- `model.add(A)` 상태 A 를 킨다 `model.add(A|B|C)` 상태 A, B, C 를 킨다
- `model.remove(A)` 상태 A 를 끈다 `model.remove(A|B|C)` 상태 A, B, C 를 끈다
- `model.clear()` 모든 상태들을 끈다
- `model.test(A)` 상태 A 가 켜져 있는지 확인 `model.test(A|B|C)` 상태 A, B, C 중 하나라도 켜져 있는지 확인 (or 검색)

## 통합 완료의 확인이 필요할 때

	class Model {
		public static const A:uint=1 << 0;
		public static const B:uint=1 << 1;
		public static const C:uint=1 << 2;
		public static const D:uint=1 << 3;

		private var flags:uint=0;

		public function complete(mask:uint):void {
			flags|=mask;
		}

		public function clear():void {
			flags=0;
		}

		public function test():Boolean {
			var c:uint=A | B | C | D;
			return (c & flags) === c;
		}
	}

여러 event 확인 처럼 상태들이 모두 완료 되었는지 확인하거나 할 때 사용할 수 있다

- `model.complete(A)` 작업 A 가 완료 되었음을 알린다 `model.complete(A|B)` 작업 A 와 B 가 완료 되었음을 알린다
- `model.test()` 작업 A, B, C, D 가 모두 완료 되었는지 확인한다
- `model.clear()` 모든 작업을 미완료 상태로 바꾼다 
