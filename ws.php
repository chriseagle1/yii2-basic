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
			echo "changes:";
			var_dump($changes);
			socket_select($changes, $write, $except, NULL);
			echo "have request\nselect_changes:";
			var_dump($changes);
		
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
						echo 'msg_len:' . $len . "\n";
						$this->closeConnect($socketId);
						var_dump($this->cycle);
						continue;
					}

					if($this->accept[$socketId]['isHand'] !== false) {//已握手
						echo "have shaked\n";
                        //解码，输出
                        $decodeContent = $this->decode($buffer, $socketId);
                        
                        echo $decodeContent . "\n";
                        $output = $this->encode($decodeContent);
                        socket_write($this->accept[$socketId]['socket'], $output, strlen($output));                
					} else {//未握手, 进行握手操作
						echo "shakeHands\n";
						$this->shakehand($socketId, $buffer);
					}
				}
			}
		}
	}
	//连接池增加一个连接	
	private function addAccept($socket) {
		$this->cycle[] = $socket;
		$key = uniqid();
		$this->accept[$key] = [
			'socket' => $socket,
			'isHand' => false,
		];
	}
	//根据socket找到其对应的id
	private function findSocket($socket) {
		foreach($this->accept as $key => $accept) {
			if($socket === $accept['socket']) {
				return $key;
			}
		}
		return false;
	}
	//握手
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
	
	public function closeConnect($socket_id) {
		socket_close($this->accept[$socket_id]['socket']);
		$index = array_search($this->accept[$socket_id]['socket'], $this->cycle);
		unset($this->accept[$socket_id]);
		unset($this->cycle[$index]);
		
		return true;
	}
   
    //对接收到的客户端数据进行解码 
    public function decode($str, $socket_id) {
        $opcode = ord(substr($str, 0, 1)) & 0x0F;
        //从客户端发来的信息一定有mask key，所以str[1]这个字节的第一位一定为1，通过"与"127,取到Payload length的长度
        $payloadLen = ord(substr($str, 1, 1)) & 0x7F;
        $ismask = (ord(substr($str, 1, 1)) & 0x80) >> 7;
        $mask_key = $data = $decoded = null;
        
        if($ismask != 1 || $opcode == 0x8) {//根据websocket协议，客户端传来的数据，如果掩码不为1或者操作码为0x8，则直接关闭
            $this->closeConnect($socket_id);
            return null;
        } 
        if($payloadLen == 126) {//Payload length 长度即为7 + 16 bit
            //第一个字节中第一位为fin，2-4位为rsv，第5-8为为操作码，第二个字符中第一位为mask标志，2-8为原始负载长度
            //原始负载长度为126时 负载长度扩展16bit， 即增加两个字节，所以0，1， 2,3字节都被占用，mask key从4开始取
            $mask_key = substr($str, 4, 4);
            $data = substr($str, 8);  
        } else if($payloadLen == 127){//Payload length 长度即为7 + 64 bit
            $mask_key = substr($str, 10, 4);
            $data = substr($str, 14);
        } else {//Payload length 长度即为7bit
            $mask_key = substr($str, 2, 4);
            $data = substr($str, 6);
        }
        $dataLen = strlen($data);
        for($i = 0; $i < $dataLen; $i++) {
            $decoded .= $data[$i] ^ $mask_key[$i%4];
        }
        return $decoded;
    }
    
    //默认操作码为0x1 文本信息;
    /*其中  0x0 继续帧, 
            0x1 文本帧, 
            0x2 二进制帧，
            0x3-0x7保留用于未来的非控制帧, 
            0x8连接关闭, 
            0x9 代表ping, 
            0xA代表pong , 
            xB-xF 保留用于未来控制帧
    */
    public function encode($msg, $opcode = 0x1) {
        $firstByte = 0x80 | $opcode ;
        $encoded = null;

        $len = strlen($msg);

        if ($len >= 0) {
            if($len <= 125) {
                $encoded = chr($firstByte) . chr($len) . $msg;
            } else if($len <= 0xFFFF){
                $low = $len & 0x00FF;
                $high = ($len & 0xFF00) >> 8;
                $encoded = chr($firstByte) . chr(0x7E) . chr($high) . chr($low) . $msg;
            } else {
                $low = $len & 0x00000000FFFFFFFF;
                $high = ($len & 0xFFFFFFFF00000000) >> 32;
                $pack = pack('NN', $high, $low);
                $encoded = chr($firstByte) . chr(0x7F) . $pack . $msg;
            }
        }
        return $encoded;
    }
}
