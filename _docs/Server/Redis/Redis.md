# Homebrew 를 통한 Redis 설치와 실행

- `brew install redis`
- `redis-server` server 가 실행된다
- `redis-cli` server 에 접속하는 cli client 가 실행된다

# 기본 명령어들
- 기본 CRUD
	- `set key value`
	- `get key`
	- `del key`
- 증가
	- `incr key` key 의 value 가 +1 된다 (increment)
	- `incrby key 2` key 의 value 를 뒤에 적힌 수만큼 증가시킨다
	- `decr key` key 의 value 가 -1 된다
	- `decrby key 2` key 의 value 를 뒤에 적힌 수만큼 감소시킨다
- Data 의 수명 결정
	- `expire key 10` 10초 후에 key 를 삭제한다
	- `expireat key {unix time stamp}` 지정된 시간에 key 를 삭제한다
	- `ttl key` expire 까지 남은 시간(초) 
		- expire 를 걸지 않은 값의 경우 -1 이 리턴됨
		- 값이 set 으로 변경되거나 del 로 삭제되는 경우 expire 가 취소되고 ttl 이 -1 로 리턴됨
- Array
	- `rpush key value` key 배열의 후방(right)에 값을 추가한다
	- `lpush key value` key 배열의 전방(left)에 값을 추가한다
	- `lrange key 0 -1` 0 에서 모든 값을 가져온다 (뒤가 -1 이 아니면 끊어온다)
	- `llen key` key 배열의 length
	- `lpop key` key 배열의 전방값을 하나 삭제하며 가져온다
	- `rpop key`
- Set
	- `sadd key "a"` key 에 "a" 를 넣는다
	- `srem key "a"` key 에 "a" 를 뺀다
	- `sismember key "a"` key 에 "a" 가 있는지 확인한다 (1 : true , 0 : false)
	- `smembers key` key 의 모든 값들을 가져온다
	- `sinter key1 key2` key1 과 key2 양쪽 모두에 있는 값들을 본다
	- `sunion key1 key2` key1 과 key2 를 합쳐서 본다
- Sorted
	- `zadd key 10 "a"` key 에 순위 10 으로 "a" 를 추가한다
	- `zrange key 0 -1` key 를 가져온다 (순위에 따라서 자동정렬되어져 온다)
- Subscribe
	- `subscribe "channelname"` "channelname" 이라는 channel 을 구독하기 시작한다 (수신측)
	- `publish "channelname" "message"` "channelname" 이라는 channel 로 메세지를 전달한다 (송신측)
	- event `message (channelname, message)` subscribe 상태에서 message 라는 이벤트가 온다 (수신측)
	- event `subscribe (channelname, count)` subscribe 명령으로 channel 에 진입했을때 발동 (수신측)
- Hash
	- `hset hash key value` hash 의 key 에 value 를 저장한다
	- `hincrby hash key 1` hash 의 key 숫자값을 증가시킨다 (없을 경우엔 해당 숫자를 추가)
	- `hget hash key` hash 의 key 값을 가져온다
	- `hgetall hash` hash 에 있는 모든 값을 key, value 순서로 가져온다
	- `hkeys hash` hash 에 있는 모든 key 들을 가져온다
	- `hvals hash` hash 에 있는 모든 value 들을 가져온다
- Sets 를 key 의 집합으로 사용하기
	- `sadd set key` set 에 특정 key 를 합류시킨다
	- `smembers set` set 에 존재하는 모든 key 들을 본다
	- `sinter set1 set2` set1 과 set2 에 동시에 존재하는 key 들을 본다 (교집합)
	- `sunion set1 set2` set1 과 set2 의 key 들을 합쳐서 본다 (합집합)
- 검색, 확인
	- `keys *a*` "name" 과 같이 중간에 a가 포함된 이름을 가진 모든 key 들을 확인한다 (ex. `*`, `type:*`...)
	- `type key` key 의 type 을 확인한다

# Node.js redis



# 추가 자료들
- <http://kerocat.tistory.com/1>
- <http://redis.io/commands>
- <https://npmjs.org/package/redis>
	


