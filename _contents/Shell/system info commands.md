---
primary: 11f6259c29
date: '2014-03-11 23:39:30'

---

# `/proc/`

각 종, System 정보들이 들어있는 directory 이다.

하드웨어에 대한 정보들은 왠만해서 이곳에서 확인 가능한듯...

참고로 Ubuntu랑 CentOS 까지는 확인했는데, MacOSX 에는 없다. 아마 FreeBSD에도 없을듯...

### `cat /proc/cpuinfo`

	processor	: 0
	vendor_id	: AuthenticAMD
	cpu family	: 16
	model		: 8
	model name	: AMD Opteron(tm) Processor 4171 HE
	stepping	: 1
	cpu MHz		: 2094.706
	cache size	: 512 KB
	fpu		: yes
	fpu_exception	: yes
	cpuid level	: 5
	wp		: yes
	flags		: fpu vme de pse tsc msr pae mce cx8 apic mtrr pge mca cmov pat pse36 clflush mmx fxsr sse sse2 syscall nx mmxext fxsr_opt lm 3dnowext 3dnow up rep_good extd_apicid unfair_spinlock pni cx16 popcnt hypervisor lahf_lm cmp_legacy cr8_legacy abm sse4a misalignsse 3dnowprefetch osvw
	bogomips	: 4189.41
	TLB size	: 1024 4K pages
	clflush size	: 64
	cache_alignment	: 64
	address sizes	: 42 bits physical, 48 bits virtual
	power management:


# `df -h`

하드디스크의 남은 공간을 알 수 있다

	# df -h
	Filesystem                    Size  Used Avail Use% Mounted on
	/dev/mapper/VolGroup-lv_root   18G  1.3G   16G   8% /
	tmpfs                         495M     0  495M   0% /dev/shm
	/dev/sda1                     485M   54M  407M  12% /boot