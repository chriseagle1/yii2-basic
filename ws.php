<?php
class WS {
	public $master;
	public $accept = [];
	public $cycle = [];

	public function __construct($addr = '127.0.0.1', $port = '8888') {
		$this->master = $this->WebSocket($addr, $port);
		echo("Master socket  : ".$this->master."\n");
		$this->cycle[] = $this->master;
	}

	public function WebSocket($addr, $port) {
		$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
		socket_bind($server, $addr, $port);
		socket_listen($server);
		return $server;
	}
	
	public function run() {
		while (true) {
			$write = NULL;
	                $except = NULL;
			$changes = $this->cycle;
			echo "wait\n";
			socket_select($changes, $write, $except, NULL);
			echo "have request\n";
			foreach($changes as $sock) {
				if($sock === $this->master) {
					$client = socket_accept($sock);
					if($client === false) {
						continue;
					}
					 echo "connect client\n";
					$this->addAccept($client);
				} else {
					$len = 0;
					$buffer = '';
					do {
						$preLen = socket_recv($sock, $pre_buf, 1024, 0);
						$len += $preLen;
						$buffer .= $pre_buf;
					} while($preLen == 1024);

					$socketId = $this->findSocket($sock);
					if ($len < 7) {
						//断开$socketId
						continue;
					}

					if($this->accept[$socketId]['isHand'] !== false) {//已握手
							
					} else {//未握手, 进行握手操作
						echo "shakeHands\n";
						$this->shakehand($socketId, $buffer);
					}
				}
			}
		}
	}
	
	private function addAccept($socket) {
		$this->cycle[] = $socket;
		$key = uniqid();
		$this->accept[$key] = [
			'socket' => $socket,
			'isHand' => false,
		];
	}

	private function findSocket($socket) {
		foreach($this->accept as $key => $accept) {
			if($socket === $accept['socket']) {
				return $key;
			}
		}
		return false;
	}

	public function shakeHand($socket_id, $buffer) {
		preg_match("/Sec-WebSocket-Key:(.*)\r\n/", $buffer, $matchs);
		$key = base64_encode(sha1(trim($matchs[1]) . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
		$upgrade = "HTTP/1.1 101 Switching Protocol\r\n" .
			   "Upgrade: websocket\r\n" .
			   "Connection: Upgrade\r\n" .
			   "Sec-WebSocket-Accept: " . $key . "\r\n\r\n";
		socket_write($this->accept[$socket_id]['socket'], $upgrade, strlen($upgrade));
		$this->accept[$socket_id]['isHand'] = true;

		return true;
	}
}
