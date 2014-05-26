---
primary: b081b7a23d

---

# Bitmap Drawing 할 때의 Matrix 계산

- 이동
	- `tx=100`
	- `ty=100`
	
- 크기
	- `a=canvas.width / bitmap.width` 리사이즈 해야하는 `canvas.width` 를 소스의 `bitmap.width` 로 나눈 비율치 
	- `d=canvas.height / bitmap.height`