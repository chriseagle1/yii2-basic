<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>vue test</title>
	<script src="https://unpkg.com/vue/dist/vue.js"></script>
</head>
<body>
	<div id ="app">{{message}}</div>
	<div id="app-2">
		<span v-bind:title="message">
			鼠标悬停几秒钟查看此处动态绑定的提示信息！
		</span>
	</div>
	<div id="app-3">
		<p v-if="seen">现在你看到我了</p>
		<p v-else>我走了</p>
	</div>

	<div id="app-4">
		<ol>
			<li v-for="todo in todos">
				{{todo.text}}
			</li>
		</ol>
	</div>

	<div id="app-5">
		<p>{{message}}</p>
		<button @click="reverseMessage">逆转消息</button>
	</div>

	<div id="app-6">
		<p>{{message}}</p>
		<input v-model="message">
	</div>
</body>
<script type="text/javascript">
	var app = new Vue({
		el:"#app",
		data:{
			message:'Hello Vue!'
		}
	});

	var app2 = new Vue({
		el:"#app-2",
		data:{
			message:'页面加载于' + new Date()
		}
	});
	var app3 = new Vue({
		el:"#app-3",
		data:{
			seen:true
		}
	});

	var app4 = new Vue({
		el:"#app-4",
		data:{
			todos:[
				{text:'学习js'},
				{text:'学习Vue'},
				{text:'整个牛项目'}
			]
		}
	});

	var app5 = new Vue({
		el:"#app-5",
		data:{
			message:'Hello Vue.js!'
		},
		methods:{
			reverseMessage:function(){
				this.message = this.message.split(' ').reverse().join(' ')
			}
		}
	});

	var app6 = new Vue({
		el:'#app-6',
		data:{
			message:'Hello Vue!'
		}
	});
	setTimeout(function(){
		app.message = 'setTimeout change'
	}, 5000);
</script>
</html>
