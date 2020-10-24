<template>
	<div class="chat-lists">
		<div class="messages" v-for="chat in chats">
			<div class="users">
				{{chat.user.name}} <span class="time">{{chat.created_at}}</span>
			</div>
			<div class="messages">
			{{chat.subject}}
			</div>
		</div>
		

	</div>


</template>
<script>
	import BusEvent from '../../bus'
	export default{
		data(){
			return{
				chats:[]
			}
		},

		mounted(){
			this.getAllChats();
			BusEvent.$on('chat.sent',(newChat)=>{
				
				this.chats.push(newChat);
				this.scrollToBottom();
			
			});
		},
		methods:{
			getAllChats(){
				axios.get('/chat/all-chats').then(response =>{
				this.chats=response.data.reverse();
				});
			},
			scrollToBottom(){
				setTimeout(function(){
					let chatLists=document.getElementsByClassName('chat-lists')[0];
				chatLists.scrollTop=chatLists.scrollHeight;
			},1);
				
			}
		}
	}
</script>
<style lang="scss">
	.messages{
		margin-top:5px;
		.time{
			font-weight:800;
		}
		.message{
			font-size:1.2rem;
		}
	}
	.chat-lists{
		max-height:300px;
		overflow-y:scroll;
	}
</style>